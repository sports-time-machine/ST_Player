<?php
App::uses('AppModel', 'Model');

class User extends AppModel
{
	public $name = 'User';
	public $useTable = 'users';
	public $primaryKey = 'id';
	
	// app_model.phpでconfig/column_list/User.php, config/validate/User.phpを読み込み
	public $column_list = array();
	public $validate = array();
    
    public function QRCodeLogin($name, $id){
        //選手名と選手idで認証
        if ($this->findByUsernameAndPlayerId($name,$id)){
            //return "OK";
        }else{
            return "ログインに失敗しました。選手名が違うか、QRコードが正しく読み取られていません。";
        }
    }
}
