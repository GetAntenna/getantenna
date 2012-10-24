<?php
	class User extends AppModel
	{
		var $belongsTo = array('Group');
		var $validate = array(
			'firstname' => array(
				'rule' => 'notEmpty',
				'required' => true, 
			),
			'lastname' => array(
				'rule' => 'notEmpty',
				'required' => true, 
			),
			'email' => array(
				'rule' => 'email',
				'required' => true, 
			),
			'newpassword' => array(
				'rule' => 'passwordCheck',
				'field' => 'newpassword', 
			),
		);

		function passwordCheck($value, $params = array())
		{
			if($value['newpassword'] != '')
			{
				if(strlen($value['newpassword']) < 8)
				{
					return false;
				}
				else
				{
					$this->data['User']['password'] = Security::hash($value['newpassword'], null, true);
					$this->data['User']['token'] = Security::hash(md5($this->data['User']['password'] . time()), null, true);
					return true;
				}
			}
			return true;
		}
	}
