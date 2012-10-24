<div id="contentWrapper" class="SF_left">
	<div id="contentHeader" class="SF_niceclear">
		<div id="contentHeaderMargin" class="SF_niceclear">
			<h1>Edition <?php echo $this->data['Edition']['issue']; ?> <span>(<?php echo $editionDate; ?>)</span></h1>
		</div>
	</div>
	<section id="content" class="SF_niceclear">

		<?php if(isset($shamrockFeedback)) { echo $shamrockFeedback; } ?>

		<?php if(isset($shamrockErrors) && $shamrockErrors == true) { ?><div class="feedback feedbackError"><?php __('<b>Oops, something wasn&#39;t right.</b> Can you review the data you entered?', false); ?></div><?php } ?>

		<?php echo $this->Form->create('Edition', array('url' => array('controller' => 'dashboard', 'edition' => $this->data['Edition']['id']))); ?>
			<?php echo $this->Form->input('draft', array('type' => 'hidden',  'label' => false,  'error' => false)); ?>
			<?php echo $this->Form->input('published', array('type' => 'hidden',  'label' => false,  'error' => false)); ?>
			<?php echo $this->Form->input('id', array('type' => 'hidden',  'label' => false,  'error' => false, )); ?>
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

			<p><a class="admin previewEmail" href="<?php echo Router::url(array('controller' => 'dashboard', 'action' => 'preview_newsletter', 'edition' => $this->data['Edition']['id'])); ?>" target="_blank">View email</a></p>

			<div class="separator"></div>

			<div class="actions SF_niceclear">
				<div class="actionsPrimary">
					<?php
						if($this->data['Edition']['published'] != '1')
						{
					?>
					<a class="button deleteButton spacedButton" href="#editionDelete" rel="shadowbox;height=220"><span><?php __('Delete this edition', false); ?></span></a>
					<a class="button readyButton spacedButton" href="#editionPublish" rel="shadowbox;height=252"><span><?php __('Publish this edition', false); ?></span></a>
					<?php
						}
						else
						{
					?>
					<a class="button readyButton spacedButton" href="<?php echo Router::url(array('controller' => 'dashboard', 'action' => 'generate_html', 'edition' => $this->data['Edition']['id'])); ?>" rel="shadowbox;width=950;height=500"><span><?php __('Generate email HTML', false); ?></span></a>
					<?php
						}
					?>
					<button type="submit"><span><?php __('Save changes', false); ?></span></button>
				</div>
				<div class="actionsSecondary">
					<a class="admin" href="<?php echo Router::url(array('controller' => 'editions', 'action' => 'index')); ?>"><?php __('Go to the editions list', false); ?></a>
				</div>
			</div>
		<?php echo $this->Form->end(); ?>

		<div id="editionDelete" class="SF_hidden">
			<div class="SBContent">
				<?php echo $this->Form->create("removeItem", array('url' => array('controller' => 'editions', 'action' => 'delete'))); ?>
					<?php echo $this->Form->input('id', array('label' => false, 'error' => false, 'type' => 'hidden', 'value' => $this->data['Edition']['id'])); ?>
					<h1>Remove this edition?</h1>
				
					<div class="separator"></div>
				
					<p>If you delete this edition all events and editorial will be removed as well</p>
					<p><strong>Please note this operation can't be undone</strong></p>

					<div class="separator"></div>

					<div class="actions SF_niceclear">
						<div class="actionsPrimary">
							<button type="submit"><span><?php __('I understand, remove this edition', false); ?></span></button>
						</div>
						<div class="actionsSecondary">
							<a class="admin" href="javascript:Shadowbox.close()"><?php __('Cancel', false); ?></a>
						</div>
					</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>

		<div id="editionPublish" class="SF_hidden">
			<div class="SBContent">
				<?php echo $this->Form->create("publishItem", array('url' => array('controller' => 'editions', 'action' => 'publish'))); ?>
					<?php echo $this->Form->input('id', array('label' => false, 'error' => false, 'type' => 'hidden', 'value' => $this->data['Edition']['id'])); ?>
					<h1>Publish this edition?</h1>
				
					<div class="separator"></div>
				
					<p>When you publish this edition it will replace the current one and the new edition will be available for your users.</p>
					<p><strong>Please note the current edition will be moved in the previous editions list</strong></p>

					<div class="separator"></div>

					<div class="actions SF_niceclear">
						<div class="actionsPrimary">
							<button type="submit"><span><?php __('I understand, publish this edition', false); ?></span></button>
						</div>
						<div class="actionsSecondary">
							<a class="admin" href="javascript:Shadowbox.close()"><?php __('Cancel', false); ?></a>
						</div>
					</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>


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
