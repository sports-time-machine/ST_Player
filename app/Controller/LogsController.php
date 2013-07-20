<?php
class LogsController extends AppController {
	public $layout = 'admin';
	public $uses = array('Log');
	public $components = array('Search.Prg' => array(
		'model' => 'Log', // SearchPluginで使うモデルを指定
		'presetForm' => array(
	        'paramType' => 'named', // or 'querystring'
	        'model' => 'Log', // or a default model name
	    ),
	));
	public $presetVars = true;
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		// admin ユーザーだけ許可
		$loginUser = $this->Auth->user('User');
		if (!in_array($loginUser['username'], Configure::read('ADMIN_USERNAME_LIST'))) {
			// 本番環境ではメッセージは表示しない
			//$this->Session->setFlash('アクセス権がありません', SET_FLASH_ERROR);
			$this->redirect(array('controller' => 'users'));
		}
		
		// ログ定数
		$this->set('LOG_TYPE_LIST',    configure::read('LOG_TYPE_LIST'));
		$this->set('LOG_LEVEL_LIST',   configure::read('LOG_LEVEL_LIST'));
		$this->set('LOG_ACTION_LIST',  configure::read('LOG_ACTION_LIST'));
	}
	
	public function index() {
		$this->redirect(array('controller' => 'log', 'action' => 'search'));
	}
	
	public function search($type = null) {
		// ソート順の指定
		$this->paginate = array(
			'order' => array('created' => 'DESC'),
		);
		
		// 検索
		$this->Prg->commonProcess();
		$conditions = $this->Log->parseCriteria($this->passedArgs);
		//pr($conditions);
		$data = $this->paginate('Log', $conditions);
		
		$this->set('data', $data);
	}
	protected function _search_csv($data) {
		// ------------------------------------------------------------
		// CSV出力
		// ------------------------------------------------------------
		//pp($data);exit;
		$buf = '';
		
		$header = array(
				'ユーザー名', // 半角だとExcelで開くときにエラー？
				'ログ',
				'ログレベル',
				'操作',
				'画面',
				'データID',
				'接続元IPアドレス',
				'日時'
				);
		$buf .= implode(',', $header) . "\r\n";
		
		foreach($data as $d) {
			$array = array();
			$array[] = $d['Log']['username'];
			$array[] = '"' . $d['Log']['log'] . '"';
			$array[] = @$this->Log->log_level_list[ $d['Log']['loglevel'] ];
			$array[] = @$this->Log->log_action_list[ $d['Log']['action'] ];
			$array[] = $d['Log']['model'];
			$array[] = $d['Log']['affected_id'];
			$array[] = $d['Log']['ip'];
			$array[] = '="' . $d['Log']['create_at'] . '"';

			$buf .= implode(',', $array) . "\r\n";
		}
		$buf = mb_convert_encoding($buf, 'SJIS-win', 'UTF-8');
		//pp($buf);exit;
		
		$csv_file = sprintf('ログ_%s.csv', date('Ymd-Hi'));
		$this->Csv->output($buf, $csv_file);
		
		return;
	}
}