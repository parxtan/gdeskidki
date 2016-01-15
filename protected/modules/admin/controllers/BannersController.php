<?
class BannersController extends Controller
{
	public function actionDefault()
	{
		$pos = Yii::app()->request->getParam('pos');
		if(!$pos)
			$pos = Yii::app()->request->getParam('photo');
		if($pos)
		{
			foreach($pos as $k=>$v)
			{
				$model = new Banners;
				$model->model()->updateByPk($v,array('pos'=>$k+1));
			}
			
			exit('success');
		}	
	
		$model = new Banners('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Banners']))
			$model->attributes = $_GET['Banners'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionAdd()
	{
		$model = new Banners;

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);

		if(isset($_POST['Banners']))
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
		
			$model->attributes = $_POST['Banners'];			
			
			if($model->save()){
			    if($file){
                    $folder = dirname(Yii::app()->request->scriptFile);
					$folder.='/userdata/banners/banners_'.$model->id.'/';
                    foreach($file as $k=>$v)
						if(in_array(strtolower($file[$k]->getExtensionName()),array('jpg','gif','png','jpeg')))
							UploadImages::upload($file[$k]->getTempName(), $model->$k, $folder, 'banners', $k);
				}
				
				$this->redirect('/admin/banners/');
			}
		}

		$this->render('form',array(
			'model'=>$model,
			'title'=>'Редактирование баннера'
		));
	}

	public function actionUpdate($id)
	{
		$model = Banners::model()->findByPk($id);

		if($_GET['del_image']){
			$image = $_GET['del_image'];
			if($model->$image){
				$oldImage = $model->$image;
				$model->$image = null;
				if($model->save()){
					$uploadPath = $_SERVER['DOCUMENT_ROOT'].'/userdata/';
					$objectPath = 'banners/banners_'.$model->id.'/';				
					foreach($this->image_size['banners'][$image] as $k=>$v){
						$thumbPath = $k.'/';
						$file = $uploadPath.$objectPath.$thumbPath.$oldImage;
						unlink($file);
					}
					$this->redirect('/'.Yii::app()->request->pathInfo);
				}				
			}
		}	

		if(isset($_POST['Banners']))
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
		
			$model->attributes = $_POST['Banners'];			
			
			if($model->save()){
			    if($file){
                    $folder = dirname(Yii::app()->request->scriptFile);
					$folder.='/userdata/banners/banners_'.$model->id.'/';
                    foreach($file as $k=>$v)
						if(in_array(strtolower($file[$k]->getExtensionName()),array('jpg','gif','png','jpeg')))
							UploadImages::upload($file[$k]->getTempName(), $model->$k, $folder, 'banners', $k);
				}
				
				$returnUrl = '/admin/banners/';
				
				$this->redirect($returnUrl.'?'.Yii::app()->request->queryString);
			}
		}

		$this->render('form',array(
			'model'=>$model,
			'title'=>'Редактирование баннера'
		));
	}	
	
	public function actionDelete($id)
	{
		$model = Banners::model()->findByPk($id)->delete();
		
		if(!Yii::app()->request->isAjaxRequest)
			$this->redirect('/admin/banners/');			
	}
}