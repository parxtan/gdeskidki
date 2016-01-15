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
				<?=$form->labelEx($model,'link')?>
			</div>
			<div class="field">
				<?=$form->textField($model,'link')?>
				<?=$form->error($model,'link')?>				
			</div>		
		</div>				
		<div class="row">
			<div class="col2">
				<div class="label">
					<?=$form->labelEx($model,'logo')?>
				</div>
				<div class="field file">
					<?=$form->fileField($model,'logo',array('name'=>'file[logo]'))?>
					<?if($model->isNewRecord==false && $model->logo){?>
						<a href="<?=$this->getImageUrl($model,'b','logo')?>" target="_blank"><?=$model->logo?></a>
						<a href="?del_image=logo">удалить</a>
					<?}?>				
				</div>
			</div>	
			<div class="col2">
				<div class="label">
					<?=$form->labelEx($model,'logo_bg')?>
				</div>
				<div class="field file">
					<?=$form->textField($model,'logo_bg')?>
					<?=$form->error($model,'logo_bg')?>
				</div>
			</div>	
			<div class="clear"></div>
		</div>
		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'categories_id')?>
			</div>
			<div class="field checkbox_list">
				<?=CHtml::checkBoxList(
					'Categories[]',
					explode(',',$model->categories_id),
					Brands::model()->getCategoriesArray(),
					array('separator'=>' ','template'=>'<span class="item">{input} {label}</span>')
				)?>
				<?=$form->error($model,'categories_id')?>
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
	</div>
	
	<div class="row">
		<div class="buttons">
			<?=CHtml::link('Отменить',Yii::app()->request->urlReferrer, array('class'=>'btn cancel right'))?>
			<?=CHtml::submitButton('Сохранить', array('class'=>'btn save'))?>
		</div>
	</div>

<?$this->endWidget()?>

</div>