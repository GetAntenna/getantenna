<?php
	class Editorial extends AppModel
	{
		public $belongsTo = array('Edition');
		public $hasOne = array(
			'EditorialsNewsletter' => array('dependent' => true), 
			'EditorialsCs1' => array('dependent' => true), 
			'EditorialsEc1' => array('dependent' => true), 
			'EditorialsHighlight' => array('dependent' => true), 
			'EditorialsCompetition' => array('dependent' => true), 
			'EditorialsNews' => array('dependent' => true), 
			'EditorialsEvent' => array('dependent' => true), 
			'EditorialsCs2' => array('dependent' => true), 
			'EditorialsOutro' => array('dependent' => true), 
		);
	}