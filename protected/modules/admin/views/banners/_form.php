<div class="title">Создание</div>
<div class="form content_block">

<?$form=$this->beginWidget('CActiveForm', array(
	'id'=>'banners-form',
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
				<?=$form->labelEx($model,'link')?>
			</div>
			<div class="field">
				<?=$form->textField($model,'link')?>
				<?=$form->error($model,'link')?>
			</div>
		</div>		

		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'image')?>
			</div>
			<div class="field file">
				<?=$form->fileField($model,'image',array('name'=>'file[image]','accept'=>'image/*'))?>
				<?if($model->isNewRecord==false && $model->image){?>
					<a href="<?=$model->getImageUrl('b')?>" target="_blank"><?=$model->image?></a>
					<a href="?del_image=image">удалить</a>
				<?}?>				
			</div>		
		</div>	
		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'pos')?>
			</div>
			<div class="field">
				<?=$form->textField($model,'pos')?>
				<?=$form->error($model,'pos')?>
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
		<br class="clear" />
	</div>
	
	<div class="row">
		<div class="buttons">
			<?=CHtml::link('Отменить',Yii::app()->request->urlReferrer, array('class'=>'btn cancel right'))?>
			<?=CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('class'=>'btn save'))?>
		</div>
	</div>

<?$this->endWidget()?>

</div>