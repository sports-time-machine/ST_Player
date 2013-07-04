<?php
App::uses('AppController', 'Controller');

class ProfilesController extends AppController {

	public $uses = array('Profile', 'User', 'Record', 'RecordImage', 'Image', 'Stm');
	public $layout = 'stm';

	public function beforeFilter() {
		$this->Auth->allow('view');
	}
	
	// ユーザーページ
	function view($player_id) {
        
        //小文字を大文字に変換
        $player_id = strtoupper($player_id);
        
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
