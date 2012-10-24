<?php  
	class shamrockDatetimeComponent
	{ 
		var $settings = array();

		function initialize(&$controller, $config = array())
		{
			// Set some initial variables
			$this->settings = array_merge($this->settings, $config);
			$this->controller = &$controller; 
		} 

		function inRange($date, $start, $end)
		{
		  // Convert to timestamp
		  $startTS = strtotime($start);
		  $endTS = strtotime($end);
		  $dateTS = strtotime($date);

		  // Check that user date is between start & end
		  return (($dateTS >= $startTS) && ($dateTS <= $endTS));
		}
	} 
