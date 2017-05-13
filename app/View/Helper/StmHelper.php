<?php
class StmHelper extends AppHelper {
	public $helpers = array('Html', 'Session');

	public function image($record_id, $filename, $htmlOptions = array()) {
		return $this->output($this->Html->image($this->url($record_id, $filename), $htmlOptions));
		//return $this->output($this->url($record_id, $filename));
	}

	public function url($record_id = null, $filename = null) {
		$record_id = strtoupper($record_id);

		// 逆から1文字ずつフォルダ階層にする
		$char_array = str_split(strrev($record_id));
		$path = implode('/', $char_array);

		$filePath = $this->base . '/upload/' . $path . '/' . $filename;

		return $filePath;
	}

	// 項目のオーナーと公開レベルによってアクセス可能かどうかを返す
	public function canAccess($data, $path) {
		$owner_user_id = $data['User']['id'];
		list($table, $column) = explode('.', $path);
		$access_level = @$data[$table][$column];
		//pr($table .'.'. $column);
		if ($table == 'Profile' && empty($data['Profile']['id'])) {
			$access_level = ACCESS_LEVEL_PLAYER; // プロフィールが未定義の時は全せんしゅに公開
		}

		$loginUser = $this->Session->read('LOGIN_USER');

		if (empty($loginUser)) {
			// ログインしていない場合、全宇宙に公開されていれば許可
			if ($access_level == ACCESS_LEVEL_UNIVERSE) {
				return true;
			}
		} else {
			// ログインしている場合
			if ($loginUser['User']['id'] == $owner_user_id) {
				// 自分のデータの場合、全て許可
				return true;
			} else {
				// 他人のデータの場合、全宇宙か全選手に公開されていれば許可
				if ($access_level == ACCESS_LEVEL_UNIVERSE || $access_level == ACCESS_LEVEL_PLAYER) {
					return true;
				}
			}
		}
		return false;
	}

	// パートナーの1行プロフィールを取得
	public function getPartnerProfileOneLine($item) {
		$nickname = $this->getUserNickname($item);
		$age      = $this->getProfileAgeRaw($item);
		$gender   = $this->getProfileGenderRaw($item);

		$html  = '';
		$html .= $this->Html->link($nickname, "/n/{$item['User']['id']}");
		if ((!empty($age) && $age != MESSAGE_ACCESS_DENIED) && (!empty($gender) && $gender != MESSAGE_ACCESS_DENIED)) {
			$html .= " ({$age}歳 $gender)";
		} else if (!empty($age) && $age != MESSAGE_ACCESS_DENIED) {
			$html .= " ({$age}歳)";
		} else if (!empty($gender) && $gender != MESSAGE_ACCESS_DENIED) {
			$html .= " ({$gender})";
		}
		return $html;
	}

	// パートナーの名前とURLへのリンク
	public function getPartnerNicknameLink($item) {
		if (empty($item)) {
			return null;
		}
		$special_partner_list = Configure::read('SPECIAL_PARTNER_LIST');
		$special_partner_id_list = array_keys($special_partner_list);
		$html = '';
		if (in_array($item['Partner']['partner_id'], $special_partner_id_list)) {
			$html = $special_partner_list[ $item['Partner']['partner_id'] ];
		} else {
			$nickname = h($this->getUserNickname($item));
			$html = $this->Html->link($nickname, "/n/{$item['User']['id']}");
		}
		return $html;
	}
	// せんしゅの名前とURLへのリンク
	public function getUserNicknameLink($data) {
		$nickname = h($this->getUserNickname($data));
		return $this->Html->link($nickname,"/n/".h($data['User']['id']));
	}
	// Twitterへのリンク
	public function getProfileTwitterIdLink($data) {
		$twitterId = $this->getProfileTwitterId($data);
		if ($twitterId == MESSAGE_ACCESS_DENIED) {
			return MESSAGE_ACCESS_DENIED;
		}
		if (!empty($twitterId)) {
			return $this->Html->link($twitterId, "https://twitter.com/{$twitterId}");
		} else {
			return null;
		}
	}

	// 3Dムービーへのリンク
	public function getRecordMovieUrl($data) {
		//pr($data);

		$player_id = $data['Record']['player_id'];
		$player_id = strtoupper($player_id);

		// 逆から1文字ずつフォルダ階層にする
		$char_array = str_split(strrev($player_id));
		$path = implode('/', $char_array);

		$filePath = 'http://www.sptmy.net/upload/' . $path . '/' . $data['Record']['record_id'] . '.zip';

		return $filePath;
	}

