<?
class Controller extends CController
{
	public $defaultAction = 'default';

	public $layout='/layouts/main';

	public $menuTypes = array(
		'nav' => array(
			'name'	=>	'Верхнее меню',	// название
			'icon'	=>	'hor_nav.jpg',		// иконка
			'lvl'	=>	2,					// кол-во уровней
		),
		'vert' => array(
			'name'	=>	'Категории',	// название
			'icon'	=>	'vert_nav.jpg',		// иконка
			'lvl'	=>	2,					// кол-во уровней
		),
		'other' => array(
			'name'	=>	'Вспомогательные разделы',	// название
			'icon'	=>	'vert_nav.jpg',		// иконка
			'lvl'	=>	1,					// кол-во уровней
		),
	);

	public $menuTypesSelect = array(
		'nav'	=>	'Верхнее меню',
		'vert'	=>	'Меню каталога',
		'other'	=>	'Вспомогательные разделы',
	);

	public $contentTypes = array(
		'text' => 'Текст',
		'news' => 'Новости',
		'catalog' => 'Каталог',
		'form' => 'Форма обратной связи',
		'sales' => 'Акции',
		'brands' => 'Бренды',
		'malls' => 'Торговые центры',
		'categories' => 'Категории',
		'brands' => 'Бренды',
		'geo' => 'Регионы',
	);

	public $staticTypes = array(
		'banners' => 'Баннеры',
		'pages' => 'Виртуальные страницы',
		'config' => 'Настройки',
		'users' => 'Пользователи',
	);

	public $defaultStatus = array(
		'0'	=>	'Черновик',
		'1'	=>	'Опубликован',
		'2'	=>	'Скрыт',
	);

	public $skladStatus = array(
		'0'	=>	'Нет в наличии',
		'1'	=>	'Ограниченно',
		'2'	=>	'Есть в наличие',
	);

	public $userStatus = array(
		'0'	=>	'Пользователь',
		'1'	=>	'Модератор',
		'2'	=>	'Админ',
		'-1'=>	'Бан',
	);

	public function getRuStatus($status)
	{
		return Yii::app()->controller->defaultStatus[$status];
	}

    public function getBaseUrl($obj='')
    {
        return '/admin/'.strtolower(get_class($obj));
    }

    public function getRequestUrl()
    {
        return rtrim(Yii::app()->request->requestUri,'/');
    }

	public function getMenu($menuType='nav',$parentId=0)
	{
		$object = new Rubrics();
		return $object->getRubricsTree($menuType,$parentId);
	}

	public $menu = array();

	public $breadcrumbs = array();

	public $month = array(
		'',
		'Январь','Февраль','Март','Апрель','Май','Июнь',
		'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'
	);

	public $cities = array(
		1=>'Алматы',
		'Астана',
		'Атырау',
		'Актобе',
		'Актау',
		'Караганда',
		'Тараз',
		'Шымкент'
	);

