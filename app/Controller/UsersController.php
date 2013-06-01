<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {
	
    public $uses = array('User');
    public $layout='stm';

	public function beforeFilter() {
        $this->Auth->allow('login', 'logout');
	}
	
	public function beforeRender() {
		parent::beforeRender();

	}
	
	function index(){ 
	}
    
    function login(){
        // ajaxでの呼び出し
		if ($this->request->is('ajax')) {
            $this->autoRender = false;
        
            // POSTデータがなかったらリダイレクト
            if (empty($this->request->data)) {
                return $this->redirect(array('action' => 'login'));
            }
  
            if ($this->Auth->login()) {
                $this->redirect($this->Auth->redirect());
            } else {
               //pr($this->request->data);
               echo "ログインに失敗しました。選手名が違うか、QRコードが正しく読み取られていません。";
            }
            
        }else if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->redirect($this->Auth->redirect());
            } else {   
              $this->Session->setFlash('ログインに失敗しました。選手名が違うか、QRコードが正しく読み取られていません。');
            }
        }
    }
    
    function logout(){
        $this->redirect($this->Auth->logout());
    }
    
    
}

?>
