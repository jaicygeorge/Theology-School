<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
ini_set("html_errors", "On");
ini_set('error_reporting', E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'School Of Theology Online',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
                'application.modules.rights.*',
                'application.modules.rights.components.*',
	),

	'defaultController'=>'users',

	// application components
	'components'=>array(
		'user'=>array(
                    'class' => 'CWebUser',
                    'loginUrl'=>array('users/login'),
                    'returnUrl'=>array('users/dashboard'),
//                    'class'=>'RWebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
//            'authManager'=>array(
//                'class'=>'RDbAuthManager',
//                ),
//		'db'=>array(
//			'connectionString' => 'sqlite:protected/data/blog.db',
//			'tablePrefix' => 'tbl_',
//		),
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=millenni_theo',
			'emulatePrepare' => true,
			'username' => 'millenni_theo',
			'password' => 'VNL;yFT1N-3u',
			'charset' => 'utf8',
			'tablePrefix' => '',
		),
//		'modules'=>array(
//                    'rights'=>array(
//                    'install'=>true,
//                    ),
//                ),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'post/<id:\d+>/<title:.*?>'=>'post/view',
				'posts/<tag:.*?>'=>'post/index',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
             'authManager'=>array(
                    
                    'class'=>'CDbAuthManager',
                    'connectionID'=>'db'                 
                ),
	),
       	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
);