<?php

/**
 * This is the model class for table "tbl_users".
 *
 * The followings are the available columns in table 'tbl_users':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property integer $status
 * @property string $last_login
 */
class Users extends CActiveRecord
{
	public $password2;
	public $oldpassword;
	public $newpassword;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('email, name, lastname', 'required', 'message'=>'Заполните поле'),
			array('password, password2, email', 'length', 'max'=>128),
			array('name, lastname, city', 'length', 'max'=>50),		
			array('email','email','message'=>'{attribute} некорректен'),
			array('oldpassword, newpassword', 'required','message'=>'Заполните поле','on'=>'chpass'),
			array('oldpassword','compareWithPassword','on'=>'chpass','message'=>'Не совпадает с текущим паролем'),
			array('password, password2', 'required','message'=>'Заполните поле','on'=>'reg'),
			array('email', 'isUserUniqie','on'=>'reg', 'message'=>'Данные E-mail уже зарегистрирован'),
            array('password2', 'compare', 'compareAttribute'=>'password','message'=>'Пароли не совпадают','on'=>'reg'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'addresses'=>array(self::HAS_MANY, 'Addresses', 'user_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attribuphoneabels()
	{
		return array(
			'id' => 'ID',
			'password' => 'Пароль:',
			'password2' => 'Повторите пароль:',
			'oldpassword' => 'Старый пароль:',
			'newpassword' => 'Новый пароль:',
			'email' => 'E-mail:',
			'name' => 'Имя:',
			'lastname' => 'Фамилия:',
			'city' => 'Город:',
			'post_index' => 'Почтовый индекс:',
			'address' => 'Адрес:',
			'phone' => 'Телефон:',
			'status' => 'Status',
		);
	}
	
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('address',$this->address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}	
	
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
            if($this->isNewRecord)
                $this->password = md5($this->password);

			return true;
		}
		else
			return false;
	}	
	
	public function isUserUniqie($attribute,$params)
	{
		$user = Users::model()->findAll(array(
			'condition'=>'email=:email',
			'params'=>array(':email'=>$this->email)
		));
		
		if($user)
			$this->addError('email', 'E-mail уже зарегистрирован.');
	}	
	
	public function compareWithPassword($attribute,$params)
	{
		$user = Users::model()->findByPk(Yii::app()->user->id);
		
		if($user->password != md5($this->oldpassword))
			$this->addError('oldpassword','Не совпадает с текущим паролем');
	}
}