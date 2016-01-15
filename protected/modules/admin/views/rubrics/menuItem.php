
<div id="<?=$model->menu?>_<?=$model->id?>" class="lvl lvl<?=$model->lvl?>">
	<div class="menu">
		<?=CHtml::link($model->name,$model->getLink(),array('class'=>'menu_link'))?>
		<?if($model->lvl < Yii::app()->controller->menuTypes[$model->menu]['lvl']){?>
			<?=CHtml::ajaxLink(
				'добавить подраздел',
				'/admin/rubrics/getAddRubricForm/',
				array(
					'type'=>'POST',
					'data'=>array('parent_id'=>$model->id, 'lvl'=>$model->lvl),
					'success'=>"function(data){
						$('body').append(data);
					}"
				),
				array(
					'id'=>'add_'.$model->id,
					'class'=>'btn_ico add none', 
					'title'=>'добавить подраздел'
				)
			)?>									
		<?}?>		
		<?=CHtml::ajaxLink(
			'Удалить раздел',
			'/admin/rubrics/delete/'.$model->id.'/',
			array(
				'type'=>'POST',
				'beforeSend'=>"function(){ return confirm ('Удалить раздел?') }",
				'success'=>"function(data){
					if(data=='success')
						$('#".$model->menu."_".$model->id."').remove();
					else
						alert(data);
				}"
			),
			array(
				'id'=>'del_'.$model->id,
				'class'=>'btn_ico del none',
				'title'=>'Удалить раздел'
			)
		)?>			
	</div>
</div>