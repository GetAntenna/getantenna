<?php
	App::import('Component', 'Auth');

	class shamrockAuthenticationComponent extends AuthComponent
	{
		var $settings = array();
		public $_isUserDisabled = false;
		public $_userExists = false;

		function initialize(&$controller, $config = array())
		{
			$this->settings = array_merge($this->settings, $config);
			$this->controller =& $controller;

			// Setup the Shamrock cookie
			$this->controller->Cookie->name = Configure::read('Application.cookie.name');
			$this->controller->Cookie->time =  Configure::read('Application.cookie.ttl');
			$this->controller->Cookie->key = Configure::read('Application.cookie.key');
		}

		function authorizeUser($userID = null)
		{
			if(!empty($userID)) { return parent::login($userID); }
			return null;
		}

		function isDisabled($userID = null)
		{
			// Get the model AuthComponent
			$model =& $this->getModel();

			if(!empty($userID))
			{
				// Do a query that will find the user
				$userFromId = $model->find('first', array('conditions'=>array(
						$this->userModel .'.id' => $userID,
					)));

				if($userFromId !== false)
				{
					return ((boolean)$userFromId[$this->userModel]['disabled'] == true);
				}
				return false;
			}
			else
			{
				// Check the disabled status for the current user
				return $this->_isUserDisabled;
			}
		}

		function userExists($userID = null)
		{
			// Get the model AuthComponent
			$model =& $this->getModel();

			if(!empty($userID))
			{
				// Do a query that will find the user
				$userFromId = $model->find('first', array('conditions'=>array(
						$this->userModel .'.id' => $userID,
					)));

				if($userFromId !== false)
				{
					return true;
				}
				return false;
			}
			else
			{
				// Check the registered status for the current user
				return $this->_userExists;
			}
		}

		function loginUser($cookie = false, $hashedPassword)
		{
			// Get the model AuthComponent
			$model =& $this->getModel();
			
			if(!empty($this->data['User']['shamrockUsername']) && !empty($hashedPassword))
			{
				// Do a query that will find a user record when given successful login data
				$userFromUsername = $model->find('first', array('conditions'=>array(
						$this->userModel .".". $this->fields['username'] => strtolower($this->data['User']['shamrockUsername']), 
					)));

				$userFromEmail = $model->find('first', array('conditions'=>array(
						$this->userModel .'.email' => $this->data['User']['shamrockUsername'],
					)));

				// Check if the current user is disabled
				if(((boolean)$userFromUsername[$this->userModel]['disabled'] == true) || ((boolean)$userFromEmail[$this->userModel]['disabled'] == true))
				{
					// The user is disabled
					$this->_isUserDisabled = true;
					return null;
				}

				if(($userFromUsername['User']['password'] == $hashedPassword) || ($userFromEmail['User'] == $hashedPassword))
				{
					// Create the auth cookie
					if($cookie)
					{
						$authCookie = array();
						// Get the UUID and the security token
						if(!empty($userFromUsername['User']['id']))
						{ 
							$authCookie['id'] = $userFromUsername['User']['id'];
							$authCookie['token'] = $userFromUsername['User']['token'];
						}
						if(!empty($userFromEmail['User']['id']))
						{ 
							$authCookie['id'] = $userFromEmail['User']['id'];
							$authCookie['token'] = $userFromEmail['User']['token'];
						}
						// Save the Auth cookie
						$this->controller->Cookie->write('srAuth', $authCookie, true, Configure::read('Application.cookie.ttl'));
					}

					// The password match
					// Login the user
					if(!empty($userFromUsername['User']['id'])) { return parent::login($userFromUsername['User']['id']); }
					if(!empty($userFromEmail['User']['id'])) { return parent::login($userFromEmail['User']['id']); }
				}
			}

			return null;
		}

		function generatePassword($size, $strengthLevel = 'MEDIUM')
		{
			// This function will create a random password of $size characters
			// Standard character dictionary without ambiguous characters
			$lowercaseDictionary = "abcdefgijkmnopqrstwxyz";
			$uppercaseDictionary = "ABCDEFGHJKLMNPQRSTWXYZ";
			$numbersDictionary = "23456789";
			$symbolDictionary = "*$-+?_&=!%{}/";

			// Define the password strength
			switch(strtoupper($strengthLevel))
			{
				case "LOW":
				{
					$dictionary = $lowercaseDictionary;
					break;
				}
				case "MEDIUM":
				{
					$dictionary = $lowercaseDictionary . $numbersDictionary . $uppercaseDictionary;
					break;
				}
				case "HIGH":
				{
					$dictionary = $lowercaseDictionary . $numbersDictionary . $uppercaseDictionary . $symbolDictionary;
					break;
				}
				default:
				{
					$dictionary = $lowercaseDictionary . $numbersDictionary;
					break;
				}
			}

			$password = NULL;

			// Append a random character at the end of the password
			while(strlen($password) < $size)
			{	
				$password .= $dictionary{rand(0, strlen($dictionary))};
			}

			// Return the password
			return($password);
		}

		function logoutUser()
		{
			return parent::logout();
		}


		function isLoggedIn()
		{
			$currentUser = parent::user();
			if(!empty($currentUser['User']['id'])) { return true; }

			// Get the model AuthComponent
			$model =& $this->getModel();
			
			// Check for the Auth cookie
			$_authCookie = $this->controller->Cookie->read('srAuth');

			if(!empty($_authCookie))
			{

				// Do a query that will find a user record when given successful login data
				$userFromCookie = $model->find('first', array('conditions'=>array(
						'User.id' => $_authCookie['id'], 
						'User.disabled !=' => '0',  
					)));
				
				if($userFromCookie['User']['token'] === $_authCookie['token'])
				{
					// The token matched the one for the user
					if($this->shamrockAuthentication->authorizeUser($userFromCookie['User']['id']))
					{
						return true;
					}
				}
				else
				{
					// Delete the auth cookie
					$this->controller->Cookie->delete('srAuth');
				}
			}

			return false;
		}

		function isAllowed($userID = null, $controller = null, $action = null)
		{
			// Get the model AuthComponent
			$model =& $this->getModel();

			if(empty($controller))
			{
				$controller = $this->RequestHandler->params['controller'];
			}
			if(empty($action))
			{
				$action = $this->RequestHandler->params['action'];
			}

			if(!empty($userID))
			{
				// Do a query that will find the user
				$currentUser = $model->find('first', array('conditions'=>array(
						$this->userModel .'.id' => $userID,
					)));
			}
			else
			{
				$currentUser = parent::user();
			}

			if($currentUser === false)
			{
				// User not found
				return false;
			}

			// Check access at action level by checking the user
			$userACLs = array_pop($model->query("SELECT `Acl`.`id`, `Acl`.`access` FROM acls AS Acl WHERE `Acl`.`user_id`='". $currentUser[$this->userModel]['id'] 
				."' AND `Acl`.`controller`='". $controller
				."' AND `Acl`.`action`='". $action ."' LIMIT 1;"));
			if(!empty($userACLs))
			{
				if($userACLs['Acl']['access'] === "true") { return true; } else { return false; }
			}

			// Check access at controller level by checking the user
			$userACLs = array_pop($model->query("SELECT `Acl`.`id`, `Acl`.`access` FROM acls AS Acl WHERE `Acl`.`user_id`='". $currentUser[$this->userModel]['id'] 
				."' AND `Acl`.`controller`='". $controller
				."' AND `Acl`.`action`='' LIMIT 1;"));
			if(!empty($userACLs))
			{
				if($userACLs['Acl']['access'] === "true") { return true; } else { return false; }
			}

			// Check access at action level by checking the group
			$userACLs = array_pop($model->query("SELECT `Acl`.`id`, `Acl`.`access` FROM acls AS Acl WHERE `Acl`.`group_id`='". $currentUser[$this->userModel]['group_id'] 
				."' AND `Acl`.`controller`='". $controller
				."' AND `Acl`.`action`='". $action ."' LIMIT 1;"));
			if(!empty($userACLs))
			{
				if($userACLs['Acl']['access'] === "true") { return true; } else { return false; }
			}

			// Check access at controller level by checking the group
			$userACLs = array_pop($model->query("SELECT `Acl`.`id`, `Acl`.`access` FROM acls AS Acl WHERE `Acl`.`group_id`='". $currentUser[$this->userModel]['group_id'] 
				."' AND `Acl`.`controller`='". $controller
				."' AND `Acl`.`action`='' LIMIT 1;"));
			if(!empty($userACLs))
			{
				if($userACLs['Acl']['access'] === "true") { return true; } else { return false; }
			}

			// Check if the action is public
			$userACLs = array_pop($model->query("SELECT `Acl`.`id`, `Acl`.`access` FROM acls AS Acl WHERE `Acl`.`group_id`='"
				."' AND `Acl`.`user_id`='"
				."' AND `Acl`.`controller`='". $controller
				."' AND `Acl`.`action`='". $action ."' LIMIT 1;"));
			if(!empty($userACLs))
			{
				return true;
			}

			// Check if the controller is public
			$userACLs = array_pop($model->query("SELECT `Acl`.`id`, `Acl`.`access` FROM acls AS Acl WHERE `Acl`.`group_id`='"
				."' AND `Acl`.`user_id`='"
				."' AND `Acl`.`controller`='". $controller
				."' AND `Acl`.`action`='' LIMIT 1;"));
			if(!empty($userACLs))
			{
				return true;
			}

			// By defaul the user has no access
			return false;
		}

		function grant($controller, $action = '', $userID = '', $groupID = '')
		{
			$uuid = String::uuid();

			// Get the model AuthComponent
			$model =& $this->getModel();

			// Revoke the grants
			$this->revoke($controller, $action, $userID, $groupID, true);

			// Add the entry 
			$model->query("INSERT INTO acls VALUES ('". $uuid ."', '". $groupID ."', '". $userID ."', '". $controller ."', '". $action ."', 'true');");
		}

		function revoke($controller, $action = '', $userID = '', $groupID = '', $delete = false)
		{
			$uuid = String::uuid();

			// Get the model AuthComponent
			$model =& $this->getModel();

			// Check action and user
			if(($userID != '') && ($action != ''))
			{
				$userACLs = array_pop($model->query("SELECT `Acl`.`id`, `Acl`.`access` FROM acls AS Acl WHERE `Acl`.`user_id`='". $userID 
					."' AND `Acl`.`controller`='". $controller
					."' AND `Acl`.`action`='". $action ."' LIMIT 1;"));
				if(!empty($userACLs))
				{
					$model->query("DELETE FROM acls WHERE `acls`.`user_id`='". $userID 
						."' AND `acls`.`controller`='". $controller
						."' AND `acls`.`action`='". $action ."';");
				}

				$groupID = '';
			}

			// Check controller and user
			if($userID != '')
			{
				$userACLs = array_pop($model->query("SELECT `Acl`.`id`, `Acl`.`access` FROM acls AS Acl WHERE `Acl`.`user_id`='". $userID 
					."' AND `Acl`.`controller`='". $controller ."' LIMIT 1;"));
				if(!empty($userACLs))
				{
					$model->query("DELETE FROM acls WHERE `acls`.`user_id`='". $userID 
						."' AND `acls`.`controller`='". $controller ."';");
				}

				$groupID = '';
			}

			// Check action and group
			if(($groupID != '') && ($action != ''))
			{
				$userACLs = array_pop($model->query("SELECT `Acl`.`id`, `Acl`.`access` FROM acls AS Acl WHERE `Acl`.`group_id`='". $groupID 
					."' AND `Acl`.`controller`='". $controller
					."' AND `Acl`.`action`='". $action ."' LIMIT 1;"));
				if(!empty($userACLs))
				{
					$model->query("DELETE FROM acls WHERE `acls`.`group_id`='". $groupID 
						."' AND `acls`.`controller`='". $controller
						."' AND `acls`.`action`='". $action ."';");
				}
			}

			// Check controller and group
			if($groupID != '')
			{
				$userACLs = array_pop($model->query("SELECT `Acl`.`id`, `Acl`.`access` FROM acls AS Acl WHERE `Acl`.`group_id`='". $groupID 
					."' AND `Acl`.`controller`='". $controller ."' LIMIT 1;"));
				if(!empty($userACLs))
				{
					$model->query("DELETE FROM acls WHERE `acls`.`group_id`='". $groupID 
						."' AND `acls`.`controller`='". $controller ."';");
				}
			}

			// Add the entry 
			if(!$delete)
			{
				$model->query("INSERT INTO acls VALUES ('". $uuid ."', '". $groupID ."', '". $userID ."', '". $controller ."', '". $action ."', 'false');");
			}
		}

		function unpublish($controller)
		{
			$uuid = String::uuid();

			// Get the model AuthComponent
			$model =& $this->getModel();

			// Remove previous entries
			$model->query("DELETE FROM acls WHERE `acls`.`group_id`='' AND `acls`.`user_id`='' AND `acls`.`action`='' AND `acls`.`controller`='". $controller ."';");
		}

		function publish($controller)
		{
			$uuid = String::uuid();

			// Get the model AuthComponent
			$model =& $this->getModel();

			// Remove previous entries
			$this->unpublish($controller);

			// Make the controller public
			$this->grant($controller);
		}
	}
