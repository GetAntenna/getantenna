<aside id="sidebar" class="SF_right">
	<div id="sidebarWrapper">
		<div class="sidebarItem">
			<p><a class="button readyButton rhsButton" href="<?php echo Router::url(array('action' => 'add')); ?>">Add recurring event</a></p>
		</div>
		<div class="sidebarItem">
			<h4>Recurring Events</h4>
			<p>Recurring events differ from regular events in the following ways:</p>
			<p>All recurring events (within the date range) are copied to any new draft edition created. Once copied to a draft edition, these are marked as weekly events, and marked as draft events (although a minority may not be weekly, and will need to be manually updated.)</p>
			<p>After each edition is published, 7 days are added to the dates of the recurring events, as most of these are weekly. For non weekly events these need to be managed manually.</p>
			<p>If you create a new current event, it is not automatically added to current draft editions, but can be opened and copied manually.</p>
			<p>If an event date is outside of the range of a draft edition, it will not be copied in to that draft edition when it is created.</p>
		</div>
	</div>
</aside>