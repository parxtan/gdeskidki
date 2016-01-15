<?php

class DefaultController extends Controller
{
	public $layout = '/layouts/main';

	public function actionIndex()
	{
		$this->render('index',$data);
	}

	public function actionDefault($url)
	{
		$uri = explode('/', trim($url,'/'));
		$level = count($uri);
		$parent_id = 0;

		foreach($uri as $k=>$v)
		{
			$breadcrumbs[$k] = Rubrics::model()->find(
				'parent_id=:parent_id and chpu=:chpu',
				array(':chpu'=>$v, ':parent_id'=>$parent_id)
			);
			if($breadcrumbs[$k])
				$parent_id = $breadcrumbs[$k]->id;
			else
				$this->render('/errors/404');
		}
		//--------------------------------------------------//
		Yii::app()->params->breadcrumbs = $breadcrumbs;
		$rubric = $breadcrumbs[$level-1];

		$obj_class = ucfirst($rubric->ctype);

		$pos = Yii::app()->request->getParam('pos');
		if(!$pos)
			$pos = Yii::app()->request->getParam('photo');
		if($pos)
		{
			foreach($pos as $k=>$v)
			{
				$model = new $obj_class;
				$model->model()->updateByPk($v,array('pos'=>$k+1));
			}

			exit('success');
		}

		$object = new $obj_class('search');
		$object->unsetAttributes();  // clear any default values
		if($rubric->ctype!='faq' && $rubric->ctype!='form')
			$object->rubric_id = $rubric->id;
		if($_GET[$obj_class])
			$object->attributes = $_GET[$obj_class];

		$text = Text::model()->find('rubric_id=:rubric_id', array(':rubric_id'=>$rubric->id));
		if(!$text)
			$text = new Text;

		$data = array(
			'model'=>$object,
			'pages'=>$pages,
			'rubric'=>$rubric,
			'text'=>$text,
			'breadcrumbs'=>$breadcrumbs,
			'levet'=>$level,
			'text'=>$text
		);

		$this->pageTitle = Yii::app()->name.': '.$rubric->name;
		$this->render('/'.$rubric->ctype.'/admin',$data);
	}

	public function actionUpdate($url,$id)
	{
		foreach($this->parseUrl($url) as $k=>$v)
			$$k = $v;

		$model = $object->findByPk($id);

		//$this->performAjaxValidation($model);

		if($_GET['del_image'])
		{
			$image = $_GET['del_image'];
			if($model->$image){
				$oldImage = $model->$image;
				$model->$image = null;
				if($model->save()){
					$uploadPath = $_SERVER['DOCUMENT_ROOT'].'/userdata/';
					$objectPath = $ctype.'/'.$ctype.'_'.$model->id.'/';
					foreach($this->image_size[$ctype][$image] as $k=>$v){
						$thumbPath = $k.'/';
						$file = $uploadPath.$objectPath.$thumbPath.$oldImage;
						unlink($file);
					}
					$this->redirect('/'.Yii::app()->request->pathInfo);
				}
			}
		}

		if(isset($_POST['Text']))
		{
			$text = Text::model()->find('rubric_id=:rubric_id', array(':rubric_id'=>$rubric->id));
			$text->attributes = $_POST['Text'];
			if($text->save())
				$this->redirect($rubric->getLink());
		}
		else
		if($_POST['Rubrics'])
		{
			$rubric->attributes = $_POST['Rubrics'];
			if($rubric->save())
				$this->redirect($rubric->getLink());
		}
		else
		if($_POST[$obj_class])
		{
            if($_FILES['file']){
                foreach($_FILES['file']['name'] as $k=>$v){
                    if($v){
			            $file[$k] = CUploadedFile::getInstanceByName('file['.$k.']');

						if(in_array(strtolower($file[$k]->getExtensionName()),array('jpg','gif','png','jpeg')))
							$model->$k = $k.'.'.$file[$k]->getExtensionName();
						else
							$model->$k = CUploadedFile::getInstanceByName('file['.$k.']');
                    }
                }
            }

			$model->attributes = $_POST[$obj_class];

			if($model->save())
			{
			  if($file){
          $folder = dirname(Yii::app()->request->scriptFile);
					$folder.='/userdata/'.$ctype.'/'.$ctype.'_'.$model->id.'/';

                    foreach($file as $k=>$v)
					{
						if(in_array(strtolower($file[$k]->getExtensionName()),array('jpg','gif','png','jpeg')))
							UploadImages::upload($file[$k]->getTempName(), $model->$k, $folder, $ctype, $k);
						else
							$model->$k->saveAs($folder.$model->$k->getName());
					}
				}

				$this->redirect($rubric->getLink().'?'.Yii::app()->request->queryString);
			}
		}

		$data = array(
			'model'=>$model,
			'title'=>$rubric->name,
			'rubric'=>$rubric
		);

		$this->render('/_form/update',$data);
	}

