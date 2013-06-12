<?php 

App::uses('FormAuthenticate', 'Controller/Component/Auth');

class QRCodeAuthenticate extends FormAuthenticate {

    protected function _password($password) {
        return $password;
    }

}
