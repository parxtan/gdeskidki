<?php

class Orders extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tbl_orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, phone, email, date', 'required'),
			array('summ', 'numerical'),
			array('email', 'email'),
			array('address', 'length', 'max'=>255),
			array('text,order_list', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, address, text, summ', 'safe', 'on'=>'search'),
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
			'name' => 'ФИО',
			'phone' => 'Телефон',
			'email' => 'E-mail',
			'date' => 'Дата',
			'address' => 'Адрес доставки',
			'text' => 'Примечание',
			'summ' => 'Итого',
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
		$criteria->compare('address',$this->address,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('summ',$this->summ);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}