<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="it">
	<head>
		<title><?php echo $title_for_layout; ?> | <?php echo Configure::read('Application.core.name'); ?></title>
		<?php echo $this->element('header_common'); ?>
		<link rel="stylesheet" type="text/css" media="all" href="/styles/login.css" />
		<!--[if IE]> <link rel="stylesheet" type="text/css" media="all" href="/styles/login_ie.css" /> <![endif]-->
	</head>
	<body>
		<?php echo $this->element('noscript'); ?>
		<div class="SF_grid_16">
			<div class="grid_10 SF_gridalpha SF_gridomega prefix_3 suffix_3">

				<?php echo $content_for_layout; ?>
				<?php echo $this->element('credits'); ?>

			</div>
		</div>
		<?php echo $this->element('footer_debug'); ?>
		<?php echo $this->element('footer_scripts'); ?>
		<script type="text/javascript" src="/scripts/jquery.vibrate.js"></script>
	</body>
</html>