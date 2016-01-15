<div class="title">Настройки</div>
<div class="form content_block">

<?$form=$this->beginWidget('CActiveForm', array(
	'id'=>'catalog-form',
	//'action'=>'/admin/config/update',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true
	),
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
))?>

	<div class="padding10">
		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'work')?>
			</div>
			<div class="field">
				<?=$form->textField($model,'work')?>
				<?=$form->error($model,'work')?>
			</div>
		</div>
		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'phone')?>
			</div>
			<div class="field">
				<?=$form->textField($model,'phone')?>
				<?=$form->error($model,'phone')?>
			</div>
		</div>
		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'fax')?>
			</div>
			<div class="field">
				<?=$form->textField($model,'fax')?>
				<?=$form->error($model,'fax')?>
			</div>
		</div>		
		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'email')?>
			</div>
			<div class="field">
				<?=$form->textField($model,'email')?>
				<?=$form->error($model,'email')?>
			</div>
		</div>
		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'skype')?>
			</div>
			<div class="field">
				<?=$form->textField($model,'skype')?>
				<?=$form->error($model,'skype')?>
			</div>
		</div>
		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'address')?>
			</div>
			<div class="field">
				<?=$form->textField($model,'address')?>
				<?=$form->error($model,'address')?>
			</div>
		</div>		
		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'text')?>
			</div>
			<div class="field">
				<?=$form->textArea($model,'text')?>
				<?=$form->error($model,'text')?>
			</div>
		</div>

		<br class="clear" />
	</div>
	
	<div class="row">
		<div class="buttons">
			<?=CHtml::submitButton('Сохранить', array('class'=>'btn save'))?>
		</div>
	</div>

<?$this->endWidget()?>

</div>