
	<div class="item shadow">
		<div class="brand" style="background:<?=$item->brand->logo_bg?>">
			<a href="<?=$this->getLink($item)?>" title="<?=$item->brand->name?>">
				<span>
					<img src="<?=$this->getImageUrl($item->brand,'m','logo')?>" alt="<?=$item->brand->name?>" />
				</span>
			</a>
		</div>
		<a href="<?=$this->getLink($item)?>" title="<?=$item->name?>"><?=$item->name?></a>
		<?if($item->announce){?>
			<p><?=nl2br($item->announce)?></p>			
		<?}?>
		<div class="labels">
			<?if($item->new){?>
				<span class="label new">новинка</span>	
			<?}?>
			<?if($item->sale>0){?>
				<span class="label sale">- <?=$item->sale?>%</span>
			<?}?>
			<?if($item->action){?>
				<span class="label action">акция</span>					
			<?}?>
			<?if((strtotime($item->start) < strtotime($item->finish)) && !$item->new){?>
				<div class="period">
					осталось <?=$item->getRemainDays()?> дн.
				</div>
			<?}?>
		</div>
	</div>	