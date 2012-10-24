<div id="contentWrapper" class="SF_left">
	<div id="contentHeader" class="SF_niceclear">
		<div id="contentHeaderMargin" class="SF_niceclear">
			<h1>Edit recurring event <span>(<a class="admin" href="<?php echo Router::url(array('action' => 'index')); ?>"><?php __('Cancel', false); ?></a>)</span></h1>
			<div id="sectionToolbar">
				<a class="button deleteButton" href="#eventDelete" rel="shadowbox;height=220"><span><?php __('Delete', false); ?></span></a>
				<a class="button" href="#eventMove" rel="shadowbox;height=198"><span><?php __('Move to scrapbook', false); ?></span></a>
				<a class="button cloneButton spacedButton" href="#eventAttach" rel="shadowbox;height=252"><span><?php __('Attach to draft editions', false); ?></span></a>
				<button type="submit" class="readyButton" id="readyButtonTop" form="WeeklyEventEditForm"><span><?php __('Save', false); ?></span></button>
			</div>
		</div>
	</div>
	<section id="content" class="SF_niceclear">

		<?php if(isset($shamrockFeedback)) { echo $shamrockFeedback; } ?>

		<?php if(isset($shamrockErrors) && $shamrockErrors == true) { ?><div class="feedback feedbackError"><?php __('<b>Oops, something wasn&#39;t right.</b> Can you review the data you entered?', false); ?></div><?php } ?>

		<?php echo $this->Form->create(null, array('url' => array('action' => 'edit', $eventId), 'enctype' => 'multipart/form-data')); ?>
			<?php echo $this->Form->input('id', array('type' => 'hidden',  'label' => false,  'error' => false, )); ?>
			<?php echo $this->Form->input('lat', array('type' => 'hidden',  'label' => false,  'error' => false, 'id' => 'eventLat', )); ?>
			<?php echo $this->Form->input('lon', array('type' => 'hidden',  'label' => false,  'error' => false, 'id' => 'eventLon', )); ?>
			<?php echo $this->Form->input('picturen', array('type' => 'hidden',  'label' => false,  'error' => false, 'id' => 'pictureName', )); ?>
			<div id="fieldsWrapper">
				<fieldset>

					<div class="SF_clear">
						<div class="formRowInlineHalf formRow<?php if($form->error('WeeklyEvent.title')) { echo ' formRowError'; } ?>">
							<div><label for="eventTitle"><?php __('Name of event', false); ?></label></div>
							<div<?php if($form->error('WeeklyEvent.title')) { echo ' class="fieldError"'; } ?>><?php 
								echo $this->Form->input('title', array(
									'type' => 'text', 
									'label' => false, 
									'error' => false,
									'id'=>'eventTitle', 
									'placeholder' => 'Event_title_goes_here_this_long',
								)); ?>
							</div>
							<?php if($form->error('WeeklyEvent.title')) { ?><p class="formTip"><?php __('The name of the event is required', false); ?></p><?php } ?>
						</div>

						<div class="formRowInlineHalf formRow<?php if($form->error('WeeklyEvent.category')) { echo ' formRowError'; } ?>">
							<div><label for="eventcategory"><?php __('Category', false); ?></label></div>
							<div<?php if($form->error('WeeklyEvent.category')) { echo ' class="fieldError"'; } ?>><?php 
								echo $this->Categories->categorySelect('WeeklyEvent.category', array(
									'label' => false, 
									'error' => false,
									'id' => 'eventCategory', 								
								)); ?>
							</div>
							<?php if($form->error('WeeklyEvent.category')) { ?><p class="formTip"><?php __('The category of the event is required', false); ?></p><?php } ?>
						</div>
					</div>

					<div class="SF_clear">
						<div class="formRowInline formRow<?php if($form->error('WeeklyEvent.start')) { echo ' formRowError'; } ?>">
							<div><label for="eventStartDate"><?php __('Date', false); ?></label></div>
							<div<?php if($form->error('WeeklyEvent.start')) { echo ' class="fieldError"'; } ?>><?php 
								echo $this->Form->input('start', array(
									'type' => 'text', 
									'label' => false, 
									'error' => false,
									'id' => 'eventStartDate', 
								)); ?>
							</div>
							<?php if($form->error('WeeklyEvent.start')) { ?><p class="formTip"><?php __('The event start date is not valid', false); ?></p><?php } ?>
						</div>

						<div class="formRowInline formRow<?php if($form->error('WeeklyEvent.stime')) { echo ' formRowError'; } ?>">
							<div><label for="eventStartTime"><?php __('Start time', false); ?></label></div>
							<div<?php if($form->error('WeeklyEvent.stime')) { echo ' class="fieldError"'; } ?>><?php 
								echo $this->Form->input('stime', array(
									'type' => 'text', 
									'label' => false, 
									'error' => false,
									'id' => 'eventStartTime', 
									'placeholder' => '18:00', 
								)); ?>
							</div>
							<?php if($form->error('WeeklyEvent.stime')) { ?><p class="formTip"><?php __('The event start time is not valid', false); ?></p><?php } ?>
						</div>

						<div class="formRowInline formRow<?php if($form->error('WeeklyEvent.etime')) { echo ' formRowError'; } ?>">
							<div><label for="eventEndTime"><?php __('End time (optional)', false); ?></label></div>
							<div<?php if($form->error('WeeklyEvent.etime')) { echo ' class="fieldError"'; } ?>><?php 
								echo $this->Form->input('etime', array(
									'type' => 'text', 
									'label' => false, 
									'error' => false,
									'id' => 'eventEndTime', 
								)); ?>
							</div>
							<?php if($form->error('WeeklyEvent.etime')) { ?><p class="formTip"><?php __('The event end time is not valid', false); ?></p><?php } ?>
						</div>

						<div class="formRowInline formRow">
							<div>&nbsp;</div>
							<div>
								<?php 
									echo $this->Form->input('highlight', array(
										'type' => 'checkbox', 
										'label' => false, 
										'error' => false,
										'id' => 'eventHighlight', 
								)); ?>
								<label for="eventHighlight" class="underlinedLabel"><?php __('Highlight', false); ?></label>
							</div>
						</div>
					</div>

					<div id="autocompleteAddress" class="formRowInlineHalf formRow<?php if($form->error('WeeklyEvent.address')) { echo ' formRowError'; } ?>">
						<div><label for="eventAddress"><?php __('Address', false); ?></label></div>
						<div<?php if($form->error('WeeklyEvent.address')) { echo ' class="fieldError"'; } ?>><?php 
							echo $this->Ajax->autoComplete('address', array(
								'type' => 'text', 
								'error' => false,
								'autocomplete' => 'off',
								'id'=>'eventAddress', 
								'class' => 'smallField', 
								'placeholder' => 'Location or street address', 
								'source' => array(
									'controller' => 'api',
									'action' => 'autocomplete_addresses',
								),
								'select' => 'function(event, ui)
									{
										var tokens = ui.item.id.split("|");
										jQuery("#eventLat").val(tokens[0]);
										jQuery("#eventLon").val(tokens[1]);
									}',
								'minLength' => 2,
								'appendTo' => "'#autocompleteAddress'", 
								'position' => " { collision: 'none' }",
							)); ?>
							<a href="#eventLocation" rel="shadowbox;height=500;width=700;" id="eventAddressLookup" class="button buttonLocation<?php if($this->data['WeeklyEvent']['lat'] != '') echo ' readyButton'; ?>"><img src="<?php echo $this->webroot; ?>images/icon_marker.png" /></a>
						</div>
						<?php if($form->error('WeeklyEvent.address')) { ?><p class="formTip"><?php __('The address of the event is required', false); ?></p><?php } ?>
					</div>

				</fieldset>

				<fieldset>
					<div class="formRow<?php if($form->error('WeeklyEvent.summary')) { echo ' formRowError'; } ?>">
						<div><label for="eventSummary"><?php __('i. Event summary - what is the event', false); ?>: </label></div>
						<div<?php if($form->error('WeeklyEvent.summary')) { echo ' class="fieldError"'; } ?>><?php 
							echo $this->Form->input('summary', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id' => 'eventSummary', 
							)); ?>
						</div>
						<?php if($form->error('WeeklyEvent.summary')) { ?><p class="formTip"><?php __('The summary of the event is required', false); ?></p><?php } ?>
					</div>

					<div class="formRow">
						<div><label for="eventDescription"><?php __('ii. About the event, organization or venue', false); ?>:</label></div>
						<div<?php if($form->error('WeeklyEvent.description')) { echo ' class="fieldError"'; } ?>><?php 
							echo $this->Form->input('description', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id' => 'eventDescription', 
							)); ?>
						</div>
					</div>

					<div class="formRow">
						<div><label for="eventLink"><?php __('URL for mobile button &\'More at:\'', false); ?>:</label></div>
						<div<?php if($form->error('WeeklyEvent.link')) { echo ' class="fieldError"'; } ?>><?php 
							echo $this->Form->input('link', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'eventLink', 
								'placeholder' => 'http://',
							)); ?>
						</div>
					</div>

				</fieldset>

				<fieldset>
					<div class="formRow<?php if($form->error('WeeklyEvent.picture')) { echo ' formRowError'; } ?>">
						<div><label for="eventPicture"><?php __('Optional image', false); ?>:</label></div>
						<div<?php if($form->error('WeeklyEvent.picture')) { echo ' class="fieldError"'; } ?>><?php 
							echo $this->Form->input('picture', array(
								'type' => 'file', 
								'label'=>false, 
								'error' => false,
								'id'=>'eventPicture', 
							)); ?>
						</div>
						<?php if($form->error('WeeklyEvent.picture')) { ?><p class="formTip"><?php __('The picture is not valid. Is this an image?', false); ?></p><?php } ?>
					</div>
					<?php 
						if($this->data['WeeklyEvent']['picturen'] != '')
						{
					?>
					<p class="formExplanation spacedTop" id="linkImageShow"><a href="#">Show current picture</a> | <a href="#" class="linkImageRemove">Remove picture</a></p>
					<div class="formRow SF_hidden" id="pictureCurrent">
						<p><img src="<?php echo Router::url(array('controller' => 'api', 'action' => 'show_weekly', $eventId)); ?>" class="eventImage"></p>
						<p class="formExplanation spacedTop" id="linkImageHide"><a href="#">Hide current picture</a> | <a href="#" class="linkImageRemove">Remove picture</a></p>
					</div>
					<script type="text/javascript">
						jQuery(document).ready(function()
							{
								jQuery('#linkImageShow').bind('click.clover', function()
									{
										jQuery('#pictureCurrent').slideDown();
										jQuery('#linkImageShow').hide();
										return false;
									});
								jQuery('#linkImageHide').bind('click.clover', function()
									{
										jQuery('#pictureCurrent').slideUp('400', function()
											{
												jQuery('#linkImageShow').show();
											});
										return false;
									});
								jQuery('.linkImageRemove').bind('click.clover', function()
									{
										jQuery('#linkImageShow').hide();
										jQuery('#pictureCurrent').hide();
										jQuery('#linkImageHide').hide();
										jQuery('#pictureName').val('');
										return false;
									});
							});
					</script>
					<?php
						}
					?>
				</fieldset>
			</div>

			<div class="separator"></div>

			<div class="actions SF_niceclear">
				<div class="actionsPrimary">
					<a class="button deleteButton" href="#eventDelete" rel="shadowbox;height=220"><span><?php __('Delete', false); ?></span></a>
					<a class="button" href="#eventMove" rel="shadowbox;height=198"><span><?php __('Move to scrapbook', false); ?></span></a>
					<a class="button cloneButton spacedButton" href="#eventAttach" rel="shadowbox;height=252"><span><?php __('Attach to draft editions', false); ?></span></a>
					<button type="submit" class="readyButton" id="readyButton"><span><?php __('Save', false); ?></span></button>
				</div>
				<div class="actionsSecondary">
					<a class="admin" href="<?php echo Router::url(array('action' => 'index')); ?>"><?php __('Cancel', false); ?></a>
				</div>
			</div>
		<?php echo $this->Form->end(); ?>

		<div id="eventLocation" class="SF_hidden">
			<div class="SBContent">
				<h2>Drag the marker to the correct location</h2>
				<div class="SBContentInnerWrapper"><div class="SBContentInner" style="width: 660px; height: 370px;"></div></div>
				<div class="separator"></div>
				<div class="actions SF_niceclear">
					<div class="actionsPrimary">
						<a class="button" href="javascript:Shadowbox.close()"><?php __('I\'m done', false); ?></a>
					</div>
					<div class="actionsSecondary">
						<a class="admin" href="javascript:Shadowbox.close()"><?php __('Cancel', false); ?></a>
					</div>
				</div>
			</div>
		</div>

		<div id="eventDelete" class="SF_hidden">
			<div class="SBContent">
				<?php echo $this->Form->create("removeItem", array('url' => array('controller' => 'weekly_events', 'action' => 'delete'))); ?>
					<?php echo $this->Form->input('id', array('label' => false, 'error' => false, 'type' => 'hidden', 'value' => $eventId)); ?>
					<h1>Remove this recurring event?</h1>
				
					<div class="separator"></div>
				
					<p>If you delete this recurring event it will be removed from the system</p>
					<p><strong>Please note this operation can't be undone</strong></p>

					<div class="separator"></div>

					<div class="actions SF_niceclear">
						<div class="actionsPrimary">
							<button type="submit"><span><?php __('I understand, remove this event', false); ?></span></button>
						</div>
						<div class="actionsSecondary">
							<a class="admin" href="javascript:Shadowbox.close()"><?php __('Cancel', false); ?></a>
						</div>
					</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>

		<div id="eventMove" class="SF_hidden">
			<div class="SBContent">
				<?php echo $this->Form->create("moveItem", array('url' => array('controller' => 'weekly_events', 'action' => 'move'))); ?>
					<?php echo $this->Form->input('id', array('label' => false, 'error' => false, 'type' => 'hidden', 'value' => $eventId)); ?>
					<h1>Move this event to scrapbook events?</h1>
				
					<div class="separator"></div>
				
					<p>If you move this event to scrapbook it will be removed from the recurring events and added to the scrapbook events</p>

					<div class="separator"></div>

					<div class="actions SF_niceclear">
						<div class="actionsPrimary">
							<button type="submit"><span><?php __('I understand, move this event', false); ?></span></button>
						</div>
						<div class="actionsSecondary">
							<a class="admin" href="javascript:Shadowbox.close()"><?php __('Cancel', false); ?></a>
						</div>
					</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>

		<div id="eventAttach" class="SF_hidden">
			<div class="SBContent">
				<?php echo $this->Form->create("attachItem", array('url' => array('controller' => 'weekly_events', 'action' => 'attach'))); ?>
					<?php echo $this->Form->input('id', array('label' => false, 'error' => false, 'type' => 'hidden', 'value' => $eventId)); ?>
					<h1>Attach to draft editions?</h1>
				
					<div class="separator"></div>
				
					<p>When you attach this recurring event to the draft editions it will be added to the system as draft</p>
					<p><strong>Please note you need to change the details on the copied version, not on this one</strong></p>

					<div class="separator"></div>

					<div class="actions SF_niceclear">
						<div class="actionsPrimary">
							<button type="submit"><span><?php __('I understand, attach this event', false); ?></span></button>
						</div>
						<div class="actionsSecondary">
							<a class="admin" href="javascript:Shadowbox.close()"><?php __('Cancel', false); ?></a>
						</div>
					</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>

		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<script type="text/javascript">
			// Map constants
			var mapCenter = new google.maps.LatLng(<?php if($this->data['WeeklyEvent']['lat'] != '' ) echo $this->data['WeeklyEvent']['lat']; else echo Configure::read('Application.map.lat'); ?>, <?php if($this->data['WeeklyEvent']['lon'] != '' ) echo $this->data['WeeklyEvent']['lon']; else echo Configure::read('Application.map.lon'); ?>)
			
			

			function shadowBoxFinish()
			{
				var mapOptions = null, geocoder = null, map = null, marker = null, $mapCanvas = null;

				// Map options
				mapOptions =
					{
						zoom: 16,
						mapTypeId: google.maps.MapTypeId.ROADMAP,
						center: mapCenter,
						streetViewControl: false
					}

				$mapCanvas = jQuery('#sb-player .SBContentInner');
				if($mapCanvas.length > 0)
				{
					map = new google.maps.Map($mapCanvas[0], mapOptions);
					marker = new google.maps.Marker({position: mapCenter, title: ""});
					marker.setMap(map);
					marker.setDraggable(true);

					google.maps.event.addListener(marker, "dragend", function(event)
						{
							var point = marker.getPosition();
							jQuery('#eventLat').val(point.lat());
							jQuery('#eventLon').val(point.lng());
						});
				}
			}

			jQuery(document).ready(function()
				{
					// Datepicker
					jQuery("#eventStartDate").datepicker(
						{
							changeMonth: false,
							numberOfMonths: 3,
							firstDay: 1,
							dateFormat: 'dd-mm-yy'
						});

					// Blur on the address
					jQuery('#eventAddressLookup').bind('click.clover', function()
						{
							if((jQuery('#eventLat').val() == '') || (jQuery('#eventLat').val() == undefined))
							{
								// Geodecode the address                                                       
								var geocoder = new google.maps.Geocoder();
								var address = jQuery('#eventAddress').val() + ', <?php echo Configure::read('Application.map.geocode_city_country'); ?>';

								// Decode the address
								if(address !== '')
								{
									geocoder.geocode({'address': address}, function(results, status)
										{
											if(status == google.maps.GeocoderStatus.OK)
											{
												mapCenter = results[0].geometry.location;

												jQuery('#eventLat').val(mapCenter.lat());
												jQuery('#eventLon').val(mapCenter.lng());
									      }
										});
								}
							}
							else
							{
								mapCenter = new google.maps.LatLng(jQuery('#eventLat').val(), jQuery('#eventLon').val());
							}
						});

				});
		</script>

	</section>
</div>
<?php echo $this->element('aside_event'); ?>
<?php 
	echo $tinyMce->init(array(
		'elements' => 'eventSummary',
		'height' => Configure::read('Application.tinymce.heightshort'),
	));
	echo $tinyMce->init(array(
		'elements' => 'eventDescription',
		'height' => Configure::read('Application.tinymce.heightshort'),
	));