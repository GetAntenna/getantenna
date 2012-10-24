<?php echo Configure::read('Application.core.name'); ?>\n\n
<?php printf(__('Your credentials for %s', true), Configure::read('Application.core.name')); ?>\n\n\n
<?php printf(__('Hi %s, ', true), $firstname); ?>\n
<?php printf(__('As you requested we are providing new credentials to allow you to login again into %s', true), Configure::read('Application.core.name')); ?>\n
\n
          <?php echo __('Username', true); ?>:</b> <?php echo $username; ?>\n
          <?php echo __('Password', true); ?>:</b> <?php echo $password; ?>\n
\n
<?php printf(__('You can login again to %s by pointing your web browser to %s', true), Configure::read('Application.core.name'), Configure::read('Application.url.login')); ?>\n
<?php echo __('Please remember that you can use also your email address to login into the application.', true); ?>\n\n\n
-------------------------------------------------------------------------------\n
<?php printf(__('Delivered by %s', true), Configure::read('Application.core.name')); ?>