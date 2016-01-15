
	<div class="content-width inner-page pressa-page">
		<div class="col4">	
			<h2 class="title"><?=$rubric->name?></h2>
			<div class="breadcrumbs">
				<a href="/">Главная</a> > 
				<?foreach($breadcrumbs as $k=>$v){?>
					<a href="<?=$v->getLink()?>"><?=$v->name?></a> > 
				<?}?>
				<span><?=$data->name?></span>
			</div>
			<hr />
					
			<div class="single">
				<h1 class="h1"><?=$data->name?></h1>
				<div class="text"><?=$data->text?></div>
				<br class="clear" />
			</div>
			
			<?=$this->renderPartial('/widgets/pages',array('pages'=>$pages, 'page'=>$page))?>
		</div>
		<div class="col col3">
			<?=$this->renderPartial('/widgets/banners_right')?>
			
			<?=$this->renderPartial('/widgets/fb_likebox')?>
		</div>
		
		<br class="clear" />
	</div>