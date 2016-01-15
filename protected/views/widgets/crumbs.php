	<?$crumbs = Yii::app()->params['crumbs'];?>
	<?$active = array_pop($crumbs);?>
	<div class="crumbs">		
		<a href="/" class="active">Главная</a> → 
		<?foreach($crumbs as $k=>$v){?>
			<?if($v->id){?>
				<a href="<?=$v->getLink()?>"><?=$v->name?></a> → 
			<?}?>
		<?}?>
		<span><?=$active->name?></span>
	</div>