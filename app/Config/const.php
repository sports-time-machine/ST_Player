<?php
// adminユーザー
Configure::write('ADMIN_USERNAME_LIST', array(
	'admin',
));
Configure::write('ADMIN_PASSWORD_LIST', array(
	'admin' => md5('stmadmin'),
));

// setFlashメッセージの種類
// ex. $this->setFlash($msg, SET_FLASH_INFO);
// default = SET_FLASH_INFO
define('SET_FLASH_INFO',    'info');
define('SET_FLASH_SUCCESS', 'success');
define('SET_FLASH_WARNING', 'warning');
define('SET_FLASH_ERROR',   'error');

?>