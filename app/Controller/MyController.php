<?php
App::uses('AppController', 'Controller');

class MyController extends AppController {

	public $uses = array('User', 'Record', 'Stm');
	public $layout = 'stm';
    public $paginate = array('order' => 'Record.register_date DESC');

	public function beforeFilter() {
	}
	
	// Myページ
	function index() {
        
		// player_id が直接取れない？
		$user_id = $this->Auth->user('id');
		$r = $this->User->findById($user_id);
		$player_id = $r['User']['player_id'];
              
		$conditions = array('user_id' => $user_id);
		//pr($conditions);
		$records = $this->paginate('Record', $conditions);
        //pr($records);
        
		// TODO 以下を共通化
		// bind
		/* ページングで記録は取得するのでここでは不要？
        $bind = array(
			'hasMany' => array(
				'Record' => array(
					'className' => 'Record',
					'foreignKey' => 'user_id',
				),
			),
		);
		$this->User->bindModel($bind);
		*/
        
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
        
		$user = $this->User->findByPlayer_id($player_id);
		$this->set(compact('user'));

	}
}

?>
