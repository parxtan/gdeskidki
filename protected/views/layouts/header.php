<?$nav = Rubrics::model()->getMenu('nav');?>

	<div id="header" class="max-width">
		<div class="left_block">
			<form action="http://cp.unisender.com/ru/subscribe?hash=56krxt7b3i5wbfu913domwk7o8wpeqzsgfrt91jy" method="post" id="search_form" target="_blank">
				<input type="hidden" name="default_list_id" value="2764862"/>			
				<input type="text" name="email" value="" placeholder="Подписаться на e-mail рассылку" class="input" />
				<input type="image" src="/static/img/ico_search.png" value="Подписаться" class="btn" />
			</form>
		</div>
		<div class="middle_block">
			<div id="nav">
				<?foreach($nav as $k=>$v){?>
					<a href="<?=$v->getLink()?>"><?=$v->name?></a>
				<?}?>
			</div>
		</div>
		<!--div class="right_block">
			
		</div-->
		<br class="clear" />
	</div>
