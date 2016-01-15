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
				<?=$form->labelEx($model,'lastname')?>
			</div>
			<div class="field">
				<?=$form->textField($model,'lastname')?>
				<?=$form->error($model,'lastname')?>
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
				<?=$form->labelEx($model,'password')?>
			</div>
			<div class="field">
				<?=$form->textField($model,'password',array('value'=>''))?>
				<?=$form->error($model,'password')?>
			</div>
		</div>			
	
		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'status')?>
			</div>
			<div class="field">
				<?=$form->dropDownList($model,'status',$this->userStatus)?>
				<?=$form->error($model,'status')?>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="buttons">
			<?=CHtml::link('Отменить','/admin/users/', array('class'=>'btn cancel right'))?>
			<?=CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('class'=>'btn save'))?>
		</div>
	</div>

<?$this->endWidget()?>

</div>