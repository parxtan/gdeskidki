<?php

class Brands extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tbl_brands';
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, rubric_id', 'required'),
			array('status, rubric_id', 'numerical', 'integerOnly'=>true),
			array('name, logo, link, logo_bg', 'length', 'max'=>100),
			array('categories_id, text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, logo, link', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'rubric'=>array(self::BELONGS_TO,'Rubrics','rubric_id'),
			'addresses'=>array(self::HAS_MANY,'Addresses','brand_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Наименование',
			'text' => 'Текст',
			'logo' => 'Лого',
			'logo_bg' => 'Фон логотипа',
			'link' => 'Ссылка',
			'categories_id' => 'Направления',
			'status' => 'Статус',
		);
	}
	
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('link',$this->link,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'name'),
			'pagination'=>array('pageSize'=>50)
		));
	}
	
	protected function beforeValidate()
	{
		if($_POST['Categories'])
			$this->categories_id = implode(',',$_POST['Categories']);

		return true;
	}	
	
	protected function afterDelete()
	{		
		$uploadPath = $_SERVER['DOCUMENT_ROOT'].'/userdata/';
		$objectPath = 'brands/brands_'.$this->id.'/';
		
		Yii::app()->controller->removeDir($uploadPath.$objectPath);

		return true;
	}
	
	public function getBrandsArray()
	{
		$brands = Brands::model()->findAll(array(
			'order'=>'name'
		));
		
		$array = array(0=>'-выберите-');
		foreach($brands as $k=>$v)
			$array[$v->id] = $v->name;
			
		return $array;
	}
	
	public function getCategoriesArray()
	{
		$categories = Rubrics::model()->findAll(array(
			'condition'=>'ctype=:sales',
			'params'=>array(':sales'=>'sales'),
			'order'=>'name'
		));
		
		$array = array();
		foreach($categories as $k=>$v)
			$array[$v->id] = $v->name;
			
		return $array;
	}
	
	public function getMarker()
	{
		if(file_exists($_SERVER['DOCUMENT_ROOT'].'/static/img/map_icons/'.$this->id.'.png'))
			$marker = '/static/img/map_icons/'.$this->id.'.png';
		else
			$marker = '/static/img/marker.png';
			
		return $marker;
	}
}