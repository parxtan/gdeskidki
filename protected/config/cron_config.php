<?php

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Cron',
 
	'preload'=>array('log'),
 
	'import'=>array(
		'application.models.*',
		'application.components.*',			
		'application.extensions.phpQuery.*',			
	),
	'components'=>array(
		'CURL' =>array(
			'class' => 'application.extensions.curl.Curl',
		),		
		'ih'=>array(
			'class'=>'CImageHandler',
		),		
		'phpQuery' => array(
			'class' => 'application.extensions.phpQuery.phpQuery'
		),	
		'request'=>array(
            //'enableCsrfValidation'=>true,
			'enableCookieValidation'=>true,
        ),			
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'logFile'=>'cron.log',
					'levels'=>'error, warning',
				),
				array(
					'class'=>'CFileLogRoute',
					'logFile'=>'cron_trace.log',
					'levels'=>'trace',
				),
			),
		),
	),
	'params'=>array(	
		'docRootPath'=>realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'),
	
		'image_size' => array(
			'kupons'=>array(
				'image' => array(                
					'thumb_b' => array('width'=>600, 'height'=>335, 'crop'=>0),
					'thumb_m' => array('width'=>435, 'height'=>200, 'crop'=>1),
					'thumb_s' => array('width'=>70, 'height'=>50, 'crop'=>1),
				),
				'image2' => array(                
					'thumb_b' => array('width'=>550, 'height'=>335, 'crop'=>0),
					'thumb_m' => array('width'=>435, 'height'=>200, 'crop'=>1),
					'thumb_s' => array('width'=>70, 'height'=>50, 'crop'=>1),
				),
				'image3' => array(                
					'thumb_b' => array('width'=>550, 'height'=>335, 'crop'=>0),
					'thumb_m' => array('width'=>435, 'height'=>200, 'crop'=>1),
					'thumb_s' => array('width'=>70, 'height'=>50, 'crop'=>1),
				)
			)
		)	
	)
);