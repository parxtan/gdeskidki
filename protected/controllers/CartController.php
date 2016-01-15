<?
class CartController extends Controller
{
	public function actionDefault()
	{
		if($_POST['new_num'])
		{
			$incart = $this->getUserState('cart','incart');
			foreach($_POST["new_num"] as $k=>$v)
			{				
				if($incart[$k])
					if(is_numeric($v)){
						$incart[$k]["n"] = $v;
						if($v>=$incart[$k]["tovar"]->opt3){
							$incart[$k]["opt"] = 3;
							$incart[$k]["price"] = $incart[$k]["tovar"]->price3;
							$incart[$k]["summ"] = $v * $incart[$k]["price"];
							$incart[$k]["skidka"] = $v * ($incart[$k]["tovar"]->price - $incart[$k]["price"]);
						}
						else
						if($v>=$incart[$k]["tovar"]->opt2){
							$incart[$k]["opt"] = 2;
							$incart[$k]["price"] = $incart[$k]["tovar"]->price2;
							$incart[$k]["summ"] = $v * $incart[$k]["price"];
							$incart[$k]["skidka"] = $v * ($incart[$k]["tovar"]->price - $incart[$k]["price"]);
						}
						else
						if($v>=$incart[$k]["tovar"]->opt1){
							$incart[$k]["opt"] = 1;
							$incart[$k]["price"] = $incart[$k]["tovar"]->price1;
							$incart[$k]["summ"] = $v * $incart[$k]["price"];
							$incart[$k]["skidka"] = $v * ($incart[$k]["tovar"]->price - $incart[$k]["price"]);
						}
						else{
							$incart[$k]["price"] = $incart[$k]["tovar"]->price;
							$incart[$k]["summ"] = $v * $incart[$k]["price"];
							$incart[$k]["skidka"] = 0;
						}
					}else{
						$incart[$k]["n"] = 0;
						$incart[$k]["summ"] = 0;
						$incart[$k]["skidka"] = 0;
					}
			}	
			$cart['summ'] = 0;
			$cart['count'] = 0;
			$cart['skidka'] = 0;
			$cart['incart'] = $incart;
			foreach($cart['incart'] as $k=>$v)
			{
				$cart['summ'] = $cart['summ'] + $v['summ'];
				$cart['count'] = $cart['count'] + $v['n'];
				$cart['skidka'] = $cart['skidka'] + $v['skidka'];
			}			
			Yii::app()->user->setState('cart',$cart);
			$this->redirect('/cart/');
		}

		$this->render('/cart/default');
	}
	
	public function actionSubmit()
	{
		$incart = $this->getUserState('cart','incart');
		
		$order_list = '<b>Заказ:</b>';
		$order_list .= '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse;">';
		$order_list .= '<tr>';
		$order_list .= '<td>Артикул</td>';
		$order_list .= '<td>Наименование</td>';
		$order_list .= '<td>Стоимость</td>';
		$order_list .= '<td>Кол-во</td>';
		$order_list .= '<td>Сумма</td>';
		$order_list .= '</tr>';
		
		foreach($incart as $k=>$v)
		{
			$order_list .='<tr>';
			$order_list .= '<td>'.$v['tovar']->art.'</td>';
			$order_list .= '<td>'.$v['tovar']->name.'</td>';
			$order_list .= '<td>'.$v['tovar']->getPrice().'</td>';
			$order_list .= '<td>'.$v['n'].'</td>';
			$order_list .= '<td>'.$v['summ'].'</td>';		
			$order_list .='</tr>';
		}
		$order_list .= '<tr>';
		$order_list .= '<td colspan="7" align="right">Итого: '.$this->getUserState('cart','summ').' руб.</td>';
		$order_list .= '</tr>';
		$order_list .= '</table>';
		
		/***** Привещите посмотреть ****/
		$wishlist = Yii::app()->user->getState('wishlist');
		
		if($wishlist){
			$order_list .='<br /><b>Привезите посмотреть:</b>';
			
			foreach($wishlist as $k=>$v)
				$order_list .= '<div>'.$v->art.', '.$v->name.'</div>';
		}
		
		$order = new Orders();
		$order->attributes = $_POST['Orders'];
		$order->date = date('Y-m-d H:i:s');
		$order->order_list = $order_list;
		$order->summ = $this->getUserState('cart','summ');		
		
		$order_list .= '<br /><b>Ваши данные:</b>';
		$order_list .= '<div>ФИО: '.$order->name.'</div>';
		$order_list .= '<div>E-mail: '.$order->email.'</div>';
		$order_list .= '<div>Телефон: '.$order->phone.'</div>';
		if($order->address)
			$order_list .= '<div>Адрес: '.$order->address.'</div>';
		if($order->text)
			$order_list .= '<div>Примечание: '.$order->text.'</div>';
			
		$order_list .= '<br /><div><b>Спасибо за заказ. Наши менеджеры свяжутся с вами вближайшее время.</b></div>';
		$order_list .= '<br />----';
		$order_list .= '<div>С уважением, Optoffka.</div>';
		
		if($order->save())
		{
			Yii::app()->user->setState('cart','');
			Yii::app()->user->setState('wishlist','');
			Yii::app()->user->setFlash('message','Спасибо за заказ! Наш менеджер свяжется с Вами в ближайшее время.');
			
			$mailer = Yii::app()->mailer;
			$mailer->CharSet = 'UTF-8';				
			$mailer->IsHTML(true);
			$mailer->From = $order->email;
			$mailer->FromName = 'OPTOFFKA';
			$mailer->AddReplyTo('noreply@optoffka.ru');
			$mailer->AddAddress($order->email);
			$mailer->AddBCC($this->getConfig('email'));
			$mailer->Subject = 'Заказ на сайте Optoffka.ru';
			$mailer->Body = $order_list;
			$mailer->Send();			
			
			$this->redirect('/cart/');
		}
		else
			exit(var_dump($order->getErrors()));
	}
	
