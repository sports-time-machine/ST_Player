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
	
    public $validate = array(
        'id' => array(

        ),
        'player_id' => array(
            'rule0' => array(
                'rule' => 'notEmpty',
                'message' => '入力必須項目です',
                'allowEmpty' => false,
            ),
            'rule1' => array(
                'rule' => 'isUnique',
                'message' => 'この選手IDはすでに登録されています',
                'allowEmpty' => false,
            )
        )
    );
 
}
