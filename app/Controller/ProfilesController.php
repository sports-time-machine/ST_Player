<?php

App::uses('AppController', 'Controller');

class ProfilesController extends AppController {

	public $uses = array('Profile', 'User', 'Record', 'RecordImage', 'Image', 'Partner', 'Stm');
	public $layout = 'stm';

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow('view', 'viewId');
	}

	// ユーザーページ
	function view($player_id) {
		//小文字を大文字に変換
		$player_id = strtoupper($player_id);
		
		// User.idを取得
		$conditions = array('player_id' => $player_id);
		$fields = array('id');
		$data = $this->User->find('first', array('conditions' => $conditions, 'fields' => $fields));
		//pr($data);exit;
		
		if (empty($data)) {
			// データが無いときはマイページへ
			// TODO ログインしてないときは？
			$this->Session->setFlash('せんしゅデータがみつかりません', SET_FLASH_WARNING);
			$this->redirect(array('controller' => 'My', 'action' => 'index'));
		}
		
		// /n/User.id (viewId)へリダイレクト
		$this->redirect("/n/{$data['User']['id']}");
	}

	// ユーザーページ User.idで表示
	public function viewId($user_id) {
		$loginUser = $this->Session->read('LOGIN_USER');
		
		// プロフィール
		$this->User->bindForView();
		$data = $this->User->findById($user_id);
		if (empty($data)) {
			// 指定されたidのデータが無いときはマイページへ
			$this->Session->setFlash('せんしゅデータがみつかりません', SET_FLASH_WARNING);
			$this->redirect(array('controller' => 'My', 'action' => 'index'));
		}
		//pr($data);
		// 見ている人に合わせて、表示項目の公開レベルを適用した結果を表示
		$data = $this->Profile->applyAccessLevel($data, $loginUser);
		
		
		// 走った記録
		$conditions = array('Record.user_id' => $data['User']['id']);
		$r = $this->Record->find('all', array('conditions' => $conditions, 'order' => array('register_date' => 'desc')));
		$data['records'] = $r;
		
		
		// 一緒にはしった人
		$partners = $this->Partner->findPartnersByUserId($data['User']['id']);
		$data['partners'] = $partners;
		
		
		$this->set('data', $data);
		
		if ($user_id == $loginUser['User']['id']) {
			// idが自分自身の場合はマイページをレンダリング
			$this->render('view_id_my');
		}
	}

}
