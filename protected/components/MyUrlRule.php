<?
class MyUrlRule extends CBaseUrlRule
{
    public function createUrl($manager,$route,$params,$ampersand)
    {
        return parent::createUrl($manager,$route,$params,$ampersand);  // не применяем данное правило
    }
	
    public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
    {
		if(preg_match('(\w+)', $pathInfo, $matches))
		{
			$uri = explode('/', trim($pathInfo,'/'));
			$level = count($uri);
			$parent_id = 0;
			$pre_route = '/';
			
			while(Yii::app()->hasModule($uri[0]))
			{
				$pre_route .= $uri[0].'/';
				array_shift($uri);
			}
			
			foreach($uri as $k=>$v)
			{				
				$crumbs[$k] = Rubrics::model()->find(array(
					'condition'=>'parent_id=:parent_id and chpu=:chpu and status>=:status',
					'params'=>array(':chpu'=>$v, ':parent_id'=>$parent_id, ':status'=>1)
				));
				
				if($crumbs[$k])
				{
					$rubric = $crumbs[$k];
					$parent_id = $rubric->id;				
					$route = $rubric->ctype.'/rubric/id/'.$rubric->id; 
				}
				elseif($k==count($uri)-1 && is_numeric($v))
				{
					array_pop($crumbs);
					
					$obj_class = ucfirst($crumbs[$k-1]->ctype);
					$model = new $obj_class;
				
					$model = $model->model()->find(array(
						'condition'=>'id=:singleId and rubric_id=:rubricId',
						'params'=>array(':singleId'=>$v, ':rubricId'=>$rubric->id)
					));
				
					if($model)
						$route = $rubric->ctype.'/single/id/'.$model->id;
					else
						return '/site/error/code/404';
				}
				else
					return '/site/error/code/404';
			}		

			Yii::app()->params['crumbs'] = $crumbs;

			return $pre_route.$route;
		}
		else
			return '/site/error/code/404';		
    }
}