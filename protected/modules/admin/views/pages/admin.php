<div class="title_razdel">
	<span>Виртуальные страницы</span>
	<?=CHtml::link('Создать',rtrim(Yii::app()->request->url,'/').'/add',array('class'=>'btn right'))?>
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
			'name'=>'id',
		),		
		array(
			'name'=>'name',
			'type'=>'html'
		),
		array(
			'name'	=>	'status',
			'filter'=>	$this->defaultStatus,
			'value'	=> 'Yii::app()->controller->defaultStatus[$data->status]',
		),

		array(
			'class'=>'CButtonColumn',
			
			'viewButtonLabel'	=>	'Просмотр',			
			'viewButtonUrl'		=>	'"/admin/pages/view/".$data->primaryKey',
			
			'updateButtonLabel'	=>	'Изменить',			
			'updateButtonUrl'	=>	'"/admin/pages/update/".$data->primaryKey',
			
			'deleteButtonLabel'	=>	'Удалить',			
			'deleteButtonUrl'	=>	'"/admin/pages/delete/".$data->primaryKey',
		),
	),
))?>
<?=$search?>