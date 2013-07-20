<?php
class Log extends AppModel {
	public $name = 'Log';
	public $useTable = 'logs';
	public $primaryKey = 'id';
	// for Search Plugin
	public $actsAs = array('Search.Searchable');
	public $filterArgs = array(
		'keyword' => array('type' => 'like', 'field' => array('Log.log')),
	);

	public function _log($log, $logtype, $loglevel = LOG_ERROR, $model = null, $action = null, $affected_id = null) {
		$logtype = $this->empty2null($logtype);
		$loglevel = $this->empty2null($loglevel);
		$affected_id = $this->empty2null($affected_id);
		$action = $this->empty2null($action);
		// usernameを保存する
		$loginUser = $this->getLoginUser();
		//pr($loginUser);exit;
		if (!empty($loginUser['User']['player_id'])) {
			$username = $loginUser['User']['player_id'];
		} else {
			$username = null;
		}
		
		$data = array(
				'Log' => array(
					'username' => $username,
					'log' => $log,
					'logtype' => $logtype,
					'loglevel' => $loglevel,
					'model' => $model,
					'action' => $action,
					'affected_id' => $affected_id,
					'ip' => $_SERVER["REMOTE_ADDR"],
					'app' => null,
					)
				);
		$this->create();
		$this->save($data);
	}
	
	// CakePHPのログ出力
	public function _cakeLog($log, $loglevel = LOG_ERROR) {
		if ($loglevel == LOG_LEVEL_ERROR || $loglevel == LOG_LEVEL_WARN) {
			$cake_loglevel = 'error';
		} else {
			$cake_loglevel = 'debug';
		}
		CakeLog::write($cake_loglevel, $log);
	}
	
	
	public function systemLog($log, $loglevel = LOG_LEVEL_ERROR, $model = null, $action = null, $affected_id = null) {
		// DBに記録
		$this->_log($log, LOG_TYPE_SYSTEM, $loglevel, $model, $action, $affected_id);
		// CakePHPのログ出力
		$this->_cakeLog($log, $loglevel);
	}
	
	public function userLog($log, $loglevel = LOG_LEVEL_ERROR, $model = null, $action = null, $affected_id = null) {
		// DBに記録
		$this->_log($log, LOG_TYPE_USER, $loglevel, $model, $action, $affected_id);
		// CakePHPのログ出力
		$this->_cakeLog($log, $loglevel);
	}
	
	public function empty2null($str) {
		if (strcmp($str, '') == 0) {
			$str = null;
		}
		return $str;
	}
}