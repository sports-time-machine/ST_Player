<?php
App::uses('AppController', 'Controller');

class ProfilesController extends AppController {

	public $uses = array('Profile', 'User', 'Record', 'RecordImage', 'Image', 'Stm');
	public $layout = 'stm';

	public function beforeFilter() {
		$this->Auth->allow('view');
	}
	
	// ユーザーページ
	function view($player_id) {
        
        //小文字を大文字に変換
        $player_id = strtoupper($player_id);
        $user = $this->User->findByPlayer_id($player_id);

        $conditions = array('user_id' => $user['User']['id']);
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
        
     
		$this->set(compact('user'));
	}
}

?>
