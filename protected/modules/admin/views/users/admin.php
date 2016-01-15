<div class="title_razdel">
	<span>Пользователи</span>
	<?=CHtml::link('Создать','/admin/users/add',array('class'=>'btn right'))?>
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
		'maxButtonCount'=>10
	),
	'summaryText'=>'Показано {start} - {end} позиций. Всего найдено <b>{count}</b> записей',
	'filter'=>$model,
	'columns'=>array(	
		'id',
		array(
			'name'=>'name',	
			'value'=>'$data->name." ".$data->lastname',
		),
		'email',	
		array(
			'name'=>'status',
			'filter'=>$this->userStatus,
			'value'=>'Yii::app()->controller->userStatus[$data->status]'
		),

		array(
			'class'=>'CButtonColumn',

			'updateButtonLabel'	=>	'Изменить',			
			'updateButtonUrl'	=>	'"/admin/users/update/".$data->primaryKey."/?".Yii::app()->request->queryString',
			
			'deleteButtonLabel'	=>	'Удалить',			
			'deleteButtonUrl'	=>	'"/admin/users/delete/".$data->primaryKey."/?".Yii::app()->request->queryString',
		),
	),
))?>