<?php
App::uses('AppController', 'Controller');

class RecordsController extends AppController {

	public $uses = array('Record'/*, 'User'*/);
	public $layout = 'stm';
	public $components = array('Search.Prg' => array(
		'model' => 'Record', // SearchPluginで使うモデルを指定
	));
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
		//pr($conditions);
		$records = $this->paginate('Record', $conditions);
        
        for ($i=0; $i<count($records); $i++){
            //タグを","で分割
            $tags_str = explode(",", $records[$i]['Record']['tags']);
            
            $records[$i]['Record']['tags'] = array();
            for ($j=0; $j<count($tags_str); $j++){
                $records[$i]['Record']['tags'][$j] = trim(mb_convert_kana($tags_str[$j], "s", "UTF-8"));
            }
        }
        //pr ($records);
		$this->set('records', $records);
	}
	
	// 記録の表示
	public function view($record_id) {
		// bind
		$this->Record->bindForView();
		
		// DBから読み込む
		$record = $this->Record->findByRecord_id($record_id);
		$this->set(compact('record'));
	}
}

?>
