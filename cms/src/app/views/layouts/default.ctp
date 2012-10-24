<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="it">
	<head>
		<title><?php echo $title_for_layout; ?> | <?php echo Configure::read('Application.core.name'); ?></title>
		<?php echo $this->element('header_common'); ?>
	</head>
	<body>
		<?php echo $this->element('noscript'); ?>
		<?php echo $this->element('navigation_meta'); ?>
		<div id="applicationWrapper">
			<?php echo $this->element('navigation_primary'); ?>
			<div id="application" class="SF_clear">

				<?php echo $content_for_layout; ?>

			</div>
			<?php echo $this->element('credits'); ?>
		</div>
		<?php echo $this->element('footer_debug'); ?>
		<?php echo $this->element('footer_scripts'); ?>
	</body>
</html>