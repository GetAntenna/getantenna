<?php
	class WeeklyEventsController extends AppController
	{
		public $name = 'WeeklyEvents';
		public $helpers = array(
			'Text', 
			'Categories', 
			'Topping.Javascript',
			'Topping.Ajax',
			'TinyMce',
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
			$this->set('title_for_layout', __('Recurring events', true));

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

			// Parse the keywords and get terms and modifiers
			$convertedKeywords = stripslashes(urldecode($searchKeyword));
			$searchTerms = preg_split("/[a-z]+\:[a-z_\-0-9]+/", $convertedKeywords, NULL, PREG_SPLIT_NO_EMPTY);

			// Only one search term allowed
			if(isset($searchTerms[0]))
			{
				$cleanSearchTerms = str_replace(' ', '', $searchTerms[0]);
				if(!empty($cleanSearchTerms)) 
				{ 
					$searchTerms = $searchTerms[0]; 
				}
				else
				{
					$searchTerms = ''; 
				}
			}
			else
			{
				$searchTerms = '';
			}
			
			$searchModifiersString = str_replace($searchTerms, ' ', $convertedKeywords);
			$searchModifiers = preg_split("/[\s,]+/", $searchModifiersString, NULL, PREG_SPLIT_NO_EMPTY);

			if($searchTerms != '')
			{
				$orSearch = array(
					'WeeklyEvent.title LIKE' => '%'. $searchTerms .'%', 
					'WeeklyEvent.summary LIKE' => '%'. $searchTerms .'%', 
				);
			}
			else
			{
				$orSearch = array('1 = 1');
			}

			if(!empty($searchModifiers))
			{
				foreach($searchModifiers as $modifier)
				{
					list($modifierString, $modifierValue) = explode(':', $modifier);

					switch($modifierString)
					{
						case 'id':
							$andSearch['WeeklyEvent.id'] = $modifierValue;
							break;
						case 'date':
							list($day, $month, $year) = explode("-", $modifierValue);
							$andSearch['WeeklyEvent.start >='] = $year ."-". $month ."-". $day;
							break;
						case 'category':
							$andSearch['WeeklyEvent.category'] = $modifierValue;
							break;
						case 'highlight':
							if($modifierValue == 'true') { $andSearch['WeeklyEvent.highlight'] = 1; } else { $andSearch['WeeklyEvent.highlight'] = 0; }
							break;
					}
				}
			}
			else
			{
				$andSearch = array('1 = 1');
			}

			// Get all the items
			$this->paginate = array(
				'recursive' => 1,
				'conditions' => array(
					"OR" => $orSearch,
					"AND" => $andSearch,
				), 
				'order' => array('WeeklyEvent.start DESC', 'WeeklyEvent.stime DESC', 'WeeklyEvent.title', 'WeeklyEvent.id'),
				'limit' => Configure::read('Application.core.pagination'),
			);
			$data = $this->paginate('WeeklyEvent');
			$this->set('listItems', $data);

			list($usec, $sec) = explode(" ", microtime());
		   $endTime = (float)$usec + (float)$sec;
			$time = $endTime - $startTime;
			$this->set('queryTime', $time);
		}

		function add()
		{
			$this->set('title_for_layout', __('Add a new recurring event', true));

			// Show the feedback message
			$this->shamrockFeedback->feedbackLoad();

			if(!empty($this->data))
			{
				$this->WeeklyEvent->create();
				
				// Save the data
				if($this->WeeklyEvent->save($this->data))
				{
					$this->shamrockFeedback->feedbackSave(__('The weekly event has been added', true), 'success');
					$this->redirect(array('action' => 'index'), null, true);
				}
				else
				{
					$this->set('shamrockErrors', true);
				}
			}
		}

		function edit($id = null)
		{
			$this->set('title_for_layout', __('Edit this recurring event', true));

			// Show the feedback message
			$this->shamrockFeedback->feedbackLoad();

			if(!$id && empty($this->data))
			{
				// The ID cannot be empty
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> You need to select a weekly event in order to edit it', true), 'error');
				$this->redirect(array('action' => 'index'), null, true);
			}

			$this->WeeklyEvent->id = $id; 
			$this->set('eventId', $this->WeeklyEvent->id);

			if(!empty($this->data))
			{
				if($this->WeeklyEvent->save($this->data))
				{
					$this->shamrockFeedback->feedbackSave(__('The weekly event has been saved', true), 'success');
					$this->redirect(array('action' => 'index'), null, true);
				}
				else
				{
					$this->set('shamrockErrors', true);
				}
			}
			else
			{
				// Read the selected event
				$this->data = $this->WeeklyEvent->read(); 

				// Parse the starting date and format it for the datepicker
				list($year, $month, $day) = explode("-", $this->data['WeeklyEvent']['start']);
				$this->data['WeeklyEvent']['start'] = $day ."-". $month ."-". $year;

				// Parse the times
				if($this->data['WeeklyEvent']['stime'] != '') { $this->data['WeeklyEvent']['stime'] = substr($this->data['WeeklyEvent']['stime'], 0, -3); }
				if($this->data['WeeklyEvent']['etime'] != '') { $this->data['WeeklyEvent']['etime'] = substr($this->data['WeeklyEvent']['etime'], 0, -3); }
			}
		}

		function attach()
		{
			$id = $this->data['attachItem']['id'];
			if(!$id)
			{
				// The ID cannot be empty
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> You need to select a weekly event in order to attach it to the current edition', true), 'error');
				$this->redirect(array('action' => 'index'), null, true);
			}

			$this->WeeklyEvent->id = $id;
			$this->data = $this->WeeklyEvent->read();

			// Get the current edition
			$results = $this->WeeklyEvent->query("SELECT * FROM `editions` AS `Edition` WHERE `Edition`.`draft` = '1' ORDER BY `Edition`.`start`;");

			// Load the event model
			Controller::loadModel('Event');
			foreach($results as $result)
			{
				$this->data['Event'] = $this->data['WeeklyEvent'];
				$this->data['Event']['draft'] = 1;
				$this->data['Event']['clone'] = 1;
				$this->data['Event']['edition_id'] = $result['Edition']['id'];
				unset($this->data['Event']['id']);

				$this->Event->create();
				$this->Event->save($this->data['Event'], false);
			}

			$this->shamrockFeedback->feedbackSave(__('The weekly event has been attached to the draft editions', true), 'success');
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

			$this->WeeklyEvent->id = $id;
			$this->data = $this->WeeklyEvent->read();
			unset($this->data['WeeklyEvent']['id']);

			// Load the event model
			Controller::loadModel('ScrapbookEvent');
			$this->data['ScrapbookEvent'] = $this->data['WeeklyEvent'];
			$this->data['ScrapbookEvent']['draft'] = 1;
			$this->data['ScrapbookEvent']['clone'] = 1;

			$this->ScrapbookEvent->create();
			$this->ScrapbookEvent->save($this->data['ScrapbookEvent'], false);

			// Delete the scrapbook event
			$this->WeeklyEvent->delete($id);

			$this->shamrockFeedback->feedbackSave(__('The event has been moved to the scrapbook', true), 'success');
			$this->redirect(array('action' => 'index'), null, true);
		}

		function delete()
		{
			$id = $this->data['removeItem']['id'];
			if(!$id)
			{
				// Something strange, redirect to the index
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> You need to select a weekly event in order to delete it', true), 'error');
				$this->redirect(array('action' => 'index'), null, true);
			}

			$this->WeeklyEvent->delete($id);

			$this->shamrockFeedback->feedbackSave(__('The weekly event has been deleted', true), 'success');
			$this->redirect(array('action' => 'index'), null, true);
		}
	}