<?php
// $actsAs = array('Log') でモデルから$this->Logを利用可能にする
class LogBehavior extends ModelBehavior {
	var $Log = null;
	
	public function setup(Model $_model, $config = array()) {
		// Logモデルをロード
		App::import('Model', 'Log');
		$this->Log = new Log;
	}
	
	public function systemLog(Model $_model, $log, $loglevel = LOG_LEVEL_ERROR, $model = null, $action = null, $affected_id = null) {
		$this->Log->systemLog($log, $loglevel, $model, $action, $affected_id);
	}
	
	public function userLog(Model $_model, $log, $loglevel = LOG_LEVEL_ERROR, $model = null, $action = null, $affected_id = null) {
		$this->Log->userLog($log, $loglevel, $model, $action, $affected_id);
	}
}