<?php
	header('Content-type: '. $type);
	if(!isset($inline))
	{
		header('Content-Disposition: attachment; filename="'. $filename .'"');
	}
	echo $content_for_layout;
	die();