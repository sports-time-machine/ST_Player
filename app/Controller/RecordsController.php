<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'phpqrcode/qrlib');   //QRコード表示

class RecordsController extends AppController {

	public $uses = array('Record'/*, 'User'*/);
	public $layout = 'stm';
	public $components = array('Search.Prg' => array(
		'model' => 'Record', // SearchPluginで使うモデルを指定
	));
    public $paginate = array('order' => 'Record.register_date DESC');
	public $presetVars = true;

	public function beforeFilter() {
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
		// bind
		$this->Record->bindForSearch();
		
		// 検索
		$this->Prg->commonProcess();
		$conditions = $this->Record->parseCriteria($this->passedArgs);
		// ページネーションと記録データの整形
        $records = $this->Record->setForView($this->paginate('Record', $conditions));
        $this->set('records',$records);
	}
	
	// 記録の表示
	public function view($record_id) {
		// bind
		$this->Record->bindForView();
		
		// DBから読み込む
		$records = $this->Record->findAllByRecord_id($record_id);
  		// 記録データの整形
        $records = $this->Record->setForView($records);     
		$this->set('record',$records[0]);
	}
    
   	// 記録の編集
	public function edit($record_id) {
        
        //編集結果が来たら
        if ($this->request->is('post')) {
            
            //タグデータを文字列に変換      
            foreach($this->request->data['Record']['tags'] as &$tag ){
                $tag = trim(mb_convert_kana(h($tag), "s", "UTF-8"));
            }
            $tags_str = implode(',', h($this->request->data['Record']['tags']));

            $record = $this->Record->findById(h($this->request->data['Record']['id']));
            $record['Record']['tags'] = h($tags_str);
            $record['Record']['comment'] = h($this->request->data['Record']['comment']);
      
            $this->Record->set($record);
            $this->Record->save();
            $this->Session->setFlash('きろくデータをへんこうしました！', SET_FLASH_SUCCESS);
            $this->redirect('/records/view/'.h($record['Record']['record_id']));
        }
        
		// DBから読み込む
		$records = $this->Record->findAllByRecord_id($record_id);      
  		// 記録データの整形
        $records = $this->Record->setForView($records); 
		$this->set('record',$records[0]);
	}
}

?>
