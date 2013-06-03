<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {
	
    public $uses = array('User');
    public $layout='stm';

	public function beforeFilter() {
        $this->Auth->allow('login', 'logout');  //ログインとログアウトしか許可しない
    }
	
	public function beforeRender() {
		parent::beforeRender();
    
        //認証されたユーザデータがあればデータ読み込み
        $user = $this->Auth->user();
        $this->set('user', $user);
	}
	
	function index(){ 
        
        
	}
    
    /**
     * ログイン機能
     */
    function login() {
        
        
        if ($this->request->is('ajax')) {
            //QRコードを利用してログイン
            
            $this->autoRender = false;      
            // POSTデータがなかったらNG
            if (empty($this->request->data)) echo "NG";
            if ($this->Auth->login()) {
                echo "OK";
            } else {
                echo "NG";
            }
            
        }else if ($this->request->is('post')) {
            //パスワードを利用してログイン           
            if ($this->Auth->login()) {
                $this->redirect($this->Auth->redirect());
            } else {   
                $this->Session->setFlash('ログインに失敗しました。選手名が違うか、QRコードが正しく読み取られていません。');
            }
        }
    }
    
    /**
     * ログアウト機能
     */
    function logout() {
        $this->redirect($this->Auth->logout());
    }
    
    /**
     * 選手追加機能
     */
    /* 選手追加は別アプリで対応予定
    function add() {
        
        if ($this->request->is('post')) {
            $this->User->create();
            
            //プレイヤーIDをハッシュ化
            $this->request->data['User']['player_id'] = AuthComponent::password($this->request->data['User']['player_id']);
            $this->User->set($this->request->data);
 
            if ($this->User->validates()) {
                $this->User->save($this->request->data);
                $this->Session->setFlash('選手登録が完了しました！');
            }else{
                $this->Session->setFlash('選手登録に失敗しました。この選手IDはすでに登録されています。');
            }
         
        }
        
    }
     */
    
    
}

?>
