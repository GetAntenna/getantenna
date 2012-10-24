<div id="contentWrapper" class="SF_left">
	<div id="contentHeader" class="SF_niceclear">
		<div id="contentHeaderMargin" class="SF_niceclear">
			<h1>Submitted event details <span>(<a class="admin" href="<?php echo Router::url(array('action' => 'index')); ?>"><?php __('Cancel', false); ?></a>)</span></h1>
			<div id="sectionToolbar">
				<a class="button deleteButton" href="#eventDelete" rel="shadowbox;height=220"><span><?php __('Delete', false); ?></span></a>
				<a class="button readyButton" href="#eventMove" rel="shadowbox;height=198"><span><?php __('Move to scrapbook', false); ?></span></a>
				<a class="button cloneButton spacedButton" href="#eventAttach" rel="shadowbox;height=252"><span><?php __('Attach to draft editions', false); ?></span></a>
			</div>
		</div>
	</div>
	<section id="content" class="SF_niceclear">

		<?php if(isset($shamrockFeedback)) { echo $shamrockFeedback; } ?>

		<?php if(isset($shamrockErrors) && $shamrockErrors == true) { ?><div class="feedback feedbackError"><?php __('<b>Oops, something wasn&#39;t right.</b> Can you review the data you entered?', false); ?></div><?php } ?>

		<?php echo $this->Form->create(null); ?>
			<?php echo $this->Form->input('id', array('type' => 'hidden',  'label' => false,  'error' => false, )); ?>
			<div id="fieldsWrapper">
				<fieldset>

					<div class="SF_clear">
						<div class="formRowInlineHalf formRow">
							<div><label for="eventTitle"><?php __('Name of event', false); ?></label></div>
							<div><?php 
								echo $this->Form->input('title', array(
									'type' => 'text', 
									'label' => false, 
									'error' => false,
									'id'=>'eventTitle', 
									'readonly' => 'readonly',
								)); ?>
							</div>
						</div>

						<div class="formRowInlineHalf formRow">
							<div><label for="eventSubmitted"><?php __('Submitted on', false); ?></label></div>
							<div><?php 
								echo $this->Form->input('created', array(
									'type' => 'text', 
									'label' => false, 
									'error' => false,
									'id'=>'eventSubmitted', 
									'style' => 'width:23%', 
									'readonly' => 'readonly',
								)); ?>
							</div>
						</div>
					</div>

					<div class="SF_clear">
						<div class="formRowInline formRow">
							<div><label for="eventStartDate"><?php __('Date', false); ?></label></div>
							<div><?php 
								echo $this->Form->input('start', array(
									'type' => 'text', 
									'label' => false, 
									'error' => false,
									'id' => 'eventStartDate', 
									'readonly' => 'readonly',
								)); ?>
							</div>
						</div>

						<div class="formRowInline formRow">
							<div><label for="eventStartTime"><?php __('Start time', false); ?></label></div>
							<div><?php 
								echo $this->Form->input('stime', array(
									'type' => 'text', 
									'label' => false, 
									'error' => false,
									'id' => 'eventStartTime', 
									'readonly' => 'readonly', 
								)); ?>
							</div>
						</div>

						<div class="formRowInline formRow">
							<div><label for="eventEndTime"><?php __('End time (optional)', false); ?></label></div>
							<div><?php 
								echo $this->Form->input('etime', array(
									'type' => 'text', 
									'label' => false, 
									'error' => false,
									'id' => 'eventEndTime', 
									'readonly' => 'readonly',
								)); ?>
							</div>
						</div>
					</div>

					<div class="formRowInlineHalf formRow">
						<div><label for="eventAddress"><?php __('Address', false); ?></label></div>
						<div><?php 
							echo $this->Form->input('address', array(
								'type' => 'text', 
								'label' => false, 
								'error' => false,
								'id' => 'eventAddress', 
								'readonly' => 'readonly',
							)); ?>
						</div>
					</div>
				</fieldset>

				<fieldset>
					<div class="formRow">
						<div><label for="eventSummary"><?php __('i. Event summary - what is the event', false); ?>: </label></div>
						<div><?php 
							echo $this->Form->input('summary', array(
								'type' => 'textarea', 
								'label' => false, 
								'error' => false,
								'id' => 'eventSummary', 
								'readonly' => 'readonly',
							)); ?>
						</div>
					</div>

					<div class="SF_clear">
						<div class="formRowInlineHalf formRow">
							<div><label for="eventEmail"><?php __('Contact email address', false); ?></label></div>
							<div><?php 
								echo $this->Form->input('contact_email', array(
									'type' => 'text', 
									'label' => false, 
									'error' => false,
									'id'=>'eventEmail', 
									'readonly' => 'readonly',
								)); ?>
							</div>
						</div>

						<div class="formRowInlineHalf formRow">
							<div><label for="eventPhone"><?php __('Contact phone number', false); ?></label></div>
							<div><?php 
								echo $this->Form->input('contact_phone', array(
									'type' => 'text', 
									'label' => false, 
									'error' => false,
									'id'=>'eventPhone', 
									'readonly' => 'readonly',
								)); ?>
							</div>
						</div>
					</div>
				</fieldset>
			</div>

			<div class="separator"></div>

			<div class="actions SF_niceclear">
				<div class="actionsPrimary">
					<a class="button deleteButton" href="#eventDelete" rel="shadowbox;height=220"><span><?php __('Delete', false); ?></span></a>
					<a class="button readyButton" href="#eventMove" rel="shadowbox;height=198"><span><?php __('Move to scrapbook', false); ?></span></a>
					<a class="button cloneButton spacedButton" href="#eventAttach" rel="shadowbox;height=252"><span><?php __('Attach to draft editions', false); ?></span></a>
				</div>
				<div class="actionsSecondary">
					<a class="admin" href="<?php echo Router::url(array('action' => 'index')); ?>"><?php __('Cancel', false); ?></a>
				</div>
			</div>
		<?php echo $this->Form->end(); ?>

		<div id="eventDelete" class="SF_hidden">
			<div class="SBContent">
				<?php echo $this->Form->create("removeItem", array('url' => array('controller' => 'submitted_events', 'action' => 'delete'))); ?>
					<?php echo $this->Form->input('id', array('label' => false, 'error' => false, 'type' => 'hidden', 'value' => $this->data['SubmittedEvent']['id'])); ?>
					<h1>Remove this event?</h1>
				
					<div class="separator"></div>
				
					<p>If you delete this event it will be removed from the system</p>
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
				<?php echo $this->Form->create("moveItem", array('url' => array('controller' => 'submitted_events', 'action' => 'move'))); ?>
					<?php echo $this->Form->input('id', array('label' => false, 'error' => false, 'type' => 'hidden', 'value' => $this->data['SubmittedEvent']['id'])); ?>
					<h1>Move this event to recurring events?</h1>
				
					<div class="separator"></div>
				
					<p>If you move this event it will be removed from the scrapbook and added to the recurring events</p>

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
				<?php echo $this->Form->create("attachItem", array('url' => array('controller' => 'submitted_events', 'action' => 'attach'))); ?>
					<?php echo $this->Form->input('id', array('label' => false, 'error' => false, 'type' => 'hidden', 'value' => $this->data['SubmittedEvent']['id'])); ?>
					<h1>Attach to draft editions?</h1>
				
					<div class="separator"></div>
				
					<p>When you attach this event to the draft editions it will be added to the system as draft</p>
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
	</section>
</div>
<?php echo $this->element('aside_details'); ?>