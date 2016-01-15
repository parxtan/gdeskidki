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
	
</head>

<body>

	<?=$content?>
	
</body>
</html>