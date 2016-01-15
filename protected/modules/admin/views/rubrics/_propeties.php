<div class="title">Параметры раздела</div>
<div class="form content_block">

<?$form=$this->beginWidget('CActiveForm', array(
	'id'=>'rubric-form',
	'action'=>$rubric->getLink().'propeties/'.$rubric->id.'/',
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
				<?=$form->labelEx($rubric,'name')?>
			</div>
			<div class="field">
				<?=$form->textField($rubric,'name')?>
				<?=$form->error($rubric,'name')?>
			</div>
		</div>
		<div class="row">
			<div class="label">
				<?=$form->labelEx($rubric,'chpu')?>
			</div>
			<div class="field">
				<?=$form->textField($rubric,'chpu')?>
				<?=$form->error($rubric,'chpu')?>
			</div>
		</div>	
		<div class="row">
			<div class="label">
				<?=$form->labelEx($rubric,'link')?>
			</div>
			<div class="field">
				<?=$form->textField($rubric,'link')?>
				<?=$form->error($rubric,'link')?>
			</div>
		</div>	
		<div class="row">
			<div class="label">
				<?=$form->labelEx($rubric,'main')?>
			</div>
			<div class="field checkbox">
				<?=$form->checkBox($rubric,'main')?>
				<?=$form->error($rubric,'main')?>
			</div>
		</div>			
		<div class="row">
			<div class="label">
				<?=$form->labelEx($rubric,'icon')?>
			</div>
			<div class="field file">
				<?=$form->fileField($rubric,'icon',array('name'=>'file[icon]'))?>
				<?if($rubric->isNewRecord==false && $rubric->icon){?>
					<a href="<?=$rubric->getImageUrl('b')?>" target="_blank"><?=$rubric->icon?></a>
					<a href="?del_image=icon">удалить</a>
				<?}?>				
			</div>		
		</div>
		<div class="row">
			<div class="label">
				<?=$form->labelEx($rubric,'ctype')?>
			</div>
			<div class="field">
				<?=$form->dropDownList($rubric,'ctype',$this->contentTypes)?>
				<?=$form->error($rubric,'ctype')?>
			</div>
		</div>						
		
		<div class="row">
			<div class="label">
				<?=$form->labelEx($rubric,'status')?>
			</div>
			<div class="field">
				<?=$form->dropDownList($rubric,'status',$this->defaultStatus)?>
				<?=$form->error($rubric,'status')?>
			</div>
		</div>
	</div>
	
	<?=$this->renderPartial('/rubrics/_meta',array('form'=>$form,'model'=>$rubric))?>
	
	<div class="row">
		<div class="buttons">
			<?=CHtml::link('Отменить','#', array('class'=>'btn cancel right'))?>
			<?=CHtml::submitButton('Сохранить', array('class'=>'btn save'))?>
		</div>
	</div>

<?$this->endWidget()?>

</div>