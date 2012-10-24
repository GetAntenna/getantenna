<nav id="primaryNavigation">
				<?php
					if(empty($selectedEdition))
					{
				?>
					<ul>
						<?php if(!$isUser) { ?>
						<li<?php if($this->params['controller'] == 'editions') { echo ' class="selected"'; } ?>>
							<a href="<?php echo Router::url(array('controller' => 'editions', 'action' => 'index')); ?>"<?php if($this->params['controller'] == 'editions') { echo ' class="selected"'; } ?>>Editions</a>
						</li>
						<?php } ?>
						<?php if(!$isUser) { ?>
						<li<?php if($this->params['controller'] == 'weekly_events') { echo ' class="selected"'; } ?>>
							<a href="<?php echo Router::url(array('controller' => 'weekly_events', 'action' => 'index')); ?>"<?php if($this->params['controller'] == 'weekly_events') { echo ' class="selected"'; } ?>>Recurring Events</a>
						</li>
						<?php } ?>
						<?php if(!$isUser) { ?>
						<li<?php if($this->params['controller'] == 'scrapbook_events') { echo ' class="selected"'; } ?>>
							<a href="<?php echo Router::url(array('controller' => 'scrapbook_events', 'action' => 'index')); ?>"<?php if($this->params['controller'] == 'scrapbook_events') { echo ' class="selected"'; } ?>>Events Scrapbook</a>
						</li>
						<?php } ?>
						<?php if(!$isUser) { ?>
						<li<?php if($this->params['controller'] == 'submitted_events') { echo ' class="selected"'; } ?>>
							<a href="<?php echo Router::url(array('controller' => 'submitted_events', 'action' => 'index')); ?>"<?php if($this->params['controller'] == 'submitted_events') { echo ' class="selected"'; } ?>>Submitted Events</a>
						</li>
						<?php } ?>
						<?php if(!$isUser) { ?>
						<li<?php if($this->params['controller'] == 'extras') { echo ' class="selected"'; } ?>>
							<a href="<?php echo Router::url(array('controller' => 'extras', 'action' => 'index')); ?>"<?php if($this->params['controller'] == 'extras') { echo ' class="selected"'; } ?>>About &amp; Statistics</a>
						</li>
						<?php } ?>
					</ul>
				<?php
					}
					else
					{
				?>
					<ul>
						<?php if(!$isUser) { ?>
						<li<?php if($this->params['controller'] == 'events') { echo ' class="selected"'; } ?>>
							<a href="<?php echo Router::url(array('controller' => 'events', 'action' => 'index', 'edition' => $selectedEdition)); ?>"<?php if($this->params['controller'] == 'events') { echo ' class="selected"'; } ?>>Events</a>
						</li>
						<?php } ?>
						<?php if(!$isUser) { ?>
						<li<?php if($this->params['controller'] == 'editorials') { echo ' class="selected"'; } ?>>
							<a href="<?php echo Router::url(array('controller' => 'editorials', 'action' => 'index', 'edition' => $selectedEdition)); ?>"<?php if($this->params['controller'] == 'editorials') { echo ' class="selected"'; } ?>>Event editorial &amp; content</a>
						</li>
						<?php } ?>
						<?php if(!$isUser) { ?>
						<li<?php if($this->params['controller'] == 'dashboard') { echo ' class="selected"'; } ?>>
							<a href="<?php echo Router::url(array('controller' => 'dashboard', 'action' => 'index', 'edition' => $selectedEdition)); ?>"<?php if($this->params['controller'] == 'dashboard') { echo ' class="selected"'; } ?>>Edition information</a>
						</li>
						<?php } ?>
					</ul>
				<?php
					}
				?>
			</nav>
