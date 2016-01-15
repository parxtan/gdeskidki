<!DOCTYPE >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>

	<title><?=CHtml::encode($this->pageTitle)?></title>
	<meta http-equiv="Content-Type" content="text/htmlcharset=utf-8" />
	<meta name="language" content="ru" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?=Yii::app()->request->baseUrl?>/static/css/admin.css" />
	
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?=Yii::app()->request->baseUrl?>/static/css/ie.css" media="screen, projection" />
	<![endif]-->
	
	<?Yii::app()->clientScript->registerCoreScript('jquery');?>
	<script type="text/javascript" src="/static/js/ui/ui.core.js"></script>
	<script type="text/javascript" src="/static/js/ui/ui.sortable.js"></script>	
	<?Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl.'/static/js/admin.js');?>
	
</head>

<body>

<div id="main_block">
	<div id="head">
		<div class="padding">
			<div class="width25">
				<div id="logo" class="valign"><?=Yii::app()->name?></div>
			</div>
			<div class="width75">
				<div>
					<span class="valign">
						<a href="/logout/">выйти</a>
					</span>
				</div>
			</div>
			<br class="clear" />
		</div>
	</div>
	<div id="content_block">
		<div id="left_block" class="width25">
			<div class="padding">				
				<div id="menu_block">
					<?foreach($this->menuTypes as $k=>$v){?>
						<div class="simple_menu" id="<?=$k?>_0">
							<?=CHtml::ajaxLink(
								'добавить подраздел',
								'/admin/rubrics/getAddRubricForm/',
								array(
									'type'=>'POST',
									'data'=>array('parent_id'=>$k),
									'success'=>"function(data){
										$('body').append(data);
									}"
								),
								array('class'=>'btn_ico add', 'title'=>'добавить раздел')
							)?>
							<h4 class="h4"><?=$v['name']?></h4>
							<?$rubrics[$k] = $this->getMenu($k);?>
							<?if(count($rubrics[$k])>0){?>
								<?foreach($rubrics[$k] as $t=>$r){?>						
									<div id="<?=$r->menu?>_<?=$r->id?>" class="lvl lvl<?=$r->lvl?> <?if($r->lvl>1 && $r->parent_id != Yii::app()->params->breadcrumbs[$r->lvl-2]->id){?>none<?}?>">
										<div class="menu">
											<?if($rubrics[$k][$t+1]->parent_id == $r->id){?>
												<span class="btn_ico childs" title="Показать подразделы"></span>
											<?}?>
											<?=CHtml::link($r->name,$r->getLink(),array('class'=>'menu_link'))?>
											<?if($r->lvl < $v['lvl']){?>
												<?=CHtml::ajaxLink(
													'добавить раздел',
													'/admin/rubrics/getAddRubricForm/',
													array(
														'type'=>'POST',
														'data'=>array('parent_id'=>$r->id,'lvl'=>$r->lvl),
														'success'=>"function(data){
															$('body').append(data);
														}"
													),
													array(
														'id'=>'add_'.$r->id,
														'class'=>'btn_ico add none', 
														'title'=>'добавить подраздел'
													)
												)?>									
											<?}?>
											<?=CHtml::ajaxLink(
												'Удалить раздел',
												'/admin/rubrics/delete/'.$r->id.'/',
												array(
													'type'=>'POST',
													'beforeSend'=>"function(){ return confirm ('Удалить раздел?') }",
													'success'=>"function(data){
														if(data=='success')
															$('#".$r->menu."_".$r->id."').remove();
														else
															alert(data);
													}"
												),
												array(
													'id'=>'del_'.$r->id,
													'class'=>'btn_ico del none',
													'title'=>'Удалить раздел'
												)
											)?>	
										</div>
									<?for($i=0; $i<=$r->lvl-($rubrics[$k][$t+1]->lvl ? $rubrics[$k][$t+1]->lvl : 1); $i++){?>
										</div>
									<?}?>
								<?}?>
							<?}?>
						</div>
					<?}?>
					<br />					
					<div class="simple_menu">
						<?foreach($this->staticTypes as $k=>$v){?>
							<?if(is_array($v)){?>
								<h4 class="h4"><?=$k?></h4>
								<?foreach($v as $k2=>$v2){?>
									<div class="menu"><a href="/admin/<?=$k2?>"><?=$v2?></a></div>
								<?}?>
							<?}else{?>
								<div class="menu"><a href="/admin/<?=$k?>"><?=$v?></a></div>
							<?}?>
						<?}?>						
					</div>
				</div>
			</div>
		</div>
		<div id="right_block" class="width75">
			<div class="padding10"><?=$content?></div>
		</div>
		<br class="clear" />
	</div>
	<div id="footer">
		<div class="padding">
			&copy; <?=date('Y')?> Copyright
		</div>
	</div>	
</div><!-- page -->


</body>
</html>