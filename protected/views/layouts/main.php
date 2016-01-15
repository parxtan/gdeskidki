<!DOCTYPE HTML>
<html>
<head>
    <title><?=($title ? $title : $rubric->name)?></title>
	<meta name="title" content="<?=htmlspecialchars($title ? $title : $rubric->name)?>" />
	<meta name="keywords" content="<?=htmlspecialchars($keywords)?>" />	
	<meta name="description" content="<?=htmlspecialchars($description)?>" />	
	
	<link rel="image_src" href="<?=$metaImage?>" />
	<meta property="og:image" content="<?=$metaImage?>" />
	
	
    <link rel="stylesheet" type="text/css" href="/static/css/styles.css" />
	<link rel="stylesheet" type="text/css" href="/static/css/styles.1024.css" media="(min-width: 0px) and (max-width: 1150px)" />

    <!--[if lte IE 8]><link rel="stylesheet" type="text/css" href="/static/css/style_ie7-8.css" /><![endif]-->
    <?Yii::app()->clientScript->registerCoreScript('jquery');?>
    <!--script type="text/javascript" src="/static/js/placeholder.min.js"></script-->	
    <script type="text/javascript" src="/static/js/common.js"></script>
	
	<script src="/static/js/masonry.pkgd.min.js"></script>

	
	<?
		$this->widget('application.extensions.fancybox.EFancyBox', array(
			'target'=>'a[rel=fancybox]',
			'config'=>array(),
			)
		);
	?>

	<meta property="og:image" content="<?=$shareImage?>" />
	<link rel="image_src" href="<?=$shareImage?>" />	
	
	<script type="text/javascript" src="//vk.com/js/api/openapi.js?112"></script>

</head>
<body>
	<div id="main_block" class="min-width">
	
		<?=$this->renderPartial('/layouts/header')?>
		
		<div id="content" class="max-width">	
			<div class="middle_block">		
				<div class="padding">
					<?=$content?>
				</div>
			</div>	
			<div class="left_block">
				<a href="/" id="logo"><img src="/static/img/logo.png" width="172" height="50" /></a>
				<?=$this->renderPartial('/layouts/vert_menu')?>
				<?=$this->renderPartial('/widgets/banners_left')?>				
				<?=$this->renderPartial('/news/widget')?>
				<hr id="hr" />
			</div>				
			<!--div class="right_block">
				<?=$this->renderPartial('/widgets/banners_right')?>
			</div-->
			<br class="clear" />
			<div id="content_bg_repeat"><img src="/static/img/bg_repeat.jpg" width="100%" /></div>			
			<div id="content_bg"><img src="/static/img/bg.jpg" width="100%" /></div>
			<div id="noise"></div>
		</div>	
		
		<?=$this->renderPartial('/widgets/social_share_header')?>
	</div>	
	
	<?=$this->renderPartial('/layouts/footer')?>
	
</body>
</html>