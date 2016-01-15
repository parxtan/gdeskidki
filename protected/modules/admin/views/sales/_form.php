<div class="title">Создание</div>
<div class="form content_block">

<?$form=$this->beginWidget('CActiveForm', array(
	'id'=>'articles-form',
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
			<div class="col2">
				<div class="label"><?=$form->labelEx($model,'start')?></div>
				<div class="field">
				<?=$form->textField($model,'start',array(
					'readonly'=>true,
					'class'=>'cursor-text',
					'value'=>($model->isNewRecord ? date('Y-m-d') : date('Y-m-d', strtotime($model->start)))
					)
				)
				?>
				<?$this->widget('application.extensions.calendar.SCalendar',
					array(
						'inputField'=>get_class($model).'_start',
						'ifFormat'=>'%Y-%m-%d',
						'showsTime'=>true,
						'range'=>'['.(date('Y')-1).','.(date('Y')+1).']',
						'skin'=>'tiger', 
					));
				?>
				<?=$form->error($model,'start')?>
				</div>
			</div>
			<div class="col2">
				<div class="label"><?=$form->labelEx($model,'finish')?></div>
				<div class="field">
				<?=$form->textField($model,'finish',array(
					'readonly'=>true,
					'class'=>'cursor-text',
					'value'=>($model->isNewRecord ? date('Y-m-d') : date('Y-m-d', strtotime($model->finish)))
					)
				)
				?>
				<?$this->widget('application.extensions.calendar.SCalendar',
					array(
						'inputField'=>get_class($model).'_finish',
						'ifFormat'=>'%Y-%m-%d',
						'showsTime'=>true,
						'range'=>'['.(date('Y')-1).','.(date('Y')+1).']',
						'skin'=>'tiger', 
					));
				?>
				<?=$form->error($model,'finish')?>
				</div>
			</div>
			<br class="clear" />
		</div>		
			
		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'name')?>
			</div>
			<div class="field">
				<?=$form->textArea($model,'name')?>
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
			<div class="col2">
				<div class="label">
					<?=$form->labelEx($model,'image')?>
				</div>
				<div class="field file">
					<?=$form->fileField($model,'image',array('name'=>'file[image]','accept'=>'image/*'))?>
					<?if($model->isNewRecord==false && $model->image){?>
						<a href="<?=$this->getImageUrl($model,'b')?>" target="_blank"><?=$model->image?></a>
						<a href="?del_image=image">удалить</a>
					<?}?>				
				</div>
			</div>
			<div class="col2">
				<div class="label">
					<?=$form->labelEx($model,'full_image')?>
				</div>
				<div class="field file">
					<?=$form->fileField($model,'full_image',array('name'=>'file[full_image]','accept'=>'image/*'))?>
					<?if($model->isNewRecord==false && $model->full_image){?>
						<a href="<?=$this->getImageUrl($model,'b')?>" target="_blank"><?=$model->full_image?></a>
						<a href="?del_image=full_image">удалить</a>
					<?}?>				
				</div>
			</div>
			<br class="clear" />
		</div>
		
		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'brand_id')?>
			</div>
			<div class="field">
				<?=$form->dropDownList($model,'brand_id',Brands::model()->getBrandsArray())?>
				<?=$form->error($model,'brand_id')?>
			</div>
		</div>	

		<div class="row">
			<div class="col3">
				<div class="label">
					<?=$form->labelEx($model,'sale')?>
				</div>
				<div class="field">
					<?=$form->textField($model,'sale')?>
					<?=$form->error($model,'sale')?>
				</div>
			</div>
			<div class="col3">
				<div class="field checkbox">
					<?=$form->checkBox($model,'new')?>
					<?=$form->labelEx($model,'new')?>
					<?=$form->error($model,'new')?>
				</div>
			</div>
			<div class="col3">
				<div class="field checkbox">
					<?=$form->checkBox($model,'action')?>
					<?=$form->labelEx($model,'action')?>
					<?=$form->error($model,'action')?>
				</div>
			</div>			
			<br class="clear" />
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
			<?=CHtml::link('Отменить','#', array('class'=>'btn cancel right'))?>
			<?=CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('class'=>'btn save'))?>
		</div>
	</div>

<?$this->endWidget()?>

</div>