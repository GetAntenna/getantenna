<?php
	class ScrapbookEventsController extends AppController
	{
		public $name = 'ScrapbookEvents';
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
			$this->set('title_for_layout', __('Events scrapbook', true));

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
					'ScrapbookEvent.title LIKE' => '%'. $searchTerms .'%', 
					'ScrapbookEvent.summary LIKE' => '%'. $searchTerms .'%', 
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
							$andSearch['ScrapbookEvent.id'] = $modifierValue;
							break;
						case 'date':
							list($day, $month, $year) = explode("-", $modifierValue);
							$andSearch['ScrapbookEvent.start >='] = $year ."-". $month ."-". $day;
							break;
						case 'category':
							$andSearch['ScrapbookEvent.category'] = $modifierValue;
							break;
						case 'highlight':
							if($modifierValue == 'true') { $andSearch['ScrapbookEvent.highlight'] = 1; } else { $andSearch['ScrapbookEvent.highlight'] = 0; }
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
				'order' => array('ScrapbookEvent.created DESC', 'ScrapbookEvent.title', 'ScrapbookEvent.address'),
				'limit' => Configure::read('Application.core.pagination'),
			);
			$data = $this->paginate('ScrapbookEvent');
			$this->set('listItems', $data);

			list($usec, $sec) = explode(" ", microtime());
		   $endTime = (float)$usec + (float)$sec;
			$time = $endTime - $startTime;
			$this->set('queryTime', $time);
		}

		function add()
		{
			$this->set('title_for_layout', __('Add a new event', true));

			// Show the feedback message
			$this->shamrockFeedback->feedbackLoad();

			if(!empty($this->data))
			{
				$this->ScrapbookEvent->create();
				
				// Save the data
				if($this->ScrapbookEvent->save($this->data))
				{
					$this->shamrockFeedback->feedbackSave(__('The event has been added', true), 'success');
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
			$this->set('title_for_layout', __('Edit this event', true));

			// Show the feedback message
			$this->shamrockFeedback->feedbackLoad();

			if(!$id && empty($this->data))
			{
				// The ID cannot be empty
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> You need to select an event in order to edit it', true), 'error');
				$this->redirect(array('action' => 'index'), null, true);
			}

			$this->ScrapbookEvent->id = $id; 
			$this->set('eventId', $this->ScrapbookEvent->id);

			if(!empty($this->data))
			{
				if($this->ScrapbookEvent->save($this->data))
				{
					$this->shamrockFeedback->feedbackSave(__('The event has been saved', true), 'success');
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
				$this->data = $this->ScrapbookEvent->read(); 

				// Parse the starting date and format it for the datepicker
				list($year, $month, $day) = explode("-", $this->data['ScrapbookEvent']['start']);
				$this->data['ScrapbookEvent']['start'] = $day ."-". $month ."-". $year;

				// Parse the times
				if($this->data['ScrapbookEvent']['stime'] != '') { $this->data['ScrapbookEvent']['stime'] = substr($this->data['ScrapbookEvent']['stime'], 0, -3); }
				if($this->data['ScrapbookEvent']['etime'] != '') { $this->data['ScrapbookEvent']['etime'] = substr($this->data['ScrapbookEvent']['etime'], 0, -3); }
			}
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

			$this->ScrapbookEvent->id = $id;
			$this->data = $this->ScrapbookEvent->read();

			// Get the draft editions
			$results = $this->ScrapbookEvent->query("SELECT * FROM `editions` AS `Edition` WHERE `Edition`.`draft` = '1' ORDER BY `Edition`.`start`;");

			// Load the event model
			Controller::loadModel('Event');
			foreach($results as $result)
			{
				$this->data['Event'] = $this->data['ScrapbookEvent'];
				$this->data['Event']['draft'] = 1;
				$this->data['Event']['clone'] = 1;
				$this->data['Event']['edition_id'] = $result['Edition']['id'];
				unset($this->data['Event']['id']);

				$this->Event->create();
				$this->Event->save($this->data['Event'], false);
			}

			$this->shamrockFeedback->feedbackSave(__('The event has been attached to the draft editions', true), 'success');
			$this->redirect(array('action' => 'index'), null, true);
		}

		function move()
		{
			$id = $this->data['moveItem']['id'];
			if(!$id)
			{
				// The ID cannot be empty
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> You need to select an event in order to move it to the recurring events', true), 'error');
				$this->redirect(array('action' => 'index'), null, true);
			}

			$this->ScrapbookEvent->id = $id;
			$this->data = $this->ScrapbookEvent->read();
			unset($this->data['ScrapbookEvent']['id']);

			// Load the event model
			Controller::loadModel('WeeklyEvent');
			$this->data['WeeklyEvent'] = $this->data['ScrapbookEvent'];
			$this->data['WeeklyEvent']['draft'] = 1;
			$this->data['WeeklyEvent']['clone'] = 1;

			$this->WeeklyEvent->create();
			$this->WeeklyEvent->save($this->data['WeeklyEvent'], false);

			// Delete the scrapbook event
			$this->ScrapbookEvent->delete($id);

			$this->shamrockFeedback->feedbackSave(__('The event has been moved to the recurring events', true), 'success');
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

			$this->ScrapbookEvent->delete($id);

			$this->shamrockFeedback->feedbackSave(__('The event has been deleted', true), 'success');
			$this->redirect(array('action' => 'index'), null, true);
		}
	}