<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {

	public $uses = array('User', 'Stm');
	public $layout = 'stm';

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow('index2', 'login', 'passwordLogin', 'adminLogin', 'logout');  //ログインとログアウトしか許可しない
	}

	// トップページ
	function index2() {
		// レンダリングを行わない
		$this->autoLayout = false;
		$this->autoRender = true;

		// user/index2 が指定されたときは / へリダイレクト
		if ($this->request->url == 'users/index2') {
			$this->redirect(FULL_BASE_URL . $this->webroot);
		}

		// 日々のデータ
		$sql = "SELECT DATE_FORMAT(created, '%Y-%m-%d') AS date, count(id) AS count FROM st_player.records WHERE '2015-10-01' < created GROUP BY DATE_FORMAT(created, '%Y%m%d');";
		$count_records = $this->User->query($sql);
		$count_records = Set::combine($count_records, '{n}.0.date', '{n}.0.count');
		$sql = "SELECT DATE_FORMAT(created, '%Y-%m-%d') AS date, count(id) AS count FROM st_player.users WHERE '2015-10-01' < created GROUP BY DATE_FORMAT(created, '%Y%m%d');";
		$count_users = $this->User->query($sql);
		$count_users = Set::combine($count_users, '{n}.0.date', '{n}.0.count');
		/*
		pr($count_records);
		pr($count_users);
		*/
		// カウンター表示用
		$start_time = strtotime('2015-10-24') + 43200;
		$end_time   = strtotime('2015-11-15') + 43200;

		$count_records_sum  = 0;
		$count_users_sum    = 0;
		for ($t = $start_time; $t <= $end_time; $t += 86400) {
			$date = date('Y-m-d', $t);

			$count_records_sum += @$count_records[$date];
			$count_users_sum   += @$count_users[$date];
		}
		$this->set('count_records_sum', $count_records_sum);
		$this->set('count_users_sum', $count_users_sum);


		$keys = array();
		// グラフ表示用
		$start_time = strtotime('2015-10-24') + 43200;
		$end_time   = strtotime('2015-11-15') + 43200;
		$count_records_full = array();
		$count_users_full   = array();

		// カウンター用
		$count_records_sum  = 0;
		$count_users_sum    = 0;
		for ($t = $start_time; $t <= $end_time; $t += 86400) {
			$date = date('Y-m-d', $t);
			$keys[] = date('n/j', $t);
			$count_records_full[] = intval(isset($count_records[$date]) ? $count_records[$date] : 0);
			$count_users_full[]   = intval(isset($count_users[$date]) ? $count_users[$date] : 0);

			$count_records_sum += @$count_records[$date];
			$count_users_sum   += @$count_users[$date];
		}
		/*
		pr($count_records_full);
		pr($count_users_full);
		pr($count_records_sum);
		pr($count_users_sum);
		*/
		//exit;
		$this->set('keys', $keys);
		$this->set('count_records_full', $count_records_full);
		$this->set('count_users_full', $count_users_full);
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
		$loginUser = $this->Session->read('LOGIN_USER');
		if (!empty($loginUser['User']['id'])) {
			$this->redirect("/n/{$loginUser['User']['id']}");
		}

		// player_idをショートIDに統一
		if (!empty($this->request->data['User']['player_id'])) {
			$this->request->data['User']['player_id'] = $this->Stm->generateShortPlayerId($this->request->data['User']['player_id']);
		}

		if ($this->request->is('ajax')) {
			//QRコードを利用してログイン
			$this->autoRender = false;

			// POSTデータがなかったらNG
			if (empty($this->request->data)) {
				echo "NG";
			}

			$this->log($this->request->data);

            // 選手コードから選手名を逆引き
            $user = $this->User->findByPlayerId($this->request->data['User']['player_id']);
			$this->request->data['User']['username'] = $user['User']['username'];

			if ($this->Auth->login()) {
				// ユーザー情報をセッションにセット
				$this->_setLoginUser($this->request->data['User']['player_id']);
				echo "OK";
			} else {
				echo "NG";
			}
		} else if ($this->request->is('post')) {

            // 選手名をtrim
            if (!empty($this->request->data['User']['username'])) {
                $this->request->data['User']['username'] = trim($this->request->data['User']['username']);
            }

			//パスワードを利用してログイン
			$this->passwordLogin();
		}
	}

	//パスワードを利用してログイン
	public function passwordLogin() {
		if ($this->request->is('post')) {

			//小文字を大文字に変換
			$this->request->data['User']['player_id'] = strtoupper($this->request->data['User']['player_id']);
			if ($this->Auth->login()) {
				// ユーザー情報をセッションにセット
				$this->_setLoginUser($this->request->data['User']['player_id']);

				$this->redirect(array('action' => 'login'));
			} else {
				// ログ
				$msg = @"ログインに失敗しました [{$this->request->data['User']['username']} / {$this->request->data['User']['player_id']}]";
				$this->Log->userLog($msg, LOG_LEVEL_WARN, $this->name, LOG_ACTION_LOGIN);

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
				$this->User->bindForView();
				$loginUser = $this->User->findByUsername($login['username']);
				//pr($loginUser);exit;

				if ($this->Auth->login($loginUser)) {
					// ユーザー情報をセッションにセット
					$this->Session->write('LOGIN_USER', $loginUser);
					// ログ
					$msg = @"{$loginUser['User']['username']} さんがログインしました";
					$this->Log->userLog($msg, LOG_LEVEL_INFO, $this->name, LOG_ACTION_LOGIN, $loginUser['User']['id']);
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

	public function _setLoginUser($player_id) {
		// ユーザー情報をセッションにセット
		$this->User->bindForView();
		$loginUser = $this->User->findByPlayer_id($player_id);
		//pr($loginUser);exit;
		$this->Session->write('LOGIN_USER', $loginUser);
		Configure::write('LOGIN_USER', $loginUser);

		// ログ
		$msg = @"{$loginUser['User']['username']} さんがログインしました";
		$this->Log->userLog($msg, LOG_LEVEL_INFO, $this->name, LOG_ACTION_LOGIN, $loginUser['User']['id']);
	}

	/**
	 * ログアウト機能
	 */
	public function logout() {
		$loginUser = $this->Session->read('LOGIN_USER');
		if (!empty($loginUser)) {
			// ログ
			$msg = @"{$loginUser['User']['username']} さんがログアウトしました";
			$this->Log->userLog($msg, LOG_LEVEL_INFO, $this->name, LOG_ACTION_LOGOUT, $loginUser['User']['id']);
		}

		// Sessionをクリア
		$this->Session->write('LOGIN_USER', null);
		$this->Session->destroy();

		// ログアウト処理
		$this->redirect($this->Auth->logout());
	}
}

?>
