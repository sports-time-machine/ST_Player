<?php
App::uses('AppController', 'Controller');

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
		//pr($conditions);
		$records = $this->paginate('Record', $conditions);
        
        for ($i=0; $i<count($records); $i++){
            //タグの加工
            //タグを","で分割
            $tags_str = explode(",", $records[$i]['Record']['tags']);
            
            $records[$i]['Record']['tags'] = array();
            for ($j=0; $j<count($tags_str); $j++){
                $records[$i]['Record']['tags'][$j] = trim(mb_convert_kana($tags_str[$j], "s", "UTF-8"));
            }
            
            //日付の加工
            $date = strtotime($records[$i]['Record']['register_date']);
            $records[$i]['Record']['register_date'] = date('Y',$date)."年".date('n',$date)."月"
                    .date('j',$date)."日 ".date('G',$date)."時".date('i',$date)."分".date('s',$date)."秒";
            
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