    public $image_size = array(
		'sales'=>array(
			'image'=>array(
				'thumb_b'=>array('width'=>977, 'height'=>450, 'crop'=>0),
				'insta'=>array('width'=>600, 'height'=>600, 'crop'=>1),
				'thumb_s'=>array('width'=>488, 'height'=>360, 'crop'=>0)
			),
			'full_image'=>array(
				'thumb_b'=>array('width'=>1000, 'height'=>500, 'crop'=>1),
				'thumb_s'=>array('width'=>500, 'height'=>250, 'crop'=>1)
			),
		),
		'brands'=>array(
			'logo'=>array(
				'thumb_b'=>array('width'=>450, 'height'=>300, 'crop'=>0),
				'thumb_m'=>array('width'=>200, 'height'=>100, 'crop'=>0),
				'thumb_s'=>array('width'=>200, 'height'=>40, 'crop'=>0),
			)
		),
		'shops'=>array(
			'logo'=>array(
				'thumb_b'=>array('width'=>500, 'height'=>100, 'crop'=>0),
				'thumb_s'=>array('width'=>300, 'height'=>20, 'crop'=>0)
			),
			'showcase'=>array(
				'thumb_b'=>array('width'=>500, 'height'=>100, 'crop'=>0),
				'thumb_s'=>array('width'=>300, 'height'=>20, 'crop'=>0)
			)
		),
		'addresses'=>array(
			'showcase'=>array(
				'thumb_b'=>array('width'=>500, 'height'=>100, 'crop'=>0),
				'thumb_s'=>array('width'=>300, 'height'=>50, 'crop'=>0)
			)
		),
		'malls'=>array(
			'logo'=>array(
				'thumb_b'=>array('width'=>500, 'height'=>100, 'crop'=>0),
				'thumb_s'=>array('width'=>300, 'height'=>30, 'crop'=>0)
			),
			'showcase'=>array(
				'thumb_b'=>array('width'=>900, 'height'=>900, 'crop'=>0),
				'thumb_m'=>array('width'=>500, 'height'=>500, 'crop'=>0),
				'thumb_s'=>array('width'=>220, 'height'=>150, 'crop'=>1)
			),
			'plan'=>array(
				'thumb_s'=>array('width'=>150, 'height'=>100, 'crop'=>0)
			)
		),


        'catalog' => array(
            'image' => array(
                'thumb_b' => array('width'=>800, 'height'=>600, 'crop'=>0),
                'thumb_l' => array('width'=>300, 'height'=>300, 'crop'=>1),
                'thumb_m' => array('width'=>110, 'height'=>75, 'crop'=>0),
                'thumb_s' => array('width'=>90, 'height'=>90, 'crop'=>1),
            ),
        ),
		'news'=>array(
            'image' => array(
                'thumb_b' => array('width'=>600, 'height'=>300, 'crop'=>0),
                'thumb_m' => array('width'=>150, 'height'=>100, 'crop'=>1),
                'thumb_s' => array('width'=>70, 'height'=>50, 'crop'=>1),
            ),
		),
		'photos'=>array(
            'photo' => array(
                'thumb_b' => array('width'=>800, 'height'=>800, 'crop'=>0),
                'thumb_m' => array('width'=>105, 'height'=>135, 'crop'=>1),
                'thumb_s' => array('width'=>50, 'height'=>50, 'crop'=>0),
            ),
		),
		'banners'=>array(
            'image' => array(
                'thumb_b' => array('width'=>1280, 'height'=>512, 'crop'=>1),
                'thumb_m' => array('width'=>900, 'height'=>360, 'crop'=>1),
                'thumb_s' => array('width'=>150, 'height'=>70, 'crop'=>0),
            ),
		),
		'rubrics'=>array(
            'icon' => array(
                'thumb_b' => array('width'=>330, 'height'=>404, 'crop'=>1),
                'thumb_m' => array('width'=>225, 'height'=>150, 'crop'=>1),
                'thumb_s' => array('width'=>50, 'height'=>50, 'crop'=>1)
            ),
		),
		'tinymce'=>array(
            'default_text_image' => array(
                'resize' => array('width'=>700, 'height'=>700),
            ),
		)
    );

	public function getUserState($state,$value)
	{
		$data = Yii::app()->user->getState($state);
		return $data[$value] ? $data[$value] : 0;
	}
	public function getConfig($param=null)
	{
		$config = Config::model()->getConfigData();

		if($param)
			return $config[$param];
		else
			return $config;
	}

	public function parseUrl($url)
	{
		$uri = explode('/', trim($url,'/'));
		$level = count($uri);
		$parent_id = 0;

		foreach($uri as $k=>$v)
		{
			$breadcrumbs[$k] = Rubrics::model()->find(
				'parent_id=:parent_id and chpu=:chpu',
				array(':chpu'=>$v, ':parent_id'=>$parent_id)
			);

			if($breadcrumbs[$k])
				$parent_id = $breadcrumbs[$k]->id;
			else
				$this->render('/errors/404');
		}
		//--------------------------------------------------//
		$rubric = $breadcrumbs[$level-1];

		$ctype = $rubric->ctype;
		$obj_class = ucfirst($ctype);
		$object = new $obj_class;

		$data = array(
			'rubric'=>$rubric,
			'ctype'=>$ctype,
			'obj_class'=>$obj_class,
			'object'=>$object
		);

		return $data;
	}

	public function removeDir($path)
	{
		return is_file($path) ? @unlink($path) : array_map(array(Yii::app()->controller,'removeDir'),glob($path."/*"))==@rmdir($path);
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

	public function getLink($obj,$abs=0)
	{
		if($obj->rubric_id)
		{
			$rubric_link = Rubrics::model()->cache(300)->findByPk($obj->rubric_id)->getLink($abs);
		}
		else
			$rubric_link = '#';

		return Yii::app()->baseUrl.$rubric_link.$obj->id.'/';
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
			$imageUrl = '/static/img/thumb_'.$thumb.'.gif';

		return $imageUrl;
	}
}
