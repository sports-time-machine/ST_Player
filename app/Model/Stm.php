<?php
App::uses('AppModel', 'Model');

// スポーツタイムマシン ドメインモデル
class Stm extends AppModel
{
	public $name = 'Stm';
	public $useTable = false;
	
	// 走った記録のバリデーションチェック
	public function isValidPlayData($data) {
		return true;
	}
	
	// 走った記録を保存する
	public function playDataSave($data) {
		pr($data);
		return true;
	}

	// 各プレイヤーの画像ディレクトリのパスを生成
	public function generateImagePathFromPlayerId(Model $model, $player_id) {
		$path = $player_id;
		return $path;
	}
}
