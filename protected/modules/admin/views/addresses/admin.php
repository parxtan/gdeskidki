<div class="title_razdel">	
	<?=CHtml::link('Назад','/admin/brands/',array('class'=>'btn right cancel'))?>	
	<?=CHtml::link('Создать','/'.Yii::app()->request->pathInfo.'/add',array('class'=>'btn right'))?>	
	<span>Адреса <?=$brand->name?></span>
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
		'address',	
		'phone',	
        array(
            'class'=>'EImageColumn',
            'name' => 'showcase',
			'parent_id' => 'id',
			'pathPrefix'=>'/userdata/addresses/addresses_',
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
			'updateButtonUrl'	=>	'"/".Yii::app()->request->pathInfo."/update/".$data->primaryKey."/?".Yii::app()->request->queryString',
			
			'deleteButtonLabel'	=>	'Удалить',			
			'deleteButtonUrl'	=>	'"/".Yii::app()->request->pathInfo."/delete/".$data->primaryKey."/?".Yii::app()->request->queryString',
		),
	),
))?>