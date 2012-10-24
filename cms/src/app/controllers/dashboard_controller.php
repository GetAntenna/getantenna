<?php
	class DashboardController extends AppController
	{
		var $name = 'Dashboard';
		public $helpers = array(
			'Newsletter',
		);
		private $_currentUser = null;
		private $_selectedEdition = null;
		private $_editorialID = null;
		
		function beforeFilter()
		{
			// Get the details for the current user
			$this->_currentUser = @$this->shamrockAuthentication->user();
			$this->_currentUser = $this->_currentUser['User'];

			// Redirect to the default page if the edition is not set
			if(!isset($this->params['named']['edition']) || empty($this->params['named']['edition']))
			{
				$this->shamrockFeedback->feedbackSave(__('<b>Oops, something wasn&#39;t right.</b> You need to select an edition in order to manage its events', true), 'error');
				$this->redirect(array('controller' => 'editions', 'action' => 'index'), null, true);
			}
			// Set the selected edition ID
			$this->_selectedEdition = $this->params['named']['edition'];
			$this->set('selectedEdition', $this->_selectedEdition);

			// Get the id for the Editorial
			$dataEditorial = array_pop($this->Dashboard->query("
				SELECT 			
					`Editorial`.`id` 
				FROM `editorials` AS `Editorial`
				WHERE 
					`Editorial`.`edition_id` = '". $this->_selectedEdition ."' 
				LIMIT 1 
			"));
			$this->_editorialID = $dataEditorial['Editorial']['id'];

			// Set some basic strings
			$this->set('userFirstName', ($this->_currentUser['firstname']));
			$this->set('userEmail', $this->_currentUser['email']);

			// Check if the user is an admin
			if($this->_currentUser['group_id'] != Configure::read('Application.acl.admingroup')) { $this->set('isUser', true); } else { $this->set('isUser', false); }
		}

		function index()
		{
			$this->set('title_for_layout', __('Edition information', true));

			// Show the feedback message
			$this->shamrockFeedback->feedbackLoad();

			// Load the edition model and set the Edition id
			Controller::loadModel('Edition');
			$this->Edition->id = $this->_selectedEdition;
			$this->Edition->recursive = -1;

			if(!empty($this->data))
			{
				// Save the details
				if($this->Edition->save($this->data))
				{
					$this->shamrockFeedback->feedbackSave(__('The edition has been saved', true), 'success');
					$this->redirect(array('controller' => 'dashboard', 'edition' => $this->_selectedEdition), null, true);
				}
				else
				{
					$this->set('shamrockErrors', true);
				}
			}
			else
			{
				// Get information about the selected edition
				$this->data = $this->Edition->read();

				// Parse the start and end date for the datepicker
				list($year, $month, $day) = explode("-", $this->data['Edition']['start']);
				$this->data['Edition']['start'] = $day ."-". $month ."-". $year;
				list($year, $month, $day) = explode("-", $this->data['Edition']['end']);
				$this->data['Edition']['end'] = $day ."-". $month ."-". $year;
			}

			// Assign the values
			$this->set('editionDate', date('l d.m.y', strtotime($this->data['Edition']['start'])) ." - ". date('l d.m.y', strtotime($this->data['Edition']['end'])));
		}

		function generate_html()
		{
			// Prapare to render the view in a variable
			$this->autoRender = false;
			$this->layout = null;
			$view = new View($this, false);
			$view->viewPath = 'dashboard';

			// Let's rock				
			// Get the details about the selected edition
			$dataEdition = array_pop($this->Dashboard->query("
				SELECT *
				FROM `editions` AS `Edition`
				WHERE `Edition`.`id` = '". $this->_selectedEdition ."' 
				LIMIT 1
			"));
			$view->set('dataEdition', $dataEdition['Edition']);

			// Get the facebook subscribers
			$subscribers = array_pop($this->Dashboard->query("SELECT * FROM `extras` AS `Extra` WHERE `Extra`.`option` = 'STATS_NEWSLETTER' LIMIT 1;"));
			$view->set('subscribers', $subscribers['Extra']['value']);

			// Get the newsletter introduction
			$dataNewsletter = array_pop($this->Dashboard->query("
				SELECT * 
				FROM `editorials_newsletters` AS `Newsletter`
				WHERE 
					`Newsletter`.`editorial_id` = '". $this->_editorialID ."' 
				LIMIT 1 
			"));
			                                          
			
			$view->set('dataNewsletter', $dataNewsletter['Newsletter']);

			// Get the Content section 1
			$dataCS1 = array_pop($this->Dashboard->query("
				SELECT * 
				FROM `editorials_cs1s` AS `CS1`
				WHERE 
					`CS1`.`editorial_id` = '". $this->_editorialID ."' 
				LIMIT 1 
			"));
			$view->set('dataCS1', $dataCS1['CS1']);

			// Get the support
			$dataEC1 = array_pop($this->Dashboard->query("
				SELECT * 
				FROM `editorials_ec1s` AS `EC1`
				WHERE 
					`EC1`.`editorial_id` = '". $this->_editorialID ."' 
				LIMIT 1 
			"));
			$view->set('dataEC1', $dataEC1['EC1']);

			// Get the highlights
			$dataHighlights = array_pop($this->Dashboard->query("
				SELECT * 
				FROM `editorials_highlights` AS `Highlight`
				WHERE 
					`Highlight`.`editorial_id` = '". $this->_editorialID ."' 
				LIMIT 1 
			"));
			$view->set('dataHighlights', $dataHighlights['Highlight']);

			// Get the competitions
			$dataCompetitions = array_pop($this->Dashboard->query("
				SELECT * 
				FROM `editorials_competitions` AS `Competition`
				WHERE 
					`Competition`.`editorial_id` = '". $this->_editorialID ."' 
				LIMIT 1 
			"));
			$view->set('dataCompetitions', $dataCompetitions['Competition']);
			
			// Get the news
			$dataNews = array_pop($this->Dashboard->query("
				SELECT * 
				FROM `editorials_news` AS `News`
				WHERE 
					`News`.`editorial_id` = '". $this->_editorialID ."' 
				LIMIT 1 
			"));
			$view->set('dataNews', $dataNews['News']);
			


			// Get all the events dates
			$dataEvents = array();
			$dataDates = array();
			$dataEventsDates = $this->Dashboard->query("
				SELECT DISTINCT 
					`Event`.`start` 
				FROM `events` AS `Event`
				WHERE `Event`.`edition_id` = '". $this->_selectedEdition ."' 
				ORDER BY 
					`Event`.`start` ASC 
			");
			foreach($dataEventsDates as $date)
			{
				$dataEventsTemp = array();
				array_push($dataDates, strtotime($date['Event']['start']));
				$dataEventsTemp['dayID'] = strtotime($date['Event']['start']);
				$dataEventsTemp['day'] = date("l", strtotime($date['Event']['start']));
				$dataEventsTemp['date'] = date("d M", strtotime($date['Event']['start']));
				$dataEventsTemp['events'] = array();

				// Get all the events for the selected edition and the selected date
				$dataEventsDate = $this->Dashboard->query("
					SELECT 			
						`Event`.`id`, 
						`Event`.`title`, 
						`Event`.`start`, 
						`Event`.`stime`, 
						`Event`.`etime`, 
						`Event`.`address`, 
						`Event`.`link`, 
						`Event`.`category`, 
						`Event`.`highlight`,  
						`Event`.`weekly`,  
						`Event`.`summary`,  
						`Event`.`description`,  
						`Event`.`picturen` 
					FROM `events` AS `Event`
					WHERE 
						`Event`.`edition_id` = '". $this->_selectedEdition  ."' AND
						`Event`.`start` = '". $date['Event']['start'] ."'
					ORDER BY 
						`Event`.`stime` ASC, 
						`Event`.`title` ASC 
				");

				foreach($dataEventsDate as $event)
				{
					if(!empty($event['Event']['stime']))
					{
						$event['Event']['stime'] = substr($event['Event']['stime'], 0, -3);
					}
					if(!empty($event['Event']['etime']))
					{
						$event['Event']['etime'] = substr($event['Event']['etime'], 0, -3);
					}
					$event['Event']['start'] = date("D d M", strtotime($date['Event']['start']));
					array_push($dataEventsTemp['events'], $event['Event']);
				}
				array_push($dataEvents, $dataEventsTemp);
			}
			$view->set('eventsDates', $dataDates);
			$view->set('eventsData', $dataEvents);





			// Get the events coming up
			$dataComing = array_pop($this->Dashboard->query("
				SELECT * 
				FROM `editorials_events` AS `Coming`
				WHERE 
					`Coming`.`editorial_id` = '". $this->_editorialID ."' 
				LIMIT 1 
			"));
			$view->set('dataComing', $dataComing['Coming']);

			// Get the this is Content section 2
			$dataCS2 = array_pop($this->Dashboard->query("
				SELECT * 
				FROM `editorials_cs2s` AS `CS2`
				WHERE 
					`CS2`.`editorial_id` = '". $this->_editorialID ."' 
				LIMIT 1 
			"));
			$view->set('dataCS2', $dataCS2['CS2']);

			// Get the wrap up
			$dataOutro = array_pop($this->Dashboard->query("
				SELECT * 
				FROM `editorials_outros` AS `Outro`
				WHERE 
					`Outro`.`editorial_id` = '". $this->_editorialID ."' 
				LIMIT 1 
			"));
			$view->set('dataOutro', $dataOutro['Outro']);





			// Save the newletter code
			$viewOutput = $view->render('newsletter');
            $viewOutput = preg_replace('~>\s+<~', '><', $viewOutput);
			$this->layout = 'content';
			$this->set('htmlCode', $viewOutput);
			$this->render('generate_html');
		}

		function preview_newsletter()
		{
			$this->set('title_for_layout', __('Newsletter preview', true));

			// Let's rock				
			// Get the details about the selected edition
			$dataEdition = array_pop($this->Dashboard->query("
				SELECT *
				FROM `editions` AS `Edition`
				WHERE `Edition`.`id` = '". $this->_selectedEdition ."' 
				LIMIT 1
			"));
			$this->set('dataEdition', $dataEdition['Edition']);

			// Get the facebook subscribers
			$subscribers = array_pop($this->Dashboard->query("SELECT * FROM `extras` AS `Extra` WHERE `Extra`.`option` = 'STATS_NEWSLETTER' LIMIT 1;"));
			$this->set('subscribers', $subscribers['Extra']['value']);

			// Get the newsletter introduction
			$dataNewsletter = array_pop($this->Dashboard->query("
				SELECT * 
				FROM `editorials_newsletters` AS `Newsletter`
				WHERE 
					`Newsletter`.`editorial_id` = '". $this->_editorialID ."' 
				LIMIT 1 
			"));                                                        
		    
			$this->set('dataNewsletter', $dataNewsletter['Newsletter']);

			// Get the Content Section 1
			$dataCS1 = array_pop($this->Dashboard->query("
				SELECT * 
				FROM `editorials_cs1s` AS `CS1`
				WHERE 
					`CS1`.`editorial_id` = '". $this->_editorialID ."' 
				LIMIT 1 
			"));
			$this->set('dataCS1', $dataCS1['CS1']);

			// Get the support
			$dataEC1 = array_pop($this->Dashboard->query("
				SELECT * 
				FROM `editorials_ec1s` AS `EC1`
				WHERE 
					`EC1`.`editorial_id` = '". $this->_editorialID ."' 
				LIMIT 1 
			"));
			$this->set('dataEC1', $dataEC1['EC1']);

			// Get the highlights
			$dataHighlight = array_pop($this->Dashboard->query("
				SELECT * 
				FROM `editorials_highlights` AS `Highlight`
				WHERE 
					`Highlight`.`editorial_id` = '". $this->_editorialID ."' 
				LIMIT 1 
			"));
			$this->set('dataHighlights', $dataHighlight['Highlight']);

			// Get the competitions
			$dataCompetitions = array_pop($this->Dashboard->query("
				SELECT * 
				FROM `editorials_competitions` AS `Competition`
				WHERE 
					`Competition`.`editorial_id` = '". $this->_editorialID ."' 
				LIMIT 1 
			"));
			$this->set('dataCompetitions', $dataCompetitions['Competition']);
			
			// Get the news
			$dataNews = array_pop($this->Dashboard->query("
				SELECT * 
				FROM `editorials_news` AS `News`
				WHERE 
					`News`.`editorial_id` = '". $this->_editorialID ."' 
				LIMIT 1 
			"));
			$this->set('dataNews', $dataNews['News']);
			
            

			// Get all the events dates
			$dataEvents = array();
			$dataDates = array();
			$dataEventsDates = $this->Dashboard->query("
				SELECT DISTINCT 
					`Event`.`start` 
				FROM `events` AS `Event`
				WHERE `Event`.`edition_id` = '". $this->_selectedEdition ."' 
				ORDER BY 
					`Event`.`start` ASC 
			");
			foreach($dataEventsDates as $date)
			{
				$dataEventsTemp = array();
				array_push($dataDates, strtotime($date['Event']['start']));
				$dataEventsTemp['dayID'] = strtotime($date['Event']['start']);
				$dataEventsTemp['day'] = date("l", strtotime($date['Event']['start']));
				$dataEventsTemp['date'] = date("d M", strtotime($date['Event']['start']));
				$dataEventsTemp['events'] = array();

				// Get all the events for the selected edition and the selected date
				$dataEventsDate = $this->Dashboard->query("
					SELECT 			
						`Event`.`id`, 
						`Event`.`title`, 
						`Event`.`start`, 
						`Event`.`stime`, 
						`Event`.`etime`, 
						`Event`.`address`, 
						`Event`.`link`, 
						`Event`.`category`, 
						`Event`.`highlight`,  
						`Event`.`weekly`,  
						`Event`.`summary`,  
						`Event`.`description`,  
						`Event`.`picturen` 
					FROM `events` AS `Event`
					WHERE 
						`Event`.`edition_id` = '". $this->_selectedEdition  ."' AND
						`Event`.`start` = '". $date['Event']['start'] ."'
					ORDER BY 
						`Event`.`stime` ASC, 
						`Event`.`title` ASC 
				");

				foreach($dataEventsDate as $event)
				{
					if(!empty($event['Event']['stime']))
					{
						$event['Event']['stime'] = substr($event['Event']['stime'], 0, -3);
					}
					if(!empty($event['Event']['etime']))
					{
						$event['Event']['etime'] = substr($event['Event']['etime'], 0, -3);
					}
					$event['Event']['start'] = date("D d M", strtotime($date['Event']['start']));
					array_push($dataEventsTemp['events'], $event['Event']);
				}
				array_push($dataEvents, $dataEventsTemp);
			}
			$this->set('eventsDates', $dataDates);
			$this->set('eventsData', $dataEvents);





			// Get the events coming up
			$dataComing = array_pop($this->Dashboard->query("
				SELECT * 
				FROM `editorials_events` AS `Coming`
				WHERE 
					`Coming`.`editorial_id` = '". $this->_editorialID ."' 
				LIMIT 1 
			"));
			$this->set('dataComing', $dataComing['Coming']);

			// Get the this is CS2
			$dataCS2 = array_pop($this->Dashboard->query("
				SELECT * 
				FROM `editorials_cs2s` AS `CS2`
				WHERE 
					`CS2`.`editorial_id` = '". $this->_editorialID ."' 
				LIMIT 1 
			"));
			$this->set('dataCS2', $dataCS2['CS2']);

			// Get the wrap up
			$dataOutro = array_pop($this->Dashboard->query("
				SELECT * 
				FROM `editorials_outros` AS `Outro`
				WHERE 
					`Outro`.`editorial_id` = '". $this->_editorialID ."' 
				LIMIT 1 
			"));
			$this->set('dataOutro', $dataOutro['Outro']);





			$this->layout = 'newsletter';
			$this->render('newsletter');
		}
	}