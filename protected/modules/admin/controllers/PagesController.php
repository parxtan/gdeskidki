<?
class PagesController extends Controller
{
	public function actionDefault()
	{
		$model = new Rubrics('search');
		$model->unsetAttributes();  // clear any default values
		$model->menu = 'virtual';

		if(isset($_GET['Rubrics']))
			$model->attributes = $_GET['Rubrics'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionAdd()
	{
		$model = new Rubrics;

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);

		if(isset($_POST['Rubrics']))
		{
			$model->attributes = $_POST['Rubrics'];			
			$model->menu = 'virtual';
			$model->ctype = 'text';
			$model->chpu = TranslitFilter::translitUrl($model->name);
			$model->parent_id = 0;
			
			if($model->save()){
				$text = new Text();
				$text->text = $_POST['Text']['text'];
				$text->rubric_id = $model->id;
				$text->save();
				
				$this->redirect('/admin/pages/');
			}
		}

		$this->render('form',array(
			'model'=>$model,
			'title'=>'Виртуальные страницы'
		));
	}

	public function actionUpdate($id)
	{
		$model = Rubrics::model()->findByPk($id);
		
		if(isset($_POST['Rubrics']))
		{
			$model->attributes = $_POST['Rubrics'];
			$model->chpu = TranslitFilter::translitUrl($model->name);			
			
			if($model->save()){
				$text = Text::model()->find('rubric_id=:rubricId',array(':rubricId'=>$model->id));
				$text->text = $_POST['Text']['text'];
				$text->save();
				
				$returnUrl = '/admin/pages/';
				
				$this->redirect($returnUrl.'?'.Yii::app()->request->queryString);
			}
		}

		$this->render('form',array(
			'model'=>$model,
			'title'=>'Виртуальные страницы'
		));
	}	
	
	public function actionDelete($id)
	{
		$model = Rubrics::model()->findByPk($id)->delete();
		
		if(!Yii::app()->request->isAjaxRequest)
			$this->redirect('/admin/pages/');			
	}
}