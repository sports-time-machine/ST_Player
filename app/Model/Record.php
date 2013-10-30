<?php
App::uses('AppModel', 'Model');

class Record extends AppModel {
	public $name = 'Record';
	public $useTable = 'records';
	public $primaryKey = 'id';
	// app_model.phpでconfig/column_list/Record.php, config/validate/Record.phpを読み込み
	public $column_list = array();
	public $validate = array();
	// for Search Plugin
	public $actsAs = array('Search.Searchable');
	public $filterArgs = array(
		//ヘッダでの検索。コメントとタグについて検索を行う
		'keyword' => array(
			'type' => 'query',
			'method' => 'multiWordSearch'
		),
		//タグの検索。タグのリンクから検索させる
		'tag' => array(
			'type' => 'query',
			'method' => 'tagSearch'
		)
	);

	//複数条件検索
	public function multiWordSearch($data = array()) {


		$keyword = trim(mb_convert_kana($data['keyword'], "as", "UTF-8"));
		$keywords = explode(' ', $keyword);

		if (count($keywords) < 2) {
			$conditions = array(
				'OR' => array(
					'User.username LIKE' => '%' . $keyword . '%',
					'User.nickname LIKE' => '%' . $keyword . '%',
					'Record.player_id LIKE' => '%' . $keyword . '%',
					'Record.record_id LIKE' => '%' . $keyword . '%',
					'Record.comment LIKE' => '%' . $keyword . '%',
					'Record.tags LIKE' => '%' . $keyword . '%',
				)
			);
		} else {
			$conditions['AND'] = array();
			foreach ($keywords as $count => $keyword) {
				$condition = array(
					'OR' => array(
						'User.username LIKE' => '%' . $keyword . '%',
						'User.nickname LIKE' => '%' . $keyword . '%',
						'Record.player_id LIKE' => '%' . $keyword . '%',
						'Record.record_id LIKE' => '%' . $keyword . '%',
						'Record.comment LIKE' => '%' . $keyword . '%',
						'Record.tags LIKE' => '%' . $keyword . '%',
					)
				);
				array_push($conditions['AND'], $condition);
			}
		}

		return $conditions;
	}

	// タグ検索
	public function tagSearch($data = array()) {

		$tag = trim(mb_convert_kana($data['tag'], "as", "UTF-8"));


		$condition = array(
			'AND' => array(
				'Record.tags LIKE' => '%' . $tag . '%',
			)
		);

		return $condition;
	}

	// search用bind
	public function bindForSearch() {
		$bind = array(
			'belongsTo' => array(
				'User' => array(
					'className' => 'User',
					'fields' => array('id', 'username', 'nickname', 'nickname_is_public'), // IDとパスワードの組みなのでplayer_idは見せないようにする
				),
				'Profile' => array(
					'className' => 'Profile',
					'foreignKey' => 'user_id',
					//'fields' => array('id', 'username', 'nickname', 'nickname_is_public'), // IDとパスワードの組みなのでplayer_idは見せないようにする
				),
			),
		);
		$this->bindModel($bind, false);
		$this->Profile->primaryKey = 'user_id'; // ProfileをJOINするため
	}

	public function unbindForSearch() {
		$bind = array(
			'belongsTo' => array(
				'User',
			),
		);
		$this->unbindModel($bind, false);
	}

	// addImage用bind
	public function bindForAddImage() {
		$bind = array(
			'belongsTo' => array(
				'User' => array(
					'className' => 'User',
					'fields' => array('player_id', 'username'),
				),
			),
		);
		$this->bindModel($bind, false);
	}

	// view用bind
	public function bindForView() {
		// Imageを読み込むため recursive = 2
		$this->recursive = 2;

		$bind = array(
			'belongsTo' => array(
				'User' => array(
					'className' => 'User',
					'foreignKey' => 'user_id',
				//'fields' => array('record_id', 'image_id'),
				//'order' => 'RecordImage.no',
				),
			),
			'hasMany' => array(
				'RecordImage' => array(
					'className' => 'RecordImage',
					'fields' => array('record_id', 'image_id'),
				//'order' => 'RecordImage.no',
				),
				'RecordObject' => array(
					'className' => 'RecordObject',
					'fields' => array('record_id', 'image_id'),
				//'order' => 'RecordObject.no',
				),
				'Partner' => array(
					'className' => 'Partner',
					'fields' => array('record_id', 'partner_id'),
				),
			),
		);
		$this->bindModel($bind, false);
	}

	public function unbindForView() {
		// Imageを読み込むため recursive = 2
		$this->recursive = -1;

		$bind = array(
			'hasMany' => array(
				'RecordImage',
				'Partner',
			),
		);
		$this->unbindModel($bind, false);
	}

	// recordsEdit用bind
	public function bindForRecordsEdit() {
		$bind = array(
			'hasMany' => array(
				'RecordImage' => array(
					'className' => 'RecordImage',
					'fields' => array('record_id', 'image_id'),
				//'order' => 'RecordImage.no',
				),
				'RecordObject' => array(
					'className' => 'RecordObject',
					'fields' => array('record_id', 'image_id'),
				//'order' => 'RecordObject.no',
				),
				'Partner' => array(
					'className' => 'Partner',
					'fields' => array('record_id', 'partner_id'),
				),
			),
		);
		$this->bindModel($bind, false);
	}
	
	// Viewに渡すために整形
	public function setForView($records) {

		foreach ($records as &$record) {
			//タグの加工
			//タグを","で分割
			$tags_str = explode(",", $record['Record']['tags']);
			$record['Record']['tags'] = array();
			for ($i = 0; $i < count($tags_str); $i++) {
				// a「全角」英数字を「半角」に変換、s「全角」スペースを「半角」に変換
				$record['Record']['tags'][$i] = trim(mb_convert_kana($tags_str[$i], "as", "UTF-8"));
			}

			//日付の加工
			$date = strtotime($record['Record']['register_date']);
			$record['Record']['register_date'] = date('Y', $date) . "年" . date('n', $date) . "月"
					. date('j', $date) . "日 " . date('G', $date) . "時" . date('i', $date) . "分" . date('s', $date) . "秒";
		}

		return $records;
	}
	
	// ,区切りのタグを配列に展開
	public function extractTags($tags) {
		$tag_list = explode(",", $tags);
		foreach($tag_list as $k => $tag) {
			// a「全角」英数字を「半角」に変換、s「全角」スペースを「半角」に変換
			$tag_list[$k] = trim(mb_convert_kana($tag, 'as', 'UTF-8'));
		}
		
		return $tag_list;
	}
	
	// ------------------------------------------------------------
	// ランキング
	// ------------------------------------------------------------
	public function getRankingOfRunCountByPlayerId() {
		$sql = "SELECT `User`.player_id, `User`.username, count(records.id) as count
				FROM
					users AS `User`
				LEFT JOIN
					records ON records.user_id = `User`.id
				GROUP BY `User`.player_id, `User`.username
				ORDER BY username DESC
				LIMIT 50;
				";
		$r = $this->query($sql);
		return $r;
	}
	public function getRankingOfRunCountByUsername() {
		$sql = "SELECT DISTINCT `User`.player_id, `User`.username, count(records.id) as count
				FROM
					users AS `User`
				LEFT JOIN
					records ON records.user_id = `User`.id
				WHERE
					`User`.username IS NOT NULL
				GROUP BY replace(replace(`User`.username, ' ', ''), '　','')
				ORDER BY count DESC
				LIMIT 50
				";
		$r = $this->query($sql);
		return $r;
	}
			
}
