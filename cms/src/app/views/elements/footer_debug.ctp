<?php if(Configure::read('debug') > 0) { ?>
<div style="clear: both">
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo $this->webroot; ?>styles/debug.css" /> <!-- debug.css -->
	<?php echo $this->Session->flash(); ?>
	<?php echo $this->element('sql_dump'); ?>
</div>
<?php } ?>                                 