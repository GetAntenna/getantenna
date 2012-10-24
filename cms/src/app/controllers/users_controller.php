<?php
	class UsersController extends AppController
	{
		public $name = 'Users';
		
		// Some internal properties
		private $_loginUsernameEmpty = true;
		private $_loginPasswordEmpty = true;
		private $_hashedPassword = null;
		private $_autoLogin = false;

		function beforeFilter()
		{
			parent::beforeFilter();

			// Change some Auth settings
			$this->shamrockAuthentication->allow('login', 'logout', 'recover');

			// Check if username and password are empty and if the autologin has been enabled
			if(!empty($this->data))
			{
				if(!empty($this->data['User']['shamrockUsername'])) { $this->_loginUsernameEmpty = false; }
				if(!empty($this->data['User']['shamrockPassword'])) 
				{ 
					$this->_loginPasswordEmpty = false; 
					// Hash the submitted password and blank it
					$this->_hashedPassword = Security::hash($this->data['User']['shamrockPassword'], null, true);
					$this->data['User']['shamrockPassword'] = '';
				}
				if($this->data['User']['shamrockRemember'] == 1) { $this->_autoLogin = true; }
			}

			// If the user is already logged in send him to the dashboard
			if(($this->action == 'login') || ($this->action == 'recover'))
			{
				if($this->shamrockAuthentication->isLoggedIn()) { $this->redirect(array('controller' => 'dashboard', 'action' => 'index'), true, null); }
			}
			else
			{
				// Redirect to the default page is the user has not access
				if(!$this->shamrockAuthentication->isAllowed())
				{
					if($this->params['action'] != 'index')
					{
						$this->redirect(array('controller' => $this->params['controller'], 'action' => 'index'), null, true);
					}
					else
					{
						$this->redirect(array('controller' => 'dashboard', 'action' => 'index'), null, true);
					}
				}
			}
		}

		function login()
		{
			$this->set('title_for_layout', __('Login', true));
			$this->layout = 'login';

			// Show the feedback message
			$this->shamrockFeedback->feedbackLoad();

			if(isset($this->data['User']['shamrockUsername']) && !empty($this->_hashedPassword))
			{
				if($this->_loginUsernameEmpty)
				{
					// The username is empty
					$this->shamrockFeedback->feedbackError(__('<b>Oops, something wasn&#39;t right.</b> Have you typed your username/email?', true));
					return;
				}
				
				if($this->_loginPasswordEmpty)
				{
					// The password is empty
					$this->shamrockFeedback->feedbackError(__('<b>Oops, something wasn&#39;t right.</b> Have you typed your password?', true));
					return;
				}

				// Execute the login
				if($this->shamrockAuthentication->loginUser($this->_autoLogin, $this->_hashedPassword))
				{
					// Redirect to the dashboard
					$this->redirect(array('controller' => 'editions', 'action' => 'index'), null, true);
				}
				else
				{
					// There's an authentication error
					if($this->shamrockAuthentication->isDisabled())
					{
						// The user is disabled
						$this->shamrockFeedback->feedbackError(__('<b>OH NO!</b> Looks like your username has been disabled.', true));
					}
					else
					{
						// Vibrate the login form
						$this->set('shamrockScripts', '<script type="text/javascript">jQuery(document).ready(function() { jQuery("#signIn").vibrate(); });</script>');
						// The login details are not valid
						$this->shamrockFeedback->feedbackError(__('<b>OH NO!</b> That username/email and password combination didn&#39;t work.', true));
					}
				}
			}
		}
		
		function logout() 
		{
			// Delete the session data
			$this->User->query("DELETE FROM `cake_sessions` WHERE `cake_sessions`.`id` = '". $_COOKIE[Configure::read('Session.cookie')] ."'");

			// Destroy the session
			$this->Session->destroy();

			// Delete the Auth session
			$this->Session->delete('Auth');

			// Delete the auth cookie
			$this->Cookie->delete('srAuth');

			// Delete the session cookie
			$this->Cookie->delete(Configure::read('Session.cookie'));

			// Execute the logout
			$this->redirect($this->shamrockAuthentication->logoutUser());
		}

		function recover()
		{
			$this->set('title_for_layout', __('Recover password', true));
			$this->layout = 'login';

			// Execute a logout
			$this->shamrockAuthentication->logout();

			// Validate the email address
			if(!empty($this->data))
			{
				if($this->shamrockEmail->isEmail($this->data['User']['shamrockEmail']))
				{
					// The provided email is valid, check if is registered
					// Get the details for the user using the provided email
					$userFromEmail = $this->User->find('first', array('conditions'=>array(
							'User.email' => $this->data['User']['shamrockEmail'], 
							'User.disabled' => '0',  
						)));

					if(!empty($userFromEmail))
					{
						// Generate a new password
						$newPassword = $this->shamrockAuthentication->generatePassword(10);

						// Update the password and the login token
						$this->User->id = $userFromEmail['User']['id'];
						$this->User->set(array(
							'password' => Security::hash($newPassword, null, true), 
							'token' => Security::hash($userFromEmail['User']['id'] . $newPassword . time(), null, true), 
						));
						$this->User->save(null, false);

						// Delete the auth cookie
						$this->Cookie->delete('srAuth');

						// Send the new password
						// Variables for the email template
						$this->set('title_for_layout', __('Your credentials', true));
						$this->set('firstname', $userFromEmail['User']['firstname']);
						$this->set('username', $userFromEmail['User']['username']);
						$this->set('password', $newPassword);
						// Set the email parameters
						$this->shamrockEmail->to = $userFromEmail['User']['email'];
						$this->shamrockEmail->toName = $userFromEmail['User']['firstname'] ." ". $userFromEmail['User']['lastname'];
						$this->shamrockEmail->templateName = 'recover';
						$this->shamrockEmail->subject = sprintf(__('Your credentials for %s', true), Configure::read('Application.core.name'));
						if($this->shamrockEmail->send())
						{
							// The email has been sent
							$this->shamrockFeedback->feedbackSave(sprintf(__('Email sent to %s', true), $userFromEmail['User']['email']), 'notice');
							$this->redirect(array('controller' => 'users', 'action' => 'login'), null, true); 
						}
						else
						{
							// The email hasn't been sent
							$this->shamrockFeedback->feedbackError(__('<b>Oops</b> There was an error sending your email. Do you mind to try again?'));
						}
					}
					else
					{
						// The provided email is registered
						$this->shamrockFeedback->feedbackError(__('<b>Oops, something wasn&#39;t right.</b> We couldn&#39;t find anyone with that email address.', true));
					}
				}
				else
				{
					// The provided email is not valid
					$this->shamrockFeedback->feedbackError(__('<b>Oops, something wasn&#39;t right.</b> Have you misspelled your email address?', true));
				}
			}
		}

		function profile()
		{
			// Get the details for the current user
			$_currentUser = @$this->shamrockAuthentication->user();
			$_currentUser = $_currentUser['User'];

			// Set some basic strings
			$this->set('userFirstName', htmlentities($_currentUser['firstname']));
			$this->set('userLastName', htmlentities($_currentUser['lastname']));
			$this->set('userEmail', $_currentUser['email']);

			// Check if the user is an admin
			if($_currentUser['group_id'] != Configure::read('Application.acl.admingroup')) { $this->set('isUser', true); } else { $this->set('isUser', false); }

			$this->set('title_for_layout', __('My profile', true));

			// Show the feedback message
			$this->shamrockFeedback->feedbackLoad();

			$this->User->id = $_currentUser['id']; 

			if(!empty($this->data))
			{
				if($this->User->save($this->data))
				{
					$this->shamrockFeedback->feedbackSave(__('Your details have been updated', true), 'success');
					$this->redirect(array('controller' => 'editions', 'action' => 'index'), null, true);
				}
				else
				{
					$this->set('shamrockErrors', true);
				}
			}
			else
			{
				// Read the selected user
				$this->data = $this->User->read(); 
				$this->data['User']['password'] = '';
			}
		}

	}