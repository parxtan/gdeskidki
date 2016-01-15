<?php

class SiteController extends Controller
{
	public function actionDefault()
	{
		$main_rubric = Rubrics::model()->find(array(
			'condition'=>'main=1'
		));

		$order = 'start desc, id desc';
		
		$sales = Sales::model()->findAll(array(
			'condition'=>'start<=:now and finish>=:now and (sale>0 or action=1) and status=1',
			'params'=>array(':now'=>date('Y-m-d')),
			'order'=>$order
		));

		$new = Sales::model()->findAll(array(
			'condition'=>'start<=:now and finish>=:now and new=1 and status=1',
			'params'=>array(':now'=>date('Y-m-d')),
			'order'=>'finish'
		));		
		
		$data = array(
			'sales'=>$sales,
			'new'=>$new,
		
			'rubric'=>$main_rubric,
			'title'=>$main_rubric->title ? $main_rubric->title : $main_rubric->name,
			'keywords'=>$main_rubric->keywords,
			'description'=>$main_rubric->description,
			'metaImage'=>'http://'.$_SERVER['HTTP_HOST'].'/static/img/logo_big.png'
		);
			
		$this->render('main',$data);
	}
	
	public function actionRubrics($url)
	{
		$uri = explode('/', trim($url,'/'));
		$level = count($uri);
		$parent_id = 0;
		
		foreach($uri as $k=>$v)
		{
			$breadcrumbs[$k] = Rubrics::model()->find(
				'parent_id=:parent_id and chpu=:chpu and status>=:status',
				array(':chpu'=>$v, ':parent_id'=>$parent_id, ':status'=>1)
			);
			if($breadcrumbs[$k])
				$parent_id = $breadcrumbs[$k]->id;
			else
				$this->render('/errors/404');
		}

		$razdel = $breadcrumbs[$level-1];

		$objClass = ucfirst($razdel->ctype);

		$this->forward('/'.$razdel->ctype.'/rubric/id/'.$razdel->id);
	}

	public function actionSingle($url,$id)
	{
		$uri = explode('/', trim($url,'/'));
		$level = count($uri);
		$parent_id = 0;
		
		foreach($uri as $k=>$v)
		{
			$breadcrumbs[$k] = Rubrics::model()->find(
				'parent_id=:parent_id and chpu=:chpu and status>=:status',
				array(':chpu'=>$v, ':parent_id'=>$parent_id, ':status'=>1)
			);
			if($breadcrumbs[$k])
				$parent_id = $breadcrumbs[$k]->id;
			else
				$this->render('/errors/404');
		}

		$razdel = $breadcrumbs[$level-1];

		$objClass = ucfirst($razdel->ctype);
		
		$this->forward('/'.$razdel->ctype.'/single/id/'.$id.'/rubric_id/'.$razdel->id);
	}	

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('/errors/error', $error);
	    }
	}

	public function actionSearch()
	{
		// страница
		$page = Yii::app()->request->getParam('page');
		if(!$page && !is_numeric($page)) 
			$page = 1;

		$per_page = 10;

		// ключевое слово	
		$select = '*';
		$where = '1';
		
		$string = Yii::app()->request->getParam('string');
		$string = strip_tags($string);
		
		if(isset($_GET['string']))
		{
			if($string)
			{
				$select .= ', MATCH(name) AGAINST (:string) as description';
				$where .= " and (MATCH(name) AGAINST(:string) > 5 OR name like '%".$string."%' OR art like '%".$string."%')";
				$params[':string'] = $string;
				$rubric = new Rubrics;
				$rubric->parent_id = -1;
				$rubric->name = $string;
			}
			else
				Yii::app()->user->setFlash('no_search_string','Задана пустая строка. Введите поисковую фразу.');
		}
	
		/* бренды */
		$brands = Brands::model()->findAll(array(
			'condition'=>'status=1',
			'order'=>'name'
		));			

		$filterBrand = Yii::app()->request->getParam('b');
		if($filterBrand>0){
			$where .= ' and brand_id=:brandId';
			$params[':brandId'] = $filterBrand;
			$filterBrand = Brands::model()->findByPk($filterBrand)->name;
		}

		if(!$rubric){
			$rubric = new Rubrics;
			$rubric->parent_id = 1;
			$rubric->name = $filterBrand;
		}
		
		/* производитель аксессуаров */
		$accessories = Accessories::model()->findAll(array(
			'condition'=>'status=1',
			'order'=>'name'
		));			

		$filterAccessories = Yii::app()->request->getParam('a');
		if($filterAccessories>0){
			$where .= ' and accessories_id=:accessoriesId';
			$params[':accessoriesId'] = $filterAccessories;
			$filterAccessories = Accessories::model()->findByPk($filterAccessories)->name;
		}

		if(!$rubric){
			$rubric = new Rubrics;
			$rubric->parent_id = 1;
			$rubric->name = $filterAccessories;
		}		
	
		$catalog = Catalog::model()->findAll(array(
			'select'=>$select,
			'condition'=>$where,
			'params'=>$params,
			'order'=>$sort,
			'limit'=>$per_page,
			'offset'=>($page-1)*$per_page
		));
			
		$cnt = Catalog::model()->count(array(
			'condition'=>$where,
			'params'=>$params,
		));
		$pages = ceil($cnt/$per_page);	
		
		$data = array(
			'rubric'=>$rubric,
			'data'=>$catalog,
			'brands'=>$brands,
			'accessories'=>$accessories,
			'pages'=>$pages,
			'page'=>$page,
			'page_link'=>'?'.Yii::app()->request->getQueryString(),
			'pp'=>$per_page
		);	
		
		$this->render('/catalog/rubric',$data);
	}
}