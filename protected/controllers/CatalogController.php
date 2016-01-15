<?
class CatalogController extends Controller
{
	public function actionRubric($id=null,$new=null)
	{
		$rubric = Rubrics::model()->findByPk($id);

		// страница
		$page = Yii::app()->request->getParam('page');
		if(!$page && !is_numeric($page)) 
			$page = 1;
				
		// кол-во товароа на странице
		$per_page = 10;

		$select = '*';
		$where = 'status=1';
		$params = array();
		
		if($new)
			$where .= ' and new=1';
		else
			$where .= ' and rubric_id IN ('.$rubric->getChildsId().')';		
			
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
			'filterBrand'=>$filterBrand,
			'pages'=>$pages,
			'page'=>$page,
			'page_link'=>'?'.Yii::app()->request->getQueryString(),
			'pp'=>$per_page
		);

		$this->render('/catalog/rubric',$data);
	}
	
	public function actionSingle($id)
	{
		$model = Catalog::model()->findByPk($id);
		if(!$model)
			$this->render('/errors/404');

		$rubric = Rubrics::model()->findByPk($model->rubric_id);
		
		$data = array(
			'data'=>$model,
			'rubric'=>$rubric
		);
		
		$this->render('/catalog/single',$data);
	}
}