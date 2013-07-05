<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {

	public $uses = array('User');
	public $layout = 'stm';

	public function beforeFilter() {
		$this->Auth->allow('index2', 'login', 'passwordLogin', 'adminLogin', 'logout');  //ログインとログアウトしか許可しない
	}
	
	// トップページ
	function index2() {
		// レンダリングを行わない
		$this->autoLayout = false;
		$this->autoRender = true;
	}
	
	// Myページへ
	function index() {
		$this->redirect(array('controller' => 'My', 'action' => 'index'));
	}


	/**
	 * ログイン機能
	 */
	public function login() {
        
        //既にログインしているのであればindexへリダイレクト
        if ($this->Auth->user()) $this->redirect(array('action' => 'index'));
        
        
		if ($this->request->is('ajax')) {
			//QRコードを利用してログイン
			$this->autoRender = false;
			// POSTデータがなかったらNG
			if (empty($this->request->data)) {
				echo "NG";
			}
			if ($this->Auth->login()) {
				echo "OK";
			} else {
				echo "NG";
			}
		} else if ($this->request->is('post')) {
			//パスワードを利用してログイン
			$this->passwordLogin();
		}
	}
	
	//パスワードを利用してログイン           
	public function passwordLogin() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash('ログインに失敗しました。選手名と選手番号を確認してもう一度入力してください', SET_FLASH_ERROR);
			}
		}
	}
	
	// 管理者ログイン
	public function adminLogin() {
		if ($this->request->is('post')) {
			$login = $this->request->data['User'];
			//pr($login);
			
			// 管理者ユーザーは特別処理
			$adminPasswordList = Configure::read('ADMIN_PASSWORD_LIST');
			if (in_array($login['username'], Configure::read('ADMIN_USERNAME_LIST'))
					&& md5($login['password']) == $adminPasswordList[$login['username']]) {
				
				// 初めてのログインの場合、管理者ユーザーを追加する
				$loginUser = $this->User->findByUsername($login['username']);
				if (empty($loginUser)) {
					// DBにはダミーパスワードを格納する
					$data = array('User' => array('username' => $login['username'], 'password' => '-1'));
					$this->User->save($data);
				}
				$loginUser = $this->User->findByUsername($login['username']);
				//pr($loginUser);exit;
				
				if ($this->Auth->login($loginUser)) {
					// 管理画面にリダイレクト
					$this->redirect(array('controller'  => 'admin', 'action' => 'index'));
				} else {
					$this->Session->setFlash('ログインに失敗しました', SET_FLASH_ERROR);
				}
			} else {
				$this->Session->setFlash('ログインに失敗しました', SET_FLASH_ERROR);
			}
			
		}
	}
	
	/**
	 * ログアウト機能
	 */
	public function logout() {
		$this->redirect($this->Auth->logout());
	}
}

?>
