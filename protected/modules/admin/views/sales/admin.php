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
	<?=CHtml::link('Создать',$rubric->getLink().'add',array('class'=>'btn right'))?>
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
			'name'=>'finish',
			'type'=>'html',
			'header'=>'Сроки',
			'value'=>'$data->start."<br /><br />".$data->finish'
		),
		'name',	
		'announce',
		array(
			'name'=>'brand_id',
			'type'=>'html',
			'value'=>'"<img src=\'/userdata/brands/brands_".$data->brand->id."/thumb_s/".$data->brand->logo."\' />"',
			'htmlOptions'=>array('align'=>'center'),
			'filter'=>Brands::model()->getBrandsArray(),
		),
        array(
            'class'=>'EImageColumn',
            'name' => 'image',
			'parent_id' => 'id',
			'pathPrefix'=>'/userdata/sales/sales_',
			'pathThumb' => '/thumb_s/',
			'link'=>true,
            'htmlOptions' => array('align'=>'center','width'=>100),
		),		
		array(
			'name'=>'status',
			'filter'=>$this->defaultStatus,
			'value'=>'Yii::app()->controller->getRuStatus($data->status)'
		),

		array(
			'class'=>'CButtonColumn',

			'updateButtonLabel'	=>	'Изменить',			
			'updateButtonUrl'	=>	'"update/".$data->primaryKey."/?".Yii::app()->request->queryString',
			
			'deleteButtonLabel'	=>	'Удалить',			
			'deleteButtonUrl'	=>	'"delete/".$data->primaryKey."/?".Yii::app()->request->queryString',
		),
	),
))?>