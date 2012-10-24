<?php
	class Edition extends AppModel
	{
		public $hasOne = array(
			'Editorial' => array('dependent' => true), 
		);
		public $hasMany = array(
			'Events' => array('dependent' => true), 
		);
		var $validate = array(
			'issue' => array(
				'rule' => 'notEmpty',
				'required' => true, 
			),
			'start' => array(
				'rule' => array('date', 'dmy'), 
				'required' => true, 
			),
			'end' => array(
				'rule' => array('date', 'dmy'), 
				'required' => true, 
			),
		);

		function beforeSave() 
		{
			// Convert the dates to the MySQL format
			list($day, $month, $year) = explode("-", $this->data['Edition']['start']);
			$this->data['Edition']['start'] = $year ."-". $month ."-". $day;
			list($day, $month, $year) = explode("-", $this->data['Edition']['end']);
			$this->data['Edition']['end'] = $year ."-". $month ."-". $day;

			$this->data['Edition']['stamp'] = time();

			return true;
		}

		function afterSave($created)
		{
			if($created)
			{
				// Get the published edition
				$currentEdition = $this->find('first', array(
					'conditions' => array(
						'published' => 1, 
					),
					'order' => array(
						'start DESC', 
					),
				));
				// Save the ID of the current published edition
				$currentEditionID = $currentEdition['Edition']['id'];
				// Get the editorial ID of the current edition
				$currentEditorial = $this->Editorial->find('first', array(
					'conditions' => array(
						'edition_id' => $currentEditionID, 
					),
				));

				$editionID = $this->getLastInsertID();
				$currentEditorialID = $currentEditorial['Editorial']['id'];

				// Setup the editorial
				$this->Editorial->create();
				$this->Editorial->set('edition_id', $editionID);
				$this->Editorial->save();
				$editorialID = $this->Editorial->getLastInsertID();
                
				$data_array = array('EditorialsNewsletter', 'EditorialsCs1', 'EditorialsEc1', 'EditorialsHighlight', 'EditorialsCompetition', 'EditorialsNews', 'EditorialsEvent', 'EditorialsCs2', 'EditorialsOutro');
				
				foreach ($data_array as $data) {
					$this->__unset_data($data, $currentEditionID, $editorialID);
				}
                
			}
			return true;
		}
		
		private function __unset_data($key, $currentEditorialID, $editorialID) {
			$data = $this->Editorial->{$key}->find('first', array(
				'conditions' => array(
					'editorial_id' => $currentEditorialID, 
				),
			));
			if ($data) {
				unset($data[$key]['id']);
				unset($data[$key]['created']);
				unset($data[$key]['modified']);
			} else {
				$data = array($key => array());
			}
			$data[$key]['editorial_id'] = $editorialID; 
			$data[$key]['draft'] = 1;
			$this->Editorial->{$key}->create();
			$this->Editorial->{$key}->save($data[$key]);
			return $data;                                  
		}
	}