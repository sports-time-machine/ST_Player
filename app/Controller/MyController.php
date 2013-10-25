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
		// bind
		$this->Record->bindForView();

		// DBから読み込む
		$records = $this->Record->findAllByRecord_id($record_id);
		if (empty($records)) {
			// データが無いときは検索画面へ
			$this->Session->setFlash('記録データがみつかりません', SET_FLASH_WARNING);
			$this->redirect(array('controller' => 'My', 'action' => 'index'));
		}

		// 記録データの整形
		$records = $this->Record->setForView($records);

		// 画像データの並べ替え
		if (!empty($records[0]['RecordImage'])) {
			$recordImage = array();
			foreach ($records[0]['RecordImage'] as $k => $v) {
				$n = substr($v['Image']['filename'], strrpos($v['Image']['filename'], '-') + 1);
				$recordImage[$n] = $v;
			}
			ksort($recordImage);
			$records[0]['RecordImage'] = $recordImage;
		}

		//Partnerとのアソシエーション
		$bind = array(
			'hasOne' => array(
				'Partner' => array(
					'className' => 'Partner',
					'foreignKey' => 'record_id',
				),
			),
		);
		$this->Record->bindModel($bind);
		//パートナー情報を検索
		$partner = $this->Partner->getPartner($records[0]['Partner'][0]['partner_id']);
		//$partner = $this->Record->findByRecordId($records[0]['Partner'][0]['partner_id']);

		$this->set('record', $records[0]);
		if ($partner) {
			$this->set('partner', $partner);
		}
	}

	// 記録の編集
	public function record_edit($record_id) {

		//編集結果が来たら
		if ($this->request->is('post')) {
			//タグデータを文字列に変換 
			$tags_str = trim(mb_convert_kana(h($this->request->data['Record']['tags']), "as", "UTF-8"));
			$tags_str = preg_replace("/\s+/", ' ', $tags_str);

			$record = $this->Record->findById(h($this->request->data['Record']['id']));
			$record['Record']['tags'] = h($tags_str);
			$record['Record']['comment'] = h($this->request->data['Record']['comment']);

			$record['Record']['is_public'] = h($this->request->data['Record']['is_public']);

			$this->Record->set($record);
			$this->Record->save();
			$this->Session->setFlash('きろくデータをへんこうしました！', SET_FLASH_SUCCESS);
			$this->redirect('/My/record_view/' . h($record['Record']['record_id']));
		}

		// DBから読み込む
		$records = $this->Record->findAllByRecord_id($record_id);

		// player_id が直接取れない？
		$user_id = $this->Auth->user('id');

		if (empty($records)) {
			// データが無いときはマイページへ
			$this->Session->setFlash('記録データがみつかりません', SET_FLASH_WARNING);
			$this->redirect(array('controller' => 'My', 'action' => 'index'));
		}

		if ($user_id !== $records[0]['Record']['user_id']) {
			//違うユーザからのアクセスだったらマイページに戻す
			$this->Session->setFlash('記録データをへんしゅうできません', SET_FLASH_WARNING);
			$this->redirect(array('controller' => 'My', 'action' => 'index'));
		}

		// 記録データの整形
		$records = $this->Record->setForView($records);
		// タグをスペースで区切る
		$records[0]['Record']['tags'] = implode(',', $records[0]['Record']['tags']);
		$this->set('record', $records[0]);
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
