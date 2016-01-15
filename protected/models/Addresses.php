<?php

class Addresses extends CActiveRecord
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
		return 'tbl_addresses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('brand_id, address', 'required'),
			array('brand_id, mall_id, status', 'numerical', 'integerOnly'=>true),
			array('address, phone, fax, email, work, showcase, coords', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, brand_id, mall_id, address, phone, fax, email, work, showcase', 'safe', 'on'=>'search'),
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
			'brand'=>array(self::BELONGS_TO,'Brands','brand_id'),
			'mall'=>array(self::BELONGS_TO,'Malls','mall_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'brand_id' => 'Бренд',
			'mall_id' => 'Торговый центр',
			'address' => 'Адрес',
			'phone' => 'Телефон',
			'fax' => 'Факс',
			'email' => 'E-mail',
			'work' => 'График работы',
			'coords' => 'Координаты',
			'showcase' => 'Витрина',
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
		$criteria->compare('brand_id',$this->brand_id);
		$criteria->compare('mall_id',$this->mall_id);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('work',$this->work,true);
		$criteria->compare('showcase',$this->showcase,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}