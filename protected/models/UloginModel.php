<?php

class UloginModel extends CModel {

    public $identity;
    public $network;
    public $email;
    public $name;
    public $lastname;
    public $phone;
    public $password;
    public $token;
    public $error_type;
    public $error_message;

    private $uloginAuthUrl = 'http://ulogin.ru/token.php?token=';

    public function rules() {
        return array(
            array('identity,network,token', 'required'),
            array('email', 'email'),
            array('identity,network,email,phone,password', 'length', 'max'=>255),
            array('name, lastname', 'length', 'max'=>55),
        );
    }

    public function attributeLabels() {
        return array(
            'network'=>'Сервис',
            'identity'=>'Идентификатор сервиса',
            'email'=>'E-mail',
            'name'=>'Имя',
            'lastname'=>'Фамилия',
            'phone'=>'Телефон',
            'password'=>'Пароль',
        );
    }

    public function getAuthData() {

        $authData = json_decode(file_get_contents($this->uloginAuthUrl.$this->token.'&host='.$_SERVER['HTTP_HOST']),true);

        $this->setAttributes($authData);

        $this->name = $authData['first_name'];
		$this->lastname = $authData['last_name'];
    }

    public function login() {
        $identity = new UloginUserIdentity();
        if ($identity->authenticate($this)) {
            $duration = 3600*24*30;
            Yii::app()->user->login($identity,$duration);
            return true;
        }
        return false;
    }

    public function attributeNames() {
        return array(
            'identity'
            ,'network'
            ,'email'
            ,'name'
            ,'lastname'
            ,'phone'
            ,'password'
            ,'token'
            ,'error_type'
            ,'error_message'
        );
    }
}