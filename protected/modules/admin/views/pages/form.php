<div class="title_razdel">
	<span><?=$title?></span>
	<?=CHtml::link('вернуться к списку','/admin/pages/',array('class'=>'btn cancel right'))?>
</div>

<?=$this->renderPartial('_form', array('model'=>$model))?>