<?php

class Catalog extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tbl_catalog';
	}

	public function rules()
	{
		return array(
			array('art, name, rubric_id', 'required'),
			array('price, price1, price2, price3, opt1, opt2, opt3, brand_id, accessories_id, rubric_id, status, new, sale', 'numerical', 'integerOnly'=>true),
			array('art', 'length', 'max'=>100),
			array('name', 'length', 'max'=>300),
			array('image, image2, image3, image4', 'length', 'max'=>200),
			array('text, title, keywords, description', 'safe'),
			array('image, image2, image3, image4', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, art, name, price, brand_id, text, image, image2, image3, image4, rubric_id, status', 'safe', 'on'=>'search'),
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
			'art' => 'Артикул',
			'name' => 'Наименование',
			'price' => 'Стоимость',
			'price1' => 'Опт1 (цена)',
			'price2' => 'Опт2 (цена)',
			'price3' => 'Опт3 (цена)',
			'opt1' => 'Опт1 (кол-во)',
			'opt2' => 'Опт2 (кол-во)',
			'opt3' => 'Опт3 (кол-во)',
			'brand_id' => 'Бренд',
			'accessories_id' => 'Произв. акс.',
			'text' => 'Описание',
			'new' => 'Новинка',
			'sale' => 'Акция',
			'image' => 'Изображение',
			'image2' => 'Изображение2',
			'image3' => 'Изображение3',
			'image4' => 'Изображение4',
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
		$criteria->compare('art',$this->art,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('brand_id',$this->brand);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('rubric_id',$this->rubric_id);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>30
			),
			'sort'=>array(
				'defaultOrder'=>'art'
			)
		));
	}
	
	public function getImageUrl($thumb='s',$image='image')
	{
		$obj = strtolower(get_class($this));
		if($this->$image)
			$imageUrl = '/userdata/'.$obj.'/'.$obj.'_'.$this->id.'/thumb_'.$thumb.'/'.$this->$image;
		else
			$imageUrl = '/static/img/thumb_'.$thumb.'.gif';
			
		return $imageUrl;
	}
	
	public function getLink()
	{
		if($this->rubric_id)
		{
			$razdel_link = Rubrics::model()->cache(300)->findByPk($this->rubric_id)->getLink();
		}
		else
			$razdel_link = '#';
		
		return Yii::app()->baseUrl.$razdel_link.$this->id.'/';
	}	

	public function getPrice()
	{
		return number_format($this->price,0,'.',' ');
	}
}