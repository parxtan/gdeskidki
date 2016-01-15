	
	<div class="registrarion-block form-holder <?if(!Yii::app()->user->isGuest){?>login_register<?}?>">
		<h2><?if(Yii::app()->user->isGuest){?>Регистрация<?}else{?>Редактировать данные<?}?></h2>
		<br />
		<?if(!$reg) $reg = new User('reg');?>
		<?$form=$this->beginWidget('CActiveForm', array(
				'id'=>'reg_form',
				'action'=>$reg->isNewRecord ? '/reg/' : '/update/',
				'htmlOptions'=>array('class'=>'form'),
				'enableAjaxValidation'=>true,
				'enableClientValidation'=>false,
				'clientOptions'=>array(
					'validateOnSubmit'=>true
				),
			))
		?>
			<?if(!Yii::app()->user->isGuest){?>
				<input type="hidden" name="act" value="update" >
			<?}?>
			<fieldset>
				<?if($uniqEmail=='false'){?>
					<div class="note error">Данный E-mail уже зарегистрирован.</div>
					<br />
				<?}elseif(isset($_GET['success'])){?>
					<div class="note error">Изменения сохранены.</div>
					<br />				
				<?}?>
				<div class="row two-cols">
					<div class="col">
						<div class="label">
							<?=$form->labelEx($reg,'name')?>
						</div>
						<div class="field text-holder">
							<?=$form->textField($reg,'name',array('class'=>'text'))?>
							<?=$form->error($reg,'name')?>
							<em class="ico-reuired">required</em>
						</div>
					</div>
					<div class="col">
						<div class="label">
							<?=$form->labelEx($reg,'lastname')?>
						</div>
						<div class="field text-holder">
							<?=$form->textField($reg,'lastname',array('class'=>'text'))?>
							<?=$form->error($reg,'lastname')?>
							<em class="ico-reuired">required</em>
						</div>
					</div>
				</div>
				<div class="row two-cols">
					<div class="col">
						<div class="label">
							<?=$form->labelEx($reg,'company')?>
						</div>
						<div class="field text-holder">
							<?=$form->textField($reg,'company',array('class'=>'text'))?>
							<?=$form->error($reg,'company')?>
						</div>
					</div>
					<div class="col">
						<div class="label">
							<?=$form->labelEx($reg,'firma')?>
						</div>
						<div class="field text-holder">
							<?=$form->textField($reg,'firma',array('class'=>'text'))?>
							<?=$form->error($reg,'firma')?>
							<em class="ico-reuired">required</em>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div class="label">
							<?=$form->labelEx($reg,'adres')?>
						</div>
						<div class=" field text-holder">
							<?=$form->textField($reg,'adres',array('class'=>'text'))?>
							<?=$form->error($reg,'adres')?>
						</div>
					</div>
				</div>
				<div class="row two-cols">
					<div class="col">
						<div class="label"><?=$form->labelEx($reg,'email')?></div>
						<div class="field text-holder">
							<?=$form->textField($reg,'email',array('class'=>'text'))?>
							<?=$form->error($reg,'email')?>
							<em class="ico-reuired">required</em>
						</div>
					</div>
					<div class="col">
						<div class="label">
							<?=$form->labelEx($reg,'tel')?>
						</div>
						<div class="field text-holder">
							<?=$form->textField($reg,'tel',array('class'=>'text'))?>
							<?=$form->error($reg,'tel')?>
							<em class="ico-reuired">required</em>
						</div>
					</div>
				</div>
				<div class="row two-cols">
					<div class="col">
						<div class="label">
							<?=$form->labelEx($reg,'password')?>
						</div>
						<div class="field text-holder">
							<?=$form->passwordField($reg,'password',array('class'=>'text','value'=>''))?>
							<?=$form->error($reg,'password')?>
							<em class="ico-reuired">required</em>
						</div>
					</div>
					<div class="col">
						<div class="label">
							<?=$form->labelEx($reg,'password2')?>
						</div>
						<div class="field text-holder">
							<?=$form->passwordField($reg,'password2',array('class'=>'text'))?>
							<?=$form->error($reg,'password2')?>
							<em class="ico-reuired">required</em>
						</div>
					</div>
				</div>
				<div class="row button-row">
					<?if(!Yii::app()->user->isGuest){?>
						<input type="image" src="/static/images/save.png" value="Сохранить" class="submit" />
					<?}else{?>
						<?=CHtml::submitButton('Зарегистрироваться',array('class'=>'submit'))?>
					<?}?>
					<p><em>* поля для обязательного заполнения</em></p>
				</div>
			</fieldset>
		<?$this->endWidget()?>
	</div>