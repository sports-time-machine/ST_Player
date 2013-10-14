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
		$data = array();
		
		// bind
		$this->Record->bindForView();
		
		// DBから読み込む
		$records = $this->Record->findAllByRecord_id($record_id);
		if (empty($records)) {
			// データが無いときは検索画面へ
			$this->Session->setFlash('記録データがみつかりません', SET_FLASH_WARNING);
			$this->redirect(array('controller' => 'records', 'action' => 'search'));
		}
        
        //非公開の記録
        if ($records[0]['Record']['is_public'] == false){
            $this->render('private');   //非公開ビューへ変更
            return;
        }
		
  		// 記録データの整形
        $records = $this->Record->setForView($records);     
		
		// 画像データの並べ替え
		if (!empty($records[0]['RecordImage'])) {
			$recordImage = array();
			foreach($records[0]['RecordImage'] as $k => $v) {
				$n = substr($v['Image']['filename'], strrpos($v['Image']['filename'], '-') + 1);
				$recordImage[$n] = $v;
			}
			ksort($recordImage);
			$records[0]['RecordImage'] = $recordImage;
		}
		
        //Partnerとのアソシエーション
        $bind = array(
			'hasOne' => array(
				'Partner' => array(
					'className' => 'Partner',
					'foreignKey' => 'record_id',
				),
			),
		);
		$this->Record->bindModel($bind);
        //パートナー情報を検索
        $partner = $this->Partner->getPartner($records[0]['Partner'][0]['partner_id']);
        //$partner = $this->Record->findByRecordId($records[0]['Partner'][0]['partner_id']);
        
		$this->set('record',$records[0]);
        if ($partner){
            $this->set('partner',$partner);
			
			$data['Partner'] = $partner;
        }
		
		$this->set('data', $data);
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
