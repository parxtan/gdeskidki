<?
class TextController extends Controller
{
	public function actionRubric($id)
	{
		$rubric = Rubrics::model()->findByPk($id);
		
		$data = array(
			'rubric'=>$rubric,
			
			'title'=>$rubric->title,
			'keywords'=>$rubric->keywords,
			'description'=>$rubric->description,			
		);
		
		$this->render('/text/single',$data);
	}
}