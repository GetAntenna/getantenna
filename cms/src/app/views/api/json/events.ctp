antenna_el({
	<?php
		$startingDay = 1;
		$lastEventGroup = end($dataEvents);
		foreach($dataEvents as $eventGroup)
		{
	?>
	"day<?php echo $startingDay; ?>":
		{
			"day": "<?php echo $eventGroup['day']; ?>",
	      "date": "<?php echo $eventGroup['date']; ?>",
	      "events":
			[
				<?php
					$lastEvent = end($eventGroup['events']);
					foreach($eventGroup['events'] as $event)
					{
				?>
				{
					"EVENT_ID": <?php echo $event['id']; ?>, 
					"CATEGORY": "<?php echo strtoupper($event['category']); ?>", 
					"TITLE": <?php echo json_encode($event['title']); ?>, 
					"TIME": "<?php echo $event['stime']; ?>", 
					"LOCATION": <?php echo json_encode($event['address']); ?>, 
					"HIGHLIGHT": "<?php echo $event['highlight']; ?>" 
				}<?php if($event != $lastEvent) { ?>,<?php } ?>
				<?php
					}
				?>
			]
		}<?php if($eventGroup != $lastEventGroup) { ?>,<?php } ?>
	<?php
			$startingDay++;
		}
	?>
});