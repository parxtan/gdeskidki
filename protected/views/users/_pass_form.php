
		<?$pass = new User('pass');?>
		<?$form=$this->beginWidget('CActiveForm', array(
				'id'=>'remind-pass',
				'action'=>'/remind/',
				'htmlOptions'=>array('class'=>'form none'),
				'enableAjaxValidation'=>true,
				'enableClientValidation'=>false,
				'clientOptions'=>array(
					'validateOnSubmit'=>true
				),
			))
		?>

			<fieldset>
				<div class="row">
					<label>введите ваш e-mail</label>
					<div class="field text-holder">
						<?=$form->textField($pass,'email',array('class'=>'text'))?>
						<?=$form->error($pass,'email')?>
					</div>
				</div>
				<div class="row">
					<input type="submit" value="отправить" class="send" />
				</div>
			</fieldset>
		
		<?$this->endWidget()?>