	public function actionAdd($url)
	{
		foreach($this->parseUrl($url) as $k=>$v)
			$$k = $v;

		$model = new $obj_class;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Text']))
		{
			$text = new Text;
			$text->attributes = $_POST['Text'];
			if($text->save())
				$this->redirect($rubric->getLink());
		}
		else
		if($_POST[$obj_class])
		{
            if($_FILES['file']){
                foreach($_FILES['file']['name'] as $k=>$v){
                    if($v){
			            $file[$k] = CUploadedFile::getInstanceByName('file['.$k.']');

						if(in_array(strtolower($file[$k]->getExtensionName()),array('jpg','gif','png','jpeg')))
							$model->$k = $k.'.'.$file[$k]->getExtensionName();
						else
							$model->$k = CUploadedFile::getInstanceByName('file['.$k.']');
                    }
                }
            }

			$model->attributes = $_POST[$obj_class];

			if($model->save())
			{
			  if($file){
          $folder = dirname(Yii::app()->request->scriptFile);
					$folder.='/userdata/'.$ctype.'/'.$ctype.'_'.$model->id.'/';
          foreach($file as $k=>$v)
					{
						if(in_array(strtolower($file[$k]->getExtensionName()),array('jpg','gif','png','jpeg')))
							UploadImages::upload($file[$k]->getTempName(), $model->$k, $folder, $ctype, $k);
						else
							$model->$k->saveAs($folder.$model->$k->getName());
					}

					if(get_class($model)=="Sales"){
						$instaPost = Instagram::sendInstagramm($_SERVER['DOCUMENT_ROOT']."/userdata/sales/sales_".$model->id."/insta/".$model->image, $model->name."\n".$model->announce."\n"." #gdeskidki #sale #гдескидки #скидки #".str_replace(' ','',$model->brand->name));
					}
				}

				if(get_class($model)=='Sales'){
					$VKWallPost = VK::wallPost($model->name, $model->announce, $this->getLink($model,1), $this->getImageUrl($model,'orig'));
				}

				$this->redirect($rubric->getLink().'?'.Yii::app()->request->queryString);
			}
			else
				exit(var_dump($model->getErrors()));
		}

		$data = array(
			'model'=>$model,
			'title'=>$rubric->name,
			'rubric'=>$rubric
		);

		$this->render('/_form/create',$data);
	}

	public function actionDelete($url,$id)
	{
		$uri = explode('/', trim($url,'/'));
		$level = count($uri);
		$parent_id = 0;

		foreach($uri as $k=>$v)
		{
			$breadcrumbs[$k] = Rubrics::model()->find(
				'parent_id=:parent_id and chpu=:chpu',
				array(':chpu'=>$v, ':parent_id'=>$parent_id)
			);

			if($breadcrumbs[$k])
				$parent_id = $breadcrumbs[$k]->id;
			else
				$this->render('/errors/404');
		}
		//--------------------------------------------------//
		$rubric = $breadcrumbs[$level-1];

		$ctype = $rubric->ctype;
		$obj_class = ucfirst($ctype);

		$object = new $obj_class;
		$model = $object->deleteByPk($id);

		if(!Yii::app()->request->isAjaxRequest)
			$this->redirect($rubric->getLink());
	}

	public function actionPropeties($url,$id)
	{
		foreach($this->parseUrl($url) as $k=>$v)
			$$k = $v;

		$model = Rubrics::model()->findByPk($id);

		if($_GET['del_image'])
		{
			$image = $_GET['del_image'];
			if($model->$image){
				$oldImage = $model->$image;
				$model->$image = null;
				if($model->save()){
					$uploadPath = $_SERVER['DOCUMENT_ROOT'].'/userdata/';
					$objectPath = 'rubrics/rubrics_'.$model->id.'/';
					foreach($this->image_size[$ctype][$image] as $k=>$v){
						$thumbPath = $k.'/';
						$file = $uploadPath.$objectPath.$thumbPath.$oldImage;
						unlink($file);
					}
					$this->redirect($model->getLink().'?'.Yii::app()->request->queryString);
				}
			}
		}

		if($_POST['Rubrics'])
		{
            if($_FILES['file']){
                foreach($_FILES['file']['name'] as $k=>$v){
                    if($v){
			            $file[$k] = CUploadedFile::getInstanceByName('file['.$k.']');

						if(in_array(strtolower($file[$k]->getExtensionName()),array('jpg','gif','png','jpeg')))
							$model->$k = $k.'.'.$file[$k]->getExtensionName();
						else
							$model->$k = CUploadedFile::getInstanceByName('file['.$k.']');
                    }
                }
            }

			$model->attributes = $_POST['Rubrics'];

			if($model->save())
			{
			    if($file){
					$folder = dirname(Yii::app()->request->scriptFile);
                    $folder .= '/userdata/rubrics/rubrics_'.$model->id.'/';
                    foreach($file as $k=>$v)
					{
						if(in_array(strtolower($file[$k]->getExtensionName()),array('jpg','gif','png','jpeg')))
						{
							UploadImages::upload($file[$k]->getTempName(), $model->$k, $folder, 'rubrics', $k);
						}
					}
				}
			}
			else
				exit(var_dump($model->getErrors()));
		}

		$this->redirect($model->getLink().'?'.Yii::app()->request->queryString);
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='service-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
