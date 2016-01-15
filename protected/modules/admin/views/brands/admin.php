<div class="title_razdel">
	<span>Бренды</span>
	<?=CHtml::link('Создать',$rubric->getLink().'add',array('class'=>'btn right'))?>
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
		),
        array(
            'class'=>'EImageColumn',
            'name' => 'logo',
			'parent_id' => 'id',
			'pathPrefix'=>'/userdata/brands/brands_',
			'pathThumb' => '/thumb_s/',
			'link'=>true,
            'htmlOptions' => array('align'=>'center'),
		),	
		array(
			'class'=>'CLinkColumn',
			'label'=>'Адреса',
			'urlExpression'=>'"/".Yii::app()->request->pathInfo."/".$data->id."/addresses/?".Yii::app()->request->queryString',
			'htmlOptions' => array('align'=>'center')
		),		
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}',

			'updateButtonLabel'	=>	'Изменить',			
			'updateButtonUrl'	=>	'"/admin/brands/update/".$data->primaryKey',
			
			'deleteButtonLabel'	=>	'Удалить',			
			'deleteButtonUrl'	=>	'"/admin/brands/delete/".$data->primaryKey',
		),
	),
))?>