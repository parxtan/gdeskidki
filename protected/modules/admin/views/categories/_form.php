<div class="title">Создание/Редактирование</div>
<div class="form content_block">

<?$form=$this->beginWidget('CActiveForm', array(
	'id'=>'form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true
	),
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
))?>	

	<?=$form->hiddenField($model,'rubric_id',array('value'=>$rubric->id))?>
	
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
				<?=$form->labelEx($model,'icon')?>
			</div>
			<div class="field file">
				<?=$form->fileField($model,'icon',array('name'=>'file[icon]'))?>
				<?if($model->isNewRecord==false && $model->icon){?>
					<a href="<?=$this->getImageUrl($model,'b','icon')?>" target="_blank"><?=$model->icon?></a>
					<a href="?del_image=icon">удалить</a>
				<?}?>				
			</div>		
		</div>
	</div>
	
	<div class="row">
		<div class="buttons">
			<?=CHtml::link('Отменить',Yii::app()->request->urlReferrer, array('class'=>'btn cancel right'))?>
			<?=CHtml::submitButton('Сохранить', array('class'=>'btn save'))?>
		</div>
	</div>

<?$this->endWidget()?>

</div>