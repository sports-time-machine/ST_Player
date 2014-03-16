<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');
App::import('Vendor', 'phpqrcode/qrlib');   //QRコード表示

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $uses = array('Log');
    public $components = array(
		'Session' => array('className' => 'MySession'), // classNameを変更するものは先に読み込む
        'DebugKit.Toolbar',
        'Auth' => Array(
            'loginRedirect' => Array('controller'  => 'My', 'action' => 'index'),    //ログイン成功時リダイレクト先
            'logoutRedirect' => Array('controller' => 'users', 'action' => 'index2'),    //ログアウト時リダイレクト先
            'loginAction' => Array('controller' => 'users', 'action' => 'login'),       
            'authenticate' => Array('QRCode' => Array('fields' => Array('username' => 'username', 'password' => 'player_id')))
        ),
	);
	public $helpers = array('UploadPack.Upload');

	public function beforeFilter() {
		parent::beforeFilter();
		
		// 言語の設定
		App::import('Core', 'L10n');
		$this->L10n = new L10n();
		$this->__setLang();
			//$lang = 'ja';
			//Configure::write('Config.language', $lang);
			//$this->L10n->get($lang);
			//$this->Session->write('lang', $lang);
		
		// 認証情報をモデルに渡す
		if (!empty($this->Auth)) {
			Configure::write('LOGIN_USER', $this->Session->read('LOGIN_USER'));
		}
	}
	
	public function beforeRender() {
		parent::beforeRender();
		// ------------------------------------------------------------
		// viewに渡す変数
		// ------------------------------------------------------------
		// 本番環境かどうか
		$this->set('PRODUCTION', PRODUCTION);
		
		// デバッグレベル
		$this->set('DEBUG', Configure::read('debug'));
		
		// ログインユーザー情報
		$this->set('LOGIN_USER', $this->Session->read('LOGIN_USER'));
		
		// 性別リスト
		$this->set('GENDER_LIST', Configure::read('GENDER_LIST'));
		// 年齢リスト
		$this->set('AGE_LIST', Configure::read('AGE_LIST'));
		$age_select_list = array(null => 'えらんでください') + Configure::read('AGE_LIST');
		$this->set('AGE_SELECT_LIST', $age_select_list);
		// 公開レベルリスト
		$this->set('ACCESS_LEVEL_LIST', Configure::read('ACCESS_LEVEL_LIST'));
		// スペシャルパートナーリスト
		$this->set('SPECIAL_PARTNER_LIST', Configure::read('SPECIAL_PARTNER_LIST'));
	}
	
	private function __setLang() {
		if (!empty($this->params['named']['lang'])) {
			$lang = $this->params['named']['lang'];
			$this->L10n->get($lang);  
			$this->Session->write('lang', $lang);  
			$this->redirect($this->referer()); 
		} else if ($this->Session->read('lang')) {
			$lang = $this->Session->read('lang');
		}

		if (isset($lang)) {
			$this->L10n->get($lang);
			$this->Session->write('lang', $lang);
			Configure::write('Config.language', $lang);
		}
	}

}
