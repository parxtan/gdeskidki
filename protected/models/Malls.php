<?php

class Malls extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_malls';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, address, rubric_id', 'required'),
			array('rubric_id, city_id, status', 'numerical'),
			array('name, address, phone, fax, work, email, website, logo, showcase, coords', 'length', 'max'=>200),
			array('contacts, text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, address, contacts, phone, fax, work, email, website', 'safe', 'on'=>'search'),
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
			'rubric'=>array(self::BELONGS_TO,'Rubrics','rubric_id'),
			'brands'=>array(self::HAS_MANY,'Addresses','mall_id'),
			'addresses'=>array(self::HAS_MANY,'Addresses','mall_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'text' => 'Описание',
			'city_id' => 'Город',
			'address' => 'Адрес',
			'contacts' => 'Контакты',
			'phone' => 'Телефон',
			'fax' => 'Факс',
			'work' => 'Часы работы',
			'email' => 'E-mail',
			'website' => 'Сайт',
			'coords' => 'Координаты',
			'logo' => 'Логотип',
			'showcase' => 'Витрина',
			'rubric_id' => 'Рубрика',
			'status' => 'Статус',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('contacts',$this->contacts,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('work',$this->work,true);
		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>50),
			'sort'=>array('defaultOrder'=>'name')
		));
	}
	
	public function getArray()
	{
		$malls = Malls::model()->findAll(array(
			'order'=>'name'
		));
		
		$array = array(0=>'-выберите-');
		foreach($malls as $k=>$v)
			$array[$v->id] = $v->name;
			
		return $array;
	}	
}