	// 3Dムービーへのパス
	public function getRecordMoviePath($data) {
		//pr($data);

		$player_id = $data['Record']['player_id'];
		$player_id = strtoupper($player_id);

		// 逆から1文字ずつフォルダ階層にする
		$char_array = str_split(strrev($player_id));
		$path = implode('/', $char_array);

		$filePath = '/st/upload/' . $path . '/' . $data['Record']['record_id'] . '.zip';

		return $filePath;
	}


	// nicknameか、無ければUser.idを表示。非公開の場合は非公開表示
	/*
		$data['User']['nickname']	// nickname
		$data['User']['id']			// User.id
		$data['Access']['id'] // TODO 追加する
	*/
	// ユーザーのニックネームまたはidを表示
	public function getUserNickname($data) {
		$canAccess = $this->canAccess($data, 'User.nickname_is_public');

		if ($canAccess == true && !empty($data['User']['nickname'])) {
			return $data['User']['nickname'];
		} else {
			return $data['User']['id'];
		}
	}
	// ユーザーのコメントを表示
	public function getProfileComment($data) {
		$canAccess = $this->canAccess($data, 'Profile.comment_is_public');

		if ($canAccess) {
			return $data['Profile']['comment'];
		} else {
			return MESSAGE_ACCESS_DENIED;
		}
	}
	// ユーザーの年齢を表示
	public function getProfileAge($data) {
		$canAccess = $this->canAccess($data, 'Profile.age_is_public');

		if ($canAccess) {
			if (isset($data['Profile']['age'])) {
				return $data['Profile']['age'] . '歳（さい）';
			} else {
				return null;
			}
		} else {
			return MESSAGE_ACCESS_DENIED;
		}
	}
	// ユーザーの年齢を表示
	public function getProfileAgeRaw($data) {
		$canAccess = $this->canAccess($data, 'Profile.age_is_public');

		if ($canAccess) {
			return $data['Profile']['age'];
		} else {
			return MESSAGE_ACCESS_DENIED;
		}
	}
	// ユーザーの性別を表示
	public function getProfileGender($data) {
		$canAccess = $this->canAccess($data, 'Profile.gender_is_public');

		$GENDER_LIST = Configure::read('GENDER_LIST');
		if ($canAccess) {
			return @$GENDER_LIST[ $data['Profile']['gender'] ];
		} else {
			return MESSAGE_ACCESS_DENIED;
		}
	}
	// ユーザーの性別を表示
	public function getProfileGenderRaw($data) {
		$canAccess = $this->canAccess($data, 'Profile.gender_is_public');

		if ($canAccess) {
			return $data['Profile']['gender'];
		} else {
			return MESSAGE_ACCESS_DENIED;
		}
	}
	// ユーザーのTwitterIDを表示
	public function getProfileTwitterId($data) {
		$canAccess = $this->canAccess($data, 'Profile.twitter_id_is_public');

		if ($canAccess) {
			return $data['Profile']['twitter_id'];
		} else {
			return MESSAGE_ACCESS_DENIED;
		}
	}

	// 日時の和暦表示
	public function getRecordRegisterDateJ($data) {
		if (empty($data['Record']['register_date'])) {
			return null;
		}
		$week = array("日", "月", "火", "水", "木", "金", "土");

		$time = strtotime($data['Record']['register_date']);
		$w = date("w", $time);

		$date_str  = '';
		$date_str .= date('Y年n月j日', $time);
		$date_str .= "({$week[$w]})";
		$date_str .= date(' G時i分', $time);

		return $date_str;
	}

	// コメント表示
	public function getRecordComment($data) {
		if (empty($data['Record']['comment'])) {
			return null;
		}

		return $data['Record']['comment'];
	}

	// タグリンクを表示
	public function getRecordTagsLink($data) {
		if (empty($data['Record']['tags'])) {
			return null;
		}

		$tag_list = explode(",", $data['Record']['tags']);

		$html = '';
		foreach($tag_list as $tag) {
			// a「全角」英数字を「半角」に変換、s「全角」スペースを「半角」に変換
			$tag = trim(mb_convert_kana($tag, "as", "UTF-8"));
			$html .= $this->Html->link(
						h($tag),
						array('controller' => 'records', 'action' => 'search', 'tag' => h($tag)),
						array('class' => 'btn')
					);
		}

		return $html;
	}

	// アクセスレベルの表示
	public function showAccessLevel($access_level) {
		if ($access_level == ACCESS_LEVEL_SELF) {
			$msg = "じぶん に公開";
		} else if ($access_level == ACCESS_LEVEL_PLAYER) {
			$msg = "全せんしゅ に公開";
		} else if ($access_level == ACCESS_LEVEL_UNIVERSE) {
			$msg = "全宇宙 に公開";
		} else {
			$msg = "";
		}

		return $msg;
	}
}
