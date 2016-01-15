<?php

class RubricsController extends Controller
{
	public function actionCreate()
	{
		$model=new Rubrics;

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);

		if(isset($_POST['Rubrics']))
		{
			$model->attributes=$_POST['Rubrics'];
			if($model->save())
				if(Yii::app()->request->isAjaxRequest)
				{
					$model->lvl = $_POST['lvl'] ? $_POST['lvl'] : 1;
					Yii::app()->clientscript->scriptMap['jquery.js'] = false;
					$this->renderPartial('/rubrics/menuItem',array('model'=>$model),false,true);
				}
				else
					$this->redirect(array('view','id'=>$model->id));
		}
		else
		{
			$this->render('/_form/create',array(
				'model'=>$model,
			));
		}
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Rubrics']))
		{
			$model->attributes=$_POST['Rubrics'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			if(Yii::app()->request->isAjaxRequest)
				exit('success');
			else
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionDefault()
	{
		$dataProvider=new CActiveDataProvider('Rubrics');
		$this->render('admin',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model=new Rubrics('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Rubrics']))
			$model->attributes=$_GET['Rubrics'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Rubrics::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='rubrics-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionGetAddRubricForm()
	{
		$parent_id = $_POST['parent_id'];
	
		$model = new Rubrics;
		
		if(is_numeric($parent_id))
		{
			$parent = Rubrics::model()->findByPk($parent_id);
			
			if($parent)
			{
				$model->parent_id = $parent->id;
				$model->menu = $parent->menu;
			}
			else
				$error = 'Вы не можете создать подраздел к выбраному разделу.';
		}
		else
		{
			$model->parent_id = 0;
			$model->menu = $parent_id;
		}
		
		$data['model'] = $model;
		$data['error'] = $error;
		$data['lvl'] = $_POST['lvl']+1;
		
		$this->renderPartial('/ajax/add_rubric_form',$data,false,true);
	}	
}
