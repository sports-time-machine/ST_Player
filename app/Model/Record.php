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
        //ヘッダでの検索。選手名とタグについて検索を行う
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
    public function multiWordSearch($data = array()){

        $keyword = trim(mb_convert_kana($data['keyword'], "s", "UTF-8"));
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
    
    // タグ検索
    public function tagSearch($data = array()){

        $tag = trim(mb_convert_kana($data['tag'], "s", "UTF-8"));
        
        
        $condition = array(
            'Record.tags LIKE' => '%' . $tag . '%'
        );
      
        return $condition;
       
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
