<?php
App::uses('AppModel', 'Model');

// スポーツタイムマシン ドメインモデル
class Stm extends AppModel
{
	public $name = 'Stm';
	public $useTable = false;
	
	public $IMAGE_DIR = '';
	
	// コンストラクタ
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		
		$this->IMAGE_DIR = APP . 'webroot' . DS . 'upload';
		//pr($IMAGE_DIR);
	}
	
	// 自分の記録
	public function myRecords() {
		$data = array(
			0 => array('Record' => array('record_id' => 'ABCD3')),
			1 => array('Record' => array('record_id' => 'EFGH3')),
			);
		return $data;
	}
	
	// ------------------------------------------------------------
	// 選手の登録・更新
	// ------------------------------------------------------------
	// 選手データのチェック
	public function isValidUser($data) {
		if (empty($data['User']['player_id'])) {
			return false;
		}
		return true;
	}
	
	// 選手データのハッシュチェック
	public function isValidUserHash($data) {
		// MD5チェック
		$md5src = $this->generateUserMd5($data);
		if ($md5src != $data['User']['md5hex']) {
			return false;
		}
		
		return true;
	}
	public function generateUserMd5($data) {
		// TODO 登録日のカラム名？
		return md5($data['User']['player_id']);
	}
	
	// 選手データを保存する
	public function userSave($data) {
		$this->loadModel(array('User'));
		
		// 関連付けるUserデータ
		$conditions = array('player_id' => $data['User']['player_id']);
		$user = $this->User->find('first', array('conditions' => $conditions));
		
		// 保存するフィールド
		$fields = array('player_id', 'username', 'created', 'modified');
		
		if (empty($user)) {
			// 未登録の場合は新規登録
			$this->User->create();
			$result = $this->User->save($data['User'], true, $fields);
		} else {
			// 登録済みの場合は更新
			$this->User->id = $user['User']['id'];
			$result = $this->User->save($data['User'], true, $fields);
		}
		
		if (!is_array($result)) {
			return false;
		}
		
		return true;
	}
	
	
	
	// ------------------------------------------------------------
	// 記録の呼び出し
	// ------------------------------------------------------------
	public function record($record_id) {
		$this->loadModel(array('User', 'Record', 'RecordImage', 'Partner', 'Image'));
		
		// image呼び出し用
		$this->Record->bindForView();
		$r = $this->Record->findByRecord_id($record_id);
		if (empty($r)) {
			return array();
		}
		//pr($r);exit;
		$u = $this->User->findById($r['Record']['user_id']);
		
		// 整形
		$data = array(
			'User' => $u['User'],
			'Record' => $r['Record'],
			'Partner' => array(),
			'Image' => array(),
		);
		foreach ($r['Partner'] as $k => $v) {
			$data['Partner'][] = array('partner_id' => $v['partner_id']);
		}
		foreach ($r['RecordImage'] as $k => $v) {
			$data['Image'][] = array(
				'filename' => $v['Image']['filename'],
				'ext'      => $v['Image']['ext'],
				'mime'     => $v['Image']['mime'],
				'size'     => $v['Image']['size'],
				'width'    => $v['Image']['width'],
				'height'   => $v['Image']['height'],
				);
			
		}
		//pr($data);
		
		return $data;
	}
	
	// ------------------------------------------------------------
	// 記録の登録
	// ------------------------------------------------------------
	// 走った記録データのチェック
	public function isValidRecord($data) {
		if (empty($data['User']['player_id'])) {
			return false;
		}
		// TODO 選手データがDBにあるかどうかチェックする
		
		return true;
	}
	
	// 走った記録データのハッシュチェック
	public function isValidRecordHash($data) {
		// MD5チェック
		$md5src = $this->generateRecordMd5($data);
		if ($md5src != $data['Record']['md5hex']) {
			return false;
		}
		
		return true;
	}
	public function generateRecordMd5($data) {
		return md5($data['Record']['player_id'] . ', ' . $data['Record']['record_id'] . ', ' . $data['Record']['register_date']);
	}
	
	// 新しい記録データかどうか
	public function isNewRecord($data) {
		$this->loadModel('Record');
		$r = $this->Record->findByRecord_id($data['Record']['record_id']);
		if (!empty($r)) {
			return false;
		}
		return true;
	}
	
	// 走った記録を保存する
	public function recordSave($data) {
		// 重複チェック
		if (!$this->isNewRecord($data)) {
			return false;
		}
		$this->loadModel(array('User', 'Record', 'RecordImage', 'Partner', 'Image'));
		$result = true;
		
		// トランザクション開始
		$this->begin();
		
		// 記録を保存する
		
		// 関連付けるUserデータ
		$conditions = array('player_id' => $data['User']['player_id']);
		$user = $this->User->find('first', array('conditions' => $conditions));
		
		// Userデータがないとき、新規登録する
		if (empty($user)) {
			$r = $this->userSave($data);
			if ($r === false) {
				return false;
			}
			$user = $this->User->find('first', array('conditions' => $conditions));
		}
		
		// 記録の保存
		$record = $data['Record'];
		$record['user_id']   = $user['User']['id'];
		$record['player_id'] = $user['User']['player_id'];
		$this->Record->create();
		$r = $this->Record->save($record);
		//pr($record);
		//pr($this->Record->id);
		if ($r === false) {
			$result = false;
		}
		
		// 記録画像の保存
		foreach($data['Image'] as $image) {
			$this->Image->create();
			$r = $this->Image->save($image);
			//pr($image);
			//pr($this->Image->id);
			if ($r === false) {
				$result = false;
			}
			
			// 画像と記録の関連付け
			$recordImage = array('record_id' => $this->Record->id, 'image_id' => $this->Image->id);
			$this->RecordImage->create();
			$r = $this->RecordImage->save($recordImage);
			if ($r === false) {
				$result = false;
			}
		}
		
		// 一緒に走った相手の保存
		foreach($data['Partner'] as $partner) {
			$partner['record_id'] = $this->Record->id;
			$this->Partner->create();
			$r = $this->Partner->save($partner);
			if ($r === false) {
				$result = false;
			}
		}
		//pr($data);
		
		// トランザクション終了
		if ($result === false) {
			$this->rollback();
			return false;
		}
		$this->commit();
		
		// 画像を保存
		if (!empty($data['Image'])) {
			// ディレクトリを作成
			$path = $this->generateImagePathFromPlayerId($data['User']['player_id']);
			$fullPath = $this->IMAGE_DIR . DS . $path;
			@mkdir($fullPath, 0755, true);
			
			foreach($data['Image'] as $image) {
				$file = $fullPath . DS . $image['filename'] . '.' . $image['ext'];
				//pr($file);exit;
				$data = base64_decode($image['data']);
				file_put_contents($file, $data);
			}
		}
		
		return true;
	}
	
	// 走った記録を削除する
	public function recordDelete($record_id) {
		
		// TODO 削除機能を実装
		
		return true;
	}

	// 各プレイヤーの画像ディレクトリのパスを生成
	// ABCD → D\C\B\A
	public function generateImagePathFromPlayerId($record_id) {
		// 正規化
		// TODO あとで共通化
		$record_id = strtoupper($record_id);
		
		// 逆から1文字ずつフォルダ階層にする
		$char_array = str_split(strrev($record_id));
		$path = implode(DS, $char_array);
		return $path;
	}
	
	
	
}
