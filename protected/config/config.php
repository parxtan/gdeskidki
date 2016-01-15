<?php

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',	
	'name'=>'GdeSkidki.KZ',
	'language'=>'ru',
	
	// preloading 'log' component
	'preload'=>array('log'),
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.yii-mail.*',
		'application.extensions.phpQuery.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'giipassword',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'admin'
	),

	// application components
	'components'=>array(
		'db'=>require(dirname(__FILE__).'/database.php'),
		'urlManager'=>require(dirname(__FILE__).'/routes.php'),
		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),			
        'cache'=>array(
            'class'=>'system.caching.CFileCache',
        ),		
		'CURL' =>array(
			'class' => 'application.extensions.curl.Curl',
			/*
			'options'=>array(
				'timeout'=>0,
				'cookie'=>array(
					'set'=>'weahter'
				),
				'login'=>array(
					'username'=>'myuser',
					'password'=>'mypass'
				),
				'proxy'=>array(
					'url'=>'someproxy.com',
					'port'=>80,
				),
				//note if you set proxlogin proxy is required
				'proxylogin'=>array(
					'username'=>'someuser',
					'password'=>'somepasswords'
				),

				'setOptions'=>array(
					CURLOPT_UPLOAD => true,
					CURLOPT_USERAGENT => Yii::app()->params['agent']
				),
			),               
			*/
		),
        'mail' => array(
			'class' => 'application.extensions.yii-mail.YiiMail',
			'transportType'=>'smtp', /// case sensitive!
			'transportOptions'=>array(
				'host'=>'smtp.gmail.com',
				'username'=>'qpgarderob@gmail.com',
				'password'=>'qpgarderobpass',
				'port'=>'465',
				'encryption'=>'ssl',
            ),
			'viewPath' => 'application.views.mail',
			'logging' => true,
			'dryRun' => false
		),	
        'phpQuery' => array(
			'class' => 'application.extensions.phpQuery.phpQuery'
		),			
		'request'=>array(
            //'enableCsrfValidation'=>true,
			'enableCookieValidation'=>true,
        ),	
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
        'widgetFactory'=>array(
            'widgets'=>array(
                'CActiveForm'=>array(
					'clientOptions'=>array(
						//'inputContainer'=>'dd',
					)
                ),
                'CJuiDatePicker'=>array(
                    'language'=>'ru',
                ),
				'CGridView'=>array(
					'cssFile' => '/static/css/yii/gridview/styles.css'
				),
                'CLinkPager'=>array(
                    'maxButtonCount'=>10,
					'header' => '<b>Страницы: </b>',
					'firstPageLabel'=>'В начало',
					'prevPageLabel'=>'Предыдущая',
					'nextPageLabel'=>'Следующая',
					'lastPageLabel'=>'В конец',					
                ),					
            ),
        ),		
        'ih'=>array(
            'class'=>'CImageHandler',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CProfileLogRoute',
					'levels'=>'profile',
					'enabled'=>false,			
				),			
			),
		),
		'clientScript'=>array(
			'scriptMap' => array(
				'jquery.js'=>'/static/js/jquery-1.7.1.min.js',
				'cookie.js'=>'/static/js/jquery.cookie.js',
				'common.js'=>'/static/js/common.js',
				'admin.js'=>'/static/js/admin.js',
				'embed.js'=>'/static/js/embed.js',
			)
		)
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'admin_email'=>'parxtan@gmail.com',
		'crumbs'=>array(), // хлебные крошки
	),
);