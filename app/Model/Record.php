<?php
App::uses('AppModel', 'Model');

class Record extends AppModel
{
	public $name = 'Record';
	public $useTable = 'records';
	public $primaryKey = 'id';
	
	// app_model.phpでconfig/column_list/Record.php, config/validate/Record.phpを読み込み
	public $column_list = array();
	public $validate = array();
	
	public $hasMany = array(
		'RecordImage' => array(
			'className' => 'RecordImage',
			'fields' => array('record_id', 'image_id'),
			//'order' => 'RecordImage.no',
		)
	);
}
