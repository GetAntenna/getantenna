<div id="contentWrapper" class="SF_left">
	<div id="contentHeader" class="SF_niceclear">
		<div id="contentHeaderMargin" class="SF_niceclear">
			<h1>Add scrapbook event <span>(<a class="admin" href="<?php echo Router::url(array('action' => 'index')); ?>"><?php __('Cancel', false); ?></a>)</span></h1>
			<div id="sectionToolbar">
				<button type="submit" class="readyButton" id="readyButtonTop" form="ScrapbookEventAddForm"><span><?php __('Add event to scrapbook', false); ?></span></button>
			</div>
		</div>
	</div>
	<section id="content" class="SF_niceclear">

		<?php if(isset($shamrockErrors) && $shamrockErrors == true) { ?><div class="feedback feedbackError"><?php __('<b>Oops, something wasn&#39;t right.</b> Can you review the data you entered?', false); ?></div><?php } ?>

		<?php echo $this->Form->create(null, array('url' => array('action' => 'add'), 'enctype' => 'multipart/form-data')); ?>
			<?php echo $this->Form->input('lat', array('type' => 'hidden',  'label' => false,  'error' => false, 'id' => 'eventLat', )); ?>
			<?php echo $this->Form->input('lon', array('type' => 'hidden',  'label' => false,  'error' => false, 'id' => 'eventLon', )); ?>
			<div id="fieldsWrapper">
				<fieldset>

					<div class="SF_clear">
						<div class="formRowInlineHalf formRow<?php if($form->error('ScrapbookEvent.title')) { echo ' formRowError'; } ?>">
							<div><label for="eventTitle"><?php __('Name of event', false); ?></label></div>
							<div<?php if($form->error('ScrapbookEvent.title')) { echo ' class="fieldError"'; } ?>><?php 
								echo $this->Form->input('title', array(
									'type' => 'text', 
									'label' => false, 
									'error' => false,
									'id'=>'eventTitle', 
									'placeholder' => 'Event_title_goes_here_this_long',
								)); ?>
							</div>
							<?php if($form->error('ScrapbookEvent.title')) { ?><p class="formTip"><?php __('The name of the event is required', false); ?></p><?php } ?>
						</div>

						<div class="formRowInlineHalf formRow<?php if($form->error('ScrapbookEvent.category')) { echo ' formRowError'; } ?>">
							<div><label for="eventcategory"><?php __('Category', false); ?></label></div>
							<div<?php if($form->error('ScrapbookEvent.category')) { echo ' class="fieldError"'; } ?>><?php 
								echo $this->Categories->categorySelect('category', array(
									'label' => false, 
									'error' => false,
									'id' => 'eventCategory', 								
								)); ?>
							</div>
							<?php if($form->error('ScrapbookEvent.category')) { ?><p class="formTip"><?php __('The category of the event is required', false); ?></p><?php } ?>
						</div>
					</div>

					<div class="SF_clear">
						<div class="formRowInline formRow<?php if($form->error('ScrapbookEvent.start')) { echo ' formRowError'; } ?>">
							<div><label for="eventStartDate"><?php __('Date', false); ?></label></div>
							<div<?php if($form->error('ScrapbookEvent.start')) { echo ' class="fieldError"'; } ?>><?php 
								echo $this->Form->input('start', array(
									'type' => 'text', 
									'label' => false, 
									'error' => false,
									'id' => 'eventStartDate', 
								)); ?>
							</div>
							<?php if($form->error('ScrapbookEvent.start')) { ?><p class="formTip"><?php __('The event start date is not valid', false); ?></p><?php } ?>
						</div>

						<div class="formRowInline formRow<?php if($form->error('ScrapbookEvent.stime')) { echo ' formRowError'; } ?>">
							<div><label for="eventStartTime"><?php __('Start time', false); ?></label></div>
							<div<?php if($form->error('ScrapbookEvent.stime')) { echo ' class="fieldError"'; } ?>><?php 
								echo $this->Form->input('stime', array(
									'type' => 'text', 
									'label' => false, 
									'error' => false,
									'id' => 'eventStartTime', 
									'placeholder' => '18:00', 
								)); ?>
							</div>
							<?php if($form->error('ScrapbookEvent.stime')) { ?><p class="formTip"><?php __('The event start time is not valid', false); ?></p><?php } ?>
						</div>

						<div class="formRowInline formRow<?php if($form->error('ScrapbookEvent.etime')) { echo ' formRowError'; } ?>">
							<div><label for="eventEndTime"><?php __('End time (optional)', false); ?></label></div>
							<div<?php if($form->error('ScrapbookEvent.etime')) { echo ' class="fieldError"'; } ?>><?php 
								echo $this->Form->input('etime', array(
									'type' => 'text', 
									'label' => false, 
									'error' => false,
									'id' => 'eventEndTime', 
								)); ?>
							</div>
							<?php if($form->error('ScrapbookEvent.etime')) { ?><p class="formTip"><?php __('The event end time is not valid', false); ?></p><?php } ?>
						</div>

						<div class="formRow formRowInline">
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

					<div id="autocompleteAddress" class="formRowInlineHalf formRow<?php if($form->error('ScrapbookEvent.address')) { echo ' formRowError'; } ?>">
						<div><label for="eventAddress"><?php __('Address', false); ?></label></div>
						<div<?php if($form->error('ScrapbookEvent.address')) { echo ' class="fieldError"'; } ?>><?php 
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
							<a href="#eventLocation" rel="shadowbox;height=500;width=700;" id="eventAddressLookup" class="button buttonLocation"><img src="<?php echo $this->webroot; ?>images/icon_marker.png" /></a>
						</div>
						<?php if($form->error('ScrapbookEvent.address')) { ?><p class="formTip"><?php __('The address of the event is required', false); ?></p><?php } ?>
					</div>

				</fieldset>

				<fieldset>
					<div class="formRow<?php if($form->error('ScrapbookEvent.summary')) { echo ' formRowError'; } ?>">
						<div><label for="eventSummary"><?php __('i. Event summary - what is the event', false); ?>: </label></div>
						<div<?php if($form->error('ScrapbookEvent.summary')) { echo ' class="fieldError"'; } ?>><?php 
							echo $this->Form->input('summary', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id' => 'eventSummary', 
							)); ?>
						</div>
						<?php if($form->error('ScrapbookEvent.summary')) { ?><p class="formTip"><?php __('The summary of the event is required', false); ?></p><?php } ?>
					</div>

					<div class="formRow">
						<div><label for="eventDescription"><?php __('ii. About the event, organization or venue', false); ?>:</label></div>
						<div<?php if($form->error('ScrapbookEvent.description')) { echo ' class="fieldError"'; } ?>><?php 
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
						<div<?php if($form->error('ScrapbookEvent.link')) { echo ' class="fieldError"'; } ?>><?php 
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
					<div class="formRow<?php if($form->error('ScrapbookEvent.picture')) { echo ' formRowError'; } ?>">
						<div><label for="eventPicture"><?php __('Optional image', false); ?>:</label></div>
						<div<?php if($form->error('ScrapbookEvent.picture')) { echo ' class="fieldError"'; } ?>><?php 
							echo $this->Form->input('picture', array(
								'type' => 'file', 
								'label'=>false, 
								'error' => false,
								'id'=>'eventPicture', 
							)); ?>
						</div>
						<?php if($form->error('ScrapbookEvent.picture')) { ?><p class="formTip"><?php __('The picture is not valid. Is this an image?', false); ?></p><?php } ?>
					</div>
				</fieldset>
			</div>

			<div class="separator"></div>

			<div class="actions SF_niceclear">
				<div class="actionsPrimary">
					<button type="submit" class="readyButton" id="readyButton"><span><?php __('Add event to scrapbook', false); ?></span></button>
				</div>
				<div class="actionsSecondary">
					<a class="admin" href="<?php echo Router::url(array('action' => 'index')); ?>"><?php __('Cancel', false); ?></a>
				</div>
			</div>
		<?php echo $this->Form->end(); ?>

		<div id="location" class="SF_hidden">
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

		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<script type="text/javascript">
			// Map constants
			var mapCenter = new google.maps.LatLng(<?php echo Configure::read('Application.map.lat'); ?>, <?php echo Configure::read('Application.map.lon'); ?>);
			

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