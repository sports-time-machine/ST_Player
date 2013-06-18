<?php
App::uses('AppController', 'Controller');

class RecordsController extends AppController {

	public $uses = array('Stm');
	public $layout = 'stm';

	public function beforeFilter() {
	}
	
	// 記録の表示
	function view($record_id) {
		// DBから読み込む
		$record = array(
			'Record' => array('record_id' => 'ABCD'),
			'Image' => array(
				0 => array('filename' => 'ABCD-1.png'),
				1 => array('filename' => 'ABCD-2.png'),
				),
			);
		$this->set(compact('record'));
	}
}

?>
