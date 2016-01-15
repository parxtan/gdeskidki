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
	<?=CHtml::link('Создать','add/?'.Yii::app()->request->queryString,array('class'=>'btn right'))?>
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
		'name',
		'address',
        array(
            'class'=>'EImageColumn',
            'name' => 'logo',
			'parent_id' => 'id',
			'pathPrefix'=>'/userdata/malls/malls_',
			'pathThumb' => '/thumb_s/',
			'link'=>true,
            'htmlOptions' => array('align'=>'center'),
		),
		array(
			'name'=>'city_id',
			'value'=>'Yii::app()->controller->cities[$data->city_id]',
			'filter'=>$this->cities
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}',

			'updateButtonLabel'	=>	'Изменить',			
			'updateButtonUrl'	=>	'$data->rubric->getLink()."update/".$data->primaryKey."/?".Yii::app()->request->queryString',
			
			'deleteButtonLabel'	=>	'Удалить',			
			'deleteButtonUrl'	=>	'$data->rubric->getLink()."delete/".$data->primaryKey."/?".Yii::app()->request->queryString',
		),
	),
))?>