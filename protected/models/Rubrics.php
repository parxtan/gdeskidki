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
			array('parent_id, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('chpu', 'length', 'max'=>150),
			array('menu, ctype', 'length', 'max'=>20),
			array('link', 'length', 'max'=>200),
			array('title, keywords, description', 'safe'),
			array('chpu', 'filter', 'filter'=>array('TranslitFilter', 'translitUrl')),
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
			'text'=>array(self::HAS_ONE, 'Text', 'rubric_id'),
			'parent'=>array(self::BELONGS_TO, 'Rubrics', 'parent_id'),
			'childs'=>array(self::HAS_MANY, 'Rubrics', 'parent_id')
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
			'title' => 'Title',
			'keywords' => 'Keywords',
			'description' => 'Description',
			'status' => 'Статус',
		);
	}

	public static function getMenu($menuType='nav', $parentId=0)
	{	
		$rubrics = self::model()->findAll(array(
			'condition'=>'menu=:menuType and parent_id=:parentId and status=:active',
			'params'=>array('menuType'=>$menuType,'parentId'=>$parentId, ':active'=>1),
			'order'=>'parent_id, pos, id, status desc, name'
		));

		return $rubrics;
	}	
	
	public $rubList,$rubTree,$rubArray,$lvl;
	
	public function getRubricsTree($menuType='nav', $parentId=-1, $level=1, $ctype='all',$returnArray=0,$withRoot=0)
	{	
		if(!$this->rubList)
		{
			$where = 'menu=:menuType and status=1';
			$params = array('menuType'=>$menuType);
			
			if($parentId>=0){
				$where .= ' and parent_id=:parentId';
				$params[':parentId'] = $parentId;
			}
				
			if($ctype!='all'){
				$where .= ' and ctype=:ctype';
				$params[':ctype'] = $ctype;
			}

			$rubrics = self::model()->findAll(array(
				//'select'=>'id,name,link,parent_id,ctype,menu,chpu',
				'condition'=>$where,
				'params'=>$params,
				'order'=>'parent_id, pos, id, status desc, name'
			));

			if($rubrics)
				foreach($rubrics as $k=>$v)
					$this->rubList[$v->parent_id][] = $v;
		}

		$parent_id = $parentId>0 ? $parentId : 0;
		if($this->rubList[$parent_id]){
			foreach($this->rubList[$parent_id] as $k=>$v)
			{
				$v->lvl = $level;
				$this->rubTree[] = $v;

				if($this->rubList[$v->id]){
					self::getRubricsTree($v->menu,$v->id,$v->lvl+1,$ctype);
				}			
			}
		}

		return $this->rubTree;
	}		
	
	public function getChildsTree($parent_id,$lvl=1,$menuType='all',$cType='all')
	{
		$condition = 'parent_id=:parent_id and status=1';
		$params = array(':parent_id'=>$parent_id);
		
		if($menuType!='all'){
			$condition .= ' and menu=:menuType';
			$params[':menuType'] = $menuType;
		}
		
		if($cType!='all'){
			$condition .= ' and ctype=:cType';
			$params[':cType'] = $cType;
		}		

		$rubrics = self::model()->findAll(array(
			'condition'=>$condition,
			'params'=>$params,
			'order'=>'parent_id, pos, id, status desc, name'
		));
		
		if($rubrics){
			foreach($rubrics as $k=>$v){
				$v->lvl = $lvl;
				$this->rubTree[] = $v;
				self::getChildsTree($v->id,$v->lvl+1);
			}
		}
		
		return $this->rubTree;
	}
		
	public function getImageUrl($thumb='s',$photo='icon')
	{
		if($this->$photo)
			$imageUrl = '/userdata/rubrics/rubrics_'.$this->id.'/thumb_'.$thumb.'/'.$this->$photo;
		else
			$imageUrl = '/static/img/thumb_'.$thumb.'.gif';
			
		return $imageUrl;
	}	
	
	public function getLink()
	{
		if(!$this->link)
		{
			if($this->main==1)
				$this->link = '/';
			else
			{
				$this->link = '/'.$this->chpu;
				$parent_id = $this->parent_id;
			
				while($parent_id>0)
				{
					$parent_data = self::model()->find(array(
						'select'=>'chpu,parent_id',
						'condition'=>'id=:parent_id',
						'params'=>array(':parent_id'=>$parent_id),
					));
			
					$this->link = '/'.$parent_data->chpu . $this->link;
					$parent_id = $parent_data->parent_id;
				}
				$this->link .= '/';
			}
		}
		
		return $this->link;
	}
	
	public function getChilds($minelevel=null)
	{
		$childs = self::model()->findAll(array(
			'condition'=>'status=1 and parent_id=:parent',
			'params'=>array(':parent'=>$this->id),
			'order'=>'pos, id, name'
		));
		
		if(!$childs && $minelevel)
			$childs = self::model()->findAll(array(
				'condition'=>'status=1 and parent_id=:parent',
				'params'=>array(':parent'=>$this->parent_id),
				'order'=>'pos, id, name'
			));		
		
		return $childs;
	}
	
	public function getChildsId($type='string')
	{
		$childs = $this->getChilds();
		
		if($type=='string')
			$childsIdString = $this->id;
		
		if($childs)
			foreach($childs as $k=>$v)
				if($type=='string')
					$childsIdString .= ','.$v->id;
				else
				if($type=='array')
					$childsIdString[] = $v->id;
		
		return $childsIdString;
	}	
	
	public function getData($limit=20)
	{
		$class = ucfirst($this->ctype);
		$object = new $class;
		$data = $object->getData($this->id);
		
		return $data;
	}
	
	public function getCountData()
	{
		$class = ucfirst($this->ctype);
		$object = new $class;
		$count = $object->getCountData($this->id);		
		
		return $count;
	}
	
	public function getCompanies()
	{	
		$companies = Yii::app()->db->createCommand()
			->selectDistinct('t1.company_id,t2.name')
			->from('tbl_catalog t1')
			->join('tbl_companies t2', 't1.company_id = t2.id')
			->where(array('in','t1.rubric_id',self::getChildsId('array')))
			->order('t2.name')
			->queryAll();

		return $companies;
	}
}