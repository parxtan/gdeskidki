<div class="title">Вводный Текст</div>
<div class="form content_block">
	<?$form=$this->beginWidget('CActiveForm', array(
		'id'=>'crud-form',
		'method'=>'POST',
		'action'=>$rubric->getLink().($text->isNewRecord ? 'add' : 'update/'.$text->id).'/',
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
			<?=CHtml::submitButton('Сохранить', array('class'=>'btn save'))?>
			<?=CHtml::link(
				'Отменить',
				'#',
				array(
					'class'=>'btn cancel right',
					'onclick'=>'$("#rubric_text").toggle();return false;'
				)
			)?>
		</div>
	<?$this->endWidget()?>
</div>