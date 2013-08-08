<?php
App::uses('AppModel', 'Model');

class RecordObject extends AppModel
{
	public $name = 'RecordObject';
	public $useTable = 'record_objects';
	public $primaryKey = 'id';
	
	// app_model.phpでconfig/validate/RecordObject.phpを読み込み
	public $validate = array();
	
	public $belongsTo = array(
		'Image' => array(
			'className' => 'Image',
		),
	);
}
