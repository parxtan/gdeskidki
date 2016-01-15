<?
class TinymceController extends Controller
{
	public function actionUpload($obj=null)
	{
		if(Yii::app()->user->isGuest)
			$this->redirect('/');
			
		if(!$obj) $obj = 'default';

		if($_FILES['uploadFile'])
		{
			$fileExt = array('doc','docx','xls','xlsx','txt','mp3');
			$imageExt = array('jpg','gif','png','jpeg');
			$serverPath = dirname(Yii::app()->request->scriptFile);
			$folder = '/userdata/uploads/u'.Yii::app()->user->id.'/';
			
			$file = CUploadedFile::getInstanceByName('uploadFile');
			$fileName = time().'.'.$file->getExtensionName();
						
			if(in_array(strtolower($file->getExtensionName()),$fileExt) || in_array(strtolower($file->getExtensionName()),$imageExt))
			{
				if(in_array(strtolower($file->getExtensionName()),$imageExt))
				{
					UploadImages::upload($file->getTempName(), $fileName, $serverPath.$folder, 'tinymce', $obj.'_text_image');
				}
				else
				{
					if(!is_dir(Yii::getPathOfAlias('webroot').$folder))
						mkdir(Yii::getPathOfAlias('webroot').$folder, 0777, true);

					$file->saveAs(Yii::getPathOfAlias('webroot').$folder.$fileName);
				}
				
				header("Content-type: application/xml; charset=utf-8");
				exit('<?xml version="1.0" encoding="utf8"?><result>'.$folder.'resize/'.$fileName.'</result>');
			}
			else
				exit('Запрещенный формат файла');
		}
		else		
			exit('No file');		
	}
}