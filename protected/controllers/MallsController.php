<?
class MallsController extends Controller
{
	public function actionRubric($id)
	{
		$rubric = Rubrics::model()->findByPk($id);
		if(!$rubric)
			$this->render('/errors/404');
			
		$malls = Malls::model()->findAll(array(
			'condition'=>'rubric_id=:rubricId and status=1',
			'params'=>array(':rubricId'=>$rubric->id),
			'order'=>'name'
		));
			
		$data = array(
			'rubric'=>$rubric,
			'data'=>$malls
		);
			
		$this->render('rubric',$data);
	}
	
	public function actionSingle($id)
	{
		$mall = Malls::model()->findByPk($id);
		if(!$mall)
			$this->render('/errors/404');
			
		$rubric = Rubrics::model()->findByPk($mall->rubric_id);
		
		$data = array(
			'rubric'=>$rubric,
			'mall'=>$mall
		);
		
		$crumbs = Yii::app()->params['crumbs'];
		$crumbs[] = $mall;
		Yii::app()->params['crumbs'] = $crumbs;
		
		$this->render('single',$data);
	}
}