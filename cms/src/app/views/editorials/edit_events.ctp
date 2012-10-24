<div id="contentWrapper" class="SF_left">
	<div id="contentHeader" class="SF_niceclear">
		<div id="contentHeaderMargin" class="SF_niceclear">
			<h1>Events Coming Up <span>(<a class="admin" href="<?php echo Router::url(array('action' => 'index', 'edition' => $selectedEdition)); ?>"><?php __('Cancel', false); ?></a>)</span></h1>
			<div id="sectionToolbar">
				<img src="<?php echo $this->webroot; ?>images/icon_mobile.png" height="16" />
				<img src="<?php echo $this->webroot; ?>images/icon_mail.png" height="16" />
				<img src="<?php echo $this->webroot; ?>images/icon_web.png" height="16" />
				<?php 
					if(!$readonly)
					{
				?>
				<button type="submit" class="draftButton" id="draftButtonTop" form="EditorialEditEventsForm"><span><?php __('Save as draft', false); ?></span></button>
				<button type="submit" class="readyButton" id="readyButtonTop" form="EditorialEditEventsForm"><span><?php __('Save as ready', false); ?></span></button>
				<?php
					}
				?>
			</div>
		</div>
	</div>
	<section id="content" class="SF_niceclear">

		<?php if(isset($shamrockFeedback)) { echo $shamrockFeedback; } ?>

		<?php if(isset($shamrockErrors) && $shamrockErrors == true) { ?><div class="feedback feedbackError"><?php __('<b>Oops, something wasn&#39;t right.</b> Can you review the data you entered?', false); ?></div><?php } ?>

		<?php echo $this->Form->create(null, array('url' => array('action' => 'edit_events', $this->data['Editorial']['id'], 'edition' => $selectedEdition))); ?>
			<?php echo $this->Form->input('EditorialsEvent.id', array('type' => 'hidden',  'label' => false,  'error' => false, )); ?>
			<?php echo $this->Form->input('EditorialsEvent.editorial_id', array('type' => 'hidden',  'label' => false,  'error' => false, )); ?>
			<?php echo $this->Form->input('EditorialsEvent.draft', array('type' => 'hidden',  'label' => false,  'error' => false, 'id' => 'draftButtonField', )); ?>
			<div id="fieldsWrapper">

				<fieldset>
					<div class="formRow">
						<div><label for="EditorialsEventIntro">Introduction</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.intro', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventIntro', 
							)); ?>
						</div>
					</div>
				</fieldset>

				<hr />

				<fieldset>
					<div class="formRow">
						<div><label for="EditorialsEventTitle_1">Title</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.title1', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventTitle_1', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsEventDate_1">Time, day & date</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.date1', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventDate_1', 
								'class' => 'smallField', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsEventLocation_1">Location</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.location1', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventLocation_1', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsEventDescription_1">Description</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.description1', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventDescription_1', 
							)); ?>
						</div>
					</div>
				</fieldset>

				<hr />

				<fieldset>
					<div class="formRow">
						<div><label for="EditorialsEventTitle_2">Title</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.title2', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventTitle_2', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsEventDate_2">Time, day & date</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.date2', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventDate_2', 
								'class' => 'smallField', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsEventLocation_2">Location</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.location2', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventLocation_2', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsEventDescription_2">Description</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.description2', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventDescription_2', 
							)); ?>
						</div>
					</div>
				</fieldset>

				<hr />

				<fieldset>
					<div class="formRow">
						<div><label for="EditorialsEventTitle_3">Title</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.title3', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventTitle_3', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsEventDate_3">Time, day & date</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.date3', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventDate_3', 
								'class' => 'smallField', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsEventLocation_3">Location</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.location3', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventLocation_3', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsEventDescription_3">Description</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.description3', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventDescription_3', 
							)); ?>
						</div>
					</div>
				</fieldset>

				<hr />

				<fieldset>
					<div class="formRow">
						<div><label for="EditorialsEventTitle_4">Title</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.title4', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventTitle_4', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsEventDate_4">Time, day & date</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.date4', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventDate_4', 
								'class' => 'smallField', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsEventLocation_4">Location</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.location4', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventLocation_4', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsEventDescription_4">Description</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.description4', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventDescription_4', 
							)); ?>
						</div>
					</div>
				</fieldset>

				<hr />

				<fieldset>
					<div class="formRow">
						<div><label for="EditorialsEventTitle_5">Title</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.title5', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventTitle_5', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsEventDate_5">Time, day & date</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.date5', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventDate_5', 
								'class' => 'smallField', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsEventLocation_5">Location</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.location5', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventLocation_5', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsEventDescription_5">Description</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.description5', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventDescription_5', 
							)); ?>
						</div>
					</div>
				</fieldset>

				<hr />

				<fieldset>
					<div class="formRow">
						<div><label for="EditorialsEventTitle_6">Title</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.title6', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventTitle_6', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsEventDate_6">Time, day & date</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.date6', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventDate_6', 
								'class' => 'smallField', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsEventLocation_6">Location</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.location6', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventLocation_6', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsEventDescription_6">Description</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.description6', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventDescription_6', 
							)); ?>
						</div>
					</div>
				</fieldset>

				<hr />

				<fieldset>
					<div class="formRow">
						<div><label for="EditorialsEventAd">Advertisement - Newsletter ONLY - paste in HTML code below</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsEvent.advertisement', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsEventAd', 
							)); ?>
						</div>
					</div>
				</fieldset>

			</div>

			<div class="actions SF_niceclear">
				<div class="actionsPrimary">
					<?php 
						if(!$readonly)
						{
					?>
					<button type="submit" class="draftButton" id="draftButton"><span><?php __('Save as draft', false); ?></span></button>
					<button type="submit" class="readyButton" id="readyButton"><span><?php __('Save as ready', false); ?></span></button>
					<?php
						}
					?>
				</div>
				<div class="actionsSecondary">
					<a class="admin" href="<?php echo Router::url(array('action' => 'index', 'edition' => $selectedEdition)); ?>"><?php __('Cancel', false); ?></a>
				</div>
			</div>
		<?php echo $this->Form->end(); ?>

	</section>
</div>
<?php echo $this->element('aside_editorial'); ?>
<?php 
	echo $tinyMce->init(array(
		'elements' => 'EditorialsEventDescription_1',
		'height' => Configure::read('Application.tinymce.heightshort'),
	));
	echo $tinyMce->init(array(
		'elements' => 'EditorialsEventDescription_2',
		'height' => Configure::read('Application.tinymce.heightshort'),
	));
	echo $tinyMce->init(array(
		'elements' => 'EditorialsEventDescription_3',
		'height' => Configure::read('Application.tinymce.heightshort'),
	));
	echo $tinyMce->init(array(
		'elements' => 'EditorialsEventDescription_4',
		'height' => Configure::read('Application.tinymce.heightshort'),
	));
	echo $tinyMce->init(array(
		'elements' => 'EditorialsEventDescription_5',
		'height' => Configure::read('Application.tinymce.heightshort'),
	));
	echo $tinyMce->init(array(
		'elements' => 'EditorialsEventDescription_6',
		'height' => Configure::read('Application.tinymce.heightshort'),
	));
	echo $tinyMce->init(array(
		'elements' => 'EditorialsEventIntro',
		'height' => Configure::read('Application.tinymce.heightshort'),
	));