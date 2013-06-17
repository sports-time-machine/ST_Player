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
	
	// 走った記録のバリデーションチェック
	public function isValidPlayData($data) {
		if (empty($data['User']['player_id'])) {
			return false;
		}
		// TODO 選手データがDBにあるかどうかチェックする
		
		return true;
	}
	
	// 走った記録を保存する
	public function playDataSave($data) {
		$result = false;
		
		// トランザクション開始
		$this->begin();
		
		// 記録を保存する
		
		pr($data);
		$result = true;
		
		
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
