antenna_ev({
	"TITLE": <?php echo json_encode($title); ?>,
	"ADDRESS": <?php echo json_encode($address); ?>,
	"DATE": "<?php echo $start; ?>",
	"DATE_START": "<?php echo $start_date; ?>",
	"START_TIME": "<?php echo $stime; ?>",
	"END_TIME": "<?php echo $etime; ?>",
	"SUMMARY": <?php echo json_encode($summary); ?>,
	"DESCRIPTION": <?php echo json_encode($description); ?>,
	"LINK": "<?php echo $link; ?>",
	"LAT": "<?php echo $lat; ?>",
	"LONG": "<?php echo $lon; ?>",
	"CATEGORY": "<?php echo $category; ?>",
	"HIGHLIGHT": "<?php echo $highlight; ?>",
	"STATUS": "2",
	"PHOTO": "<?php echo $picture; ?>",
	"WEEKLY": "<?php echo $weekly; ?>",
	"CANCELLED": "0"
});