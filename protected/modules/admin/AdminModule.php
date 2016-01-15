<?php

class AdminModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'admin.models.*',
			'admin.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			if(Yii::app()->user->isGuest){
				if($action->id!='login'){
					Yii::app()->controller->redirect('/admin/login');
				}
			}elseif(Yii::app()->user->getState('status')<=2){
				Yii::app()->controller->redirect('/');
			}
				
			return true;
		}
		else
			return false;
	}
}