	public function actionDelete()
	{
		$key = Yii::app()->request->getParam('key');
		$incart = $this->getUserState('cart','incart');

		$tovar = $incart[$key]['tovar'];
		unset($incart[$key]);
			
		$cart['summ'] = 0;
		$cart['count'] = 0;
		$cart['incart'] = $incart;
		foreach($cart['incart'] as $k=>$v)
		{
			$cart['summ'] = $cart['summ'] + $v['summ'];
			$cart['count'] = $cart['count'] + $v['n'];
			$cart['skidka'] = $cart['skidka'] + $v['skidka'];
		}			
		Yii::app()->user->setState('cart',$cart);
		
		if(Yii::app()->request->isAjaxRequest)
			exit('{"status": "success", "summ": "'.$cart['summ'].'", "count": "'.$cart['count'].'", "message": "'.addslashes($tovar->name).' удален из корзины."}');
		else
			$this->redirect('/cart/');
	}

	public function actionAdd()
	{
		$id = Yii::app()->request->getParam('catalogId');
		$cnt = Yii::app()->request->getParam('n');
		$count = $cnt ? $cnt : 1;
		$action = 'add';	
	
		$tovar = Catalog::model()->findByPk($id);
		if($tovar)
		{
			$cart = Yii::app()->user->getState('cart');
			
			$key = $id;
			
			if($cart && $cart['incart'][$key]['n']>0 && is_numeric($count))
			{
				if($action=='update')
					$n = $count;
				else
					$n = $cart['incart'][$key]['n'] + $count;
					
				$cart['incart'][$key] = array(
					'n'=>$n,
					'tovar'=>$tovar
				);
				
				if($n>=$tovar->opt3){
					$cart['incart'][$key]["opt"] = 3;
					$cart['incart'][$key]["price"] = $tovar->price3;
					$cart['incart'][$key]["summ"] = $n * $cart['incart'][$key]["price"];
					$cart['incart'][$key]["skidka"] = $n * ($tovar->price - $cart['incart'][$key]["price"]);
				}
				else
				if($n>=$tovar->opt2){
					$cart['incart'][$key]["opt"] = 2;
					$cart['incart'][$key]["price"] = $tovar->price2;
					$cart['incart'][$key]["summ"] = $n * $cart['incart'][$key]["price"];
					$cart['incart'][$key]["skidka"] = $n * ($tovar->price - $cart['incart'][$key]["price"]);
				}
				else
				if($n>=$tovar->opt1){
					$cart['incart'][$key]["opt"] = 1;
					$cart['incart'][$key]["price"] = $tovar->price1;
					$cart['incart'][$key]["summ"] = $n * $cart['incart'][$key]["price"];
					$cart['incart'][$key]["skidka"] = $n * ($tovar->price - $cart['incart'][$key]["price"]);
				}
				else{
					$cart['incart'][$key]["price"] = $tovar->price;
					$cart['incart'][$key]["summ"] = $n * $cart['incart'][$key]["price"];
					$cart['incart'][$key]["skidka"] = 0;
				}				
			}
			else
			{
				$cart['incart'][$key] = array(
					'n'=>$count, 			
					'summ'=>$count*$tovar->price,
					'price'=>$tovar->price,
					'tovar'=>$tovar
				);
			}
				
			$cart['summ'] = 0;
			$cart['count'] = 0;
			$cart['skidka'] = 0;
			foreach($cart['incart'] as $k=>$v)
			{
				$cart['summ'] = $cart['summ'] + $v['summ'];
				$cart['count'] = $cart['count'] + $v['n'];
				$cart['skidka'] = $cart['skidka'] + $v['skidka'];
			}

			Yii::app()->user->setState('cart',$cart);

			exit('{"status": "success", "summ": "'.$cart['summ'].'", "count": "'.$cart['count'].'", "message": "'.addslashes($tovar->name).' добавлен в корзину."}');
		}
		else
			exit ('{"status": "faild", "message": "Товар не найден"}');
	}
	
	public function actionReset()
	{
		Yii::app()->user->setState('cart','');
		
		$this->redirect('/cart/');
	}
	
	/******* Wishlist *******/
	public function actionAddToWishlist()
	{
		$id = Yii::app()->request->getParam('catalogId');	
		$tovar = Catalog::model()->findByPk($id);
		if($tovar)
		{
			$wishlist = Yii::app()->user->getState('wishlist');
		
			if(!$wishlist[$id])
				$wishlist[$id] = $tovar;

			Yii::app()->user->setState('wishlist',$wishlist);

			exit('{"status": "success", "message": "'.addslashes($tovar->name).' добавлен в Wishlist."}');
		}
		else
			exit ('{"status": "faild", "message": "Товар не найден"}');
	}	
	
	public function actionDeleteFromWishlist()
	{
		$id = Yii::app()->request->getParam('catalogId');
		$wishlist = Yii::app()->user->getState('wishlist');

		$tovar = $wishlist[$id];
		unset($wishlist[$id]);
			
		Yii::app()->user->setState('wishlist',$wishlist);
		
		if(Yii::app()->request->isAjaxRequest)
			exit('{"status": "success", "message": "'.addslashes($tovar->name).' удален из Wishlist."}');
		else
			$this->redirect('/cart/');
	}	
}