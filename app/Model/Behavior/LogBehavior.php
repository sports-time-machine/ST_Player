<?php
// $actsAs = array('Log') でモデルから$this->Logを利用可能にする
class LogBehavior extends ModelBehavior {
	var $Log = null;
	
	public function setup(Model $_model, $config = array()) {
		// Logモデルをロード
		App::import('Model', 'Log');
		$this->Log = new Log;
	}
	
	// システムログ
	public function systemLog(Model $_model, $log, $loglevel = LOG_LEVEL_ERROR, $model = null, $action = null, $affected_id = null) {
		$this->Log->systemLog($log, $loglevel, $model, $action, $affected_id);
	}
	
	// ユーザー操作のログ
	public function userLog(Model $_model, $log, $loglevel = LOG_LEVEL_ERROR, $model = null, $action = null, $affected_id = null) {
		$this->Log->userLog($log, $loglevel, $model, $action, $affected_id);
	}
	
	// saveログ
	public function afterSave(Model $model, $created) {
		parent::afterSave($model, $created);
		//pr($model->data);exit;
		/* 個別に記録する
		if ($created) {
			// INSERTの場合
			$log = "データを登録しました";
			$this->userLog($model, $log, LOG_LEVEL_INFO, $model->name, LOG_ACTION_CREATE, $model->data[$model->name]['id']);
		} else {
			// UPDATEの場合
			$log = "データを更新しました";
			$this->userLog($model, $log, LOG_LEVEL_INFO, $model->name, LOG_ACTION_UPDATE, $model->data[$model->name]['id']);
		}
		 */
	}
}