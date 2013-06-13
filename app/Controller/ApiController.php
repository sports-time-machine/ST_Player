<?php
App::uses('AppController', 'Controller');

// コード定数
define('API_SUCCESS',				0);
define('API_ERROR_NOMETHOD',		1);
define('API_ERROR_NODATA',			2);
define('API_ERROR_INVALID_DATA',	3);

class ApiController extends AppController {
    public $uses = array('Stm');

	public function beforeFilter() {
		parent::beforeFilter();
		
		// API はログインチェックをしない（APIキーをチェックするなど要検討）
		$this->Auth->allow();
		
		// レンダリングを行わない
		$this->autoLayout = false;
		$this->autoRender = false;
		
		// ------------------------------------------------------------
		// APIメソッドチェック
		// ------------------------------------------------------------
		//pr( get_class_methods('ApiController') );
		//pr($this->methods);exit;
		
		if (!in_array($this->action, $this->methods)) {
			// ログ
			//$this->Log->userLog("APIの呼び出しに失敗しました ( {$this->action} )", LOG_LEVEL_WARN, $this->name);
			
			// APIが存在しないとき用のアクションへ
			$this->action = 'dummy';
			return $this->outputHandler(API_ERROR_NOMETHOD);
		}
	}
	
	public function index(){
	}
	
	// 走った記録の保存
	public function playDataSave() {
		$json = null;
		if (!empty($this->request->data['json'])) {
			$json = $this->request->data['json'];
		}
		$data = json_decode($json, true);
		
		if (empty($data)) {
			return $this->outputHandler(API_ERROR_NODATA);
		}
		
		if (!$this->Stm->isValidPlayData($data)) {
			return $this->outputHandler(API_ERROR_INVALID_DATA);
		}
		
		// TODO 登録処理
		$r = $this->Stm->playDataSave($data);
		
		return $this->outputHandler(API_SUCCESS);
	}
	
	// 走った記録の保存デバッグ用
	public function playDataSaveDebug() {
		// POSTデータ
		print_r("POST DATA\n");
		print_r("------------------------------------------------------------\n");
		print_r($this->request->data);
		print_r("\n------------------------------------------------------------\n");
		
		$json = null;
		if (!empty($this->request->data['json'])) {
			$json = $this->request->data['json'];
		}
		
		print_r("JSON DATA\n");
		print_r("------------------------------------------------------------\n");
		print_r($json);
		print_r("\n------------------------------------------------------------\n");
		
		$data = json_decode($json, true);
		
		print_r("Array DATA\n");
		print_r("------------------------------------------------------------\n");
		print_r($data);
		print_r("\n------------------------------------------------------------\n");
		
		return;
	}
	
	// プレイヤー登録
	public function playerAdd() {
		$json = $this->request->data['json'];
		$data = json_decode($json, true);
		if (empty($data)) {
			return $this->outputHandler(API_ERROR_NODATA);
		}
		
		// TODO 登録処理
		
		return $this->outputHandler(API_SUCCESS);
	}
	
	// プレイヤー削除
	public function playerDelete() {
		$json = $this->request->data['json'];
		$data = json_decode($json, true);
		if (empty($data)) {
			return $this->outputHandler(API_ERROR_NODATA);
		}
		
		// TODO 削除処理
		
		return $this->outputHandler(API_SUCCESS);
	}
	
	// メソッドが無いとき用のダミーアクション
	public function dummy() {
		
	}
	
	// 
	protected function outputHandler($errorCode = null, $data = null) {
		$result = array();
		$result['result']['data'] = $data;
		
		if ($errorCode == API_SUCCESS) {
			$result['code'] = '200';
			$result['result']['message'] = 'success';
		} else if ($errorCode == API_ERROR_NOMETHOD) {
			$result['code'] = '401';
			$result['result']['message'] = 'API Method was not found';
		} else if ($errorCode == API_ERROR_NODATA) {
			$result['code'] = '402';
			$result['result']['message'] = 'No data posted';
		} else if ($errorCode == API_ERROR_INVALID_DATA) {
			$result['code'] = '403';
			$result['result']['message'] = 'invalid data';
		} else {
			$result['code'] = '400';
			$result['result']['message'] = 'Error';
		}
		echo json_encode($result);
		return;
	}
}

?>
