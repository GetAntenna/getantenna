<div id="contentWrapper" class="SF_left">
	<div id="contentHeader" class="SF_niceclear">
		<div id="contentHeaderMargin" class="SF_niceclear">
			<h1>Add a new draft edition? <span>(<a class="admin" href="<?php echo Router::url(array('action' => 'index')); ?>"><?php __('Cancel', false); ?></a>)</span></h1>
		</div>
	</div>
	<section id="content" class="SF_niceclear">

		<?php if(isset($shamrockErrors) && $shamrockErrors == true) { ?><div class="feedback feedbackError"><?php __('<b>Oops, something wasn&#39;t right.</b> Can you review the data you entered?', false); ?></div><?php } ?>

		<?php echo $this->Form->create(null, array('url' => array('action' => 'add'))); ?>
			<?php echo $this->Form->input('draft', array('type' => 'hidden',  'label' => false,  'error' => false, 'value' => 1)); ?>
			<?php echo $this->Form->input('published', array('type' => 'hidden',  'label' => false,  'error' => false, 'value' => 0)); ?>
			<div id="fieldsWrapper">
				<fieldset>

					<div class="formRowInline formRow<?php if($form->error('Edition.issue')) { echo ' formRowError'; } ?>">
						<div><label for="eventTitle" class="mandatory"><?php __('Edition number', false); ?>: <span>(<?php __('Required', false); ?>)</span></label></div>
						<div<?php if($form->error('Edition.issue')) { echo ' class="fieldError"'; } ?>><?php 
							echo $this->Form->input('issue', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id'=>'editionIssue', 
							)); ?>
						</div>
						<?php if($form->error('Edition.issue')) { ?><p class="formTip"><?php __('The edition issue number is required', false); ?></p><?php } ?>
					</div>

					<div class="formRowInline formRow<?php if($form->error('Edition.start')) { echo ' formRowError'; } ?>">
						<div><label for="editionStartDate" class="mandatory"><?php __('Start date', false); ?>: <span>(<?php __('Required', false); ?>)</span></label></div>
						<div<?php if($form->error('Edition.start')) { echo ' class="fieldError"'; } ?>><?php 
							echo $this->Form->input('start', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id' => 'editionStartDate', 
							)); ?>
						</div>
						<?php if($form->error('Edition.start')) { ?><p class="formTip"><?php __('The edition start date is not valid', false); ?></p><?php } ?>
					</div>

					<div class="formRowInline formRow<?php if($form->error('Edition.end')) { echo ' formRowError'; } ?>">
						<div><label for="editionEndDate" class="mandatory"><?php __('End date', false); ?>: <span>(<?php __('Required', false); ?>)</span></label></div>
						<div<?php if($form->error('Edition.end')) { echo ' class="fieldError"'; } ?>><?php 
							echo $this->Form->input('end', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id' => 'editionEndDate', 
							)); ?>
						</div>
						<?php if($form->error('Edition.end')) { ?><p class="formTip"><?php __('The edition end date is not valid', false); ?></p><?php } ?>
					</div>

				</fieldset>
			</div>

			<div class="separator"></div>

			<div class="actions SF_niceclear">
				<div class="actionsPrimary">
					<button type="submit" class="readyButton"><span><?php __('Add draft edition', false); ?></span></button>
				</div>
				<div class="actionsSecondary">
					<a class="admin" href="<?php echo Router::url(array('action' => 'index')); ?>"><?php __('Cancel', false); ?></a>
				</div>
			</div>
		<?php echo $this->Form->end(); ?>

		<script type="text/javascript">
			jQuery(document).ready(function()
				{
					// Datepicker
					jQuery("#editionStartDate").datepicker(
						{
							changeMonth: false,
							numberOfMonths: 3,
							firstDay: 1,
							dateFormat: 'dd-mm-yy'
						});
					jQuery("#editionEndDate").datepicker(
						{
							changeMonth: false,
							numberOfMonths: 3,
							firstDay: 1,
							dateFormat: 'dd-mm-yy'
						});
				});
		</script>
	</section>
</div>
<?php echo $this->element('aside_editions'); ?>