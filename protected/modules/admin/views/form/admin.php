<div class="title_razdel">
	<span><?=$rubric->name?></span>
	<?=CHtml::link('Свойства','#',array(
			'class'=>'btn right cancel',
			'onclick'=>'$("#rubric_propeties").toggle();return false;'
		)
	)?>		
	<?=CHtml::link(
		'Вводный текст',
		'#',
		array(
			'class'=>'btn right cancel',
			'onclick'=>'$("#rubric_text").toggle();return false;'
		)
	)?>
</div>

<div id="rubric_text" class="none">
	<?=$this->renderPartial('/text/_form',array('rubric'=>$rubric,'text'=>$text))?>
</div>

<div id="rubric_propeties" class="none">
	<?=$this->renderPartial('/rubrics/_propeties',array('rubric'=>$rubric))?>
</div>

<?$this->widget('zii.widgets.grid.CGridView', array(
	'template'=>'{summary} {pager} {items} {pager}',
	'id'=>'data-grid',
	'dataProvider'=>$model->search(),
	'pager'=>array(
		'class'=>'CLinkPager',
		'firstPageLabel'=>'Первая',
		'prevPageLabel'=>'Предыдущая',
		'nextPageLabel'=>'Следующая',
		'lastPageLabel'=>'В конец',
		'header' => '<b>Страницы: </b>',
	),
	'summaryText'=>'Показано {start} - {end} позиций. Всего найдено <b>{count}</b> записей',
	'filter'=>$model,
	'columns'=>array(	
		'id',
		array(
			'name'=>'date',
			'value'=>'date("d.m.Y",$data->date)'
		),	
		array(
			'name'=>'name',
			'value'=>'$data->name." ".$data->lastname'
		),	
		'email',	
		array(
			'name'=>'text',
		),		

		array(
			'class'=>'CButtonColumn',

			'updateButtonLabel'	=>	'Изменить',			
			'updateButtonUrl'	=>	'$data->rubric->getLink()."update/".$data->primaryKey."/?".Yii::app()->request->queryString',
			
			'deleteButtonLabel'	=>	'Удалить',			
			'deleteButtonUrl'	=>	'$data->rubric->getLink()."delete/".$data->primaryKey."/?".Yii::app()->request->queryString',
		),
	),
))?>