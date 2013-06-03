<?php
App::uses('AppModel', 'Model');

class User extends AppModel
{
	public $name = 'User';
	public $useTable = 'users';
	public $primaryKey = 'id';

    public $validate = array(
        'id' => array(

        ),
        'username' => array(
            'rule0' => array(
                'rule' => 'notEmpty',
                'message' => '入力必須項目です',
                'allowEmpty' => false,
            ),
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
