<?php
App::uses('AppController', 'Controller');

class MyController extends AppController {

	public $uses = array('Stm');
	public $layout = 'stm';

	public function beforeFilter() {
	}
	
	// Myページ
	function index() {
		$records = $this->Stm->myRecords();
		$this->set(compact('records'));
	}
}

?>
