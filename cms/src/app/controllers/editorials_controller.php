<?php
	class EditorialsController extends AppController
	{
		public $name = 'Editorials';
		private $_currentUser = null;
		private $_selectedEdition = null;
		private $_readonlyEdition = false;
		public $helpers = array('TinyMce');

		function beforeFilter()
		{
			@header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
			@header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

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
			$this->Editorial->Edition->id = $this->_selectedEdition;
			$editionData = $this->Editorial->Edition->read();
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

			$this->Editorial->query("SET SQL_BIG_SELECTS =1");
		}

		function index()
		{
			$this->set('title_for_layout', __('Editorial &amp; Content', true));

			// Show the feedback message
			$this->shamrockFeedback->feedbackLoad();

			$editorialData = $this->Editorial->find('first', array(
				'conditions' => array(
					'edition_id' => $this->_selectedEdition, 
				),
			));
			$this->set('editorialData', $editorialData);
		}

		function edit_newsletter($id = null)
		{
			$this->set('title_for_layout', __('Edit newsletter', true));

			// Show the feedback message
			$this->shamrockFeedback->feedbackLoad();

			if(!$id && empty($this->data))
			{
				// The ID cannot be empty
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> the system could not find the item', true), 'error');
				$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
			}

			$this->Editorial->id = $id; 

			if(!empty($this->data))
			{
				if($this->Editorial->EditorialsNewsletter->save($this->data))
				{
					$this->shamrockFeedback->feedbackSave(__('This editorial has been saved', true), 'success');
					$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
				}
				else
				{
					$this->set('shamrockErrors', true);
				}
			}
			else
			{
				// Read the selected editorial
				$this->data = $this->Editorial->read(); 
			}

			// Readonly edition
			$this->set('readonly', $this->_readonlyEdition);
		}

		function edit_cs1($id = null)
		{
			$this->set('title_for_layout', __('Edit content section 1', true));

			// Show the feedback message
			$this->shamrockFeedback->feedbackLoad();

			if(!$id && empty($this->data))
			{
				// The ID cannot be empty
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> the system could not find the item', true), 'error');
				$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
			}

			$this->Editorial->id = $id; 

			if(!empty($this->data))
			{
				if($this->Editorial->EditorialsCs1->save($this->data))
				{
					$this->shamrockFeedback->feedbackSave(__('This editorial has been saved', true), 'success');
					$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
				}
				else
				{
					$this->set('shamrockErrors', true);
				}
			}
			else
			{
				// Read the selected editorial
				$this->data = $this->Editorial->read(); 
			}

			// Readonly edition
			$this->set('readonly', $this->_readonlyEdition);
		}

		function edit_ec1($id = null)
		{
			$this->set('title_for_layout', __('Edit Support the Dublin Event Guide', true));

			// Show the feedback message
			$this->shamrockFeedback->feedbackLoad();

			if(!$id && empty($this->data))
			{
				// The ID cannot be empty
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> the system could not find the item', true), 'error');
				$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
			}

			$this->Editorial->id = $id; 

			if(!empty($this->data))
			{
				if($this->Editorial->EditorialsEc1->save($this->data))
				{
					$this->shamrockFeedback->feedbackSave(__('This editorial has been saved', true), 'success');
					$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
				}
				else
				{
					$this->set('shamrockErrors', true);
				}
			}
			else
			{
				// Read the selected editorial
				$this->data = $this->Editorial->read(); 
			}

			// Readonly edition
			$this->set('readonly', $this->_readonlyEdition);
	   
	 	}

		function edit_highlight($id = null)
		{
			$this->set('title_for_layout', __('Edit highlights', true));

			// Show the feedback message
			$this->shamrockFeedback->feedbackLoad();

			if(!$id && empty($this->data))
			{
				// The ID cannot be empty
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> the system could not find the item', true), 'error');
				$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
			}

			$this->Editorial->id = $id; 

			if(!empty($this->data))
			{
				if($this->Editorial->EditorialsHighlight->save($this->data))
				{
					$this->shamrockFeedback->feedbackSave(__('This editorial has been saved', true), 'success');
					$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
				}
				else
				{
					$this->set('shamrockErrors', true);
				}
			}
			else
			{
				// Read the selected editorial
				$this->data = $this->Editorial->read(); 
			}

			// Readonly edition
			$this->set('readonly', $this->_readonlyEdition);
		}

		function edit_competitions($id = null)
		{
			$this->set('title_for_layout', __('Edit Competitions', true));

			// Show the feedback message
			$this->shamrockFeedback->feedbackLoad();

			if(!$id && empty($this->data))
			{
				// The ID cannot be empty
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> the system could not find the item', true), 'error');
				$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
			}

			$this->Editorial->id = $id; 

			if(!empty($this->data))
			{
				if($this->Editorial->EditorialsCompetition->save($this->data))
				{
					$this->shamrockFeedback->feedbackSave(__('This editorial has been saved', true), 'success');
					$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
				}
				else
				{
					$this->set('shamrockErrors', true);
				}
			}
			else
			{
				// Read the selected editorial
				$this->data = $this->Editorial->read(); 
			}

			// Readonly edition
			$this->set('readonly', $this->_readonlyEdition);
		}

		function edit_news($id = null)
		{
			$this->set('title_for_layout', __('Edit News', true));

			// Show the feedback message
			$this->shamrockFeedback->feedbackLoad();

			if(!$id && empty($this->data))
			{
				// The ID cannot be empty
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> the system could not find the item', true), 'error');
				$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
			}

			$this->Editorial->id = $id; 

			if(!empty($this->data))
			{
				if($this->Editorial->EditorialsNews->save($this->data))
				{
					$this->shamrockFeedback->feedbackSave(__('This editorial has been saved', true), 'success');
					$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
				}
				else
				{
					$this->set('shamrockErrors', true);
				}
			}
			else
			{
				// Read the selected editorial
				$this->data = $this->Editorial->read(); 
			}

			// Readonly edition
			$this->set('readonly', $this->_readonlyEdition);
		}
        

		function edit_events($id = null)
		{
			$this->set('title_for_layout', __('Edit Events', true));

			// Show the feedback message
			$this->shamrockFeedback->feedbackLoad();

			if(!$id && empty($this->data))
			{
				// The ID cannot be empty
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> the system could not find the item', true), 'error');
				$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
			}

			$this->Editorial->id = $id; 

			if(!empty($this->data))
			{
				if($this->Editorial->EditorialsEvent->save($this->data))
				{
					$this->shamrockFeedback->feedbackSave(__('This editorial has been saved', true), 'success');
					$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
				}
				else
				{
					$this->set('shamrockErrors', true);
				}
			}
			else
			{
				// Read the selected editorial
				$this->data = $this->Editorial->read(); 
			}

			// Readonly edition
			$this->set('readonly', $this->_readonlyEdition);
		}

		function edit_cs2($id = null)
		{
			$this->set('title_for_layout', __('Edit content section 2', true));

			// Show the feedback message
			$this->shamrockFeedback->feedbackLoad();

			if(!$id && empty($this->data))
			{
				// The ID cannot be empty
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> the system could not find the item', true), 'error');
				$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
			}

			$this->Editorial->id = $id; 

			if(!empty($this->data))
			{
				if($this->Editorial->EditorialsCs2->save($this->data))
				{
					$this->shamrockFeedback->feedbackSave(__('This editorial has been saved', true), 'success');
					$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
				}
				else
				{
					$this->set('shamrockErrors', true);
				}
			}
			else
			{
				// Read the selected editorial
				$this->data = $this->Editorial->read(); 
			}

			// Readonly edition
			$this->set('readonly', $this->_readonlyEdition);
		}

		function edit_outro($id = null)
		{
			$this->set('title_for_layout', __('Edit newsletter outro', true));

			// Show the feedback message
			$this->shamrockFeedback->feedbackLoad();

			if(!$id && empty($this->data))
			{
				// The ID cannot be empty
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> the system could not find the item', true), 'error');
				$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
			}

			$this->Editorial->id = $id; 

			if(!empty($this->data))
			{
				if($this->Editorial->EditorialsOutro->save($this->data))
				{
					$this->shamrockFeedback->feedbackSave(__('This editorial has been saved', true), 'success');
					$this->redirect(array('action' => 'index', 'edition' => $this->_selectedEdition), null, true);
				}
				else
				{
					$this->set('shamrockErrors', true);
				}
			}
			else
			{
				// Read the selected editorial
				$this->data = $this->Editorial->read(); 
			}

			// Readonly edition
			$this->set('readonly', $this->_readonlyEdition);
		}

	}