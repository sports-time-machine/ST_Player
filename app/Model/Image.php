<?php
App::uses('AppModel', 'Model');

class Image extends AppModel
{
	public $name = 'Image';
	public $useTable = 'images';
	public $primaryKey = 'id';
	
	// app_model.phpでconfig/column_list/Image.php, config/validate/Image.phpを読み込み
	public $column_list = array();
	public $validate = array();
}
