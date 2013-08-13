<?php
App::uses('AppModel', 'Model');

class Partner extends AppModel
{
	public $name = 'Partner';
	public $useTable = 'partners';
	public $primaryKey = 'id';
	
	// app_model.phpでconfig/column_list/Partner.php, config/validate/Partner.phpを読み込み
	public $column_list = array();
	public $validate = array();
    
    //パートナー取得
    public function getPartner($partner_id){

        $partner = null;
        App::import('Model', 'Record');      
        $Record = new Record;
        $data = $Record->findByRecordId($partner_id);
        
        //通常の記録の場合
        if ($data){
            $partner['record_id'] = $data['Record']['record_id'];
            $partner['name'] = $data['Record']['player_id'];
            $partner['is_linked'] = true;
        }else{
            //動物などの記録の場合
             if (preg_match("/M:/", $partner_id)){
                $str = substr($partner_id,2);   //2文字以降を取り出す
                $partner['name']="";
                if (strcmp($str, "CHEETAH-1") == 0) $partner['name'] = "チーター";
                if (strcmp($str, "ELEPHANT-3") == 0) $partner['name'] = "アフリカゾウ";
                if (strcmp($str, "MUSAGI") == 0) $partner['name'] = "ミナコウサギ";
                if (strcmp($str, "MIZUESAIBOU") == 0) $partner['name'] = "水江未来 細胞";
                if (strcmp($str, "PETER-1") == 0) $partner['name'] = "Peter Millard 1";
                if (strcmp($str, "PETER-2") == 0) $partner['name'] = "Peter Millard 2";
                
                $partner['record_id'] = $partner_id;
                $partner['is_linked'] = false;
             }
        }
        
        return $partner;     
        
    }
}
