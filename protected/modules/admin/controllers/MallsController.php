<?
class MallsController extends Controller
{
	public function actionGetData()
	{
		$id = Yii::app()->request->getParam('mall_id');
		if(is_numeric($id))
		{
			$mall = Malls::model()->findByPk($id);
			if($mall)
			{
				if(Yii::app()->request->isAjaxRequest)
					exit('{
						"status":"success", 
						"coords":"'.$mall->coords.'", 
						"address": "'.str_replace("\r\n","",'г. '.$this->cities[$mall->city_id].', '.$mall->address).'", 
						"work": "'.$mall->work.'"
					}');
				else
					return $mall;
			}
		}
		
		exit('{"status":"faild"}');
	}
}