<?php

class MyUrlManager extends CUrlManager
{
	public function createPathInfo($params,$equal,$ampersand, $key=null)
	{
		$pairs = array();
		foreach($params as $k => $v)
		{
			if ($key!==null)
				$k = $key.'['.$k.']';

			if (is_array($v))
				$pairs[]=$this->createPathInfo($v,$equal,$ampersand, $k);
			else
				//$pairs[]=urlencode($k).$equal.urlencode($v);
                 $pairs[]=urlencode($k).$equal.str_replace('%2F','/',urlencode($v));

		}
		return implode($ampersand,$pairs);
	}

	protected function createUrlRule($route,$pattern)
    {
        return new MyUrlRule($route,$pattern);
    }

}


class MyUrlRule extends CUrlRule
{

	/**
	 * Creates a URL based on this rule.
	 * @param CUrlManager the manager
	 * @param string the route
	 * @param array list of parameters
	 * @param string the token separating name-value pairs in the URL.
	 * @return string the constructed URL
	 */
	public function createUrl($manager,$route,$params,$ampersand)
	{
		if($manager->caseSensitive && $this->caseSensitive===null || $this->caseSensitive)
			$case='';
		else
			$case='i';

		$tr=array();
		if($route!==$this->route)
		{
			if($this->routePattern!==null && preg_match($this->routePattern.$case,$route,$matches))
			{
				foreach($this->references as $key=>$name)
					$tr[$name]=$matches[$key];
			}
			else
				return false;
		}

		foreach($this->params as $key=>$value)
			if(!isset($params[$key]))
				return false;

		if($manager->matchValue && $this->matchValue===null || $this->matchValue)
		{
			foreach($this->params as $key=>$value)
			{
				if(!preg_match('/'.$value.'/'.$case,$params[$key]))
					return false;
			}
		}

		foreach($this->params as $key=>$value)
		{
			//$tr["<$key>"]=urlencode($params[$key]);
			$tr["<$key>"]=str_replace('%2F','/',urlencode($params[$key]));			
			unset($params[$key]);
		}

		$suffix=$this->urlSuffix===null ? $manager->urlSuffix : $this->urlSuffix;

		$url=strtr($this->template,$tr);
		if(empty($params))
			return $url!=='' ? $url.$suffix : $url;

		if($this->append)
			$url.='/'.$manager->createPathInfo($params,'/','/').$suffix;
		else
		{
			if($url!=='')
				$url.=$suffix;
			$url.='?'.$manager->createPathInfo($params,'=',$ampersand);
		}
		return $url;
	}
}
