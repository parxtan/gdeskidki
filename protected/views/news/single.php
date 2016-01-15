
	<?=$this->renderPartial('/widgets/crumbs',array('title'=>$data->name))?>

	<div class="single_news">
		<h1><?=$data->name?></h1>
		<div class="text"><?=$data->text?></div>
		
		<?=$this->renderPartial('/widgets/pluso_widget2')?>
	</div>