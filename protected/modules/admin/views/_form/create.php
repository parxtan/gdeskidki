<div class="title_razdel">
	<span><?=$title?></span>
	<?=CHtml::link('вернуться к списку',$rubric->getLink(),array('class'=>'btn cancel right'))?>
</div>

<?=$this->renderPartial(
	'/'.strtolower(get_class($model)).'/_form', 
	array('model'=>$model, 'rubric'=>$rubric)
)?>