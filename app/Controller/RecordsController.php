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
        
        //表示のための加工(共通化してModelにいれるつもり)
        foreach ($records as &$record) {
            //タグの加工
            //タグを","で分割
            $tags_str = explode(",", $record['Record']['tags']);          
            $record['Record']['tags'] = array();
            for ($i=0; $i<count($tags_str); $i++){
                $record['Record']['tags'][$i] = trim(mb_convert_kana($tags_str[$i], "s", "UTF-8"));
            }
          
            //日付の加工
            $date = strtotime($record['Record']['register_date']);
            $record['Record']['register_date'] = date('Y',$date)."年".date('n',$date)."月"
                    .date('j',$date)."日 ".date('G',$date)."時".date('i',$date)."分".date('s',$date)."秒"; 
        }
        $this->set('records',$records);
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
