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

// ログタイプリスト
Configure::write('LOG_TYPE_LIST', array(
	LOG_TYPE_SYSTEM => 'SYSTEM',
	LOG_TYPE_USER => 'USER',
));
// ログレベルリスト
Configure::write('LOG_LEVEL_LIST', array(
	LOG_LEVEL_ERROR => 'ERROR',
	LOG_LEVEL_WARN  => 'WARN',
	LOG_LEVEL_INFO  => 'INFO',
	LOG_LEVEL_DEBUG => 'DEBUG',
));
// ログアクションリスト
Configure::write('LOG_ACTION_LIST', array(
	LOG_ACTION_CREATE => '登録',
	LOG_ACTION_READ   => '表示',
	LOG_ACTION_UPDATE => '変更',
	LOG_ACTION_DELETE => '削除',
	LOG_ACTION_LOGIN  => 'ログイン',
	LOG_ACTION_LOGOUT => 'ログアウト',
	LOG_ACTION_MAIL   => 'メール',
));


// 性別一覧
Configure::write('GENDER_LIST', array(
	'男性' => __('男性（おとこのこ）'),
	'女性' => __('女性（おんなのこ）'),
	'その他' => __('その他（そのた）'),
));

// 年齢一覧
$age_list = array();
for ($i = 0; $i <= 150; $i++) {
	$age_list[$i] = $i;
}
Configure::write('AGE_LIST', $age_list);

// 公開レベル　じぶん・せんしゅ・全宇宙（うちゅう）
define('ACCESS_LEVEL_SELF',     0);
define('ACCESS_LEVEL_PLAYER',   1);
define('ACCESS_LEVEL_UNIVERSE', 99);
Configure::write('ACCESS_LEVEL_LIST', array(
	ACCESS_LEVEL_SELF     => __('じぶん　'),
	ACCESS_LEVEL_PLAYER   => __('全せんしゅ　'),
	ACCESS_LEVEL_UNIVERSE => __('全宇宙　'),
));
// アクセス拒否メッセージ
define('MESSAGE_ACCESS_DENIED', '<span class="access-denied">'.__('公開されていません').'</span>');

// スペシャルパートナーリスト
Configure::write('SPECIAL_PARTNER_LIST', array(
	'M:CHEETAH-1'   => __('チーター'),
	'M:ELEPHANT-3'  => __('アフリカゾウ'),
	'M:MUSAGI'      => __('ミナコウサギ'),
	'M:MIZUESAIBOU' => __('水江未来 細胞'),
	'M:PETER-1'     => __('Peter Millard 1'),
	'M:PETER-2'     => __('Peter Millard 2'),
));

