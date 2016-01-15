<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ConfigForm extends CFormModel
{
	public $vkontakte;
	public $facebook;
	public $odnoklassniki;
	public $twitter;
	
	public $email;
	public $email2;
	public $email3;
	public $citycode;
	public $phone;
	public $fax;
	public $skype;
	public $address;
	public $work;
	
	public $text;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// rememberMe needs to be a boolean
			array('vkontakte, facebook, twitter, odnoklassniki, email, citycode, phone, fax, skype, address, work, text', 'safe'),
			array('email,email2,email3', 'email'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'vkontakte'=>'Вконтакте',		
			'facebook'=>'Facebook',
			'odnoklassniki'=>'Одноклассники',
			'twitter'=>'Twitter',
			'work'=>'Рабочие часы',
			
			'email'=>'E-mail (заказы)',
			'email2'=>'E-mail (вакансии)',
			'email3'=>'E-mail (нанесение)',
			'citycode'=>'Код города',
			'phone'=>'Телефон',
			'fax'=>'Факс',
			'skype'=>'Skype',
			'address'=>'Адрес',
			
			'text'=>'Текст',			
		);
	}
	
	public function save()
	{
		foreach($this->attributes as $k=>$v)
		{
			$model = Config::model()->findByPk($k);
			if(!$model)
				$model = new Config;
				
			$model->config_name = $k;
			$model->config_value = $v;
			$model->save();
		}
		
		return true;
	}
}
