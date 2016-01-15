
	<div class="login-block">
		<h2 id="login-form">Вход</h2>
		<br />
		<?if(isset($_GET['remind'])){?>
			<div class="row">
				<em class="note error">на ваш e-mail было отправлено сообщение с новым паролем</em>
			</div>				
		<?}?>
		<br />
		<?$auth = new LoginForm('auth');?>
		<?$form=$this->beginWidget('CActiveForm', array(
				'id'=>'login_form',
				'action'=>'/auth/',
				'htmlOptions'=>array('class'=>'form'),
				'enableAjaxValidation'=>true,
				'enableClientValidation'=>false,
				'clientOptions'=>array(
					'validateOnSubmit'=>true
				),
			))
		?>		
			<fieldset>
				<div class="row">
					<label>Ваш e-mail</label>
					<div class="field text-holder">
						<?=$form->textField($auth,'email',array('class'=>'text'))?>
						<?=$form->error($auth,'email')?>
					</div>
				</div>
				<div class="row">
					<label>пароль</label>
					<div class="field text-holder">
						<?=$form->passwordField($auth,'password',array('class'=>'text'))?>
						<?=$form->error($auth,'password')?>
					</div>
				</div>
				<div class="row">
					<?=CHtml::submitButton('Войти',array('class'=>'submit'))?>
					<p><a href="#" onclick="$('#remind-pass').slideDown();$('body,html').animate({scrollTop: $('#remind-pass').position().top });return false;">забыли пароль?</a></p>
					<p>
						<br />Логином является ваш E-mail который вы указывали при регистрации.<br />
						<br />Если ваш текущий пароль не подходит, то вам необходимо нажать на ссылку "забыли пароль?" и ввести ваш E-mail, на который будет выслан технический пароль для входа в личный кабинет.<br />
						<br />После авторизации в личном кабинете с техническим паролем, вы можете его изменить на более удобный для Вас.
					</p>					
				</div>
			</fieldset>
		
		<?$this->endWidget()?>		
		
		<?=$this->renderPartial('/users/_pass_form')?>
	</div>