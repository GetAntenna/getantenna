<?php
	class AppController extends Controller
	{
		var $components = array('Session', 'Cookie', 'shamrockAuthentication', 'shamrockEmail', 'shamrockFeedback', 'shamrockDatetime');
		
		function beforeFilter()
		{
			// Setup the Authentication component
			$this->shamrockAuthentication->autoRedirect = false;
			$this->shamrockAuthentication->loginAction = array('controller' => 'users', 'action' => 'login');
			$this->shamrockAuthentication->logoutAction = array('controller' => 'users', 'action' => ',logout');
			$this->shamrockAuthentication->loginRedirect = array('controller' => 'editions', 'action' => 'index');
		}
	}