<?php

App::uses('AppController', 'Controller');
App::import('Vendor', 'phpqrcode/qrlib');   //QRコード表示

class MyController extends AppController {

	public $uses = array('User', 'Record', 'Stm', 'Profile', 'Partner');
	public $layout = 'stm';
	public $paginate = array('order' => 'Record.register_date DESC');

	public function beforeFilter() {
		parent::beforeFilter();
	}

	// Myページ n/id = profile/viewId へリダイレクト
	function index() {
		$loginUser = $this->Session->read('LOGIN_USER');
		$this->redirect("/n/{$loginUser['User']['id']}");
	}

	// 選手名編集
	function edit() {
		$loginUser = $this->Session->read('LOGIN_USER');

		//編集結果が来たら
		if ($this->request->is('post')) {
			$this->request->data['User']['id'] = $loginUser['User']['id'];
			$this->request->data['Profile']['id'] = $loginUser['Profile']['id'];
			$this->request->data['Profile']['user_id'] = $loginUser['User']['id'];
			//pr($this->request->data);exit;
			// TODO バリデーションチェック
			
			
			$this->User->save($this->request->data);
			$this->Profile->save($this->request->data);
			
			
			$this->Session->setFlash('プロフィールをへんこうしました！', SET_FLASH_SUCCESS);
			$this->redirect('/My');
		}
		
		$this->User->bindForView();
		$this->request->data = $this->User->findById($loginUser['User']['id']);
	}
	
	// 記録の一括編集
	public function recordsEdit() {
		$loginUser = $this->Session->read('LOGIN_USER');
		$this->Record->bindForRecordsEdit();
		
		$conditions = array('Record.player_id' => $loginUser['User']['player_id']);
		//$data = $this->Record->find('all', array('conditions' => $conditions));
		$data = $this->Paginate('Record', $conditions);
		$this->set('data', $data);
	}

	// 記録の表示
	public function record_view($record_id) {
		// Records/view へリダイレクト
		$this->redirect("/r/{$record_id}");
	}

	// 記録の編集
	public function record_edit($record_id) {
		$loginUser = $this->Session->read('LOGIN_USER');

		//編集結果が来たら
		if (!empty($this->request->data)) {
			$r = $this->Record->findById($this->request->data['Record']['id']);
			
			// 自分の記録かどうかチェック
			if ($r['Record']['user_id'] != $loginUser['User']['id']) {
				// 違うユーザの記録は変更できない
				$this->Session->setFlash('自分の記録データではありません', SET_FLASH_WARNING);
				$this->redirect(array('controller' => 'My', 'action' => 'index'));
			}
			
			// タグをカンマ区切りの文字列に変換 
			$tags_str = trim(mb_convert_kana(h($this->request->data['Record']['tags']), "as", "UTF-8"));
			$tags_str = preg_replace("/\s+/", ' ', $tags_str);
			$tags_str = str_replace(' ', ',', $tags_str);
			
			$record = array();
			$record['Record']['tags'] = h($tags_str);
			$record['Record']['comment'] = h($this->request->data['Record']['comment']);
			$record['Record']['is_public'] = h($this->request->data['Record']['is_public']);
			$record['Record']['register_date'] = $r['Record']['register_date'];
			
			$this->Record->id = $this->request->data['Record']['id'];
			$this->Record->save($record);
			$this->Session->setFlash('きろくデータをへんこうしました！', SET_FLASH_SUCCESS);
			
			$this->redirect("/r/{$r['Record']['record_id']}");
		}

		// DBから読み込む
		$this->Record->bindForView();
		$data = $this->Record->findByRecord_id($record_id);

		if (empty($data)) {
			// データが無いときはマイページへ
			$this->Session->setFlash('記録データがみつかりません', SET_FLASH_WARNING);
			$this->redirect(array('controller' => 'My', 'action' => 'index'));
		}

		if ($loginUser['User']['id'] != $data['Record']['user_id']) {
			// 違うユーザの記録は変更できない
			$this->Session->setFlash('自分の記録データではありません', SET_FLASH_WARNING);
			$this->redirect(array('controller' => 'My', 'action' => 'index'));
		}
		
		// タグをスペース区切りに変換
		$data['Record']['tags'] = str_replace(',', ' ', $data['Record']['tags']);
		$data['Record']['tags'] = preg_replace("/\s+/", ' ', $data['Record']['tags']);
		
		$this->request->data = $data;
	}

	//オブジェクトデータのダウンロード
	public function download($record_id, $filename) {
		$this->autoRender = false;

		$record_id = strtoupper($record_id);
		// 逆から1文字ずつフォルダ階層にする
		$char_array = str_split(strrev($record_id));
		$path = implode('/', $char_array);
		$filePath = 'webroot/upload/' . $path . '/' . $filename;

		$this->response->type(array('obj' => 'application/stm'));
		$this->response->type('obj');

		$this->response->file($filePath);
		$this->response->download($filename);
	}

}

?>
