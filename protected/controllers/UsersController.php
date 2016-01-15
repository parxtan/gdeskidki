<?php

class UsersController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionAuth()
	{
		if(Yii::app()->user->isGuest)
		{
			$authModel = new LoginForm('auth');

			$this->performAjaxValidation($authModel);

			if(isset($_POST['LoginForm']))
			{
				$authModel->attributes = $_POST['LoginForm'];
				if($authModel->validate() && $authModel->login())
				{
					$user = User::model()->find(array(
						'condition'=>'email=:email and password=:pass',
						'params'=>array(':email'=>$authModel->email, ':pass'=>md5($authModel->password))
					));
					
					$this->redirect('/cart/');
				}
				else{
					$data = array('auth'=>$authModel,'reg'=>$regModel);
					$this->render('/users/auth',$data);
				}
			}
			else{		
				$data = array('auth'=>$authModel,'reg'=>$regModel);
				$this->render('/users/auth',$data);
			}
		}
		else
			$this->redirect('/katalog/');
	}
	
	public function actionReg()
	{
		$model = new User('reg');
		
		$this->performAjaxValidation($model);
		
		if(isset($_POST['User']))
		{
			$model->attributes = $_POST['User'];
			
			$login = new LoginForm;
			$login->email = $model->email;
			$login->password = $model->password;
			$login->rememberMe = 1;

			if($model->validate())
			{
				if($model->save() && $login->login()){
					// отправляем уведомление
					$text = 'Вы успешно зарегистрировались на сайте '.$_SERVER['HTTP_HOST'];
					$text .= '<br />Ваш логин: '.$model->email;
					$text .= '<br />Ваш пароль: '.$_POST['User']['password'];
				
					$message = new YiiMailMessage();				
					$message->setTo(array($model->email => $model->name.' '.$model->lastname));
					$message->setFrom(array($model->email => 'Комплекс Бар'));
					$message->setSubject('Регистрация на сайте Complexbar.ru');
					$message->setBody($text,'text/html','utf8');
		
					Yii::app()->mail->send($message);				
					
					$this->redirect('/katalog/');
				}
			}
		}
		
		$data = array();
		
		$this->render('/users/auth',$data);
	}
	
	public function actionRemind()
	{
		if(!Yii::app()->user->isGuest)
			$this->redirect('/cabinet/');
			
		$user = new User('pass');
		$user = User::model()->find('email=:email',array(':email'=>$_POST['User']['email']));
		
		$this->performAjaxValidation($user);
		
		if(isset($_POST['User']))
		{
			$chars="123456789abcdefghijklmnopqrstuvwxyz";
			$num_chars=strlen($chars);
			$char=$chars[rand(0,$num_chars-1)];
			for ($i=1; $i<6; $i++){
				$char.=$chars[rand(0, $num_chars-1)];
			}
			
			$user->password = $char;
			
			if($user->save())
			{
				$text = "На ваш E-mail был отправлен запрос восстановления пароля:<br /><br /><b>Ваш новый пароль:</b> ".$char."<br /><br />Администрация Комплекс Бар.";
				
				$message = new YiiMailMessage();				
				$message->setTo(array($user->email => $user->name.' '.$user->lastname));
				$message->setFrom(array('noreply@complexbar.ru' => 'Комплекс Бар'));
				$message->setSubject('Новый пароля для сайта Complexbar.ru');
				$message->setBody($text,'text/html','utf8');
		
				Yii::app()->mail->send($message);				
					
				$this->redirect('/auth/?remind');
			}
			else
				exit(var_dump($user->getErrors()));

		}
		
		$data = array();
		
		$this->render('/users/auth',$data);		
	}
	
	public function actionLogout()
	{
		Yii::app()->user->logout();
		
		$this->redirect('/');
	}
	
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']))
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}	
	
	public function actionUpdate()
	{
		if(Yii::app()->user->isGuest)
			$this->render('/errors/404');
			
		$user = new User('change');		
		
		$this->performAjaxValidation($user);
		
		$user = $user->model()->findByPk(Yii::app()->user->id);
		
		if($_POST['User'])
		{
			$user->attributes = $_POST['User'];
			if($user->save())
				$this->redirect('/cabinet/?success');
		}
	}

	public function actionCabinet()
	{
		if(Yii::app()->user->isGuest)
			$this->redirect('/auth/');
			
		$user = new User('change');
		$user = $user->findByPk(Yii::app()->user->id);
			
		$this->render('/users/_reg_form',array('reg'=>$user));
	}
}