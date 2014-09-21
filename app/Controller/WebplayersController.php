<?php

App::uses('AppController', 'Controller');

class WebplayersController extends AppController {

	public $uses = array('User', 'Record', 'Stm');
	public $layout = 'stm';

	public function beforeFilter() {
		parent::beforeFilter();
	}

	function index() {
		
		$loginUser = $this->Session->read('LOGIN_USER');
		
		if ($this->request->is('get')) {
			$passcode = 'sportstimemachine';
			$userId = $this->request->query['userId'];
			$sptmId = $this->request->query['sptmId'];
			$hash = Security::hash( $userId.$sptmId.$passcode, 'md5', false);

			$this->set('userId', $userId);
			$this->set('sptmId', $sptmId);
			$this->set('hash', $hash);
		}
	}
}

?>
