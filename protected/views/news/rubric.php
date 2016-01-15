
	<?=$this->renderPartial('/widgets/crumbs',array('title'=>$rubric->name))?>

	<div class="rubric_news">
		<h1><?=$rubric->name?></h1>
		<?foreach($data as $k=>$v){?>
			<div class="news">
				<?if($v->image){?>
					<a href="<?=$this->getLink($v)?>"><img src="<?=$this->getImageUrl($v,'m')?>" /></a>
				<?}?>
				<a href="<?=$this->getLink($v)?>"><?=$v->name?></a>
				<p><?=nl2br($v->announce)?></p>
				<div class="clear"></div>
			</div>
		<?}?>
	</div>