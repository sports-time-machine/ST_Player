<?php
App::uses('AppModel', 'Model');

class Profile extends AppModel
{
	public $name = 'Profile';
	public $useTable = 'profiles';
	public $primaryKey = 'id';
	public $actsAs = array('Log');
	
	// app_model.phpでconfig/validate/Profile.phpを読み込み
	public $validate = array();
	
	public function applyAccessLevel($data, $loginUser) {
		$accessLevel = null;
		if (empty($loginUser)) {
			// ログインしていない場合、全宇宙公開では無い場合、非表示化
			//pr("ログインしていません");
			$accessLevel = ACCESS_LEVEL_UNIVERSE;
			if ($data['User']['nickname_is_public'] != ACCESS_LEVEL_UNIVERSE) {
				$data['User']['nickname'] = null;
				$data['User']['nickname_is_disabled'] = true;
			}
			if ($data['Profile']['age_is_public'] != ACCESS_LEVEL_UNIVERSE) {
				$data['Profile']['age'] = null;
				$data['Profile']['age_is_disabled'] = true;
			}
			if ($data['Profile']['gender_is_public'] != ACCESS_LEVEL_UNIVERSE) {
				$data['Profile']['gender'] = null;
				$data['Profile']['gender_is_disabled'] = true;
			}
			if ($data['Profile']['twitter_id_is_public'] != ACCESS_LEVEL_UNIVERSE) {
				$data['Profile']['twitter_id'] = null;
				$data['Profile']['twitter_id_is_disabled'] = true;
			}
			if ($data['Profile']['comment_is_public'] != ACCESS_LEVEL_UNIVERSE) {
				$data['Profile']['comment'] = null;
				$data['Profile']['comment_is_disabled'] = true;
			}
		} else if ($data['User']['id'] != $loginUser['User']['id']) {
			// 他人のデータの場合、自分にのみ公開の場合は非表示化
			//pr("他人のデータです");
			$accessLevel = ACCESS_LEVEL_PLAYER;
			if ($data['User']['nickname_is_public'] == ACCESS_LEVEL_SELF) {
				$data['User']['nickname'] = null;
				$data['User']['nickname_is_disabled'] = true;
			}
			if ($data['Profile']['age_is_public'] == ACCESS_LEVEL_SELF) {
				$data['Profile']['age'] = null;
				$data['Profile']['age_is_disabled'] = true;
			}
			if ($data['Profile']['gender_is_public'] == ACCESS_LEVEL_SELF) {
				$data['Profile']['gender'] = null;
				$data['Profile']['gender_is_disabled'] = true;
			}
			if ($data['Profile']['twitter_id_is_public'] == ACCESS_LEVEL_SELF) {
				$data['Profile']['twitter_id'] = null;
				$data['Profile']['twitter_id_is_disabled'] = true;
			}
			if ($data['Profile']['comment_is_public'] == ACCESS_LEVEL_SELF) {
				$data['Profile']['comment'] = null;
				$data['Profile']['comment_is_disabled'] = true;
			}
			
		} else {
			$accessLevel = ACCESS_LEVEL_SELF;
			// 自分のデータの場合はそのまま
		}
		
		// どのアクセスレベルで判定したかをセット
		$data['accessLevel'] = $accessLevel;
		
		return $data;
	}
}
