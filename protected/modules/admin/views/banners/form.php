<div class="title_razdel">
	<span><?=$title?></span>
	<?=CHtml::link('вернуться к списку','/admin/banners/',array('class'=>'btn cancel right'))?>
</div>

<?=$this->renderPartial('/banners/_form', array('model'=>$model))?>