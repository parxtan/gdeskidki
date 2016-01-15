<?
class NewsController extends Controller
{
	public function actionRubric($id)
	{
		$rubric = Rubrics::model()->findByPk($id);
		
		$per_page = 4;
		$page = Yii::app()->request->getParam('page');
		if(!$page) $page = 1;
		
		$condition = "rubric_id=:rubric and date<=:now and status=:active";
		$params = array(':rubric'=>$rubric->id, ':now'=>date('Y-m-d H:i:s'), ':active'=>1);
		
		$count = News::model()->count($condition, $params);
		$pages = ceil($count/$per_page);
		
		$news = News::model()->findAll(array(
			'condition'=>$condition,
			'params'=>$params,
			'order'=>'date desc',
			'limit'=>$per_page,
			'offset'=>($page-1)*$per_page
		));

		$data = array(
			'rubric'=>$rubric,
			'data'=>$news,
			'page'=>$page,
			'pages'=>$pages,
			
			'title'=>$rubric->title,
			'keywords'=>$rubric->keywords,
			'description'=>$rubric->description,			
		);
		
		$this->render('/news/rubric',$data);
	}
	
	public function actionSingle($id)
	{
		$news = News::model()->findByPk($id);
		if(!$news)
			$this->renderPartial('/errors/404');
			
		$rubric = $news->rubric;
		
		$crumbs = Yii::app()->params['crumbs'];
		$crumbs[] = $news;
		Yii::app()->params['crumbs'] = $crumbs;
		
		$data = array(
			'data'=>$news,
			'rubric'=>$rubric,
			
			'title'=>$news->name,
			'keywords'=>$news->name,
			'description'=>$news->announce,
			'shareImage'=>'http://gdeskidki.kz'.Yii::app()->controller->getImageUrl($news,'b'),
		);
		
		$this->render('single',$data);
	}	
}