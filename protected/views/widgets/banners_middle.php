<?$banners = Banners::model()->findAll(array(	'condition'=>'side=1 and status=1',	'order'=>'pos, id'));?><?if($banners){?>	<div class="carusel" id="stSlider">		<?foreach($banners as $k=>$v){?>			<a href="<?=$v->link?>" class="<?if($k==0){?>active<?}?>"><img src="<?=$this->getImageUrl($v,'b')?>" width="100%" /></a>						<?}?>				<img src="/static/img/empty2x5.gif" width="100%" />				<div class="carusel_pages">			<?foreach($banners as $k=>$v){?>				<span class="dot <?if($k==0){?>active<?}?>" onclick="scrollCarusel('#stSlider',<?=$k?>);"><?=($k+1)?></span>			<?}?>		</div>				<span class="prev-next prev" onclick="scrollCarusel('#stSlider','prev');">Назад</span>		<span class="prev-next next" onclick="scrollCarusel('#stSlider','next');">Вперед</span>	</div>		<div class="wave"></div><?}?>