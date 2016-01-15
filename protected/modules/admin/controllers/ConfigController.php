<?php

class ConfigController extends Controller
{
	public function actionDefault()
	{
		$model = new ConfigForm;
		
		if(isset($_POST['ConfigForm']))
		{
			$model->attributes = $_POST['ConfigForm'];
			$model->save();
			
			$this->redirect('/admin/config');
		}
		
		foreach($model->attributes as $k=>$v)
			$model->$k = Config::model()->findByPk($k)->config_value;
		
		$data = array(
			'model'=>$model
		);
		
		$this->render('default',$data);
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}