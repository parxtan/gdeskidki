	<div class="title cursor-pointer mt5" onclick="$('#meta-form').toggle();">
		<span>META - теги</span>
	</div>	
	<div class="padding10 none" id="meta-form">
		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'title')?>
			</div>
			<div class="field">
				<?=$form->textField($model,'title')?>
				<?=$form->error($model,'title')?>
			</div>
		</div>	
		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'keywords')?>
			</div>
			<div class="field">
				<?=$form->textField($model,'keywords')?>
				<?=$form->error($model,'keywords')?>
			</div>
		</div>		
		<div class="row">
			<div class="label">
				<?=$form->labelEx($model,'description')?>
			</div>
			<div class="field">
				<?=$form->textArea($model,'description')?>
				<?=$form->error($model,'description')?>
			</div>
		</div>		
	</div>