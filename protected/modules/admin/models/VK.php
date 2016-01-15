<?
class VK
{
	/**
		Получить токен можно по адресу:
		http://oauth.vk.com/authorize?
			client_id=' .VK_APP_ID.'
			&scope=notify,wall,offline
			&display=popup
			&redirect_uri=http://oauth.vk.com/blank.html
			&response_type=token
	**/

	const TOKEN = '6e48b02d1f72f60d734f092ad4f1d0773732e32e1a7851657e2a9c0d150ad1a1745893d7d4ab5a82ac83d';
	const APPID = 4280261;
	const GROUPID = 66298559;
	
	// получение доступа к ВК
	public static function requestVK($method, $params)
	{	 
		$params['access_token'] = VK::TOKEN;
	 
		$query = http_build_query($params);
	 
		$link = 'https://api.vk.com/method/'.$method.'?'.$query;
		
		/*
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $link);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
		curl_close($ch);
		*/
			//exit(var_dump(file_get_contents($link)));
		return file_get_contents($link);
	}
	
	//метод отправки изображения 
	public static function sendImageToVK($img)
	{	
		$attachment = $_SERVER['DOCUMENT_ROOT'].$img;

		if(empty($attachment))
			return false;

		$thumbUploadUrl = self::requestVK('photos.getWallUploadServer',array(
			'gid' => VK::GROUPID
		));
		
		if($thumbUploadUrl)
		{
			$thumbUploadUrlObj = json_decode($thumbUploadUrl);
			$VKuploadUrl = $thumbUploadUrlObj->response->upload_url;
		}
	 
		if($VKuploadUrl)
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_URL, $VKuploadUrl);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, array('photo' => '@' . $attachment));
			 
			$result = curl_exec($ch);
			curl_close($ch);

			$uploadResultObj = json_decode($result);

			if($uploadResultObj->server && $uploadResultObj->photo && $uploadResultObj->hash)
			{
				$saveImageResult = self::requestVK('photos.saveWallPhoto', array(
					'server' => $uploadResultObj->server,
					'photo' => $uploadResultObj->photo,
					'hash' => $uploadResultObj->hash,
					'gid' => VK::GROUPID
				));
				 
				$resultObject = json_decode($saveImageResult);
				if ($resultObject && $resultObject->response[0]->id)
					return $resultObject->response[0];
				else 
					return false;
			}
		}
	}
	
	//Метод обработки данных и подготовки к отправке
	public static function wallPost($name, $content, $link, $img)
	{ 
		$text = '';
		$excerpt = strip_tags(strtok($content, '.'));
 
		$text = $name."\n".$excerpt;
		$text = stripslashes(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
 
		if($imageId = self::sendImageToVK($img)) 
		{
			$attachments = $imageId->id;
			$text .= "\n".$link;
		} 
		else 
		{
			$attachments = $link;
		}

		$result = self::requestVK('wall.post', array(
			'owner_id' => '-'.VK::GROUPID,
			'message' => $text,
			'from_group' => 1,
			'attachments' => $attachments
		));

		$obj_result = json_decode($result);
 
		$response_post_id = $obj_result->response->post_id;
			
		return $response_post_id;
	}
}