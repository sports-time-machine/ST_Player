<?php
App::uses('AppModel', 'Model');

class Profile extends AppModel
{
	public $name = 'Profile';
	public $useTable = 'profiles';
	public $primaryKey = 'id';
	public $actsAs = array('Log');
	
	// app_model.phpでconfig/validate/Profile.phpを読み込み
	public $validate = array();
}
