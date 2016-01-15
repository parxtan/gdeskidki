<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	public $defaultAction = 'default';
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	
	public function getMenu($menuType='nav',$parentId=0)
	{
		$object = new Rubrics();
		$menu = $object->getRubricsTree($menuType,$parentId);
		
		return $menu;
	}	
	
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	public function getCookies($id)
	{
		$order = Yii::app()->request->cookies[$id]->value;
		if(!$order){
			$firstKey = array_keys($this->$id);
			$cookie = new CHttpCookie($id,$firstKey[0]);
			$cookie->expire = time()+60*60*24*30; 
			
			Yii::app()->request->cookies[$id] = $cookie;
			
			$order = Yii::app()->request->cookies[$id]->value;
		}
		
		return $order;
	}
	
	public function setCookies($id,$vl)
	{
		$cookie = new CHttpCookie($id,$vl);
		$cookie->expire = time()+60*60*24*30; 
			
		Yii::app()->request->cookies[$id] = $cookie;
			
		$order = Yii::app()->request->cookies[$vl]->value;
		
		return $order;
	}	

	public function render($view,$data=null,$return=false)
	{
		if($this->beforeRender($view))
		{
			$output=$this->renderPartial($view,$data,true);
			if(($layoutFile=$this->getLayoutFile($this->layout))!==false)
			{
				$data['content'] = $output;
				$output=$this->renderFile($layoutFile,$data,true);
			}				

			$this->afterRender($view,$output);

			$output=$this->processOutput($output);

			if($return)
				return $output;
			else
				echo $output;
		}
	}

	public function getConfig($param=null)
	{
		$config = Config::model()->getConfigData();
		
		if($param)
			return $config[$param];
		else
			return $config;
	}

	public $month_en = array(
		1=>'January','February','March','April','May','June','July','August','September','October','November','December'
	);
	
	public $month = array(
		1=>'января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'
	);	
		
	public function getDate($date, $format='date-time')
	{
		if($format=='date')
			$format = 'd F Y';
		else
			$format = 'd F Y, H:i';
		
		if(date('Y', strtotime($date))==date('Y'))
			$format = str_replace(' Y','',$format);
		
		if(date('d.m.y', strtotime($date))==date('d.m.y'))
			$format = 'сегодня, H:i';
		else
		if(date('d.m.y', strtotime($date)+(60*60*24))==date('d.m.y'))
			$format = 'вчера, H:i';			

		$date = date($format, strtotime($date));
		$date = str_replace($this->month_en,$this->month,$date);
		
		return $date;
	}	
	
	public function getImageUrl($obj,$thumb='s',$image='image')
	{
		$obj_class = strtolower(get_class($obj));
		
		if($thumb=='orig')
			$thumb_path = '';
		else
			$thumb_path = '/thumb_'.$thumb;
			
		if($obj->$image)
			$imageUrl = '/userdata/'.$obj_class.'/'.$obj_class.'_'.$obj->id.$thumb_path.'/'.$obj->$image;
		else
			$imageUrl = '/static/img/marker.png';
			
		return $imageUrl;
	}
	
	public function getLink($obj)
	{
		if($obj->rubric_id)
		{
			$rubric_link = Rubrics::model()->cache(300)->findByPk($obj->rubric_id)->getLink();
		}
		else
			$rubric_link = '#';
		
		return Yii::app()->baseUrl.$rubric_link.$obj->id.'/';
	}	

	public function getSubText($text,$cnt=200)
	{
		if(strlen($text)>$cnt){
			$text = preg_replace('/[[\/\!]*?[^\[\]]*?]/si', '', strip_tags($text));
			$end_pos = strrpos(substr($text,0,$cnt)," ")>0 ? strrpos(substr($text,0,$cnt)," ") : $cnt;
			$subtext = substr($text,0,$end_pos).'...';
		}
		else
			$subtext = strip_tags($text);
		
		return $subtext;
	}		
}