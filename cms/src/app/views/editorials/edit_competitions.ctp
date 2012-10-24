<div id="contentWrapper" class="SF_left">
	<div id="contentHeader" class="SF_niceclear">
		<div id="contentHeaderMargin" class="SF_niceclear">
			<h1>Competitions <span>(<a class="admin" href="<?php echo Router::url(array('action' => 'index', 'edition' => $selectedEdition)); ?>"><?php __('Cancel', false); ?></a>)</span></h1>
			<div id="sectionToolbar">
				<img src="<?php echo $this->webroot; ?>images/icon_mobile.png" height="16" />
				<img src="<?php echo $this->webroot; ?>images/icon_mail.png" height="16" />
				<img src="<?php echo $this->webroot; ?>images/icon_web.png" height="16" />
				<?php 
					if(!$readonly)
					{
				?>
				<button type="submit" class="draftButton" id="draftButtonTop" form="EditorialEditCompetitionsForm"><span><?php __('Save as draft', false); ?></span></button>
				<button type="submit" class="readyButton" id="readyButtonTop" form="EditorialEditCompetitionsForm"><span><?php __('Save as ready', false); ?></span></button>
				<?php
					}
				?>
			</div>
		</div>
	</div>
	<section id="content" class="SF_niceclear">

		<?php if(isset($shamrockFeedback)) { echo $shamrockFeedback; } ?>

		<?php if(isset($shamrockErrors) && $shamrockErrors == true) { ?><div class="feedback feedbackError"><?php __('<b>Oops, something wasn&#39;t right.</b> Can you review the data you entered?', false); ?></div><?php } ?>

		<?php echo $this->Form->create(null, array('url' => array('action' => 'edit_competitions', $this->data['Editorial']['id'], 'edition' => $selectedEdition))); ?>
			<?php echo $this->Form->input('EditorialsCompetition.id', array('type' => 'hidden',  'label' => false,  'error' => false, )); ?>
			<?php echo $this->Form->input('EditorialsCompetition.editorial_id', array('type' => 'hidden',  'label' => false,  'error' => false, )); ?>
			<?php echo $this->Form->input('EditorialsCompetition.draft', array('type' => 'hidden',  'label' => false,  'error' => false, 'id' => 'draftButtonField', )); ?>
			<div id="fieldsWrapper">

				<fieldset>
					<div class="formRow">
						<div><label for="EditorialsCompetitionTitle_1">Competition 1 - Name</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.title1', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionTitle_1', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsCompetitionDate_1">Time, day & date</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.date1', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionDate_1', 
								'class' => 'smallField', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsCompetitionLocation_1">Location</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.location1', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionLocation_1', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsCompetitionDescription_1">Competition 1 - Description</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.description1', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionDescription_1', 
							)); ?>
						</div>
					</div>
				</fieldset>

				<hr />

				<fieldset>
					<div class="formRow">
						<div><label for="EditorialsCompetitionTitle_2">Competition 2 - Name</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.title2', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionTitle_2', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsCompetitionDate_2">Time, day & date</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.date2', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionDate_2', 
								'class' => 'smallField', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsCompetitionLocation_2">Location</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.location2', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionLocation_2', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsCompetitionDescription_2">Competition 2 - Description</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.description2', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionDescription_2', 
							)); ?>
						</div>
					</div>
				</fieldset>

				<hr />

				<fieldset>
					<div class="formRow">
						<div><label for="EditorialsCompetitionTitle_3">Competition 3 - Name</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.title3', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionTitle_3', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsCompetitionDate_3">Time, day & date</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.date3', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionDate_3', 
								'class' => 'smallField', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsCompetitionLocation_3">Location</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.location3', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionLocation_3', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsCompetitionDescription_3">Competition 3 - Description</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.description3', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionDescription_3', 
							)); ?>
						</div>
					</div>
				</fieldset>

				<hr />

				<fieldset>
					<div class="formRow">
						<div><label for="EditorialsCompetitionTitle_4">Competition 4 - Name</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.title4', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionTitle_4', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsCompetitionDate_4">Time, day & date</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.date4', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionDate_4', 
								'class' => 'smallField', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsCompetitionLocation_4">Location</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.location4', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionLocation_4', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsCompetitionDescription_4">Competition 4 - Description</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.description4', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionDescription_4', 
							)); ?>
						</div>
					</div>
				</fieldset>

				<hr />

				<fieldset>
					<div class="formRow">
						<div><label for="EditorialsCompetitionTitle_5">Competition 5 - Name</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.title5', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionTitle_5', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsCompetitionDate_5">Time, day & date</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.date5', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionDate_5', 
								'class' => 'smallField', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsCompetitionLocation_5">Location</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.location5', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionLocation_5', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsCompetitionDescription_5">Competition 5 - Description</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.description5', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionDescription_5', 
							)); ?>
						</div>
					</div>
				</fieldset>

				<hr />

				<fieldset>
					<div class="formRow">
						<div><label for="EditorialsCompetitionTitle_6">Competition 6 - Name</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.title6', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionTitle_6', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsCompetitionDate_6">Time, day & date</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.date6', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionDate_6', 
								'class' => 'smallField', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsCompetitionLocation_6">Location</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.location6', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionLocation_6', 
							)); ?>
						</div>
					</div>
					<div class="formRow">
						<div><label for="EditorialsCompetitionDescription_6">Competition 6 - Description</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.description6', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionDescription_6', 
							)); ?>
						</div>
					</div>
				</fieldset>

				<hr />

				<fieldset>
					<div class="formRow">
						<div><label for="EditorialsCompetitionAd">Advertisement - Newsletter ONLY - paste in HTML code below</label></div>
						<div><?php 
							echo $this->Form->input('EditorialsCompetition.advertisement', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id'=>'EditorialsCompetitionAd', 
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
		'elements' => 'EditorialsCompetitionDescription_1',
	));
	echo $tinyMce->init(array(
		'elements' => 'EditorialsCompetitionDescription_2',
	));
	echo $tinyMce->init(array(
		'elements' => 'EditorialsCompetitionDescription_3',
	));
	echo $tinyMce->init(array(
		'elements' => 'EditorialsCompetitionDescription_4',
	));
	echo $tinyMce->init(array(
		'elements' => 'EditorialsCompetitionDescription_5',
	));
	echo $tinyMce->init(array(
		'elements' => 'EditorialsCompetitionDescription_6',
	));