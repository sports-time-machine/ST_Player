<?php
App::uses('AppModel', 'Model');

class Record extends AppModel
{
	public $name = 'Record';
	public $useTable = 'records';
	public $primaryKey = 'id';
	
	// app_model.phpでconfig/column_list/Record.php, config/validate/Record.phpを読み込み
	public $column_list = array();
	public $validate = array();

	// for Search Plugin
	public $actsAs = array('Search.Searchable');
    /*
	public $filterArgs = array(
		'keyword' => array(
            'type' => 'like',
            'field' => array('User.username', 'Record.tags'),
            'connectorAnd' => ' ',
            'connectorOr' => null,
         )
	);*/
    public $filterArgs = array(
		'keyword' => array(
            'type' => 'query',
            'method' => 'multiWordSearch'
         )
	);
    
    //複数条件検索
    public function multiWordSearch($data = array()){

        $keyword = mb_convert_kana($data['keyword'], "s", "UTF-8");
        $keywords = explode(' ', $keyword);
        
        if(count($keywords) < 2) {
            $conditions = array(
                'OR' => array(
                    'User.username LIKE' => '%' . $keyword . '%',
                    'Record.tags LIKE' => '%' . $keyword . '%',
                )
            );
        }else{
        $conditions['AND'] = array();
            foreach($keywords as $count => $keyword) {
                $condition = array(
                    'OR' => array(
                        'User.username LIKE' => '%' . $keyword . '%',
                        'Record.tags LIKE' => '%' . $keyword . '%',
                    )
                );
                array_push($conditions['AND'], $condition);
            }
        }
        return $conditions;
        
    }
    
    
	// search用bind
	public function bindForSearch() {
		$bind = array(
			'belongsTo' => array(
				'User' => array(
					'className' => 'User',
					'fields' => array(/*'player_id', */'username'), // IDとパスワードの組みなのでplayer_idは見せないようにする
				),
			),
		);
		$this->bindModel($bind, false);
	}
	public function unbindForSearch() {
		$bind = array(
			'belongsTo' => array(
				'User',
			),
		);
		$this->unbindModel($bind, false);
	}
	
	
	// view用bind
	public function bindForView() {
		// Imageを読み込むため recursive = 2
		$this->recursive = 2;
		
		$bind = array(
			'hasMany' => array(
				'RecordImage' => array(
					'className' => 'RecordImage',
					'fields' => array('record_id', 'image_id'),
					//'order' => 'RecordImage.no',
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
}
