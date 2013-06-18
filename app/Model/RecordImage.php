<?php
App::uses('AppModel', 'Model');

class RecordImage extends AppModel
{
	public $name = 'RecordImage';
	public $useTable = 'record_images';
	public $primaryKey = 'id';
	
	// app_model.phpでconfig/column_list/RecordImage.php, config/validate/RecordImage.phpを読み込み
	public $column_list = array();
	public $validate = array();
	
	public $belongsTo = array(
		'Image' => array(
			'className' => 'Image',
		),
	);
}
