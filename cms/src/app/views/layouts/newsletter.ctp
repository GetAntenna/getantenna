<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="it">
	<head>
		<title><?php echo $title_for_layout; ?> | <?php echo Configure::read('Application.core.name'); ?></title>
		<meta charset="<?php echo strtolower(Configure::read('App.encoding')); ?>" />
		<script type="text/javascript">window.resizeTo(850,650)</script>
	</head>
	<body id="newsletter">
		<div id="applicationWrapper" class="applicationNewsletter">
			<div id="application" class="SF_clear">

				<?php echo $content_for_layout; ?>

			</div>
		</div>
	</body>
</html>