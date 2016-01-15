<?php

class Sales extends CActiveRecord
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
		return 'tbl_sales';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, start, finish, brand_id, rubric_id', 'required'),
			array('brand_id, rubric_id, sale, action, new, status', 'numerical', 'integerOnly'=>true),
			array('name, image, full_image', 'length', 'max'=>200),
			array('announce, text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, start, finish, brand_id, rubric_id, announce, text, image, sale, new_collection, status', 'safe', 'on'=>'search'),
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
			'brand'=>array(self::BELONGS_TO,'Brands','brand_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Заголовок',
			'start' => 'Начало',
			'finish' => 'Окончание',
			'brand_id' => 'Бренд',
			'rubric_id' => 'Рубрика',
			'announce' => 'Анонс',
			'text' => 'Описание',
			'image' => 'Изображение',
			'full_image' => 'Баннер',
			'sale' => 'Скидка',
			'action' => 'Акция',
			'new' => 'Новая коллекция',
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
		$criteria->compare('start',$this->start,true);
		$criteria->compare('finish',$this->finish,true);
		$criteria->compare('brand_id',$this->brand_id);
		$criteria->compare('rubric_id',$this->rubric_id);
		$criteria->compare('name',$this->name,true);		
		$criteria->compare('announce',$this->announce,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('sale',$this->sale);
		$criteria->compare('action',$this->action);
		$criteria->compare('new',$this->new);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'id desc'),
			'pagination'=>array('pageSize'=>20)
		));
	}
	
	public function getCountRubricSales($rubric_id)
	{
		$cnt = Sales::model()->count(array(
			'condition'=>'status=1 and rubric_id=:rubricId',
			'params'=>array(':rubricId'=>$rubric_id)
		));
		
		return $cnt;
	}
	
	public function getRemainDays()
	{
		$remain = ceil((strtotime($this->finish)-strtotime(date('Y-m-d')))/(60*60*24))+1;
			
		return $remain;
	}
}