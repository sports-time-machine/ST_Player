<?php
App::uses('AppModel', 'Model');

class Partner extends AppModel
{
	public $name = 'Partner';
	public $useTable = 'partners';
	public $primaryKey = 'id';
	
	// app_model.phpでconfig/column_list/Partner.php, config/validate/Partner.phpを読み込み
	public $column_list = array();
	public $validate = array();
}
