<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'phpqrcode/qrlib');   //QRコード表示

class MyController extends AppController {

	public $uses = array('User', 'Record', 'Stm', 'Profile');
	public $layout = 'stm';
    public $paginate = array('order' => 'Record.register_date DESC');

	public function beforeFilter() {
		parent::beforeFilter();
	}
	
	// Myページ
	function index() {
		// player_id が直接取れない？
		$user_id = $this->Auth->user('id');
		$r = $this->User->findById($user_id);
		$player_id = $r['User']['player_id'];
              
		$conditions = array('user_id' => $user_id);
        // ページネーションと記録データの整形
        $records = $this->Record->setForView($this->paginate('Record', $conditions));

		$this->User->bindForView();
   		$user = $this->User->findByPlayer_id($player_id);
		$this->set(compact('user'));

        

        $this->set('records',$records);
     
	}
    
    // 選手名編集
    function edit() {
        
        //編集結果が来たら
        if ($this->request->is('post')) {
            
            $user = $this->User->findById($this->Auth->user('id'));
            $user['User']['username'] = h($this->request->data['User']['username']);
            
            $profile = $this->Profile->findByUserId($this->Auth->user('id'));
            $profile['Profile']['user_id'] = $this->Auth->user('id');
            $profile['Profile']['comment'] = h($this->request->data['User']['comment']);
      
            $this->User->set($user);
            $this->Profile->set($profile);
            
            $this->User->save();
            $this->Profile->save();
            $this->Session->setFlash('プロフィールをへんこうしました！', SET_FLASH_SUCCESS);
            $this->redirect('/My');
        }
        
		// player_id が直接取れない？
		$user_id = $this->Auth->user('id');
		$r = $this->User->findById($user_id);
		$player_id = $r['User']['player_id'];
              
        //Profileとのアソシエーション
        $bind = array(
			'hasOne' => array(
				'Profile' => array(
					'className' => 'Profile',
					'foreignKey' => 'user_id',
				),
			),
		);
		$this->User->bindModel($bind);
        
		$user = $this->User->findByPlayer_id($player_id);
		$this->set(compact('user'));
	
        
    }
    
    // 記録の表示
	public function record_view($record_id) {
		// bind
		$this->Record->bindForView();
		
		// DBから読み込む
		$records = $this->Record->findAllByRecord_id($record_id);
		if (empty($records)) {
			// データが無いときは検索画面へ
			$this->Session->setFlash('記録データがみつかりません', SET_FLASH_WARNING);
			$this->redirect(array('controller' => 'My', 'action' => 'index'));
		}
		
  		// 記録データの整形
        $records = $this->Record->setForView($records);    

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
        $partner = $this->Record->findByRecordId($records[0]['Partner'][0]['partner_id']);
        
		$this->set('record',$records[0]);
        if ($partner){
            $this->set('partner',$partner['Record']);
        }
	}
    
    // 記録の編集
	public function record_edit($record_id) {
        
        //編集結果が来たら
        if ($this->request->is('post')) {
            //タグデータを文字列に変換 
            $tags_str = trim(mb_convert_kana(h($this->request->data['Record']['tags']), "as", "UTF-8"));
            $tags_str = preg_replace("/\s+/",' ',$tags_str);

            $record = $this->Record->findById(h($this->request->data['Record']['id']));
            $record['Record']['tags'] = h($tags_str);
            $record['Record']['comment'] = h($this->request->data['Record']['comment']);
            
            $record['Record']['is_public'] = h($this->request->data['Record']['is_public']);
      
            $this->Record->set($record);
            $this->Record->save();
            $this->Session->setFlash('きろくデータをへんこうしました！', SET_FLASH_SUCCESS);
            $this->redirect('/My/record_view/'.h($record['Record']['record_id']));
        }
        
		// DBから読み込む
		$records = $this->Record->findAllByRecord_id($record_id);  
        
        // player_id が直接取れない？
		$user_id = $this->Auth->user('id');

        if (empty($records)) {
			// データが無いときはマイページへ
			$this->Session->setFlash('記録データがみつかりません', SET_FLASH_WARNING);
			$this->redirect(array('controller' => 'My', 'action' => 'index'));
		}
 
        if ($user_id !== $records[0]['Record']['user_id']){
            //違うユーザからのアクセスだったらマイページに戻す
            $this->Session->setFlash('記録データをへんしゅうできません', SET_FLASH_WARNING);
			$this->redirect(array('controller' => 'My', 'action' => 'index'));
        }
        
  		// 記録データの整形
        $records = $this->Record->setForView($records); 
        // タグをスペースで区切る
        $records[0]['Record']['tags'] = implode(',', $records[0]['Record']['tags']);
		$this->set('record',$records[0]);
	}
}

?>
