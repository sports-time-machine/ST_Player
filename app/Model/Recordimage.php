<?php
App::uses('AppModel', 'Model');

class Recordimage extends AppModel
{
	public $name = 'Recordimage';
	public $useTable = 'recordimages';
	public $primaryKey = 'id';
	
	// app_model.phpでconfig/column_list/Recordimage.php, config/validate/Recordimage.phpを読み込み
	public $column_list = array();
	public $validate = array();
}
