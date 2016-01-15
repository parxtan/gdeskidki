<div class="popup">
	<div class="popup_bg"></div>
	<div class="popup_content">
		<?$form=$this->beginWidget('CActiveForm', array(
			'id'=>'add-rubric-form',
			'action'=>'/admin/rubrics/create/',
			//'enableAjaxValidation'=>true,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
				'afterValidate'=>"js: function(form, data, hasError) {
					if(!hasError){
						$(form).find('.load').show();
						$.ajax({
							type: 'POST',
							url: form[0].action,
							data: $(form).serialize(),
							success: function(data)
							{
								$('#".$model->menu."_".$model->parent_id."').append(data);
								$(form).find('.load').hide();
								$(form).parents('.popup').remove();
							}
						});
					}
					return false;
				}"
			),
			'htmlOptions'=>array('class'=>'form'),
		))
		?>
		<div class="title">Добавить раздел</div>
		<div class="block_content">
			<?=CHtml::hiddenField('lvl',$lvl)?>
			<?=$form->hiddenField($model,'parent_id',array('value'=>$model->parent_id))?>
			<div class="row">
				<div class="label">
					<?=$form->labelEx($model,'name')?>
				</div>
				<div class="field">
					<?=$form->textField($model,'name')?>
					<?=$form->error($model,'name')?>
				</div>
			</div>
			
			<?if(count($this->menuTypesSelect)>1){?>
				<div class="row">
					<div class="label">
						<?=$form->labelEx($model,'menu')?>
					</div>
					<div class="field">
						<?=$form->dropDownList($model,'menu',$this->menuTypesSelect)?>
						<?=$form->error($model,'menu')?>
					</div>
				</div>
			<?}else{?>
				<?=$form->hiddenField($model,'menu',array('value'=>$this->menuTypesSelect[0]))?>
			<?}?>

			<?if(count($this->contentTypes)>0){?>
				<div class="row">
					<div class="label">
						<?=$form->labelEx($model,'ctype')?>
					</div>
					<div class="field">
						<?=$form->dropDownList($model,'ctype',$this->contentTypes)?>
						<?=$form->error($model,'ctype')?>
					</div>
				</div>
			<?}else{?>
				<?=$form->hiddenFied($model,'ctype',array('value'=>$this->contentTypes[0]))?>
			<?}?>
				
			<div class="row">
				<div class="label">
					<img src="/static/img/admin/load.gif" class="load none" />
				</div>
				<div class="buttons">
					<?=CHtml::submitButton('Сохранить',array('type' => 'submit', 'class'=>'btn'))?>
				
					<?=CHtml::link('Отменить','#',array('class'=>'btn cancel right','onclick'=>"$(this).parents('.popup').remove();return false;"))?>
				</div>
			</div>
		</div>

		<?$this->endWidget()?>	
	</div>
</div>