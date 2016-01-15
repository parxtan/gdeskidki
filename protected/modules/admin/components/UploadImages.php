<?
class UploadImages
{
    public static function upload($tmpFile, $file, $folder, $class='news', $img='photo')
	{	
		$previews = Yii::app()->controller->image_size[$class][$img];
		
		if($previews)
		{
			foreach($previews as $k=>$v)
			{
				$thumb_folder[$k] = $folder.$k.'/';
				$size[$k] = $v;
			}	

			$image = Yii::app()->ih->load($tmpFile);

			$image->resize(1000,800)->save($folder.$file);
		
			foreach($size as $k=>$v)
			{
				$image->reload();
				if($v['crop']==1)
					if($v['startX'] || $v['startY'])
						$image->adaptiveThumb($v['width'], $v['height'], $v['startX'], $v['startY']);
					else
						$image->adaptiveThumb($v['width'], $v['height']);
				else
					$image->resize($v['width'], $v['height']);
				
				if($v['rotate'])
					$image->rotate($v['rotate']);				
			
				$image->save($thumb_folder[$k].$file);
			}
		}
		else
			$image->save($folder.$file);
			
		return true;
    }
}