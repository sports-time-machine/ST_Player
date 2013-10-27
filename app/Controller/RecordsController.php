<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'phpqrcode/qrlib');   //QRコード表示

class RecordsController extends AppController {

	public $uses = array('Record','Partner'/*, 'User'*/);
	public $layout = 'stm';
	public $components = array('Search.Prg' => array(
		'model' => 'Record', // SearchPluginで使うモデルを指定
	));
    public $paginate = array('order' => 'Record.register_date DESC');

	public function beforeFilter() {
		parent::beforeFilter();
		
		// ログインなしで実行できるアクション
		$this->Auth->allow();
	}
	
	// 記録の検索
	public function index() {
		$this->redirect(array('action' => 'search'));
	}
	public function search() {
		// 検索フォームのバリデーションを無効化
		$this->Record->validate = array();
		// 検索条件をビューでセットするための指定
		$this->presetVars = array(
			array('field' => 'keyword', 'type' => 'value'),
		);
		// bind
		$this->Record->bindForSearch();
		
		// 検索
		$this->Prg->commonProcess();
		$conditions = $this->Record->parseCriteria($this->passedArgs);
        
        //and検索条件がなければ追加
        if (!isset($conditions['AND'])) $conditions['AND'] = array();
        //非公開記録は検索しない
        array_push($conditions['AND'], array('Record.is_public ' => true));
        //pr($conditions);
		// ページネーションと記録データの整形
        $records = $this->Record->setForView($this->paginate('Record', $conditions));
        $this->set('records',$records);
	}
	
	// 記録の表示
	public function view($record_id) {
		$loginUser = $this->Session->read('LOGIN_USER');
		$data = array();
		
		// bind
		$this->Record->bindForView();
		$data = $this->Record->findByRecord_id($record_id);
		//pr($data);
		
		if (empty($data)) {
			// データが無いときは検索画面へ
			$this->Session->setFlash('記録データがみつかりません', SET_FLASH_WARNING);
			$this->redirect(array('controller' => 'records', 'action' => 'search'));
		}
		
		// 画像の並べ替え
		$data = $this->view_sortRecordImages($data);
		
		// パートナー情報のセット
		//pr($data['Partner']);
		$partner = $this->Partner->getPartnerInfo($data['Partner'][0]['partner_id']);
		//pr($partner);
		$data['Partner'][0] = $partner;
		
		$partners = $this->Partner->getPartnerByRecordId($data['Record']['id']);
		//pr($partners);
		$data['partners'] = $partners;
		
		
		// タグの分割
		$data['Record']['tags'] = $this->Record->extractTags($data['Record']['tags']);
		
		
		$this->set('data', $data);
		if ($data['Record']['user_id'] == $loginUser['User']['id']) {
			// user_idが自分自身の場合はマイページをレンダリング
			$this->render('view_my');
			return;
		}
		if (empty($loginUser) && $data['Record']['is_public'] == ACCESS_LEVEL_PLAYER || $data['Record']['is_public'] == ACCESS_LEVEL_SELF) {
			// ログインしていない、かつせんしゅに公開、じぶんに公開の場合は非公開
            $this->render('view_private');
            return;
		}
		if (!empty($loginUser) && $data['Record']['is_public'] == ACCESS_LEVEL_SELF) {
			// ログインしている、かつじぶんに公開の場合は非公開
            $this->render('view_private');
            return;
		}
	}

	// RecordImagesの並べ替え
	public function view_sortRecordImages($data) {
		if (!empty($data['RecordImage'])) {
			$recordImage = array();
			foreach($data['RecordImage'] as $k => $v) {
				$n = substr($v['Image']['filename'], strrpos($v['Image']['filename'], '-') + 1);
				$recordImage[$n] = $v;
			}
			ksort($recordImage);
			$data['RecordImage'] = $recordImage;
		}
		return $data;
	}
    
    //オブジェクトデータのダウンロード
    public function download($record_id, $filename) {
        $this->autoRender = false;

        $record_id = strtoupper($record_id);
		// 逆から1文字ずつフォルダ階層にする
		$char_array = str_split(strrev($record_id));
		$path = implode('/', $char_array);
		$filePath = 'webroot/upload/' . $path . '/' . $filename;
        
        $this->response->type(array('obj' => 'application/stm'));
        $this->response->type('obj');
        
        $this->response->file($filePath);
        $this->response->download($filename);
    }
   
}

?>
