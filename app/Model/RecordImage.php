<?php
App::uses('AppModel', 'Model');

class RecordImage extends AppModel
{
	public $name = 'RecordImage';
	public $useTable = 'record_images';
	public $primaryKey = 'id';
	
	// app_model.phpでconfig/validate/RecordImage.phpを読み込み
	public $validate = array();
	
	public $belongsTo = array(
		'Image' => array(
			'className' => 'Image',
		),
	);
}
