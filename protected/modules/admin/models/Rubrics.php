<?php

class Rubrics extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rubrics the static model class
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
		return 'tbl_rubrics';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, menu, ctype', 'required', 'message'=>'Заполните поле'),
			array('parent_id, status, main', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('chpu', 'length', 'max'=>150),
			array('menu, ctype', 'length', 'max'=>20),
			array('link', 'length', 'max'=>200),
			array('title, keywords, description', 'safe'),
			array('chpu', 'filter', 'filter'=>array('TranslitFilter', 'translitUrl')),
			array('icon', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, chpu, menu, ctype, parent_id, link, title, keywords, description, status', 'safe', 'on'=>'search'),
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
			'text'=>array(self::HAS_ONE, 'Text', 'rubric_id')
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
			'chpu' => 'ЧПУ',
			'menu' => 'Навигация',
			'ctype' => 'Тип данных',
			'parent_id' => 'Родитель',
			'link' => 'Переадресация',
			'main' => 'Главная',
			'icon' => 'Иконка',
			'title' => 'Title',
			'keywords' => 'Keywords',
			'description' => 'Description',
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
		$criteria->compare('chpu',$this->chpu,true);
		$criteria->compare('menu',$this->menu,true);
		$criteria->compare('ctype',$this->ctype,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>50
			),
			'sort'=>array(
				'defaultOrder'=>'id'
			)
		));
	}
	
	protected function beforeSave()
	{
		if(!$this->chpu)
			$this->chpu = TranslitFilter::translitUrl($this->name);
			
		return true;
	}
	
	public function getImageUrl($thumb='s',$photo='icon')
	{
		if($this->$photo)
			$imageUrl = '/userdata/rubrics/rubrics_'.$this->id.'/thumb_'.$thumb.'/'.$this->$photo;
		else
			$imageUrl = '/static/img/thumb_'.$thumb.'.gif';
			
		return $imageUrl;
	}	
	
	public function getLink($abs=0)
	{
		$link = '/'.$this->chpu;
		$parent_id = $this->parent_id;
			
		while($parent_id>0)
		{
			$parent_data = self::model()->cache(300)->find(array(
				'select'=>'chpu,parent_id',
				'condition'=>'id=:parent_id',
				'params'=>array(':parent_id'=>$parent_id),
			));
			
			$link = '/'.$parent_data->chpu . $link;
			$parent_id = $parent_data->parent_id;
		}
		$link .= '/';
		
		if($abs==1)
			$link = 'http://'.$_SERVER['HTTP_HOST'].$link;
		else
			$link = '/admin'.$link;
		
		return $link;
	}
	
	public $rubList,$rubTree,$rubArray,$lvl;
	
	public function getRubricsTree($menuType='nav', $parentId=-1, $level=1,$withRoot=0,$returnArray=0,$ctype='all')
	{	
		if(!$this->rubList)
		{
			$rubrics = self::model()->findAll(array(
				'condition'=>'menu=:menuType',
				'params'=>array('menuType'=>$menuType),
				'order'=>'parent_id, pos, id, status desc, name'
			));
			if($rubrics)
				foreach($rubrics as $k=>$v)
					$this->rubList[$v->parent_id][] = $v;
		}
		
		if($this->rubList[$parentId]){
			foreach($this->rubList[$parentId] as $k=>$v)
			{
				$v->lvl = $level;
				$this->rubTree[] = $v;

				if($this->rubList[$v->id]){
					self::getRubricsTree($v->menu,$v->id,$v->lvl+1);
				}			
			}
		}

		return $this->rubTree;
	}
}