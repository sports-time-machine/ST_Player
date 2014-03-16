<?php
// AppController.phpのBeforeFilterで読み込む

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

