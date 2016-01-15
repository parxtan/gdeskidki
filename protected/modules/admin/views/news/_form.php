<div class="title">Создание</div>
<div class="form content_block">

<?$form=$this->beginWidget('CActiveForm', array(
	'id'=>'news-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true
	),
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
))?>

	<div class="padding10">
		<?=$form->hiddenField($model,'rubric_id',array('value'=>$rubric->id))?>

		<div class="row">
			<div class="label"><?=$form->labelEx($model,'date')?></div>
			<div class="field">
				<?=$form->textField($model,'date',array(
					'readonly'=>true,
					'class'=>'cursor-text',
					'value'=>($model->isNewRecord ? date('Y-m-d H:i') : date('Y-m-d H:i', strtotime($model->date)))
					)
				)
				?>
				<?$this->widget('application.extensions.calendar.SCalendar',
					array(
						'inputField'=>get_class($model).'_date',
						'ifFormat'=>'%Y-%m-%d %H:%M',
						'showsTime'=>true,
						'range'=>'['.(date('Y')-1).','.(date('Y')+1).']',
						'skin'=>'tiger', 
					));
				?>
				<?=$form->error($model,'date')?>
			</div>
		</div>
			
		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'name')?>
			</div>
			<div class="field">
				<?=$form->textField($model,'name')?>
				<?=$form->error($model,'name')?>
			</div>
		</div>
		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'announce')?>
			</div>
			<div class="field">
				<?=$form->textArea($model,'announce')?>
				<?=$form->error($model,'announce')?>
			</div>
		</div>		
		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'text')?>
			</div>
			<div class="field">
				<?$this->widget('application.extensions.tinymce.ETinyMce', array(
					'name'=>get_class($model).'[text]',
					'value'=>$model->getAttribute('text'),
					'height'=>'300px'
				))?>
				<?=$form->error($model,'text')?>
			</div>
		</div>
		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'image')?>
			</div>
			<div class="field file">
				<?=$form->fileField($model,'image',array('name'=>'file[image]'))?>
				<?if($model->isNewRecord==false && $model->image){?>
					<a href="<?=$model->getImageUrl('b')?>" target="_blank"><?=$model->image?></a>
					<a href="?del_image=image">удалить</a>
				<?}?>				
			</div>		
		</div>					
		
		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'status')?>
			</div>
			<div class="field">
				<?=$form->dropDownList($model,'status',$this->defaultStatus)?>
				<?=$form->error($model,'status')?>
			</div>
		</div>
	</div>
	
	<?=$this->renderPartial('/rubrics/_meta',array('form'=>$form,'model'=>$model))?>
	
	<div class="row">
		<div class="buttons">
			<?=CHtml::link('Отменить','#', array('class'=>'btn cancel right'))?>
			<?=CHtml::submitButton('Сохранить', array('class'=>'btn save'))?>
		</div>
	</div>

<?$this->endWidget()?>

</div>