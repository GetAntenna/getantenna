<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="it">
	<head>
		<title><?php echo $title_for_layout; ?> | <?php echo Configure::read('Application.core.name'); ?></title>
		<?php echo $this->element('header_common'); ?>
	</head>
	<body id="contentOnly">
		<div id="applicationWrapper" class="applicationWrapperSpaced">
			<div id="application" class="SF_clear">

				<?php echo $content_for_layout; ?>

			</div>
		</div>
		<?php echo $this->element('footer_scripts'); ?>
	</body>
</html>