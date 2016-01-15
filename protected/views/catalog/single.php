
<div class="column w100p">
	<div class="ml175">
		<div class="text"><h1>Каталог</h1></div>
		
		<?=$this->renderPartial('/widgets/breadcrumbs',array('rubric'=>$rubric))?>

		<?=$this->renderPartial('/catalog/submenu',array('rubric'=>$rubric))?>

		<h1 class="black"><?=$data->name?></h1>
		<div class="itemBlock cl">
			<div class="descWrapper">
				<div class="desc">
					<div class="descText"><?=$data->text?></div>
					<div class="cl">
						<div class="price column">
							<table cellpadding="0" cellspacing="0">
								<tr><td>Цена</td><td>:</td><td><b><?=$data->price?> р.</b></td></tr>
								<tr><td>Опт 1</td><td></td><td><b><?=$data->price1?> р.</b></td></tr>
                                <tr><td>Опт 2</td><td></td><td><b><?=$data->price2?> р.</b></td></tr>
                                <tr><td>Опт 3</td><td></td><td><b><?=$data->price3?> р.</b></td></tr>
							</table>
						</div>
                        <div class="order column">
							<div class="count">
								<a href="" class="minus"><i class="spriteHugeMinus"></i></a>
								<input name="" type="text" value="1" id="n<?=$data->id?>" />
								<a href="" class="plus"><i class="spriteHugePlus"></i></a>
							</div>
							<p><a href="javascript:void(0);" class="button" onclick="addToCart(<?=$data->id?>);"><i class="button1"></i></a></p>
                            <p><a href="javascript:void(0);" onclick="addToWishlist(<?=$data->id?>);" class="button"><i class="button2"></i></a></p>
						</div>
					</div>
				</div>
			</div>
            <div class="images cl">
				<a href="<?=$data->getImageUrl('b')?>" rel="fancybox"><img class="bigImage" src="<?=$data->getImageUrl('l')?>" alt="<?=$data->name?>" /></a>
                <p class="cl">
					<?if($data->image2){?>
						<a href="<?=$data->getImageUrl('b','image2')?>" rel="fancybox"><img src="<?=$data->getImageUrl('s','image2')?>" alt="<?=$data->name?>" /></a>
					<?}?>
					<?if($data->image3){?>
						<a href="<?=$data->getImageUrl('b','image3')?>" rel="fancybox"><img src="<?=$data->getImageUrl('s','image3')?>" alt="<?=$data->name?>" /></a>
					<?}?>
					<?if($data->image4){?>
						<a href="<?=$data->getImageUrl('b','image4')?>" rel="fancybox"><img src="<?=$data->getImageUrl('s','image4')?>" alt="<?=$data->name?>" /></a>
					<?}?>
					<br class="clear" />
				</p>
			</div>
		</div>
		
        <h1 class="black">Возможно вас заинтересует</h1>
		<ul class="none blockItems cl">
			<li class="left pie">
				<div class="itemImage pie"><img src="images/item.jpg" alt="" /></div>
                <div class="itemTitle"><span>Силиконовый чехол<br />для HTC Flyer, арт.</span></div>
                <div class="itemCount"><span><a href="" class="spriteMinus minus"></a><input value="2" name="" type="text" /><a href="" class="spritePlus plus"></a></span></div>
                <div class="itemPrice"><span><b>100 р.</b><b>120р.</b><b>200р.</b></span></div>
                <div class="itemButtons"><a href="" class=""><i class="spriteEye"></i><br />привезите<br />посмотреть</a><a href=""><i class="spriteToCart"></i><br />в&nbsp;корзину</a></div>
			</li>
		</ul>
	</div>
</div>
				
<?=$this->renderPartial('/layouts/vert_menu',array('rubric'=>$rubric))?>