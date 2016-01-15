
<div class="column w100p">
	<div class="ml175">
		<div class="text"><h1>Каталог</h1></div>
		
		<?=$this->renderPartial('/widgets/breadcrumbs',array('rubric'=>$rubric))?>

		<?=$this->renderPartial('/catalog/submenu',array('rubric'=>$rubric))?>
		
		<?if($data){?>
			<div class="pagination cl">
				<p class="changeView">
					<a href="" class="grey blocks"><i class="spriteBlocks"></i>Плиткой</a>
					<a href="" class="grey lines"><i class="spriteLines"></i>Построчно</a>
				</p>
				<?=$this->renderPartial('/widgets/pager',array('page'=>$page,'pages'=>$pages))?>
				<br class="clear" />
			</div>
		
			<ul class="none blockItems cl">
			<?foreach($data as $k=>$v){?>
				<li class="pie <?if(($k+1)%4==0){?>left<?}?>">
					<div class="itemImage pie"><a href="<?=$v->getLink()?>"><img src="<?=$v->getImageUrl('m')?>" alt="<?=$v->name?>" /></a></div>
                    <div class="itemTitle">
						<a href="<?=$v->getLink()?>"><span><?=$v->name?>, арт. <?=$v->art?></span></a>
					</div>
                    <div class="itemCount">
						<span>
							<a href="" class="spriteMinus minus"></a>
							<input value="1" name="" type="text" id="n<?=$v->id?>" />
							<a href="" class="spritePlus plus"></a>
						</span>
					</div>
                    <div class="itemPrice">
						<span>
							<b><?=$v->price1?>р.</b>
							<b><?=$v->price2?>р.</b>
							<b><?=$v->price3?>р.</b>
						</span>
					</div>
                    <div class="itemButtons">
						<a href="javascript:void(0);" class="" onclick="addToWishlist(<?=$v->id?>);">
							<i class="spriteEye"></i>
							<br />привезите
							<br />посмотреть
						</a>
						<a href="javascript:void(0);" onclick="addToCart(<?=$v->id?>);">
							<i class="spriteToCart"></i>
							<br />в&nbsp;корзину
						</a>
					</div>
				</li>
			<?}?>
			</ul>
					
			<div class="pagination cl">
				<?=$this->renderPartial('/widgets/pager',array('page'=>$page,'pages'=>$pages))?>
			</div>
		<?}else{?>
			<p>Ничего не найдено</p>
		<?}?>
	</div>
</div>
				
<?=$this->renderPartial('/layouts/vert_menu',array('rubric'=>$rubric))?>