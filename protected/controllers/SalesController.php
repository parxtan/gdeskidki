<?
class SalesController extends Controller
{
	public function actionRubric($id)
	{
		$rubric = Rubrics::model()->findByPk($id);
		
		$per_page = 50;
		$page = Yii::app()->request->getParam('page');
		if(!$page) $page = 1;
		
		$condition = "rubric_id=:rubric and status=:active and start<=:now and finish>=:now";
		$params = array(':rubric'=>$rubric->id, ':now'=>date('Y-m-d H:i:s'), ':active'=>1);		
		
		$sales = Sales::model()->findAll(array(
			'condition'=>$condition,
			'params'=>$params,
			'order'=>'id desc',
			'limit'=>$per_page,
			'offset'=>($page-1)*$per_page
		));
		
		$count = Sales::model()->count($condition, $params);
		$pages = ceil($count/$per_page);		
		
		$data = array(
			'rubric'=>$rubric,
			'data'=>$sales,
			'page'=>$page,
			'pages'=>$pages,			
			
			'title'=>$rubric->title ? $rubric->title : $rubric->name,
			'keywords'=>$rubric->keywords,
			'description'=>$rubric->description,
			'metaImage'=>'http://'.$_SERVER['HTTP_HOST'].'/static/img/logo_big.png'
		);
		
		$this->render('rubric',$data);
	}
	
	public function actionSingle($id)
	{
		$single = Sales::model()->findByPk($id);
		if(!$single)
			$this->render('/errors/404');
			
		$rubric = Rubrics::model()->findByPk($single->rubric_id);
			
		$data = array(
			'rubric'=>$rubric,
			'data'=>$single,
			
			'title'=>$single->name,
			'keywords'=>str_replace(' ',',',$single->announce),
			'description'=>$single->announce,			
			'metaImage'=>'http://'.$_SERVER['HTTP_HOST'].$this->getImageUrl($single,'b'),
		);
		
		$this->render('single',$data);
	}
}