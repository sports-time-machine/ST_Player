<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {
	
    public $uses = array('User');
    public $layout='stm';

	public function beforeFilter() {

	}
	
	public function beforeRender() {
		parent::beforeRender();

	}
	
	function index(){ 
        $this->redirect(login());
	}
    
    function login(){
        if ($this->request->is('post')) {
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
    
    /*
     * qrコードでのログイン
     */
    function ajax_qrlogin(){
        
        // ajaxでの呼び出しでなければリダイレクト
		if (!$this->request->is('ajax')) {
			return $this->redirect(array('action' => 'login'));
		}
        
        $this->autoRender = false;
        
        // POSTデータがなかったらリダイレクト
		if (empty($this->request->data)) {
			return $this->redirect(array('action' => 'login'));
		}
	
        //認証
        echo $this->User->QRCodeLogin($this->request->data['name'], $this->request->data['id']);
        
		return;
    
    }
    
}

?>
