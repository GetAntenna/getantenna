<?php
	class EventsController extends AppController
	{
		public $name = 'Events';
		public $helpers = array(
			'Text', 
			'Categories', 
			'Topping.Javascript',
			'Topping.Ajax',
			'TinyMce',
		);
		private $_currentUser = null;
		private $_selectedEdition = null;
		private $_readonlyEdition = false;
		
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

			// Redirect to the default page if the edition is not set
			if(!isset($this->params['named']['edition']) || empty($this->params['named']['edition']))
			{
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> You need to select an edition in order to manage its events', true), 'error');
				$this->redirect(array('controller' => 'editions', 'action' => 'index'), null, true);
			}
			// Set the selected edition ID
			$this->_selectedEdition = $this->params['named']['edition'];
			$this->set('selectedEdition', $this->_selectedEdition);

			// Get the edition details
			$this->Event->Edition->id = $this->_selectedEdition;
			$editionData = $this->Event->Edition->read();
			if($editionData['Edition']['readonly'] == 1)
			{
				$this->_readonlyEdition = true;
			}
			// Assign the values
			$this->set('editionNumber', $editionData['Edition']['issue']);
			$this->set('editionDate', date('l d.m.y', strtotime($editionData['Edition']['start'])) ." - ". date('l d.m.y', strtotime($editionData['Edition']['end'])));

			// Set some basic strings
			$this->set('userFirstName', ($this->_currentUser['firstname']));
			$this->set('userEmail', $this->_currentUser['email']);

			// Check if the user is an admin
			if($this->_currentUser['group_id'] != Configure::read('Application.acl.admingroup')) { $this->set('isUser', true); } else { $this->set('isUser', false); }
		}

		function index()
		{
			$this->set('title_for_layout', __('Events management', true));

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
					'Event.title LIKE' => '%'. $searchTerms .'%', 
					'Event.summary LIKE' => '%'. $searchTerms .'%', 
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
							$andSearch['Event.id'] = $modifierValue;
							break;
						case 'date':
							list($day, $month, $year) = explode("-", $modifierValue);
							$andSearch['Event.start >='] = $year ."-". $month ."-". $day;
							break;
						case 'category':
							$andSearch['Event.category'] = $modifierValue;
							break;
						case 'highlight':
							if($modifierValue == 'true') { $andSearch['Event.highlight'] = 1; } else { $andSearch['Event.highlight'] = 0; }
							break;
						case 'draft':
							if($modifierValue == 'true') { $andSearch['Event.draft'] = 1; } else { $andSearch['Event.draft'] = 0; }
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
					"edition_id" => $this->_selectedEdition, 
					"OR" => $orSearch,
					"AND" => $andSearch,
				), 
				'order' => array('Event.start ASC', 'Event.stime ASC', 'Event.title', 'Event.id'),
				'limit' => Configure::read('Application.core.pagination'),
			);
			$data = $this->paginate('Event');
			$this->set('listItems', $data);

			list($usec, $sec) = explode(" ", microtime());
		   $endTime = (float)$usec + (float)$sec;
			$time = $endTime - $startTime;
			$this->set('queryTime', $time);

			// Readonly edition
			$this->set('readonly', $this->_readonlyEdition);
		}

		function add()
		{
			$this->set('title_for_layout', __('Add a new event', true));

			if($this->_readonlyEdition)
			{
				$this->shamrockFeedback->feedbackSave(__('This edition is read only', true), 'error');
				$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
			}

			// Show the feedback message
			$this->shamrockFeedback->feedbackLoad();

			if(!empty($this->data))
			{
				$this->Event->create();
				
				// Save the data
				if($this->Event->save($this->data))
				{
					$this->shamrockFeedback->feedbackSave(__('The event has been added', true), 'success');
					$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
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
				$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
			}

			$this->Event->id = $id; 
			$this->set('eventId', $this->Event->id);

			if(!empty($this->data))
			{
				if($this->Event->save($this->data))
				{
					$this->shamrockFeedback->feedbackSave(__('The event has been saved', true), 'success');
					$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
				}
				else
				{
					$this->set('shamrockErrors', true);
				}
			}
			else
			{
				// Read the selected event
				$this->data = $this->Event->read(); 

				// Parse the starting date and format it for the datepicker
				list($year, $month, $day) = explode("-", $this->data['Event']['start']);
				$this->data['Event']['start'] = $day ."-". $month ."-". $year;

				// Parse the times
				if($this->data['Event']['stime'] != '') { $this->data['Event']['stime'] = substr($this->data['Event']['stime'], 0, -3); }
				if($this->data['Event']['etime'] != '') { $this->data['Event']['etime'] = substr($this->data['Event']['etime'], 0, -3); }
			}

			// Readonly edition
			$this->set('readonly', $this->_readonlyEdition);
		}

		function duplicate()
		{
			if($this->_readonlyEdition)
			{
				$this->shamrockFeedback->feedbackSave(__('This edition is read only', true), 'error');
				$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
			}

			$id = $this->data['cloneItem']['id'];
			if(!$id)
			{
				// The ID cannot be empty
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> You need to select an event in order to duplicate it', true), 'error');
				$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
			}

			$this->Event->id = $id;
			$this->data = $this->Event->read();
			unset($this->data['Event']['id']);
			unset($this->Event->id);

			// Change some values
			$this->data['Event']['clone'] = true;
			$this->data['Event']['draft'] = 1;

			$this->Event->create();
			$this->Event->save($this->data['Event'], false);

			$this->shamrockFeedback->feedbackSave(__('The event has been cloned', true), 'success');
			$this->redirect(array('action' => 'edit', $this->Event->id, 'edition' => $this->_selectedEdition), null, true);
		}

		function scrapbook()
		{
			$id = $this->data['cloneItem']['id'];
			if(!$id)
			{
				// The ID cannot be empty
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> You need to select an event in order to duplicate it', true), 'error');
				$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
			}

			$this->Event->id = $id;
			$this->data = $this->Event->read();
			unset($this->data['Event']['id']);
			unset($this->Event->id);

			// Load the scrapbook event model
			Controller::loadModel('ScrapbookEvent');
			$this->data['ScrapbookEvent'] = $this->data['Event'];
			$this->data['ScrapbookEvent']['clone'] = 1;
			$this->data['ScrapbookEvent']['draft'] = 1;

			$this->ScrapbookEvent->create();
			$this->ScrapbookEvent->save($this->data['ScrapbookEvent'], false);

			$this->shamrockFeedback->feedbackSave(__('The event has been added to the scrapbook', true), 'success');
			$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
		}

		function delete()
		{
			if($this->_readonlyEdition)
			{
				$this->shamrockFeedback->feedbackSave(__('This edition is read only', true), 'error');
				$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
			}

			$id = $this->data['removeItem']['id'];
			if(!$id)
			{
				// Something strange, redirect to the index
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> You need to select an event in order to delete it', true), 'error');
				$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
			}

			$this->Event->delete($id);

			$this->shamrockFeedback->feedbackSave(__('The event has been deleted', true), 'success');
			$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
		}
	}