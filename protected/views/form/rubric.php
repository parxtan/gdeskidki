<div id="content">
	<div class="heading">
		<h2><?=$rubric->name?></h2>
	</div>
	<div class="forbar-body">
		<div class="content-body">
			<?if(Yii::app()->user->hasFlash('message')){?>
				<p class="message"><?=Yii::app()->user->getFlash('message')?></p>
			<?}?>
			<?$model = new Form('new');?>
			<?$form=$this->beginWidget('CActiveForm', array(
				'id'=>'form',
				'htmlOptions'=>array('enctype'=>'multipart/form-data', 'class'=>'form form-holder order-form'),
				'enableAjaxValidation'=>true,
				'enableClientValidation'=>true,
				'clientOptions'=>array(
					'validateOnSubmit'=>true
				),
			))
			?>
				<input type="hidden" name="flag" value="1">

				<div class="area">
					<div class="box">
						<?=$form->labelEx($model,'name')?>
						<span class="input-txt">
							<?=$form->textField($model,'name')?>
							<?=$form->error($model,'name')?>
						</span>
					</div>
					<div class="box">
						<?=$form->labelEx($model,'lastname')?>
						<span class="input-txt">
							<?=$form->textField($model,'lastname',array('value'=>$user->lastname))?>
							<?=$form->error($model,'lastname')?>
						</span>
					</div>
				</div>
				<div class="area">
					<div class="box">
						<?=$form->labelEx($model,'email')?>
						<span class="input-txt">
							<?=$form->textField($model,'email',array('value'=>$user->email))?>
							<?=$form->error($model,'email')?>
						</span>
					</div>
					<div class="box">
						<?=$form->labelEx($model,'tel')?>
						<span class="input-txt">
							<?=$form->textField($model,'tel',array('value'=>$user->tel))?>
							<?=$form->error($model,'tel')?>
						</span>
					</div>
				</div>
				<div class="area">
					<div class="box">
						<?=$form->labelEx($model,'arts')?>
						<span class="input-txt norequired">
							<?=$form->textField($model,'arts')?>
						</span>
					</div>				
					<div class="box">
						<?=$form->labelEx($model,'delivered')?>
						<span class="input-txt">
							<?=$form->textField($model,'delivered')?>
						</span>
					</div>
				</div>
				<div class="area">
					<div class="box">
						<?=$form->labelEx($model,'color')?>
						<span class="input-txt">
							<?=$form->textField($model,'color')?>
							<?=$form->error($model,'color')?>
						</span>
					</div>				
					<div class="box">
						<?=$form->labelEx($model,'tirazh')?>
						<span class="input-txt">
							<?=$form->textField($model,'tirazh')?>
							<?=$form->error($model,'tirazh')?>
						</span>
					</div>
				</div>				
				<div class="area">
					<div class="box">
						<label>Размеры рисунка</label>
						<span class="input-txt small">
							<?=$form->textField($model,'width')?>
							<?=$form->error($model,'width')?>
						</span>
						<em class="side-space">x</em>
						<span class="input-txt small">
							<?=$form->textField($model,'height')?>
							<?=$form->error($model,'height')?>
						</span>						
						мм
					</div>								
					<div class="box">
						<?=$form->labelEx($model,'file')?>
						<span class="input-txt file">
							<input type="file" name="file" class="file-input-area hide">
							<img src="/static/images/browse.gif" />
						</span>
					</div>					
				</div>
				<div class="area">
					<div class="box">
						<label>Наличие драгоценных металлов</label>
						<span class="checkbox">
							<?=$form->hiddenField($model,'gold',array('value'=>0))?>
							<span class="false" onclick="toggleCheckbox(this);">Золото</span>
						</span>
						<span class="checkbox">
							<?=$form->hiddenField($model,'platina',array('value'=>0))?>
							<span class="false" onclick="toggleCheckbox(this);">Платина</span>
						</span>						
					</div>
					<div class="box">

					</div>					
				</div>				
				<div class="area">
					<?=$form->labelEx($model,'text')?>
					<span class="textarea">
						<?=$form->textArea($model,'text')?>
					</span>
				</div>				
				<div class="area">
					<a href="#" onclick="$(this).parents('form').submit();return false;" class="btn-order">сделать заказ</a>
				</div>
			<?$this->endWidget();?>
		</div>	
	</div>
</div>
<?=$this->renderPartial('/layouts/vert_menu')?>