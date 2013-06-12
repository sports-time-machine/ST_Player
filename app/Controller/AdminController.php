<?php

class AdminController extends AppController {
	public $layout = 'admin';
	public $uses = array(
			'User',
		);
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		// TODO admin ユーザーだけ許可する
		//$this->Auth->allow(); // 仮
		
		$loginUser = $this->Auth->user('User');
		if (!in_array($loginUser['username'], Configure::read('ADMIN_USERNAME_LIST'))) {
			// 本番環境ではメッセージは表示しない
			//$this->Session->setFlash('アクセス権がありません', SET_FLASH_ERROR);
			$this->redirect(array('controller' => 'users'));
		}
	}
	
	public function index(){
		$this->redirect(array('controller' => 'admin', 'action' => 'users'));
	}
	
	// 選手一覧
	public function users() {
		/*
		$this->paginate = array(
			'limit' => 20,
			);
		*/
		$users = $this->paginate('User');
		$this->set('users', $users);
	}
	
	// 選手登録
	public function userAdd() {
		if ($this->request->is('post')) {
			pr($this->request->data);exit;
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('選手を登録しました', SET_FLASH_SUCCESS);
				$this->redirect(array('action' => 'users'));
			} else {
				$this->Session->setFlash('選手の登録に失敗しました', SET_FLASH_ERROR);
			}
		}
	}
	
	// 選手詳細
	public function user($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException('該当する選手が存在しません');
		}
		
		// Imageを読み込むため recursive = 2
		$this->User->recursive = 2;
		
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}
	
	// 選手変更
	public function userEdit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException('該当する選手が存在しません');
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'), SET_FLASH_SUCCESS);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'), SET_FLASH_ERROR);
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}
	
	// 選手削除
	public function userDelete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException('該当する選手が存在しません');
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'), SET_FLASH_SUCCESS);
			$this->redirect(array('action' => 'users'));
		}
		$this->Session->setFlash(__('User was not deleted'), SET_FLASH_ERROR);
		$this->redirect(array('action' => 'users'));
	}

	// 選手画像登録
	public function userImageAdd($id = null) {
		//pr($this->request->data); exit;
		if (!$this->User->exists($id)) {
			throw new NotFoundException('該当する選手が存在しません');
		}
		
		// トランザクション開始
		$this->User->begin();
		
		// Image登録
		$msg = '';
		$result = false;
		if (!empty($this->request->data)) {
			$this->Image->create($this->request->data);
			
			if ($this->Image->save()) {
				$msg .= "Image save OK! id = {$this->Image->id}\n";
				
				// UserImage登録
				$userImage = array('user_id' => $id, 'image_id' => $this->Image->id);
				$this->UserImage->create($userImage);
				if ($this->UserImage->save()) {
					$msg .= "UserImage save OK! id = {$this->UserImage->id}\n";
					$result = true;
				} else {
					$msg .= "UserImage save NG! rollbacked\n";
					$result = false;
				}
			} else {
				$msg .= "Image save NG! rollbacked\n";
				$result = false;
			}
		}
		
		// トランザクション終了
		if ($result) {
			$this->User->commit();
			$this->Session->setFlash(nl2br($msg), SET_FLASH_SUCCESS);
		} else {
			$this->User->rollback();
			$this->Session->setFlash(nl2br($msg), SET_FLASH_ERROR);
		}
		
		$this->redirect(array('action' => 'user', $id));
	}
	
	// 選手画像削除
	public function userImageDelete($userId, $userImageId = null) {
		$this->User->id = $userId;
		if (!$this->User->exists()) {
			throw new NotFoundException('該当する選手が存在しません');
		}
		$this->UserImage->id = $userImageId;
		if (!$this->UserImage->exists()) {
			throw new NotFoundException('該当する userImage がありません');
		}
		$this->request->onlyAllow('post', 'delete');
		
		$userImage = $this->UserImage->findById($userImageId);
		//pr($userImage);exit;
		
		$this->Image->id = $userImage['Image']['id'];
		if (!$this->Image->exists()) {
			throw new NotFoundException('該当する Image がありません');
		}
		
		
		// トランザクション開始
		$this->UserImage->begin();
		
		// UserImage削除
		$msg = '';
		$result = false;
		if ($this->UserImage->delete($userImageId)) {
			$msg .= __("UserImage delete OK!\n");
			// Image削除（アップロードされたファイルも同時に削除される）
			if ($this->Image->delete($userImage['Image']['id'])) {
				$msg .= __("Image delete OK!\n");
				$result = true;
			} else {
				$msg .= __("Image delete NG! rollbacked\n");
				$result = false;
			}
		} else {
			$msg .= __("UserImage delete NG! rollbacked\n");
			$result = false;
		}
		
		// トランザクション終了
		if ($result) {
			$this->UserImage->commit();
			$this->Session->setFlash(nl2br($msg), SET_FLASH_SUCCESS);
		} else {
			$this->UserImage->rollback();
			$this->Session->setFlash(nl2br($msg), SET_FLASH_ERROR);
		}
		
		$this->redirect(array('action' => 'user', $userId));
	}


}
?>
