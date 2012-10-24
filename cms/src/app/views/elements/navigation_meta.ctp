<div id="metaNavigationWrapper" class="fancyy">
			<header id="metaNavigation">
				<div id="metaLogo" class="SF_left"><a href="<?php echo Router::url(array('controller' => 'editions', 'action' => 'index')); ?>"><img src="<?php echo $this->webroot; ?>images/logo_meta.png" width="43" height="43" alt="" /></a></div>
				<div class="SF_right">
					<a class="userProfileLink" href="<?php echo Router::url(array('controller' => 'users', 'action' => 'profile')); ?>"><img src="<?php echo $this->webroot; ?>images/silhouette.20x20.png" width="20" height="20" alt="<?php printf(__('Profile picture of %s', true), $userFirstName); ?>" id="metaAvatar" /></a> <?php echo $userFirstName; ?> (<?php echo $userEmail; ?>) | 
					<a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'profile')); ?>"><?php __('My profile', false); ?></a> |
					<a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'logout')); ?>" class="admin"><?php __('Log out', false); ?></a>
				</div>
			</header>
		</div>
