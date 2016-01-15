<?php

class News extends CActiveRecord
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
		return 'tbl_news';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, name, rubric_id, user_id', 'required'),
			array('rubric_id, user_id, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>200),
			array('image', 'length', 'max'=>100),
			array('text, announce, title, keywords, description', 'safe'),
			array('image', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, date, name, text, image, rubric_id, user_id, status', 'safe', 'on'=>'search'),
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
			'rubric'=>array(self::BELONGS_TO, 'Rubrics', 'rubric_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'date' => 'Дата',
			'name' => 'Заголовок',
			'announce' => 'Анонс',
			'text' => 'Текст',
			'image' => 'Изображение',
			'rubric_id' => 'Rubric',
			'user_id' => 'User',
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
		$criteria->compare('date',$this->date,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('rubric_id',$this->rubric_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'date desc')
		));
	}
	
	protected function beforeValidate()
	{
		$this->user_id = Yii::app()->user->id;
		
		return true;
	}
	
	public function getLatest($limit=3)
	{
		$news = self::model()->findAll(array(
			'condition'=>"date<=now() and status=1",
			'order'=>'date desc',
			'limit'=>$limit
		));
		
		return $news;
	}

	public function getImageUrl($thumb='s',$image='image')
	{
		if($this->image)
			$imageUrl = '/userdata/news/news_'.$this->id.'/thumb_'.$thumb.'/'.$this->$image;
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
	
	public function getSubText($cnt=200)
	{
		if(strlen($this->text)>$cnt){
			$text = preg_replace('/[[\/\!]*?[^\[\]]*?]/si', '', strip_tags($this->text));
			$end_pos = strrpos(substr($text,0,$cnt)," ")>0 ? strrpos(substr($text,0,$cnt)," ") : $cnt;
			$subtext = substr($text,0,$end_pos).'...';
		}
		else
			$subtext = strip_tags($this->text);
		
		return $subtext;
	}	
}