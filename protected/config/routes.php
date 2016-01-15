<?php

return array(
	//'class' => 'MyUrlManager',
	'urlFormat'=>'path',
	//'caseSensitive'=>false,
	'showScriptName'=>false,
	'rules'=>array(			
		'gii'=>'gii',
        'gii/<controller:\w+>'=>'gii/<controller>',
        'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
		
		'logout'=>'users/logout',		
		
		'admin'=>'admin/default/index',		
        'admin/login'=>'admin/users/login',
        'admin/logout'=>'admin/users/logout',
		
		'admin/<controller:tinymce>/<action:\w+>'=>'admin/<controller>/<action>',
		'admin/<controller:tinymce>/<action:\w+>/<obj:\w+>'=>'admin/<controller>/<action>',		
		
		'admin/<controller:actions|ajax|rubrics|users>'=>'admin/<controller>/default',
		'admin/<controller:actions|ajax|rubrics|users>/<action:\w+>'=>'admin/<controller>/<action>',
		'admin/<controller:actions|ajax|rubrics|users>/<action:\w+>/<id:\d+>'=>'admin/<controller>/<action>',		
		
		'admin/<controller:actions|ajax>/<action:\w+>/<ctype:\w+>'=>'admin/<controller>/<action>',
		'admin/<controller:actions|ajax>/<action:\w+>/<ctype:\w+>/<id:\d+>'=>'admin/<controller>/<action>',		

		'admin/<controller:photos>'=>'admin/<controller>/default',
		'admin/<controller:photos>/<action:\w+>'=>'admin/<controller>/<action>',
		'admin/<controller:photos>/<action:\w+>/<id:\d+>'=>'admin/<controller>/<action>',
				
		'admin/<controller:config>'=>'admin/<controller>/default',
				
		'admin/<controller:banners>'=>'admin/<controller>/default',
		'admin/<controller:banners>/<action:add>'=>'admin/<controller>/<action>',
		'admin/<controller:banners>/<action:update|delete>/<id:\d+>'=>'admin/<controller>/<action>',
		
		'admin/brands/<bid:\d+>/<controller:addresses>'=>'admin/<controller>/default',
		'admin/brands/<bid:\d+>/<controller:addresses>/<action:\w+>'=>'admin/<controller>/<action>',
		'admin/brands/<bid:\d+>/<controller:addresses>/<action:\w+>/<id:\d+>'=>'admin/<controller>/<action>',
		
		'admin/<controller:malls>/<action:\w+>'=>'admin/<controller>/<action>',
				
		'admin/<url:[\w+\/-]+>/<action:update|add|delete|propeties>/<id:\d+>'=>'admin/default/<action>',
		'admin/<url:[\w+\/-]+>/<action:update|add|importBase>'=>'admin/default/<action>',
		'admin/<url:[\w+\/-]+>/<id:\d+>'=>'admin/default/single',				
		'admin/<url:[\w+\/-]+>'=>'admin/default/default',
			
		'admin/<controller:\w+>'=>'admin/<controller>/default',
		'admin/<controller:\w+>/<action:\w+>'=>'admin/<controller>/<action>',
		'admin/<controller:\w+>/<action:\w+>/<id:\d+>'=>'admin/<controller>/<action>',
			
		/* ----------------------------- end admin routes --------------------------------------------- */

		''=>'site/default',				
		array(
			'class' => 'application.components.MyUrlRule'
		),
	)
);