<?php

App::uses('AppController', 'Controller');

class WebplayersController extends AppController {

	public $uses = array('User', 'Record');
	public $layout = 'stm';

	public function beforeFilter() {
		parent::beforeFilter();
		// ログインなしで実行できるアクション
		$this->Auth->allow();
	}

	function index() {
		
		$loginUser = $this->Session->read('LOGIN_USER');
		$data = array();

		$recordId = $this->request->query['recordId'];

		$this->Record->bindForView();
		$data = $this->Record->findByRecord_id($recordId);
		
		if (empty($data)) {
			// データが無いときは検索画面へ
			$this->Session->setFlash('記録データがみつかりません', SET_FLASH_WARNING);
			$this->redirect(array('controller' => 'records', 'action' => 'search'));
		}

		// ユーザid
		$userId = $data['Record']['user_id'];
		// プレイヤーid
		$playerId = $data['Record']['player_id'];

		if(!empty($loginUser)){
			// ログインしている
			if ($data['Record']['is_public'] == ACCESS_LEVEL_PLAYER ||
				$data['Record']['is_public'] == ACCESS_LEVEL_UNIVERSE){
				// 選手に公開、宇宙に公開の場合、公開
				$this->__generatePlayer($playerId, $recordId);
			}else if ($data['Record']['user_id'] == $loginUser['User']['id']){
				// 記録が本人のものなら公開レベルにかかわらず公開
				$this->__generatePlayer($playerId, $recordId);
			}else{
				// それ以外は非公開
				$this->set('userId', $userId);
				$this->render('view_private');
			}
		}else{
			// ログインしていない
			if ($data['Record']['is_public'] == ACCESS_LEVEL_UNIVERSE){
				// 宇宙に公開の場合、公開
				$this->__generatePlayer($playerId, $recordId);
			}else{
				// それ以外は非公開
				$this->set('userId', $userId);
				$this->render('view_private');
			}
		}
	}

	// WebPlayer設定
	private function __generatePlayer($playerId, $recordId){
		// パスコード.unity側で一致する必要がある.
		$passcode = '8tktClgobQ52q6pF';
		
		// ハッシュ値計算
		$hash = Security::hash($playerId.$recordId.$passcode, 'md5', false);

		$this->set('playerId', $playerId);
		$this->set('recordId', $recordId);
		$this->set('hash', $hash);	
	}

}

?>
