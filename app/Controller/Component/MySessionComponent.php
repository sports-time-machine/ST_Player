<?php
App::uses('SessionComponent', 'Controller/Component');

class MySessionComponent extends SessionComponent {
	public function setFlash($message, $element = 'default', $params = array(), $key = 'flash') {
		$element = 'flash'.DS.$element; // $elementをflash/エレメント名に置き換えるだけ
		CakeSession::write('Message.' . $key, compact('message', 'element', 'params'));
	}
}
?>