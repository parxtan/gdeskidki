<div class="title_razdel">
	<span><?=$rubric->name?></span>
	<?=CHtml::link('Создать','add',array('class'=>'btn right'))?>
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
        array(
            'class'=>'EImageColumn',
            'name' => 'icon',
			'parent_id' => 'id',
			'pathPrefix'=>'/userdata/categories/categories_',
			'pathThumb' => '/thumb_s/',
			'link'=>true,
            'htmlOptions' => array('align'=>'center'),
		),	
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}',

			'updateButtonLabel'	=>	'Изменить',			
			'updateButtonUrl'	=>	'"update/".$data->primaryKey',
			
			'deleteButtonLabel'	=>	'Удалить',			
			'deleteButtonUrl'	=>	'"delete/".$data->primaryKey',
		),
	),
))?>