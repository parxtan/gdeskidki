	
	<?if($title){?>
		<h2><?=$title?> <span>(всего: <?=count($data)?>)</span></h2>
	<?}else{?>		
		<?=$this->renderPartial('/widgets/crumbs')?>
		<h1><?=$rubric->name?> <span>(всего: <?=count($data)?>)</span></h1>
	<?}?>
	
	<script type="text/javascript">
		<?$masonry_id = time();?>
		$(function(){
			var container<?=$masonry_id?> = document.querySelector('#id<?=$masonry_id?>');
			var msnry<?=$masonry_id?> = new Masonry( container<?=$masonry_id?>, {
				itemSelector: '.item',
			});					
		})
	</script>	
	
	<div class="sales" id="id<?=$masonry_id?>">
		<?foreach($data as $k=>$v){?>
			<?=$this->renderPartial('/sales/_item',array('item'=>$v))?>
		<?}?>
		<br class="clear" />
	</div>
	<br />