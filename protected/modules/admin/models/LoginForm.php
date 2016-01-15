<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required', 'message'=>'Заполните поле'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			array('username', 'checkEmail'),
			array('password', 'authenticate', 'message'=>'Неверный пароль'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'username'=>'Логин',		
			'password'=>'Пароль',
			'rememberMe'=>'Запомнить',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
			
			if($this->_identity->errorCode===UserIdentity::ERROR_PASSWORD_INVALID)
				$this->addError('password','Неверный пароль');
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity = new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration = $this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			
			$user = Users::model()->findByPk(Yii::app()->user->id);
			$user->last_login = date('Y-m-d H:i:s');
			$user->save();			
			
			return true;
		}
		else
			return false;
	}
	
	public function checkEmail($attribute,$params)
	{
		$this->_identity = new Users;
		$user = $this->_identity->find(array(
			'condition'=>'email=:email',
			'params'=>array(':email'=>$this->username)
		));
		if(!$user)
			$this->addError('email','Этот Пользователь не зарегистрирован');
	}	
}
