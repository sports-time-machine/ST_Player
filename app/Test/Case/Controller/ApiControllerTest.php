<?php
App::uses('ApiController', 'Controller');

/**
 * ApiController Test Case
 *
 */
class ApiControllerTest extends ControllerTestCase {
	var $start_time_ms = 0.000;
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
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
	}
	
	// 標準出力と実行時間(s)を返す
	public function myTestAction($url, $params = array()) {
		ob_start();
		
		$this->start_time_ms = microtime(true);
		parent::testAction($url, $params);
		$t = sprintf("%.3f", microtime(true) - $this->start_time_ms);
		
		$r = ob_get_contents();
		ob_end_clean();
		
		$b = number_format(strlen($r));
		echo ": $t s / $b bytes";
		return $r;
	}
	
	
	public function test_Api() {
		// API メソッドが存在しない場合はエラー
		echo "API not found";
		$data = array('key' => 'value');
		$r = $this->myTestAction('/api/hoge', array('data' => $data, 'method' => 'post'));
		pr($r);
		$expected = array(
			'code' => '401',
			'result' => array('message' => 'API Method was not found', 'data' => null),
			);
		$this->assertEquals($expected, json_decode($r, true));
		
		
		// 適切なデータを渡さなかった場合はエラー
		echo "playerAdd - NG";
		$array = array();
		$data = array('json' => json_encode($array));
		$r = $this->myTestAction('/api/playerAdd', array('data' => $data, 'method' => 'post'));
		pr($r);
		$expected = array(
			'code' => '402',
			'result' => array('message' => 'No data posted', 'data' => null),
			);
		$this->assertEquals($expected, json_decode($r, true));
		
		
		// 選手データ登録
		echo "playerAdd - OK";
		$array = array(
			'user_id'  => '12345678',
			'username' => 'たろう',
			'tag'      => '小学生,男子,犬',
			);
		$data = array('json' => json_encode($array));
		$r = $this->myTestAction('/api/playerAdd', array('data' => $data, 'method' => 'post'));
		pr($r);
		$expected = array(
			'code' => '200',
			'result' => array('message' => 'success', 'data' => null),
			);
		$this->assertEquals($expected, json_decode($r, true));
		
		
		// 選手データ削除
		echo "playerDelete - OK";
		$array = array(
			'user_id'  => '12345678',
			);
		$data = array('json' => json_encode($array));
		$r = $this->myTestAction('/api/playerDelete', array('data' => $data, 'method' => 'post'));
		pr($r);
		$expected = array(
			'code' => '200',
			'result' => array('message' => 'success', 'data' => null),
			);
		$this->assertEquals($expected, json_decode($r, true));
		
	}
}
