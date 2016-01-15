<?
class FormController extends Controller
{
	public function actionRubric($id=null)
	{
	
		if($_POST['Form'])
		{
			$model = new Form('new');
			
			$this->performAjaxValidation($model);
			
			$model->attributes = $_POST['Form'];
			$model->date = time();
			
			if($_FILES['file']['tmp_name']){
				$file = CUploadedFile::getInstanceByName('file');
				$model->file = $file->getName();
			}
			
			if($model->save())
			{
				$text = 'Имя: '.$model->name;
				$text .= '<br />Фамилия: '.$model->lastname;
				$text .= '<br />E-mail: '.$model->email;
				$text .= '<br />Телефон: '.$model->tel;
				if($model->arts)
					$text .= '<br />Артикулы под нанесение: '.$model->arts;
				if($model->delivered)
					$text .= '<br />Желаемая дата заказа: '.$model->delivered;
				$text .= '<br />Кол-во цветов: '.$model->color;
				$text .= '<br />Тираж: '.$model->tirazh;
				$text .= '<br />Размеры: '.$model->width.' x '.$model->height;
				$text .= '<br />Драг.металы:';
				$text .= '<br />Золото - '.($model->gold ? 'Да' : 'Нет');
				$text .= '<br />Платина - '.($model->platina ? 'Да' : 'Нет');
				if($model->text)
					$text .= '<br />Примечание: '.$model->text;
			
				$message = new YiiMailMessage();				
				$message->setTo(array($this->getConfig('email3') => 'Комплекс Бар'));
				$message->setFrom(array($model->email => $model->name.' '.$model->lastname));
				$message->setSubject('Заказ на нанесение');
				$message->setBody($text,'text/html','utf8');
				
				if($_FILES['file']['tmp_name'])
				{
					$fileNewPath = $_SERVER['DOCUMENT_ROOT'].'/userdata/nanesenie/'.$file->getName();
					$file->saveAs($fileNewPath);
					$message->attach(Swift_Attachment::fromPath($fileNewPath));
				}
				Yii::app()->mail->send($message);
				
				Yii::app()->user->setFlash('message','Спасибо за заказ. Наш менеджер свяжется с вами в ближайшее время.');
			}
			else
				$this->render('rubric',$data);
				
			$this->refresh();
		}	
	
		$rubric = Rubrics::model()->findByPk($id);
		
		$data = array(
			'rubric'=>$rubric
		);
		
		$this->render('rubric',$data);
	}
	
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}	
}