<?php
	class SubmittedEventsController extends AppController
	{
		public $name = 'SubmittedEvents';
		public $helpers = array(
			'Text',
		);
		private $_currentUser = null;

		function beforeFilter()
		{
			// Get the details for the current user
			$this->_currentUser = @$this->shamrockAuthentication->user();
			$this->_currentUser = $this->_currentUser['User'];

			// Redirect to the default page if the user has not access
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
		}

		function index()
		{
			$this->set('title_for_layout', __('Submitted Events', true));

			// Show the feedback message
			$this->shamrockFeedback->feedbackLoad();

			// Search functionalities
			if(isset($_GET['q']))
			{
				$this->passedArgs = array_merge(array('q' => $_GET['q']), $this->passedArgs);
			}

			if(isset($this->passedArgs['q']) && !empty($this->passedArgs['q']))
			{
				$searchKeyword = $this->passedArgs['q'];
				$this->set('searchKeyword', $searchKeyword);
			}
			else
			{
				$searchKeyword = '';
				$this->set('searchKeyword', '');
			}

		   list($usec, $sec) = explode(" ", microtime());
		   $startTime = (float)$usec + (float)$sec;

			$orSearch = array(
				'SubmittedEvent.title LIKE' => '%'. $searchKeyword .'%', 
				'SubmittedEvent.summary LIKE' => '%'. $searchKeyword .'%', 
			);

			// Get all the items
			$this->paginate = array(
				'recursive' => 1,
				'conditions' => array(
					"OR" => $orSearch,
				), 
				'order' => array('SubmittedEvent.created DESC', 'SubmittedEvent.title', 'SubmittedEvent.address'),
				'limit' => Configure::read('Application.core.pagination'),
			);
			$data = $this->paginate('SubmittedEvent');
			$this->set('listItems', $data);

			list($usec, $sec) = explode(" ", microtime());
		   $endTime = (float)$usec + (float)$sec;
			$time = $endTime - $startTime;
			$this->set('queryTime', $time);
		}

		function details($id = null)
		{
			$this->set('title_for_layout', __('Details of this event', true));

			// Show the feedback message
			$this->shamrockFeedback->feedbackLoad();

			if(!$id && empty($this->data))
			{
				// The ID cannot be empty
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> You need to select an event in order to show the details', true), 'error');
				$this->redirect(array('action' => 'index'), null, true);
			}

			$this->SubmittedEvent->id = $id; 

			// Read the selected event
			$this->data = $this->SubmittedEvent->read(); 

			// Parse the starting date and format it for the datepicker
			list($year, $month, $day) = explode("-", $this->data['SubmittedEvent']['start']);
			$this->data['SubmittedEvent']['start'] = $day ."-". $month ."-". $year;

			list($date, $time) = explode(" ", $this->data['SubmittedEvent']['created']);
			list($year, $month, $day) = explode("-", $date);
			$this->data['SubmittedEvent']['created'] = $day ."-". $month ."-". $year;

			// Parse the times
			if($this->data['SubmittedEvent']['stime'] != '') { $this->data['SubmittedEvent']['stime'] = substr($this->data['SubmittedEvent']['stime'], 0, -3); }
			if($this->data['SubmittedEvent']['etime'] != '') { $this->data['SubmittedEvent']['etime'] = substr($this->data['SubmittedEvent']['etime'], 0, -3); }
		}

		function attach()
		{
			$id = $this->data['attachItem']['id'];
			if(!$id)
			{
				// The ID cannot be empty
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> You need to select an event in order to attach it to the draft editions', true), 'error');
				$this->redirect(array('action' => 'index'), null, true);
			}

			$this->SubmittedEvent->id = $id;
			$this->data = $this->SubmittedEvent->read();

			// Get the draft editions
			$results = $this->SubmittedEvent->query("SELECT * FROM `editions` AS `Edition` WHERE `Edition`.`draft` = '1' ORDER BY `Edition`.`start`;");

			// Load the event model
			Controller::loadModel('Event');
			foreach($results as $result)
			{
				$this->data['Event'] = $this->data['SubmittedEvent'];
				$this->data['Event']['draft'] = 1;
				$this->data['Event']['clone'] = true;
				$this->data['Event']['edition_id'] = $result['Edition']['id'];
				unset($this->data['Event']['id']);

				$this->Event->create();
				$this->Event->save($this->data['Event'], false);
			}

			$this->SubmittedEvent->delete($id);

			$this->shamrockFeedback->feedbackSave(__('The event has been attached to the draft editions', true), 'success');
			$this->redirect(array('action' => 'index'), null, true);
		}

		function move()
		{
			$id = $this->data['moveItem']['id'];
			if(!$id)
			{
				// The ID cannot be empty
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> You need to select an event in order to move it to the scrapbook', true), 'error');
				$this->redirect(array('action' => 'index'), null, true);
			}

			$this->SubmittedEvent->id = $id;
			$this->data = $this->SubmittedEvent->read();
			unset($this->data['SubmittedEvent']['id']);

			// Load the event model
			Controller::loadModel('ScrapbookEvent');
			$this->data['ScrapbookEvent'] = $this->data['SubmittedEvent'];
			$this->data['ScrapbookEvent']['draft'] = 1;
			$this->data['ScrapbookEvent']['clone'] = 1;

			$this->ScrapbookEvent->create();
			$this->ScrapbookEvent->save($this->data['ScrapbookEvent'], false);

			// Delete the scrapbook event
			$this->SubmittedEvent->delete($id);

			$this->shamrockFeedback->feedbackSave(__('The event has been moved to the scrapbook', true), 'success');
			$this->redirect(array('action' => 'index'), null, true);
		}

		function delete()
		{
			$id = $this->data['removeItem']['id'];
			if(!$id)
			{
				// Something strange, redirect to the index
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> You need to select an event in order to delete it', true), 'error');
				$this->redirect(array('action' => 'index'), null, true);
			}

			$this->SubmittedEvent->delete($id);

			$this->shamrockFeedback->feedbackSave(__('The event has been deleted', true), 'success');
			$this->redirect(array('action' => 'index'), null, true);
		}
	}