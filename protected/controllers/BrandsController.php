<?
class BrandsController extends Controller
{
	public function actionSingle($id)
	{
		$brand = Brands::model()->findByPk($id);
		
		$sales = Sales::model()->findAll(array(
			'condition'=>'status=1 and brand_id=:brandId and ((start=finish and start<=:now) OR :now between start and finish)',
			'params'=>array(':brandId'=>$brand->id,':now'=>date('Y-m-d H:i:s'))
		));
		
		$data = array(
			'brand'=>$brand,
			'sales'=>$sales,
			
			'title'=>$brand->name
		);
		
		$this->render('single',$data);
	}
}