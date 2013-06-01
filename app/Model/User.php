<?php
App::uses('AppModel', 'Model');

class User extends AppModel
{
	public $name = 'User';
	public $useTable = 'users';
	public $primaryKey = 'id';
	
	// app_model.phpでconfig/column_list/User.php, config/validate/User.phpを読み込み
	public $column_list = array();
	public $validate = array();
    
 
}
