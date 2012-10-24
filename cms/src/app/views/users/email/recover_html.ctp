<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en"> 
	<head> 
		<title><?php echo $title_for_layout; ?> | <?php echo Configure::read('Application.core.name'); ?></title>
	</head>
	<body style="font-family: 'Lucida Grande', 'Segoe UI', 'Segoe', 'Tahoma', Arial, Sans-serif; color: #626262; text-shadow: 0 1px 0 rgba(250, 250, 250, .75); width: 90%; margin: 20px auto 0; font-size: 13px; line-height: 16px;">
		<h1 style="font-size: 14px; margin-bottom: 30px; font-weight: normal;"><?php echo Configure::read('Application.core.name'); ?></h1>
		<h2 style="font-size: 20px; font-weight: bold; margin-bottom: 25px;"><?php printf(__('Your credentials for %s', true), Configure::read('Application.core.name')); ?></h2>
		<p><?php printf(__('Hi %s, ', true), $firstname); ?></p>
		<p><?php printf(__('As you requested we are providing new credentials to allow you to login again into %s', true), Configure::read('Application.core.name')); ?></p>
		<div style="margin: 25px 5%; border: 1px solid #92c8e2; padding: 8px 20px; background-color: #edf4ff;">
			<p><b><?php echo __('Username', true); ?>:</b> <?php echo $username; ?></p>
			<p><b><?php echo __('Password', true); ?>:</b> <?php echo $password; ?></p>
		</div>
		<p><?php printf(__('You can login again to %s by pointing your web browser to %s', true), Configure::read('Application.core.name'), '<a href="'. Configure::read('Application.url.login') .'">'. Configure::read('Application.url.login') .'</a>'); ?></p>
		<p><?php echo __('Please remember that you can use also your email address to login into the application.', true); ?></p>
		<div style="margin-top: 25px; border-top: 1px solid #ccc; padding-top: 20px; font-size: 12px; text-align: right;">
			<?php printf(__('Delivered by %s', true), Configure::read('Application.core.name')); ?>
		</div>
	</body> 
</html>