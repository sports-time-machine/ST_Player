<?php
App::uses('AppController', 'Controller');

class MyController extends AppController {

	public $uses = array('User', 'Record', 'Stm');
	public $layout = 'stm';

	public function beforeFilter() {
	}
	
	// Myページ
	function index() {
		// player_id が直接取れない？
		$user_id = $this->Auth->user('id');
		$r = $this->User->findById($user_id);
		$player_id = $r['User']['player_id'];
		
		// TODO 以下を共通化
		// bind
		$bind = array(
			'hasMany' => array(
				'Record' => array(
					'className' => 'Record',
					'foreignKey' => 'user_id',
				),
			),
		);
		$this->User->bindModel($bind);
		
		$user = $this->User->findByPlayer_id($player_id);
		
		$this->set(compact('user'));
	}
}

?>