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


// ログ定数
// ログタイプ
define('LOG_TYPE_SYSTEM',     1);
define('LOG_TYPE_USER',       2);
// ログレベル
define('LOG_LEVEL_ERROR',     1);
define('LOG_LEVEL_WARN',      2);
define('LOG_LEVEL_INFO',      3);
define('LOG_LEVEL_DEBUG',     4);
// ログアクション
define('LOG_ACTION_CREATE',   1); // 作成
define('LOG_ACTION_READ',     2); // 表示
define('LOG_ACTION_UPDATE',   3); // 変更
define('LOG_ACTION_DELETE',   4); // 削除
define('LOG_ACTION_LOGIN',    5); // ログイン
define('LOG_ACTION_LOGOUT',   6); // ログアウト
define('LOG_ACTION_MAIL',     7); // メール

?>