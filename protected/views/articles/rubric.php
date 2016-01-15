
	<div class="content-width inner-page">
		<div class="col4">	
			<h2 class="title"><?=$rubric->name?></h2>
			<div class="breadcrumbs">
				<a href="/">Главная</a> > 
				<?foreach($this->breadcrumbs as $k=>$v){?>
					<a href="<?=$v->getLink()?>"><?=$v->name?></a> > 
				<?}?>
				<span><?=$rubric->name?></span>
			</div>
			<hr />
					
			<?if($data){?>
				<?foreach($data as $k=>$v){?>
					<?if($k==0){?>
						<div class="articles first">
							<div class="name"><a href="<?=$v->getLink()?>" class="h1"><?=$v->name?></a></div>
							<img src="<?=$v->getImageUrl('b')?>" alt="<?=$v->name?>" />
							<p><?=$v->announce?></p>
							<a href="<?=$v->getLink()?>">Подробное описание</a>							
						</div>
					<?}else{?>
						<div class="articles">
							<div class="name"><a href="<?=$v->getLink()?>" class="h3"><?=$v->name?></a></div>
							<img src="<?=$v->getImageUrl('m')?>" alt="<?=$v->name?>" />
							<p><?=$v->announce?></p>
							<a href="<?=$v->getLink()?>">подробнее</a>
						</div>
					<?}?>
				<?}?>
				<br class="clear" />
			<?}?>			
			
			<?=$this->renderPartial('/widgets/pages',array('pages'=>$pages, 'page'=>$page))?>
		</div>
		<div class="col col3">
			<?=$this->renderPartial('/widgets/banners_right')?>
			
			<?=$this->renderPartial('/widgets/fb_likebox')?>
		</div>
		
		<br class="clear" />
	</div>