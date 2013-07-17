<?php
App::uses('AppController', 'Controller');

class ProfilesController extends AppController {

	public $uses = array('Profile', 'User', 'Record', 'RecordImage', 'Image', 'Stm');
	public $layout = 'stm';

	public function beforeFilter() {
		parent::beforeFilter();
		
		$this->Auth->allow('view');
	}
	
	// ユーザーページ
	function view($player_id) {
        
        //小文字を大文字に変換
        $player_id = strtoupper($player_id);  
        
        //Profileとのアソシエーション
        $bind = array(
			'hasOne' => array(
				'Profile' => array(
					'className' => 'Profile',
					'foreignKey' => 'user_id',
				),
			),
		);
		$this->User->bindModel($bind);
        
        $user = $this->User->findByPlayer_id($player_id);
		if (empty($user)) {
			// データが無いときはマイページへ
			$this->Session->setFlash('せんしゅデータがみつかりません', SET_FLASH_WARNING);
			$this->redirect(array('controller' => 'My', 'action' => 'index'));
		}
		
        $this->set(compact('user'));
        
        $conditions = array('user_id' => $user['User']['id']);
        // ページネーションと記録データの整形
        $records = $this->Record->setForView($this->paginate('Record', $conditions));
        $this->set('records',$records);

	}
}

?>
