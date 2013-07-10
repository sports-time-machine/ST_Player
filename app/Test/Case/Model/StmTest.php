<?php
App::uses('Stm', 'Model');

/**
 * Stm Test Case
 *
 */
class StmTest extends CakeTestCase {
/**
 * test case startup
 *
 * @return void
 */
	public static function setupBeforeClass() {
	}
/**
 * cleanup after test case.
 *
 * @return void
 */
	public static function teardownAfterClass() {
	}

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Stm = ClassRegistry::init('Stm');
		// テーブルを空にする
		$this->Stm->query('DELETE FROM users;');
		$this->Stm->query('DELETE FROM profiles;');
		$this->Stm->query('DELETE FROM records;');
		$this->Stm->query('DELETE FROM record_images;');
		$this->Stm->query('DELETE FROM partners;');
		$this->Stm->query('DELETE FROM images;');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Stm);
		parent::tearDown();
	}
	
	
	public function test_Stm() {
		$USER_DATA = array('User' => array('player_id' => 'P0000ABCD', 'username' => 'やまぐちたろう'));
		
        /*
		pr("選手データのチェック - 失敗");
		$data = array();
		$this->assertFalse($this->Stm->isValidUser($data));
		
		pr("選手データのチェック - 成功");
		$this->assertTrue($this->Stm->isValidUser($USER_DATA));
		
		pr("選手データの登録 - 成功");
		$this->assertTrue($this->Stm->userSave($USER_DATA));
		
		pr("選手データの登録 - 存在する場合は更新");
		$this->assertTrue($this->Stm->userSave($USER_DATA));
		
        pr("選手名が空欄の時");
        $USER_DATA = array('User' => array('player_id' => 'P0000BCDE', 'username' => ''));
		
		pr("選手データのチェック - 失敗");
		$data = array();
		$this->assertFalse($this->Stm->isValidUser($data));
		
		pr("選手データのチェック - 成功");
		$this->assertTrue($this->Stm->isValidUser($USER_DATA));
		
		pr("選手データの登録 - 成功");
		$this->assertTrue($this->Stm->userSave($USER_DATA));
		
		pr("選手データの登録 - 存在する場合は更新");
		$this->assertTrue($this->Stm->userSave($USER_DATA));
		
		pr("記録データの登録 - 成功");
         */
		// テスト用画像データ
		$image = base64_encode(file_get_contents(APP . 'webroot' . DS . 'img' . DS . 'test-pass-icon.png'));
		// 記録データ
		$RECORD_DATA = array(
			'User' => array( // 選手を特定するデータ
				'username'  => 'やまぐちたろう',	// 選手名 文字列
				'player_id' => 'P0000ABCD',			// 選手ID 文字列
				),
			'Record' => array( // 走った記録
				'player_id' => 'P0000ABCD',			// 選手ID 文字列
				'record_id' => 'ABCD3',			// 記録ID(QRコード)
				'movie_path'   => '',			// 動画のパス 文字列
				'movie_length' => '',			// 動画の長さ 文字列 
				'register_date' => '',			// 登録日 'YYYY-MM-DD HH:MM:SS' 空なら現在時刻を生成
				'data' => '',					// 記録データ 文字列
				'tags' => '小学生,男子',			// タグ カンマ区切りの文字列
				'comment' => '',				// コメント 文字列
				'pattern' => 'まだら',			// 自分の色 文字列
				'sound' => 'ぽっぷ',				// 音 文字列
				'pattern' => '宇宙',				// 背景 文字列
				),
			'Partner' => array( // 一緒に走った相手
				0 => array(
					'partner_id' => 'ABCD2',			// 一緒に走った相手のID 文字列
					),
				1 => array(
					'partner_id' => 'ABCD3',			// 一緒に走った相手のID 文字列
					),
				// ... 当面は1人
				),
			'Image' => array( // 画像 6枚
				0 => array(
					'filename' => 'ABCD-1',		// ファイル名 文字列
					'ext' => 'png',				// 拡張子 文字列
					'mime' => 'image/png',		// jpgはimage/jpeg、pngはimage/png
					'width' => 1024,			// 画像の幅 数値
					'height' => 768,			// 画像の高さ 数値
					'data' => $image,			// 画像データをBASE64エンコードしたもの 文字列
					),
				1 => array(
					'filename' => 'ABCD-2',		// ファイル名 文字列
					'ext' => 'png',				// 拡張子 文字列
					'mime' => 'image/png',		// jpgはimage/jpeg、pngはimage/png
					'width' => 1024,			// 画像の幅 数値
					'height' => 768,			// 画像の高さ 数値
					'data' => $image,			// 画像データをBASE64エンコードしたもの 文字列
					),
				// ... 6枚登録？
				),
			);
		$RECORD_DATA['Record']['md5hex'] = md5($RECORD_DATA['Record']['player_id'] . ', ' . $RECORD_DATA['Record']['record_id'] . ', ' . $RECORD_DATA['Record']['register_date']);
		
		$this->assertTrue($this->Stm->recordSave($RECORD_DATA));  // 1回目は成功
		$this->assertFalse($this->Stm->recordSave($RECORD_DATA)); // 同じ記録は2回登録できない
		
	}
}
