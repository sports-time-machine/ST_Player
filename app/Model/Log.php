<?php
class Log extends AppModel {
	public $name = 'Log';
	public $useTable = 'logs';
	public $primaryKey = 'id';
	// for Search Plugin
	var $actsAs = array('Search.Searchable');
	var $filterArgs = array(
		'log' => array('type' => 'like', 'field' => array('Log.log')),
	);

	var $log_type_list = array(
		LOG_TYPE_SYSTEM => 'SYSTEM',
		LOG_TYPE_USER => 'USER',
	);
	
	var $log_level_list = array(
		LOG_LEVEL_ERROR => 'ERROR',
		LOG_LEVEL_WARN  => 'WARN',
		LOG_LEVEL_INFO  => 'INFO',
		LOG_LEVEL_DEBUG => 'DEBUG',
	);
	
	var $log_action_list = array(
		LOG_ACTION_CREATE => '登録',
		LOG_ACTION_READ   => '表示',
		LOG_ACTION_UPDATE => '変更',
		LOG_ACTION_DELETE => '削除',
		LOG_ACTION_LOGIN  => 'ログイン',
		LOG_ACTION_LOGOUT => 'ログアウト',
		LOG_ACTION_MAIL   => 'メール',
	);
	
	function _log($log, $logtype, $loglevel = LOG_ERROR, $model = null, $action = null, $affected_id = null) {
		$logtype = $this->empty2null($logtype);
		$loglevel = $this->empty2null($loglevel);
		$affected_id = $this->empty2null($affected_id);
		$action = $this->empty2null($action);
		// TODO ログインユーザーを考慮する
		if (!empty($_SESSION['FW_LOGIN_USER']['User']['username'])) {
			$username = $_SESSION['FW_LOGIN_USER']['User']['username'];
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
	function _cakeLog($log, $loglevel = LOG_ERROR) {
		if ($loglevel == LOG_LEVEL_ERROR || $loglevel == LOG_LEVEL_WARN) {
			$cake_loglevel = 'error';
		} else {
			$cake_loglevel = 'debug';
		}
		CakeLog::write($cake_loglevel, $log);
	}
	
	
	function systemLog($log, $loglevel = LOG_LEVEL_ERROR, $model = null, $action = null, $affected_id = null) {
		// DBに記録
		$this->_log($log, LOG_TYPE_SYSTEM, $loglevel, $model, $action, $affected_id);
		// CakePHPのログ出力
		$this->_cakeLog($log, $loglevel);
	}
	
	function userLog($log, $loglevel = LOG_LEVEL_ERROR, $model = null, $action = null, $affected_id = null) {
		// DBに記録
		$this->_log($log, LOG_TYPE_USER, $loglevel, $model, $action, $affected_id);
		// CakePHPのログ出力
		$this->_cakeLog($log, $loglevel);
	}
	
}