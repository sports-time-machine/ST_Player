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
        
		$user = $this->User->findByPlayer_id($player_id);
		
		$this->set(compact('user'));
        $this->set('records',$records);
	}
}

?>
