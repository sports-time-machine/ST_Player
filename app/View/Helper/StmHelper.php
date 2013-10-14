<?php
class StmHelper extends AppHelper {
	public $helpers = array('Html');

	public function image($record_id, $filename, $htmlOptions = array()) {
		return $this->output($this->Html->image($this->url($record_id, $filename), $htmlOptions));
		//return $this->output($this->url($record_id, $filename));
	}

	public function url($record_id = null, $filename = null) {
		$record_id = strtoupper($record_id);
		
		// 逆から1文字ずつフォルダ階層にする
		$char_array = str_split(strrev($record_id));
		$path = implode('/', $char_array);
		
		$filePath = '../upload/' . $path . '/' . $filename;

		return $filePath;
	}
	
	// nicknameか、無ければUser.idを表示。非公開の場合は非公開表示
	/*
		$data['User']['nickname']	// nickname
		$data['User']['id']			// User.id
		$data['Access']['id'] // TODO 追加する
	*/
	public function getUserNickname($data) {
		if (!empty($data['User']['nickname'])) {
			return $data['User']['nickname'];
		} else {
			return $data['User']['id'];
		}
	}
	public function getPartnerNickname($data) {
		if (!empty($data['Partner']['nickname'])) {
			return $data['Partner']['nickname'];
		} else {
			return $data['Partner']['user_id'];
		}
	}
}
