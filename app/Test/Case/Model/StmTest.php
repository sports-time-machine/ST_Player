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
		$USER_DATA = array('User' => array('player_id' => 'ABCD', 'username' => 'やまぐちたろう'));
		
		pr("選手データのチェック - 失敗");
		$data = array();
		$this->assertFalse($this->Stm->isValidUser($data));
		
		pr("選手データのチェック - 成功");
		$this->assertTrue($this->Stm->isValidUser($USER_DATA));
		
		pr("選手データの登録 - 成功");
		$this->assertTrue($this->Stm->userSave($USER_DATA));
		
	}
}
