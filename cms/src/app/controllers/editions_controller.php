<?php
	class EditionsController extends AppController
	{
		public $name = 'Editions';
		private $_currentUser = null;
		
		function beforeFilter()
		{
			// Get the details for the current user
			$this->_currentUser = @$this->shamrockAuthentication->user();
			$this->_currentUser = $this->_currentUser['User'];

			// Redirect to the default page is the user has not access
			if(!$this->shamrockAuthentication->isAllowed())
			{
				if($this->params['action'] != 'index')
				{
					$this->redirect(array('controller' => $this->params['controller'], 'action' => 'index'), null, true);
				}
				else
				{
					$this->redirect(array('controller' => 'editions', 'action' => 'index'), null, true);
				}
			}

			// Set some basic strings
			$this->set('userFirstName', ($this->_currentUser['firstname']));
			$this->set('userEmail', $this->_currentUser['email']);

			// Check if the user is an admin
			if($this->_currentUser['group_id'] != Configure::read('Application.acl.admingroup')) { $this->set('isUser', true); } else { $this->set('isUser', false); }

			$this->Edition->query("SET SQL_BIG_SELECTS =1");
		}

		function index()
		{
			$this->set('title_for_layout', __('Editions management', true));

			// Show the feedback message
			$this->shamrockFeedback->feedbackLoad();

			// Get the published edition
			$currentEdition = $this->Edition->find('first', array(
				'conditions' => array(
					'published' => 1, 
				),
				'order' => array(
					'start DESC', 
				),
			));
			if(!empty($currentEdition))
			{
				$this->set('publishedEdition', $currentEdition);
			}

			$draftEditions = $this->Edition->find('all', array(
				'conditions' => array(
					'draft' => 1,
				),
				'order' => array(
					'start DESC', 
				),
			));
			if(!empty($draftEditions))
			{
				$this->set('draftEditions', $draftEditions);
			}

			$previousEditions = $this->Edition->find('all', array(
				'conditions' => array(
					'draft' => 0,
					'`Edition`.id !=' => $currentEdition['Edition']['id'],
					'DATEDIFF(`Edition`.`start`, \''. $currentEdition['Edition']['start'] .'\') <=' => 90,
				),
				'order' => array(
					'start DESC', 
				),
			));
			if(!empty($previousEditions))
			{
				$this->set('previousEditions', $previousEditions);
			}
		}

		function add()
		{
			$this->set('title_for_layout', __('Editions management', true));

			// Show the feedback message
			$this->shamrockFeedback->feedbackLoad();

			if(!empty($this->data))
			{
				$this->Edition->create();
				
				// Save the data
				if($this->Edition->save($this->data))
				{
					$editionID = $this->Edition->id;
					list($day, $month, $year) = explode("-", $this->data['Edition']['start']);
					$editionDataStart = $year ."-". $month ."-". $day;
					list($day, $month, $year) = explode("-", $this->data['Edition']['end']);
					$editionDataEnd = $year ."-". $month ."-". $day;

					// Load the event model
					Controller::loadModel('Event');

					// Attach the weekly events
					$weeklyEvents = $this->Edition->query("
						SELECT * 
						FROM `weekly_events` AS WeeklyEvent 
						WHERE 
							`WeeklyEvent`.`start` >= '". $editionDataStart ."' 
						AND 
							`WeeklyEvent`.`start` <= '". $editionDataEnd ."' 
					");
					foreach($weeklyEvents as $event)
					{
						unset($data);
						unset($event['WeeklyEvent']['id']);
						$data['Event'] = $event['WeeklyEvent'];
						$data['Event']['clone'] = 1;
						$data['Event']['weekly'] = 1;
						$data['Event']['draft'] = 0;
						$data['Event']['edition_id'] = $editionID;

						$this->Event->create();
						$this->Event->save($data['Event'], false);
					}

					$this->shamrockFeedback->feedbackSave(__('The edition has been added', true), 'success');
					$this->redirect(array('action' => 'index'), null, true);
				}
				else
				{
					$this->set('shamrockErrors', true);
				}
			}
			else
			{
				if(empty($this->data['Edition']['issue']))
				{
					// Get the published edition
					$currentEdition = $this->Edition->find('first', array(
						'conditions' => array(
							'published' => 1
						),
						'order' => array(
							'start DESC', 
						),
					));
					if(!empty($currentEdition))
					{
						$this->data['Edition']['issue'] = $currentEdition['Edition']['issue'] + 1;
					}
				}
			}
		}

		function delete()
		{
			$this->autoRender = false;
			$id = $this->data['removeItem']['id'];
			if(!$id)
			{
				// Something strange, redirect to the index
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> You need to select an edition in order to delete it', true), 'error');
				$this->redirect(array('action' => 'index'), null, true);
			}

			$this->Edition->delete($id, true);

			$this->shamrockFeedback->feedbackSave(__('The edition has been deleted', true), 'success');
			$this->redirect(array('action' => 'index'), null, true);
		}

		function publish()
		{
			$this->autoRender = false;
			$id = $this->data['publishItem']['id'];
			unset($this->data);
			if(!$id)
			{
				// Something strange, redirect to the index
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> You need to select an edition in order to publish it', true), 'error');
				$this->redirect(array('action' => 'index'), null, true);
			}

			// Remove the published flag
			$this->Edition->query("UPDATE `editions` SET `published` = '0';");
			// Mark previous events as read only
			$this->Edition->query("UPDATE `editions` SET `readonly` = '1' WHERE `draft` != '1';");

			$this->Edition->id = $id;
			$this->data = $this->Edition->read();
			
			$this->data['Edition']['draft'] = 0;
			$this->data['Edition']['published'] = 1;
			$this->data['Edition']['readonly'] = 0;

			// Parse the start and end date for validation
			$editionData = $this->data['Edition']['end'];
			list($year, $month, $day) = explode("-", $this->data['Edition']['start']);
			$this->data['Edition']['start'] = $day ."-". $month ."-". $year;
			list($year, $month, $day) = explode("-", $this->data['Edition']['end']);
			$this->data['Edition']['end'] = $day ."-". $month ."-". $year;

			if($this->Edition->save($this->data))
			{
				// Add 7 days to the recurring events
				$weeklyEvents = $this->Edition->query("
					UPDATE `weekly_events` 
					SET `start` = DATE_ADD(`start`, INTERVAL 7 DAY)
					WHERE `weekly_events`.`start` <= '". $editionData ."'");

				$this->shamrockFeedback->feedbackSave(__('The edition has been published', true), 'success');
				$this->redirect(array('action' => 'index'), null, true);
			}
		}
	}