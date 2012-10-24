<div id="signIn" class="standaloneWindow">
					<div class="windowContent">
						<?php echo $this->Form->create(null, array('url' => array('controller' => 'users', 'action' => 'login'))); ?>
							<?php if(isset($shamrockFeedback)) { echo $shamrockFeedback; } ?>
							<div class="form_wrapper SF_niceclear">
								<img src="<?php echo $this->webroot; ?>images/logo.png" alt="" class="SF_left" />
								<dl class="SF_right">
									<dt><label for="username"><?php __('Username or email', false); ?></label></dt>
									<dd><?php echo $this->Form->input('shamrockUsername', array('label'=>false, 'id'=>'username', 'maxlength'=>'64', 'autocomplete'=>'off')); ?></dd>
									<dt><label for="password"><?php __('Password', false); ?></label></dt>
									<dd><?php echo $this->Form->password('shamrockPassword', array('label'=>false, 'id'=>'password', 'maxlength'=>'64', 'autocomplete'=>'off')); ?></dd>
									<dd><?php echo $this->Form->checkbox('shamrockRemember', array('id'=>'remember')); ?><label for="remember"><?php __('Remember me on this computer', false); ?></label></dd>
								</dl>
							</div>
							<div class="separator"></div>
							<div class="actions SF_niceclear">
								<div class="actionsPrimary">
									<button type="submit"><span><?php __('Login', false); ?></span></button>
								</div>
								<div class="actionsSecondary">
									<b><?php __('Help:', false); ?>&#160;</b><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'recover')); ?>"><?php __('I can&#39;t login!', false); ?></a>
								</div>
							</div>
						<?php echo $this->Form->end(); ?>
					</div>
				</div>
