<?php
	class SubmittedEvent extends AppModel
	{
		function beforeSave() 
		{
			// Convert the dates to the MySQL format
			list($day, $month, $year) = explode(".", $this->data['SubmittedEvent']['start']);
			$this->data['SubmittedEvent']['start'] = $year ."-". $month ."-". $day;

			// Set the end time to null if empty
			if($this->data['SubmittedEvent']['etime'] == '')
			{
				$this->data['SubmittedEvent']['etime'] = null;
			}

			return true;
		}
	}