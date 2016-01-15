<?php

/**
 * This is the model class for table "tbl_orders".
 *
 * The followings are the available columns in table 'tbl_orders':
 * @property integer $id
 * @property integer $order_date
 * @property integer $date
 * @property string $delivered
 * @property string $address
 * @property string $text
 * @property integer $user_id
 * @property integer $catalog_id
 * @property integer $cnt
 * @property integer $order_id
 * @property double $summ
 */
class Orders extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Orders the static model class
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
			array('date, user_id, catalog_id', 'required'),
			array('order_date, date, user_id, catalog_id, cnt, order_id', 'numerical', 'integerOnly'=>true),
			array('summ', 'numerical'),
			array('delivered', 'length', 'max'=>100),
			array('address', 'length', 'max'=>255),
			array('text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, order_date, date, delivered, address, text, user_id, catalog_id, cnt, order_id, summ', 'safe', 'on'=>'search'),
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
			'order_date' => 'Order Date',
			'date' => 'Date',
			'delivered' => 'Delivered',
			'address' => 'Address',
			'text' => 'Text',
			'user_id' => 'User',
			'catalog_id' => 'Catalog',
			'cnt' => 'Cnt',
			'order_id' => 'Order',
			'summ' => 'Summ',
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
		$criteria->compare('order_date',$this->order_date);
		$criteria->compare('date',$this->date);
		$criteria->compare('delivered',$this->delivered,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('catalog_id',$this->catalog_id);
		$criteria->compare('cnt',$this->cnt);
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('summ',$this->summ);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}