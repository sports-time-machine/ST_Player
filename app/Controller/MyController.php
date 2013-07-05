<?php
App::uses('AppController', 'Controller');

class MyController extends AppController {

	public $uses = array('User', 'Record', 'Stm', 'Profile');
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
        // ページネーションと記録データの整形
        $records = $this->Record->setForView($this->paginate('Record', $conditions));

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
              
		$conditions = array('user_id' => $user_id);
        // ページネーションと記録データの整形
        $records = $this->Record->setForView($this->paginate('Record', $conditions));
          
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
        
        $this->set('records',$records);
    
		$user = $this->User->findByPlayer_id($player_id);
		$this->set(compact('user'));
	
        
    }
}

?>
