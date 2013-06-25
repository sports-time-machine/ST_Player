<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	
	function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		
		// 外部ファイルが存在すれば、バリデーションを初期化
		$filename = APP . 'Config' . DS . 'validate' . DS . $this->name . '.php';
		if (file_exists($filename)) {
			require_once($filename);
			$this->validate = Configure::read(strtoupper('VALIDATE_' . $this->name));
		}
		
	}
	
	// モデルを読み込んでインスタンスを作成
	public function loadModel($models) {
		if (empty($models)) {
			return;
		}
		
		if (is_array($models)) {
			foreach($models as $model) {
				App::uses($model, 'Model');
				$this->{$model} = new $model;
				$this->{$model}->useDbConfig = $this->useDbConfig; // for UnitTest useDbConfigを引き継ぐ

			}
		} else {
			App::uses($models, 'Model');
			$this->{$models} = new $models;
			$this->{$models}->useDbConfig = $this->useDbConfig; // for UnitTest useDbConfigを引き継ぐ
		}
	}
	
	/**
	 * MySQLトランザクション用
	 */
	function begin() {
		$db = ConnectionManager::getDataSource($this->useDbConfig);
		$db->begin($this);
	}

	function commit() {
		$db = ConnectionManager::getDataSource($this->useDbConfig);
		$db->commit($this);
	}

	function rollback() {
		$db = ConnectionManager::getDataSource($this->useDbConfig);
		$db->rollback($this);
	}
}
