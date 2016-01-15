<div class="title_razdel">
	<span>Баннеры</span>
	<?=CHtml::link('Создать','/admin/banners/add',array('class'=>'btn right'))?>
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
		array(
			'type'=>'html',
			'value'=>'"<img src=\"/static/img/admin/ico_vote_poll.png\">"',
			'htmlOptions'=>array('class'=>'cursor-move')
		),	
		'id',
		'name',	
		'link',	
        array(
            'class'=>'EImageColumn',
            'name' => 'image',
			'parent_id' => 'id',
			'pathPrefix'=>'/userdata/banners/banners_',
			'pathThumb' => '/thumb_s/',
			'link'=>true,
			'htmlOptions'=>array('align'=>'center')			
		),
		array(
			'name'=>'status',
			'filter'=>$this->defaultStatus,
			'value'=>'Yii::app()->controller->getRuStatus($data->status)'
		),

		array(
			'class'=>'CButtonColumn',

			'updateButtonLabel'	=>	'Изменить',			
			'updateButtonUrl'	=>	'"/admin/banners/update/".$data->primaryKey."/?".Yii::app()->request->queryString',
			
			'deleteButtonLabel'	=>	'Удалить',			
			'deleteButtonUrl'	=>	'"/admin/banners/delete/".$data->primaryKey."/?".Yii::app()->request->queryString',
		),
	),
))?>