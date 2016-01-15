<?$nav = Rubrics::model()->getMenu('nav');?>

<?if($nav){?>
	<div id="nav_menu">
		<div class="site-width">
			<?foreach($nav as $k=>$v){?>
				<a href="<?=$v->getLink()?>"><?=$v->name?></a>
			<?}?>
		</div>
	</div>
<?}?>