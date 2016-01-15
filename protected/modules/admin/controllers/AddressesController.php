<?
class AddressesController extends Controller
{
	public function actionDefault($bid)
	{
		$brand = Brands::model()->findByPk($bid);
	
		$model = new Addresses('search');
		$model->unsetAttributes();  // clear any default values
		$model->brand_id = $bid;
		if(isset($_GET['Addresses']))
			$model->attributes = $_GET['Addresses'];

		$this->render('admin',array(
			'model'=>$model,
			'brand'=>$brand
		));	
	}
		
	public function actionAdd($bid)
	{
		$brand = Brands::model()->findByPk($bid);
		
		$model = new Addresses;

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);

		if(isset($_POST['Addresses']))
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
		
			$model->attributes = $_POST['Addresses'];			
			
			if($model->save()){
			    if($file){
                    $folder = dirname(Yii::app()->request->scriptFile);
					$folder.='/userdata/addresses/addresses_'.$model->id.'/';
                    foreach($file as $k=>$v)
						if(in_array(strtolower($file[$k]->getExtensionName()),array('jpg','gif','png','jpeg')))
							UploadImages::upload($file[$k]->getTempName(), $model->$k, $folder, 'addresses', $k);
				}
				
				$this->redirect('/admin/brands/'.$bid.'/addresses/');
			}
		}

		$this->render('_form',array(
			'model'=>$model,
			'brand'=>$brand,
			'title'=>'Добавление адреса'
		));
	}
	
	public function actionUpdate($bid,$id)
	{
		$brand = Brands::model()->findByPk($bid);
		
		$model = Addresses::model()->findByPk($id);

		if($_GET['del_image']){
			$image = $_GET['del_image'];
			if($model->$image){
				$oldImage = $model->$image;
				$model->$image = null;
				if($model->save()){
					$uploadPath = $_SERVER['DOCUMENT_ROOT'].'/userdata/';
					$objectPath = 'addresses/addresses_'.$model->id.'/';				
					foreach($this->image_size['addresses'][$image] as $k=>$v){
						$thumbPath = $k.'/';
						$file = $uploadPath.$objectPath.$thumbPath.$oldImage;
						unlink($file);
					}
					$this->redirect('/'.Yii::app()->request->pathInfo);
				}				
			}
		}	

		if(isset($_POST['Addresses']))
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
		
			$model->attributes = $_POST['Addresses'];			
			
			if($model->save()){
			    if($file){
                    $folder = dirname(Yii::app()->request->scriptFile);
					$folder.='/userdata/addresses/addresses_'.$model->id.'/';
                    foreach($file as $k=>$v)
						if(in_array(strtolower($file[$k]->getExtensionName()),array('jpg','gif','png','jpeg')))
							UploadImages::upload($file[$k]->getTempName(), $model->$k, $folder, 'addresses', $k);
				}
				
				$returnUrl = '/admin/brands/'.$bid.'/addresses/';
				
				$this->redirect($returnUrl.'?'.Yii::app()->request->queryString);
			}
		}

		$this->render('_form',array(
			'model'=>$model,
			'brand'=>$brand,
			'title'=>'Редактирование адреса'
		));
	}	
	
	public function actionDelete($id)
	{
		$brand = Brands::model()->findByPk($bid);
		
		$model = Addresses::model()->findByPk($id)->delete();
		
		if(!Yii::app()->request->isAjaxRequest)
			$this->redirect('/admin/brands/'.$bid.'/addresses/');			
	}	
}