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
	
	// 走った記録のバリデーションチェック
	public function isValidRecord($data) {
		if (empty($data['User']['player_id'])) {
			return false;
		}
		// TODO 選手データがDBにあるかどうかチェックする
		
		return true;
	}
	
	// 走った記録のバリデーションチェック
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
		$this->log($data);
		$this->loadModel(array('User', 'Record', 'Recordimage', 'Partner', 'Image'));
		$result = true;
		
		// トランザクション開始
		$this->begin();
		
		// 記録を保存する
		
		// 関連付けるUserデータ
		$conditions = array('username' => $data['User']['username'], 'player_id' => $data['User']['player_id']);
		$user = $this->User->find('first', array('conditions' => $conditions));
		
		// TODO データがないときの処理
		
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
			$this->Recordimage->create();
			$r = $this->Recordimage->save($recordImage);
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
		
		
		pr($data);
		
		
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

	// 各プレイヤーの画像ディレクトリのパスを生成
	// ABCD → D\C\B\A
	public function generateImagePathFromPlayerId($player_id) {
		// 正規化
		// TODO あとで共通化
		$player_id = strtoupper($player_id);
		
		// 逆から1文字ずつフォルダ階層にする
		$char_array = str_split(strrev($player_id));
		$path = implode(DS, $char_array);
		return $path;
	}
}
