<?php
App::uses('AppModel', 'Model');

class User extends AppModel
{
	public $name = 'User';
	public $useTable = 'users';
	public $primaryKey = 'id';

	// for Search Plugin
	public $actsAs = array('Search.Searchable');
	public $filterArgs = array(
		'keyword' => array('type' => 'like', 'field' => array('User.player_id', 'User.username')),
	);
	
	// view用bind
	public function bindForView() {
        $bind = array(
			'hasOne' => array(
				'Profile' => array(
					'className' => 'Profile',
					'foreignKey' => 'user_id',
				),
			),
		);
		$this->bindModel($bind);
	}
}
