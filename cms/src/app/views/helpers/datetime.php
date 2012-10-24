<?php
	class DatetimeHelper extends AppHelper
	{
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