<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property integer $date
 * @property string $email
 * @property string $pass
 * @property string $name
 * @property string $lastname
 * @property string $tel
 * @property string $adres
 * @property string $company
 * @property string $firma
 */
class User extends CActiveRecord
{
	public $password2;
	public $password_old;
	public $password_new;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'tbl_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, email, password, name, lastname, tel, firma', 'required', 'message'=>'Поле обязательно для заполнения', 'on'=>'reg'),
			array('date, status', 'numerical', 'integerOnly'=>true),
			array('email, password, name, lastname', 'length', 'max'=>50),
			array('password', 'length', 'min'=>5),
			array('tel, company, firma', 'length', 'max'=>100),
			array('adres', 'length', 'max'=>150),
			array('email, password, password2', 'required', 'message'=>'Поле обязательно для заполнения', 'on'=>'reg, change'),

			array('email', 'isUserEmail', 'message'=>'Данные E-mail не зарегистрирован','on'=>'pass'),
			
			array('email', 'isUserUniqie', 'message'=>'Данные E-mail уже зарегистрирован','on'=>'reg'),
            array('password2', 'compare', 'compareAttribute'=>'password','message'=>'Пароли не совпадают','on'=>'reg, change'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, date, email, password, name, lastname, tel, adres, company, firma', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'date' => 'Date',
			'email' => 'Ваш E-mail',
			'password' => 'Пароль',
			'password2' => 'Подтверждение пароля',
			'name' => 'Ваше Имя',
			'lastname' => 'Фамилия',
			'tel' => 'Контактный телефон',
			'adres' => 'Адрес',
			'company' => 'Юридическое название организации',
			'firma' => 'Фактическое название организации',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('date',$this->date);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('tel',$this->tel,true);
		$criteria->compare('adres',$this->adres,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('firma',$this->firma,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	protected function beforeValidate()
	{
		if(parent::beforeValidate())
			$this->date = time();
			
		return true;
	}
	
	protected function beforeSave()
	{
		$this->password = md5($this->password);
	
		return true;
	}
	
	public function isUserUniqie($attribute,$params)
	{
		$user = User::model()->findAll(array(
			'condition'=>'email=:email',
			'params'=>array(':email'=>$this->email)
		));		
		
		if($user)
			#exit( '{"status":"error", "field":"email", "message": "E-mail уже зарегистрирован."}' );
			$this->addError('email', 'E-mail уже зарегистрирован.');
	}	
	
	public function isUserEmail($attribute,$params)
	{
		$user = User::model()->findAll(array(
			'condition'=>'email=:email',
			'params'=>array(':email'=>$this->email)
		));		
		
		if(!$user)
			$this->addError('email', 'E-mail не зарегистрирован.');
	}		
}