<?php
	class Group extends AppModel
	{
		var $hasMany = array('User');
	}