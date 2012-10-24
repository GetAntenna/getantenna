<?php
	ob_start();
	App::import('Sanitize');

	class ApiController extends AppController
	{
		public $name = 'Api';
		public $components = array('RequestHandler');

		public function beforeFilter()
		{
			parent::beforeFilter();

			// Change some Auth settings
			$this->shamrockAuthentication->allow(
				'index', 
				'events', 
				'categories', 
				'event', 
				'cs1', 
				'competitions', 
				'coming', 
				'news', 
				'cs2', 
				'about', 
				'submit', 
				'show', 
				'show_weekly', 
				'show_banner', 
				'autocomplete_addresses'
			);
		}



		/*
		========================================================================
			Initialize
		========================================================================
		*/

		public function index()
		{
			// Clear all the output
			ob_clean();
			$this->autoRender = false;

			// Get the current edition
			$dataEdition = $this->Api->query("
				SELECT *
				FROM `editions` AS `Edition`
				WHERE `Edition`.`published` = 1 
				ORDER BY `Edition`.`start`
				LIMIT 1
			");
            
			// Set the values
			$this->set('dataEdition', $dataEdition[0]);
			
			// Outputs the JSON data
			$this->render('json/index', 'json/default');
			ob_end_clean();
		}



		/*
		========================================================================
			Main list
		========================================================================
		*/

		public function events($id = null)
		{
			// Clear all the output
			ob_clean();
			$this->autoRender = false;

			if($id != null)
			{
				$dataEvents = array();

				// Get all the dates for the selected edition
				// We need to display only the available events
				if(date('G') < 6)
				{
					$dataEventsDates = $this->Api->query("
						SELECT DISTINCT 
							`Event`.`start` 
						FROM `events` AS `Event`
						WHERE `Event`.`edition_id` = '". $id ."' AND
							`Event`.`start` >= '". date("Y-m-d", time() - 60 * 60 * 24) ."'
						ORDER BY 
							`Event`.`start` ASC 
					");
				}
				else
				{
					$dataEventsDates = $this->Api->query("
						SELECT DISTINCT 
							`Event`.`start` 
						FROM `events` AS `Event`
						WHERE `Event`.`edition_id` = '". $id ."' AND
							`Event`.`start` >= '". date('Y-m-d') ."'
						ORDER BY 
							`Event`.`start` ASC 
					");
				}
				foreach($dataEventsDates as $date)
				{
					$dataEventsTemp = array();
					$dataEventsTemp['day'] = date("l", strtotime($date['Event']['start']));
					$dataEventsTemp['date'] = date("d M", strtotime($date['Event']['start']));
					$dataEventsTemp['events'] = array();

					// Get all the events for the selected edition and the selected date
					$dataEventsDate = $this->Api->query("
						SELECT 			
							`Event`.`id`, 
							`Event`.`title`, 
							`Event`.`start`, 
							`Event`.`stime`, 
							`Event`.`address`, 
							`Event`.`category`, 
							`Event`.`highlight` 
						FROM `events` AS `Event`
						WHERE 
							`Event`.`edition_id` = '". $id ."' AND
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
						array_push($dataEventsTemp['events'], $event['Event']);
					}
					array_push($dataEvents, $dataEventsTemp);
				}

				// Set the values
				$this->set('dataEvents', $dataEvents);

				// Outputs the JSON data
				$this->render('json/events', 'json/default');
				ob_end_clean();
			}
		}



		/*
		========================================================================
			Categories
		========================================================================
		*/

		public function categories($id = null)
		{
			// Clear all the output
			ob_clean();
			$this->autoRender = false;

			if($id != null)
			{
				if(date('G') < 6)
				{
					$dateFilter = "AND `Event`.`start` >= '". date("Y-m-d", time() - 60 * 60 * 24) ."'";
				}
				else
				{
					$dateFilter = "AND `Event`.`start` >= '". date('Y-m-d') ."'";
				}

				// Get all the events for the selected edition and the specific category
				$dataCategory = $this->Api->query("SELECT `Event`.`id` FROM `events` AS `Event` WHERE `Event`.`category` = 'category01' AND `Event`.`edition_id` = '". $id ."' ". $dateFilter);
				$this->set('category01', count($dataCategory));
				$dataCategory = $this->Api->query("SELECT `Event`.`id` FROM `events` AS `Event` WHERE `Event`.`category` = 'category02' AND `Event`.`edition_id` = '". $id ."' ". $dateFilter);
				$this->set('category02', count($dataCategory));
				$dataCategory = $this->Api->query("SELECT `Event`.`id` FROM `events` AS `Event` WHERE `Event`.`category` = 'category03' AND `Event`.`edition_id` = '". $id ."' ". $dateFilter);
				$this->set('category03', count($dataCategory));
				$dataCategory = $this->Api->query("SELECT `Event`.`id` FROM `events` AS `Event` WHERE `Event`.`category` = 'category04' AND `Event`.`edition_id` = '". $id ."' ". $dateFilter);
				$this->set('category04', count($dataCategory));
				$dataCategory = $this->Api->query("SELECT `Event`.`id` FROM `events` AS `Event` WHERE `Event`.`category` = 'category05' AND `Event`.`edition_id` = '". $id ."' ". $dateFilter);
				$this->set('category05', count($dataCategory));
				$dataCategory = $this->Api->query("SELECT `Event`.`id` FROM `events` AS `Event` WHERE `Event`.`category` = 'category06' AND `Event`.`edition_id` = '". $id ."' ". $dateFilter);
				$this->set('category06', count($dataCategory));
				$dataCategory = $this->Api->query("SELECT `Event`.`id` FROM `events` AS `Event` WHERE `Event`.`category` = 'category07' AND `Event`.`edition_id` = '". $id ."' ". $dateFilter);
				$this->set('category07', count($dataCategory));
				$dataCategory = $this->Api->query("SELECT `Event`.`id` FROM `events` AS `Event` WHERE `Event`.`category` = 'category08' AND `Event`.`edition_id` = '". $id ."' ". $dateFilter);
				$this->set('category08', count($dataCategory));
				$dataCategory = $this->Api->query("SELECT `Event`.`id` FROM `events` AS `Event` WHERE `Event`.`category` = 'category09' AND `Event`.`edition_id` = '". $id ."' ". $dateFilter);
				$this->set('category09', count($dataCategory));
				$dataCategory = $this->Api->query("SELECT `Event`.`id` FROM `events` AS `Event` WHERE `Event`.`category` = 'category10' AND `Event`.`edition_id` = '". $id ."' ". $dateFilter);
				$this->set('category10', count($dataCategory));
				$dataCategory = $this->Api->query("SELECT `Event`.`id` FROM `events` AS `Event` WHERE `Event`.`category` = 'category11' AND `Event`.`edition_id` = '". $id ."' ". $dateFilter);
				$this->set('category11', count($dataCategory));

				// Outputs the JSON data
				$this->render('json/categories', 'json/default');
				ob_end_clean();
			}
		}



		/*
		========================================================================
			Event details
		========================================================================
		*/

		public function event($id = null)
		{
			// Clear all the output
			ob_clean();
			$this->autoRender = false;

			if($id != null)
			{
				// Get the details about the single event
				$dataEvent = $this->Api->query("
					SELECT 			
						`Event`.`id`, 
						`Event`.`title`, 
						`Event`.`address`, 
						`Event`.`start`, 
						`Event`.`stime`, 
						`Event`.`etime`, 
						`Event`.`summary`, 
						`Event`.`description`, 
						`Event`.`link`, 
						`Event`.`lat`, 
						`Event`.`lon`, 
						`Event`.`category`, 
						`Event`.`highlight`,  
						`Event`.`weekly`,  
						`Event`.`picturen` 
					FROM `events` AS `Event`
					WHERE 
						`Event`.`id` = '". $id ."' 
				");

				$this->set('id', $dataEvent[0]['Event']['id']);
				$this->set('title', $dataEvent[0]['Event']['title']);
				$this->set('address', $dataEvent[0]['Event']['address']);
				$this->set('start', strtotime($dataEvent[0]['Event']['start']));
				$this->set('start_date', $dataEvent[0]['Event']['start']);
				if(!empty($dataEvent[0]['Event']['stime']))
				{
					$this->set('stime', substr($dataEvent[0]['Event']['stime'], 0, -3));
				}
				else
				{
					$this->set('stime', $dataEvent[0]['Event']['stime']);
				}
				if(!empty($dataEvent[0]['Event']['etime']))
				{
					$this->set('etime', substr($dataEvent[0]['Event']['etime'], 0, -3));
				}
				else
				{
					$this->set('etime', $dataEvent[0]['Event']['etime']);
				}
				$this->set('summary', $dataEvent[0]['Event']['summary']);
				$this->set('description', $dataEvent[0]['Event']['description']);
				$this->set('link', $dataEvent[0]['Event']['link']);
				$this->set('lat', $dataEvent[0]['Event']['lat']);
				$this->set('lon', $dataEvent[0]['Event']['lon']);
				$this->set('category', strtoupper($dataEvent[0]['Event']['category']));
				$this->set('highlight', $dataEvent[0]['Event']['highlight']);
				$this->set('weekly', $dataEvent[0]['Event']['weekly']);
				if($dataEvent[0]['Event']['picturen'] != '')
				{
					$this->set('picture', Router::url(array('controller' => 'api', 'action' => 'show', $dataEvent[0]['Event']['id']), true));
				}
				else
				{
					$this->set('picture', '');
				}

				// Outputs the JSON data
				$this->render('json/event', 'json/default');
				ob_end_clean();
			}
		}



		/*
		========================================================================
			Content section1
		========================================================================
		*/

		public function cs1($id = null)
		{
			// Clear all the output
			ob_clean();
			$this->autoRender = false;

			if($id != null)
			{
				// Get the id for the Editorial
				$dataEditorial = $this->Api->query("
					SELECT 			
						`Editorial`.`id` 
					FROM `editorials` AS `Editorial`
					WHERE 
						`Editorial`.`edition_id` = '". $id ."' 
					LIMIT 1 
				");
				$dataEditorialID = $dataEditorial[0]['Editorial']['id'];

				// Get Content section 1
				$dataCS1 = $this->Api->query("
					SELECT 			
						`CS1`.`content` 
					FROM `editorials_cs1s` AS `CS1`
					WHERE 
						`CS1`.`editorial_id` = '". $dataEditorialID ."' 
					LIMIT 1 
				");
				$this->set('content', $dataCS1[0]['CS1']['content']);

				// Outputs the JSON data
				$this->render('json/cs1', 'json/default');
				ob_end_clean();
			}
		}



		/*
		========================================================================
			Competitions
		========================================================================
		*/

		public function competitions($id = null)
		{
			// Clear all the output
			ob_clean();
			$this->autoRender = false;

			if($id != null)
			{
				// Get the id for the Editorial
				$dataEditorial = $this->Api->query("
					SELECT 			
						`Editorial`.`id` 
					FROM `editorials` AS `Editorial`
					WHERE 
						`Editorial`.`edition_id` = '". $id ."' 
					LIMIT 1 
				");
				$dataEditorialID = $dataEditorial[0]['Editorial']['id'];

				// Get the competitions
				$dataCompetitions = $this->Api->query("
					SELECT 			
						`Competition`.`title1`, 
						`Competition`.`date1`, 
						`Competition`.`location1`, 
						`Competition`.`description1`, 						 
						`Competition`.`title2`, 
						`Competition`.`date2`, 
						`Competition`.`location2`, 
						`Competition`.`description2`, 						 
						`Competition`.`title3`, 
						`Competition`.`date3`, 
						`Competition`.`location3`, 
						`Competition`.`description3`, 						 
						`Competition`.`title4`, 
						`Competition`.`date4`, 
						`Competition`.`location4`, 
						`Competition`.`description4`, 						 
						`Competition`.`title5`, 
						`Competition`.`date5`, 
						`Competition`.`location5`, 
						`Competition`.`description5`, 						 
						`Competition`.`title6`, 
						`Competition`.`date6`, 
						`Competition`.`location6`, 
						`Competition`.`description6` 						 
					FROM `editorials_competitions` AS `Competition`
					WHERE 
						`Competition`.`editorial_id` = '". $dataEditorialID ."' 
					LIMIT 1 
				");
				$this->set('dataCompetitions', $dataCompetitions[0]['Competition']);

				// Outputs the JSON data
				$this->render('json/competitions', 'json/default');
				ob_end_clean();
			}
		}



		


		/*
		========================================================================
			Events coming up
		========================================================================
		*/

		public function coming($id = null)
		{
			// Clear all the output
			ob_clean();
			$this->autoRender = false;

			if($id != null)
			{
				// Get the id for the Editorial
				$dataEditorial = $this->Api->query("
					SELECT 			
						`Editorial`.`id` 
					FROM `editorials` AS `Editorial`
					WHERE 
						`Editorial`.`edition_id` = '". $id ."' 
					LIMIT 1 
				");
				$dataEditorialID = $dataEditorial[0]['Editorial']['id'];

				// Get the events coming up
				$dataEvents = $this->Api->query("
					SELECT 			
						`Event`.`intro`, 
						`Event`.`title1`, 
						`Event`.`date1`, 
						`Event`.`location1`, 
						`Event`.`description1`, 						 
						`Event`.`title2`, 
						`Event`.`date2`, 
						`Event`.`location2`, 
						`Event`.`description2`, 						 
						`Event`.`title3`, 
						`Event`.`date3`, 
						`Event`.`location3`, 
						`Event`.`description3`, 						 
						`Event`.`title4`, 
						`Event`.`date4`, 
						`Event`.`location4`, 
						`Event`.`description4`, 						 
						`Event`.`title5`, 
						`Event`.`date5`, 
						`Event`.`location5`, 
						`Event`.`description5`, 						 
						`Event`.`title6`, 
						`Event`.`date6`, 
						`Event`.`location6`, 
						`Event`.`description6` 						 
					FROM `editorials_events` AS `Event`
					WHERE 
						`Event`.`editorial_id` = '". $dataEditorialID ."' 
					LIMIT 1 
				");
				$this->set('dataEvents', $dataEvents[0]['Event']);

				// Outputs the JSON data
				$this->render('json/coming', 'json/default');
				ob_end_clean();
			}
		}



		/*
		========================================================================
			News
		========================================================================
		*/

		public function news($id = null)
		{
			// Clear all the output
			ob_clean();
			$this->autoRender = false;

			if($id != null)
			{
				// Get the id for the Editorial
				$dataEditorial = $this->Api->query("
					SELECT 			
						`Editorial`.`id` 
					FROM `editorials` AS `Editorial`
					WHERE 
						`Editorial`.`edition_id` = '". $id ."' 
					LIMIT 1 
				");
				$dataEditorialID = $dataEditorial[0]['Editorial']['id'];

				// Get the news
				$dataNews = $this->Api->query("
					SELECT 			
						`News`.`title1`, 
						`News`.`description1`, 						 
						`News`.`title2`, 
						`News`.`description2`, 						 
						`News`.`title3`, 
						`News`.`description3`, 						 
						`News`.`title4`, 
						`News`.`description4`, 						 
						`News`.`title5`, 
						`News`.`description5`, 						 
						`News`.`title6`, 
						`News`.`description6` 						 
					FROM `editorials_news` AS `News`
					WHERE 
						`News`.`editorial_id` = '". $dataEditorialID ."' 
					LIMIT 1 
				");
				$this->set('dataNews', $dataNews[0]['News']);

				// Outputs the JSON data
				$this->render('json/news', 'json/default');
				ob_end_clean();
			}
		}



		/*
		========================================================================
			Content section 2
		========================================================================
		*/

		public function cs2($id = null)
		{
			// Clear all the output
			ob_clean();
			$this->autoRender = false;

			if($id != null)
			{
				// Get the id for the Editorial
				$dataEditorial = $this->Api->query("
					SELECT 			
						`Editorial`.`id` 
					FROM `editorials` AS `Editorial`
					WHERE 
						`Editorial`.`edition_id` = '". $id ."' 
					LIMIT 1 
				");
				$dataEditorialID = $dataEditorial[0]['Editorial']['id'];

				// Get the this is content section 2
				$dataCS2 = $this->Api->query("
					SELECT 			
						`CS2`.`content` 
					FROM `editorials_cs2s` AS `CS2`
					WHERE 
						`CS2`.`editorial_id` = '". $dataEditorialID ."' 
					LIMIT 1 
				");
				$this->set('content', $dataCS2[0]['CS2']['content']);

				// Outputs the JSON data
				$this->render('json/cs2', 'json/default');
				ob_end_clean();
			}
		}



		/*
		========================================================================
			About page
		========================================================================
		*/

		public function about()
		{
			// Clear all the output
			ob_clean();
			$this->autoRender = false;

			$mobile = array_pop($this->Api->query("SELECT * FROM `extras` AS `Extra` WHERE `Extra`.`option` = 'STATS_MOBILE' LIMIT 1;"));
			$this->set('mobile', $mobile['Extra']['value']);
			$facebook = array_pop($this->Api->query("SELECT * FROM `extras` AS `Extra` WHERE `Extra`.`option` = 'STATS_FACEBOOK' LIMIT 1;"));
			$this->set('facebook', $facebook['Extra']['value']);
			$newsletter = array_pop($this->Api->query("SELECT * FROM `extras` AS `Extra` WHERE `Extra`.`option` = 'STATS_NEWSLETTER' LIMIT 1;"));
			$this->set('newsletter', $newsletter['Extra']['value']);
			$intro = array_pop($this->Api->query("SELECT * FROM `extras` AS `Extra` WHERE `Extra`.`option` = 'ABOUT_INTRO' LIMIT 1;"));
			$this->set('intro', $intro['Extra']['value']);
			$outro = array_pop($this->Api->query("SELECT * FROM `extras` AS `Extra` WHERE `Extra`.`option` = 'ABOUT_OUTRO' LIMIT 1;"));
			$this->set('outro', $outro['Extra']['value']);
			$sponsor = array_pop($this->Api->query("SELECT * FROM `extras` AS `Extra` WHERE `Extra`.`option` = 'ABOUT_SPONSOR' LIMIT 1;"));
			$this->set('sponsor', $sponsor['Extra']['value']);

			// Outputs the JSON data
			$this->render('json/about', 'json/default');
			ob_end_clean();
		}



		/*
		========================================================================
			Submit events
		========================================================================
		*/

		public function submit()
		{
			// Clear all the output
			ob_clean();
			$this->autoRender = false;

			if(!empty($this->data))
			{
				$jsonData = json_decode($this->data, true);

				if($jsonData)
				{
					Controller::loadModel('SubmittedEvent');
					$this->SubmittedEvent->create();
					$this->SubmittedEvent->save($jsonData, false);
				}

				$submitStatus = 'OK';
			}
			else
			{
				$submitStatus = 'KO';
			}

			$this->set('submitStatus', $submitStatus);

			// Outputs the JSON data
			$this->render('json/submit', 'json/default');
			ob_end_clean();
		}



		/*
		========================================================================
			Images
		========================================================================
		*/

		public function show($id = null)
		{
			// Clear all the output
			ob_clean();
			$this->autoRender = false;

			if($id !== null)
			{
				$result = array_pop($this->Api->query("SELECT * FROM `events` AS `Event` WHERE `Event`.`id` = ". Sanitize::paranoid($id) ." LIMIT 1;"));

				// Show the image
				$this->set('inline', true);

				// Set some image parameters
				$this->set('type', $result['Event']['picturet']);
				$this->set('filename', $result['Event']['picturen']);

				// Send the data
				$this->set('data', base64_decode($result['Event']['pictured']));

				$this->render('show', 'picture');
				ob_end_clean();
			}
		}

		public function show_weekly($id = null)
		{
			// Clear all the output
			ob_clean();

			if($id !== null)
			{
				$result = array_pop($this->Api->query("SELECT * FROM `weekly_events` AS `WeeklyEvent` WHERE `WeeklyEvent`.`id` = ". Sanitize::paranoid($id) ." LIMIT 1;"));

				// Show the image
				$this->set('inline', true);

				// Set some image parameters
				$this->set('type', $result['WeeklyEvent']['picturet']);
				$this->set('filename', $result['WeeklyEvent']['picturen']);

				// Send the data
				$this->set('data', base64_decode($result['WeeklyEvent']['pictured']));

				$this->render('show', 'picture');
				ob_end_clean();
			}
		}

		public function show_banner()
		{
			// Clear all the output
			ob_clean();

			$name = array_pop($this->Api->query("SELECT * FROM `extras` AS `Extra` WHERE `Extra`.`option` = 'BANNER_NAME' LIMIT 1;"));
			$name = $name['Extra']['value'];

			if($name != '')
			{
				$type = array_pop($this->Api->query("SELECT * FROM `extras` AS `Extra` WHERE `Extra`.`option` = 'BANNER_TYPE' LIMIT 1;"));
				$type = $type['Extra']['value'];

				$data = array_pop($this->Api->query("SELECT * FROM `extras` AS `Extra` WHERE `Extra`.`option` = 'BANNER_DATA' LIMIT 1;"));
				$data = $data['Extra']['value'];

				// Show the image
				$this->set('inline', true);

				// Set some image parameters
				$this->set('type', $type);
				$this->set('filename', $name);

				// Send the data
				$this->set('data', base64_decode($data));

				$this->render('show', 'picture');
				ob_end_clean();
			}
		}
		
		public function subscribe_newsletter()
		{
			   echo 'http://us5.api.mailchimp.com/1.3/?output=OUTPUT_FORMAT&method=SOME-METHOD&[other parameters]';
		}



		/*
		========================================================================
			Address autocomplete
		========================================================================
		*/

		function autocomplete_addresses()
		{
			$autocompleteData = array();
			$counter = 1;

			$this->autoRender = false;
			$autocompleteEvents = $this->Api->query("
				SELECT DISTINCT 
					`Event`.`address`, CONCAT(`Event`.`lat`, '|', `Event`.`lon`) AS data
				FROM `events` AS Event 
				WHERE `Event`.`address` LIKE '%". $_GET['term'] ."%' 
				ORDER BY `Event`.`modified` DESC
			");
			foreach($autocompleteEvents as $autocompleteEvent)
			{
				array_push($autocompleteData, array('id' => $counter, 'address' => $autocompleteEvent['Event']['address'], 'data' => $autocompleteEvent[0]['data']));
				$counter++;
			}
			$autocompleteRecurringEvents = $this->Api->query("
				SELECT DISTINCT 
					`Event`.`address`, CONCAT(`Event`.`lat`, '|', `Event`.`lon`) AS data
				FROM `weekly_events` AS Event 
				WHERE `Event`.`address` LIKE '%". $_GET['term'] ."%' 
				ORDER BY `Event`.`modified` DESC
			");
			foreach($autocompleteRecurringEvents as $autocompleteRecurringEvent)
			{
				array_push($autocompleteData, array('id' => $counter, 'address' => $autocompleteRecurringEvent['Event']['address'], 'data' => $autocompleteRecurringEvent[0]['data']));
				$counter++;
			}
			$autocompleteScrapbookEvents = $this->Api->query("
				SELECT DISTINCT 
					`Event`.`address`, CONCAT(`Event`.`lat`, '|', `Event`.`lon`) AS data
				FROM `scrapbook_events` AS Event 
				WHERE `Event`.`address` LIKE '%". $_GET['term'] ."%' 
				ORDER BY `Event`.`modified` DESC
			");
			foreach($autocompleteScrapbookEvents as $autocompleteScrapbookEvent)
			{
				array_push($autocompleteData, array('id' => $counter, 'address' => $autocompleteScrapbookEvent['Event']['address'], 'data' => $autocompleteScrapbookEvent[0]['data']));
				$counter++;
			}

			echo json_encode($this->_encode($autocompleteData));
		}

		function _encode($ajaxData)
		{
			$temp = array();
			foreach ($ajaxData as $item)
			{
				array_push($temp, array(
					'id' => $item['data'],
					'label' => $item['address'],
					'value' => $item['address'],
				));
			}
			return $temp;
		}
	}