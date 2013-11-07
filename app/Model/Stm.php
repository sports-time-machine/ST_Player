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
		$this->loadModel(array('User', 'Profile'));
		
		// 関連付けるUserデータ
		$conditions = array('player_id' => $this->generateShortPlayerId($data['User']['player_id']));
		$user = $this->User->find('first', array('conditions' => $conditions));
		
		// 保存するフィールド
		$fields = array('player_id', 'username', 'created', 'modified');
	
        //ロングIDをショートIDに変換
        $data['User']['player_id'] = $this->generateShortPlayerId($data['User']['player_id']);

		if (empty($user)) {
			// 未登録の場合は新規登録
			$this->User->create();
			$result = $this->User->save($data['User'], true, $fields);
		} else {
			// 登録済みの場合は更新
			$this->User->id = $user['User']['id'];
			$result = $this->User->save($data['User'], true, $fields);
		}
		
		// プロフィールを保存
		$profile = $this->Profile->findByUser_id($this->User->id);
		if (empty($profile)) {
			$profile['Profile']['user_id'] = $this->User->id;
			$profile['Profile']['gender']  = !empty($data['Profile']['gender']) ? $data['Profile']['gender'] : null;
			$profile['Profile']['age']     = !empty($data['Profile']['age']) ? $data['Profile']['age'] : null;
			$this->Profile->save($profile);
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
		$conditions = array('player_id' => $this->generateShortPlayerId($data['User']['player_id']));
        
        //ロングIDをショートIDに変換
        $data['User']['player_id'] = $this->generateShortPlayerId($data['User']['player_id']);
        $data['Record']['player_id'] = $this->generateShortPlayerId($data['Record']['player_id']);
        
		$user = $this->User->find('first', array('conditions' => $conditions));
		
		// Userデータがないとき、新規登録する
		if (empty($user)) {
			$r = $this->userSave($data);
			if ($r === false) {
				return false;
			}
            //pr($data);
			$user = $this->User->find('first', array('conditions' => $conditions));
		}
        
		
		// 記録の保存
		$record = $data['Record'];
		$record['user_id']   = $user['User']['id'];
		$record['player_id'] = $this->generateShortPlayerId($user['User']['player_id']);
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
	
	// 走った記録に画像を追加する
	public function recordImageAdd($data) {
		// 新規データは対象外
		if ($this->isNewRecord($data)) {
			return false;
		}
		$this->loadModel(array('User', 'Record', 'RecordImage', 'Partner', 'Image'));
		$result = true;
		
		// 記録の呼び出し(Userも呼び出す)
		$this->Record->bindForAddImage();
		$record = $this->Record->findByRecord_id($data['Record']['record_id']);
		//pr($record);exit;
		
		// 以前の画像をすべて削除する
		$this->recordImageDelete($record);
		
		
		// トランザクション開始
		$this->begin();
		
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
			$recordImage = array('record_id' => $record['Record']['id'], 'image_id' => $this->Image->id);
			$this->RecordImage->create();
			$r = $this->RecordImage->save($recordImage);
			if ($r === false) {
				$result = false;
			}
		}
		
		// トランザクション終了
		if ($result === false) {
			$this->rollback();
			return false;
		}
		$this->commit();
		
		// 画像を保存
		if (!empty($data['Image'])) {
			// ディレクトリを作成
			$path = $this->generateImagePathFromPlayerId($record['User']['player_id']);
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
	
	// 走った記録にオブジェクトを追加する
	public function recordObjectAdd($data) {
		//pr($data);exit;
		// 新規データは対象外
		if ($this->isNewRecord($data)) {
			return false;
		}
		$this->loadModel(array('User', 'Record', 'RecordObject', 'Partner', 'Image'));
		$result = true;
		
		// 記録の呼び出し(Userも呼び出す)
		$this->Record->bindForAddImage();
		$record = $this->Record->findByRecord_id($data['Record']['record_id']);
		//pr($record);exit;
		
		// 以前のオブジェクトをすべて削除する
		$this->recordObjectDelete($record);
		
		
		// トランザクション開始
		$this->begin();
		
		// 記録オブジェクトの保存
		foreach($data['Object'] as $image) {
			$this->Image->create();
			$r = $this->Image->save($image);
			//pr($image);
			//pr($this->Image->id);
			if ($r === false) {
				$result = false;
			}
			
			// オブジェクトと記録の関連付け
			$recordObject = array('record_id' => $record['Record']['id'], 'image_id' => $this->Image->id);
			$this->RecordObject->create();
			$r = $this->RecordObject->save($recordObject);
			if ($r === false) {
				$result = false;
			}
		}
		
		// トランザクション終了
		if ($result === false) {
			$this->rollback();
			return false;
		}
		$this->commit();
		
		// オブジェクトを保存
		if (!empty($data['Object'])) {
			// ディレクトリを作成
			$path = $this->generateImagePathFromPlayerId($record['User']['player_id']);
			$fullPath = $this->IMAGE_DIR . DS . $path;
			@mkdir($fullPath, 0755, true);
			
			foreach($data['Object'] as $image) {
				$file = $fullPath . DS . $image['filename'] . '.' . $image['ext'];
				//pr($file);
				$data = base64_decode($image['data']);
				file_put_contents($file, $data);
			}
		}
		
		return true;
	}
	
	// 走った記録にオブジェクトを追加する（ファイルは保存しない。さくら用）
	public function recordObjectAddWithoutFile($data) {
		//pr($data);exit;
		// 新規データは対象外
		if ($this->isNewRecord($data)) {
			return false;
		}
		$this->loadModel(array('User', 'Record', 'RecordObject', 'Partner', 'Image'));
		$result = true;
		
		// 記録の呼び出し(Userも呼び出す)
		$this->Record->bindForAddImage();
		$record = $this->Record->findByRecord_id($data['Record']['record_id']);
		//pr($record);exit;
		
		// 以前のオブジェクトをすべて削除する
		$this->recordObjectDelete($record);
		
		
		// トランザクション開始
		$this->begin();
		
		// 記録オブジェクトの保存
		foreach($data['Object'] as $image) {
			$this->Image->create();
			$r = $this->Image->save($image);
			//pr($image);
			//pr($this->Image->id);
			if ($r === false) {
				$result = false;
			}
			
			// オブジェクトと記録の関連付け
			$recordObject = array('record_id' => $record['Record']['id'], 'image_id' => $this->Image->id);
			$this->RecordObject->create();
			$r = $this->RecordObject->save($recordObject);
			if ($r === false) {
				$result = false;
			}
		}
		
		// トランザクション終了
		if ($result === false) {
			$this->rollback();
			return false;
		}
		$this->commit();
		
		// 容量が足りないのでファイルは保存しない
		
		return true;
	}
	
	// 走った記録にムービーデータを追加する
	public function recordMovieAdd($data) {
		//pr($data);exit;
		// 新規データは対象外
		if ($this->isNewRecord($data)) {
			return false;
		}
		$this->loadModel(array('User', 'Record', 'RecordMovie', 'Partner', 'Image'));
		$result = true;
		
		// 記録の呼び出し(Userも呼び出す)
		$this->Record->bindForAddImage();
		$record = $this->Record->findByRecord_id($data['Record']['record_id']);
		//pr($record);exit;
		
		// 以前のオブジェクトをすべて削除する
		$this->recordMovieDelete($record);
		
		
		// トランザクション開始
		$this->begin();
		
		// 記録オブジェクトの保存
		foreach($data['Movie'] as $image) {
			$this->Image->create();
			$r = $this->Image->save($image);
			//pr($image);
			//pr($this->Image->id);
			if ($r === false) {
				$result = false;
			}
			
			// オブジェクトと記録の関連付け
			$recordMovie = array('record_id' => $record['Record']['id'], 'image_id' => $this->Image->id);
			$this->RecordMovie->create();
			$r = $this->RecordMovie->save($recordMovie);
			if ($r === false) {
				$result = false;
			}
		}
		
		// トランザクション終了
		if ($result === false) {
			$this->rollback();
			return false;
		}
		$this->commit();
		
		// オブジェクトを保存
		if (!empty($data['Movie'])) {
			// ディレクトリを作成
			$path = $this->generateImagePathFromPlayerId($record['User']['player_id']);
			$fullPath = $this->IMAGE_DIR . DS . $path;
			@mkdir($fullPath, 0755, true);
			
			foreach($data['Movie'] as $image) {
				$file = $fullPath . DS . $image['filename'] . '.' . $image['ext'];
				//pr($file);
				$data = base64_decode($image['data']);
				file_put_contents($file, $data);
			}
		}
		
		return true;
	}
	
	// 走った記録にムービーデータを追加する
	public function recordMovieAddWithoutFile($data) {
		//pr($data);exit;
		// 新規データは対象外
		if ($this->isNewRecord($data)) {
			return false;
		}
		$this->loadModel(array('User', 'Record', 'RecordMovie', 'Partner', 'Image'));
		$result = true;
		
		// 記録の呼び出し(Userも呼び出す)
		$this->Record->bindForAddImage();
		$record = $this->Record->findByRecord_id($data['Record']['record_id']);
		//pr($record);exit;
		
		// 以前のオブジェクトをすべて削除する
		$this->recordMovieDelete($record);
		
		
		// トランザクション開始
		$this->begin();
		
		// 記録オブジェクトの保存
		foreach($data['Movie'] as $image) {
			$this->Image->create();
			$r = $this->Image->save($image);
			//pr($image);
			//pr($this->Image->id);
			if ($r === false) {
				$result = false;
			}
			
			// オブジェクトと記録の関連付け
			$recordMovie = array('record_id' => $record['Record']['id'], 'image_id' => $this->Image->id);
			$this->RecordMovie->create();
			$r = $this->RecordMovie->save($recordMovie);
			if ($r === false) {
				$result = false;
			}
		}
		
		// トランザクション終了
		if ($result === false) {
			$this->rollback();
			return false;
		}
		$this->commit();
		/*
		// オブジェクトを保存
		if (!empty($data['Movie'])) {
			// ディレクトリを作成
			$path = $this->generateImagePathFromPlayerId($record['User']['player_id']);
			$fullPath = $this->IMAGE_DIR . DS . $path;
			@mkdir($fullPath, 0755, true);
			
			foreach($data['Movie'] as $image) {
				$file = $fullPath . DS . $image['filename'] . '.' . $image['ext'];
				//pr($file);
				$data = base64_decode($image['data']);
				file_put_contents($file, $data);
			}
		}
		*/
		return true;
	}
	
	// 走った記録を削除する
	public function recordDelete($record_id) {
		
		// TODO 削除機能を実装
		
		return true;
	}
	
	// 走った記録の画像を削除する
	public function recordImageDelete($record) {
		$this->loadModel(array('RecordImage', 'Image'));
		$recordImages = $this->RecordImage->find('all', array('conditions' => array('record_id' => $record['Record']['id'])));
		
		$path = $this->generateImagePathFromPlayerId($record['User']['player_id']);
		$fullPath = $this->IMAGE_DIR . DS . $path;
		
		foreach($recordImages as $recordImage) {
			$file = $fullPath . DS . $recordImage['Image']['filename'] . '.' . $recordImage['Image']['ext'];
			unlink($file);
			
			$this->Image->delete($recordImage['Image']['id']);
			$this->RecordImage->delete($recordImage['RecordImage']['id']);
		}
		
		return true;
	}
	
	// 走った記録のオブジェクトを削除する
	public function recordObjectDelete($record) {
		$this->loadModel(array('RecordObject', 'Image'));
		$recordImages = $this->RecordObject->find('all', array('conditions' => array('record_id' => $record['Record']['id'])));
		
		$path = $this->generateImagePathFromPlayerId($record['User']['player_id']);
		$fullPath = $this->IMAGE_DIR . DS . $path;
		
		foreach($recordImages as $recordImage) {
			$file = $fullPath . DS . $recordImage['Image']['filename'] . '.' . $recordImage['Image']['ext'];
			unlink($file);
			
			$this->Image->delete($recordImage['Image']['id']);
			$this->RecordObject->delete($recordImage['RecordObject']['id']);
		}
		
		return true;
	}
	
	// 走った記録のムービーを削除する
	public function recordMovieDelete($record) {
		$this->loadModel(array('RecordMovie', 'Image'));
		$recordImages = $this->RecordMovie->find('all', array('conditions' => array('record_id' => $record['Record']['id'])));
		
		$path = $this->generateImagePathFromPlayerId($record['User']['player_id']);
		$fullPath = $this->IMAGE_DIR . DS . $path;
		
		foreach($recordImages as $recordImage) {
			$file = $fullPath . DS . $recordImage['Image']['filename'] . '.' . $recordImage['Image']['ext'];
			unlink($file);
			
			$this->Image->delete($recordImage['Image']['id']);
			$this->RecordMovie->delete($recordImage['RecordMovie']['id']);
		}
		
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
	
	public function generateShortPlayerId($player_id) {
        
		$player_id = strtoupper($player_id);
		if (strlen($player_id) >= 8) {
			$player_id = preg_replace("/^P/",'',$player_id);    //最初のPを取り除く
		    $player_id = preg_replace("/^0+/",'',$player_id);    //先頭から連続する０を取り除く
		}
		
		return $player_id;
	}
	
}
