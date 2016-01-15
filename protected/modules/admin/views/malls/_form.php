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
				<?=$form->labelEx($model,'website')?>
			</div>
			<div class="field">
				<?=$form->textField($model,'website')?>
				<?=$form->error($model,'website')?>				
			</div>		
		</div>	
		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'city_id')?>
			</div>
			<div class="field">
				<?=$form->dropDownList($model,'city_id',$this->cities)?>
				<?=$form->error($model,'city_id')?>
			</div>
		</div>
		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'address')?>
			</div>
			<div class="field">
				<?=$form->textArea($model,'address')?>
				<?=$form->error($model,'address')?>
			</div>
		</div>		
		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'coords')?>
			</div>
			<div class="field">
				<?=$form->textField($model,'coords')?>
				<?=$form->error($model,'coords')?>
			</div>
		</div>		
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
				<?=$form->labelEx($model,'logo')?>
			</div>
			<div class="field file">
				<?=$form->fileField($model,'logo',array('name'=>'file[logo]','accept'=>'image/*'))?>
				<?if($model->isNewRecord==false && $model->logo){?>
					<a href="<?=$this->getImageUrl($model,'b','logo')?>" target="_blank"><?=$model->logo?></a>
					<a href="?del_image=logo">удалить</a>
				<?}?>				
			</div>		
		</div>
		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'showcase')?>
			</div>
			<div class="field file">
				<?=$form->fileField($model,'showcase',array('name'=>'file[showcase]','accept'=>'image/*'))?>
				<?if($model->isNewRecord==false && $model->showcase){?>
					<a href="<?=$this->getImageUrl($model,'b','showcase')?>" target="_blank"><?=$model->showcase?></a>
					<a href="?del_image=showcase">удалить</a>
				<?}?>				
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
				<?=$form->labelEx($model,'status')?>
			</div>
			<div class="field">
				<?=$form->dropDownList($model,'status',$this->defaultStatus)?>
				<?=$form->error($model,'status')?>
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