<div id="auth_form">
	<h1 class="title">Авторизация</h1>
	
	<div class="form block_content">
	<?$form=$this->beginWidget('CActiveForm', array(
		'id'=>'login-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	))
	?>

	<div class="row">
		<div class="label">
			<?=$form->labelEx($model,'username')?>
		</div>
		<div class="field">
			<?=$form->textField($model,'username')?>
			<?=$form->error($model,'username')?>
		</div>
	</div>

	<div class="row">
		<div class="label">
			<?=$form->labelEx($model,'password')?>
		</div>
		<div class="field">
			<?=$form->passwordField($model,'password')?>
			<?=$form->error($model,'password')?>
		</div>
	</div>

	<div class="row rememberMe">
		<div class="label">
		</div>
		<div class="field checkbox">
			<?=$form->checkBox($model,'rememberMe')?>		
			<?=$form->label($model,'rememberMe')?>
			<?=$form->error($model,'rememberMe')?>
		</div>
	</div>

	<div class="row buttons">
		<?=CHtml::submitButton('Войти',array('class'=>'btn radius'))?>
	</div>

	<?$this->endWidget()?>
	</div><!-- form -->
</div>
