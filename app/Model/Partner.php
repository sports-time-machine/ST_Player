<?php

App::uses('AppModel', 'Model');

class Partner extends AppModel {

	public $name = 'Partner';
	public $useTable = 'partners';
	public $primaryKey = 'id';
	// app_model.phpでconfig/column_list/Partner.php, config/validate/Partner.phpを読み込み
	public $column_list = array();
	public $validate = array();
	
	// ある選手と一緒にに走った人
	public function findPartnersByUserId($user_id) {
		if (empty($user_id)) {
			return array();
		}
		
		$sql = "SELECT 
					`Partner`.`partner_id`,
					`Record`.player_id,
					`Record`.record_id,
					`Record`.register_date,
					`Record`.tags,
					`Record`.comment,
					`User`.id,
					`User`.player_id,
					`User`.username,
					`User`.nickname,
					`User`.nickname_is_public,
					`Profile`.*
				FROM partners AS `Partner`
				LEFT JOIN records AS `Record` ON `Partner`.record_id = `Record`.id
				LEFT JOIN users AS `User` ON `Record`.user_id = `User`.id
				LEFT JOIN profiles AS `Profile` ON `Profile`.user_id = `User`.id
				WHERE `Partner`.partner_id IN (
					SELECT records.record_id FROM records WHERE records.user_id = {$user_id}
				)
				ORDER BY `Record`.created DESC
				";
		$r = $this->query($sql);
		
		return $r;
	}
	
	// ある記録と一緒にに走った人 // Record.idの数字を指定すること
	public function getPartnerByRecordId($id) {
		if (empty($id)) {
			return array();
		}
		
		$sql = "SELECT 
					`Partner`.`partner_id`,
					`Record`.player_id,
					`Record`.record_id,
					`Record`.register_date,
					`Record`.tags,
					`Record`.comment,
					`User`.id,
					`User`.player_id,
					`User`.username,
					`User`.nickname,
					`User`.nickname_is_public,
					`Profile`.*
				FROM partners AS `Partner`
				LEFT JOIN records AS `Record` ON `Partner`.partner_id = `Record`.record_id
				LEFT JOIN users AS `User` ON `Record`.user_id = `User`.id
				LEFT JOIN profiles AS `Profile` ON `Profile`.user_id = `User`.id
				WHERE `Partner`.record_id = '{$id}'
				";
		$r = $this->query($sql);
		
		return $r;
	}
	
	//パートナー取得
	public function getPartnerInfo($partner_id) {

		$partner = null;
		$this->loadModel('Record');
		$this->Record->bindForView();
		$data = $this->Record->findByRecordId($partner_id);
		//pr($data);
		//通常の記録の場合
		if ($data) {
			$partner['record_id'] = $data['Record']['record_id'];
			$partner['name'] = $data['Record']['player_id'];
			$partner['is_linked'] = true;
			
			$partner['nickname'] = $data['User']['nickname'];
			$partner['user_id'] = $data['User']['id'];
		} else {
			//動物などの記録の場合
			if (preg_match("/M:/", $partner_id)) {
				$str = substr($partner_id, 2);   //2文字以降を取り出す
				$partner['name'] = "";
				if (strcmp($str, "CHEETAH-1") == 0) $partner['name'] = "チーター";
				if (strcmp($str, "ELEPHANT-3") == 0) $partner['name'] = "アフリカゾウ";
				if (strcmp($str, "MUSAGI") == 0) $partner['name'] = "ミナコウサギ";
				if (strcmp($str, "MIZUESAIBOU") == 0) $partner['name'] = "水江未来 細胞";
				if (strcmp($str, "PETER-1") == 0) $partner['name'] = "Peter Millard 1";
				if (strcmp($str, "PETER-2") == 0) $partner['name'] = "Peter Millard 2";
                
                $partner['record_id'] = $partner_id;
				$partner['is_linked'] = false;
				
				$partner['nickname'] = $partner['name'];
				$partner['user_id']  = 0;
			}
		}

		return $partner;
	}

}
