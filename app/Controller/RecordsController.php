<?php
App::uses('AppController', 'Controller');

class RecordsController extends AppController {

	public $uses = array('Record', 'RecordImage', 'Image', 'Stm');
	public $layout = 'stm';

	public function beforeFilter() {
		// ログインなしで実行できるアクション
		$this->Auth->allow('view');
		
		// Imageを読み込むため recursive = 2
		$this->Record->recursive = 2;
	}
	
	// 記録の表示
	function view($record_id) {
		// DBから読み込む
		$record = $this->Record->findByRecord_id($record_id);
		/*
		$record = array(
			'Record' => array('record_id' => 'ABCD'),
			'Image' => array(
				0 => array('filename' => 'ABCD-1.png'),
				1 => array('filename' => 'ABCD-2.png'),
				),
			);
		 */
		$this->set(compact('record'));
	}
}

?>
