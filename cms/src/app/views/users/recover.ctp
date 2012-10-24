<div id="recoverPassword" class="standaloneWindow">
					<div class="windowContent">
						<?php echo $this->Form->create(null, array('url' => array('controller' => 'users', 'action' => 'recover'))); ?>
							<?php if(isset($shamrockFeedback)) { echo $shamrockFeedback; } ?>
							<div class="form_wrapper">
								<h1><?php __('Can&#39;t login?', false); ?></h1>
								<div class="separator"></div>
								<p><?php __('Give us the email address you used to register and we will send you back a message with your username and a new password. If you don&#39;t get an email from us within a few minutes please be sure to check your spam folder.', false); ?></p>
								<dl>
									<dt><label for="email"><?php __('Enter your email address', false); ?></label></dt>
									<dd><?php echo $this->Form->input('shamrockEmail', array('label'=>false, 'id'=>'email', 'maxlength'=>'320', 'autocomplete'=>'off')); ?></dd>
								</dl>
							</div>
							<div class="separator"></div>
							<div class="actions SF_niceclear">
								<div class="actionsPrimary">
									<button  type="submit"><span><?php __('Send me my details', false); ?></span></button>
								</div>
								<div class="actionsSecondary">
									<a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'login')); ?>"><?php __('Take me back to the login page', false); ?></a>
								</div>
							</div>
						<?php echo $this->Form->end(); ?>
					</div>
				</div>
