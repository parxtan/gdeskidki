<div class="title_razdel">
	<span><?=$title?></span>
	<?=CHtml::link('Назад',Yii::app()->request->urlReferrer,array('class'=>'btn cancel right'))?>
</div>

<?=$this->renderPartial('/'.strtolower(get_class($model)).'/_form', array('model'=>$model, 'title'=>'Редактирование', 'rubric'=>$rubric))?>