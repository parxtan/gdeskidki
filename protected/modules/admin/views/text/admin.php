<div class="title_razdel">
	<span><?=$rubric->name?></span>
	<?=CHtml::link('Свойства','#',array(
			'class'=>'btn right cancel',
			'onclick'=>'$("#rubric_propeties").toggle();return false;'
		)
	)?>		
</div>

<div id="rubric_propeties" class="none">
	<?=$this->renderPartial('/rubrics/_propeties',array('rubric'=>$rubric))?>
</div>

<div class="title">Текст</div>
<div class="form content_block">
	<?$form=$this->beginWidget('CActiveForm', array(
		'id'=>'crud-form',
		'action'=>Yii::app()->request->requestUri.($text->isNewRecord ? 'add/' : 'update/'.$text->id.'/'),
		'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	))
	?>
		<?=$form->hiddenField($text,'rubric_id',array('value'=>$rubric->id))?>
		<div class="padding10">
			<?$this->widget('application.extensions.tinymce.ETinyMce', array(
				'name'=>get_class($text).'[text]',
				'value'=>$text->getAttribute('text')
			))?>
		</div>
		<div class="row buttons">
			<?=CHtml::submitButton($text->isNewRecord ? 'Создать' : 'Сохранить', array('class'=>'btn save'))?>
			<?=CHtml::link('Отменить',Yii::app()->request->urlReferrer,array('class'=>'btn cancel right'))?>
		</div>
	<?$this->endWidget()?>
</div>