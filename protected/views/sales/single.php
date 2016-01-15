
<?=$this->renderPartial('/widgets/crumbs',array('title'=>$data->brand->name))?>

<div class="single_sale">
	<div class="fright">
		<div class="brand_info">
			<div class="brand_logo" style="background:<?=$data->brand->logo_bg?>">
				<a href="<?=$this->getLink($data->brand)?>">
					<img src="<?=$this->getImageUrl($data->brand,'s','logo')?>" />
				</a>
			</div>
			<div class="brand_addresses">
				<b>Адреса:</b>
				<ul>
					<?foreach($data->brand->addresses as $k=>$v){?>
						<li><?=($v->mall_id ? $v->mall->name : $v->address)?></li>
					<?}?>
				</ul>
				<a href="<?=$this->getLink($data->brand)?>#map">Посмотреть на карте</a>
			</div>		
		</div>
		<?=$this->renderPartial('/widgets/pluso_widget2')?>		
		<br />
		<?=$this->renderPartial('/widgets/social_box')?>
	</div>
	<h1><?=$data->name?></h1>
	<?if(strtotime($data->finish)<strtotime(date('Y-m-d'))){?>
		<div class="text"><p class="alert">Акция завершена!</p></div>
	<?}?>
	<div class="text"><?=$data->text?></div>
	
	<?=$this->renderPartial('/widgets/cackle')?>
</div>
	