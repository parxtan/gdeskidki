<?$childs = $rubric->getChilds(true);?>

<div class="submenu">
	<div class="lines"></div>
	<?if($childs){?>
		<ul class="none cl threecolumns">
			<?foreach($childs as $k=>$v){?>
				<li class="column">
					<a href="<?=$v->getLink()?>" class="<?if(Yii::app()->params['breadcrumbs'][1]->id==$v->id){?>active pie<?}?>"><?=$v->name?></a>
				</li>
			<?}?>
		</ul>
		<div class="lines"></div>
	<?}?>	
</div>