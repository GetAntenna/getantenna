<aside id="sidebar" class="SF_right">
	<div id="sidebarWrapper">
		<div class="sidebarItem">
			<?php 
				if(!$readonly)
				{
			?>
			<p><a class="button readyButton rhsButton" href="<?php echo Router::url(array('action' => 'add', 'edition' => $selectedEdition)); ?>">Add event</a></p>
			<?php
				}
			?>
			<p><a class="admin previewEmail" href="<?php echo Router::url(array('controller' => 'dashboard', 'action' => 'preview_newsletter', 'edition' => $selectedEdition)); ?>" target="_blank">Preview email</a></p>
		</div>
		<div class="sidebarItem">
			<h4>Events</h4>
			<p>Use this view as an overview of the events for the event guide.</p>
			<p>You can add events here.</p>
			<p>You can use any one of the filters at a time to search the list. The results will always be displayed in chronological order. </p>
		</div>
	</div>
</aside>