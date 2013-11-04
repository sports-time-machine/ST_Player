<?php
App::uses('AppModel', 'Model');

class RecordMovie extends AppModel
{
	public $name = 'RecordMovie';
	public $useTable = 'record_movies';
	public $primaryKey = 'id';
	
	// app_model.phpでconfig/validate/RecordMovie.phpを読み込み
	public $validate = array();
	
	public $belongsTo = array(
		'Image' => array(
			'className' => 'Image',
		),
	);
}
