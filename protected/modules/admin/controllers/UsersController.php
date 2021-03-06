<?php

class UsersController extends Controller
{
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionAdd()
	{
		$model=new Users;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			
			if($_POST['Users']['password'])
				$model->password = md5($_POST['Users']['password']);
			
			if($model->save())
				$this->redirect('/admin/users/');
		}

		$this->render('_form',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			
			if($_POST['Users']['password'])
				$model->password = md5($_POST['Users']['password']);
				
			if($model->save())
				$this->redirect('/admin/users/');
		}

		$this->render('_form',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionDefault()
	{
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users']))
			$model->attributes=$_GET['Users'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	//--------------------------------------------------//
	
	public function actionLogin()
	{
		$this->layout = '/layouts/login';
		
		if(Yii::app()->user->isGuest)
		{
			$model = new LoginForm;

			$this->performAjaxValidation($model);

			if(isset($_POST['LoginForm']))
			{
				$model->attributes = $_POST['LoginForm'];
				if($model->validate() && $model->login())
				{
					$user = Users::model()->find(array(
						'condition'=>'email=:email and password=:pass',
						'params'=>array(':email'=>$model->username, ':pass'=>md5($model->password))
					));
					$this->redirect('/admin');
				}
				else
					$this->render('/users/login',array('model'=>$model));
			}
			else
				$this->render('/users/login',array('model'=>$model));
		}
		else
			$this->redirect('/admin');
	}		
	
	public function actionLogout()
	{
		Yii::app()->user->logout();
		
		$this->redirect(Yii::app()->baseUrl);
	}		
}
