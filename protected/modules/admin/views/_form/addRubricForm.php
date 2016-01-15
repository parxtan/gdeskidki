<?$model = new Rubrics;?>
<?$form=$this->beginWidget('CActiveForm', array(
	'id'=>'add-rubric-form',
	'htmlOptions'=>array('class'=>'form'),
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true
	)
))
?>
	<div class="title">Добавить раздел</div>
	<div class="block_content">
		<dl>
			<dt><?=$form->labelEx($model,'name')?></dt>
			<dd>
				<?=$form->textField($model,'name')?>
				<?=$form->error($model,'name')?>
			</dd>
			
			<?if(count($this->menuTypesSelect)>1){?>
				<dt><?=$form->labelEx($model,'menu')?></dt>
				<dd>
					<?=$form->dropDownList($model,'menu',$this->menuTypesSelect)?>
					<?=$form->error($model,'menu')?>
				</dd>	
			<?}else{?>
				<?=$form->hiddenField($model,'menu',array('value'=>$this->menuTypesSelect[0]))?>
			<?}?>

			<?if(count($this->contentTypes)>0){?>
				<dt><?=$form->labelEx($model,'ctype')?></dt>
				<dd>
					<?=$form->dropDownList($model,'ctype',$this->contentTypes)?>
					<?=$form->error($model,'ctype')?>
				</dd>	
			<?}else{?>
				<?=$form->hiddenFied($model,'ctype',array('value'=>$this->contentTypes[0]))?>
			<?}?>
		</dl>		

		<div class="row buttons">
			<?=CHtml::submitButton(
				'Сохранить',
				array(
					'type' => 'submit', 
					'class'=>'btn save'
				)
			);?>
				
			<?=CHtml::link('Отменить',Yii::app()->request->urlReferrer,array('class'=>'btn cancel right'))?>
		</div>
	</div>

<?$this->endWidget()?>