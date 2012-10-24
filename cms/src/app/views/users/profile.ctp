<div id="contentWrapper" class="SF_left">
	<div id="contentHeader">
		<div id="contentHeaderMargin" class="SF_niceclear">
			<h1>My Profile</h1>
		</div>
	</div>
	<section id="content" class="SF_niceclear">

		<?php if(isset($shamrockErrors) && $shamrockErrors == true) { ?><div class="feedback feedbackError"><?php __('<b>Oops, something wasn&#39;t right.</b> Can you review the data you entered?', false); ?></div><?php } ?>

		<?php echo $this->Form->create(null, array('url' => array('action' => 'profile'))); ?>
			<?php echo $this->Form->input('id', array('label' => false, 'error' => false, 'type' => 'hidden')); ?>
			<?php echo $this->Form->input('group_id', array('label' => false, 'error' => false, 'type' => 'hidden')); ?>
			<?php echo $this->Form->input('username', array('label' => false, 'error' => false, 'type' => 'hidden')); ?>
			<?php echo $this->Form->input('token', array('label' => false, 'error' => false, 'type' => 'hidden')); ?>
			<?php echo $this->Form->input('disabled', array('label' => false, 'error' => false, 'type' => 'hidden')); ?>
			<div id="fieldsWrapper">

				<h3>Account details</h3>
				<p class="formExplanation"><b>These are your account details. </b></p>
				<fieldset>
					<div class="formRow<?php if($form->error('User.firstname')) { echo ' formRowError'; } ?>">
						<div><label for="Userfirstname" class="mandatory"><?php __('First name', false); ?>: <span>(<?php __('Required', false); ?>)</span></label></div>
						<div<?php if($form->error('User.firstname')) { echo ' class="fieldError"'; } ?>><?php 
							echo $this->Form->input('firstname', array(
								'label' => false, 
								'error' => false,
								'id'=>'Userfirstname', 
							)); ?>
						</div>
						<?php if($form->error('User.firstname')) { ?><p class="formTip"><?php __('Your first name is required', false); ?></p><?php } ?>
					</div>

					<div class="formRow<?php if($form->error('User.lastname')) { echo ' formRowError'; } ?>">
						<div><label for="Userlastname" class="mandatory"><?php __('Last name', false); ?>: <span>(<?php __('Required', false); ?>)</span></label></div>
						<div<?php if($form->error('User.lastname')) { echo ' class="fieldError"'; } ?>><?php 
							echo $this->Form->input('lastname', array(
								'label' => false, 
								'error' => false,
								'id'=>'Userlastname', 
							)); ?>
						</div>
						<?php if($form->error('User.lastname')) { ?><p class="formTip"><?php __('Your last name is required', false); ?></p><?php } ?>
					</div>

					<div class="formRow<?php if($form->error('User.email')) { echo ' formRowError'; } ?>">
						<div><label for="Useremail" class="mandatory"><?php __('Email', false); ?>: <span>(<?php __('Required', false); ?>)</span></label></div>
						<div<?php if($form->error('User.email')) { echo ' class="fieldError"'; } ?>><?php 
							echo $this->Form->input('email', array(
								'label' => false, 
								'error' => false,
								'id'=>'Useremail', 
							)); ?>
						</div>
						<?php if($form->error('User.email')) { ?><p class="formTip"><?php __('Your email address is not valid', false); ?></p><?php } ?>
					</div>

					<div class="formRow<?php if($form->error('User.newpassword')) { echo ' formRowError'; } ?>">
						<div><label for="UserPassword"><?php __('Your password', false); ?>:</label></div>
						<div<?php if($form->error('User.newpassword')) { echo ' class="fieldError"'; } ?>><?php 
							echo $this->Form->input('newpassword', array(
								'type' => 'password', 
								'label' => false, 
								'error' => false,
								'id' => 'UserPassword', 
								'class' => 'smallField cTooltipEnabled', 
								'title' => __("Leave empty if you don't want to change it. The password needs to be at least 8 characters long.", true),
							)); ?>
						</div>
						<?php if($form->error('User.newpassword')) { ?><p class="formTip"><?php __('The password is not valid', false); ?></p><?php } ?>
					</div>
				</fieldset>

				<h3>Other details</h3>
				<p class="formExplanation"><b>These details cannot be changed.</b></p>
				<fieldset>

					<div class="formRow">
						<div><span class="rowLabel"><?php __('Your username', false); ?>:</span></div>
						<div><b><?php echo $this->data['User']['username']; ?></b></div>
					</div>

				</fieldset>
			</div>

			<div class="separator"></div>

			<div class="actions SF_niceclear">
				<div class="actionsPrimary">
					<button type="submit"><span><?php __('Update my profile', false); ?></span></button>
				</div>
				<div class="actionsSecondary">
					<a class="admin" href="<?php echo Router::url(array('controller' => 'editions', 'action' => 'index')); ?>"><?php __('Cancel', false); ?></a>
				</div>
			</div>
		<?php echo $this->Form->end(); ?>

	</section>
</div>
