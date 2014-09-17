<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'			=> dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'				=> 'my',
	'language'			=> 'ru',
	'defaultController' => 'base',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
        'application.controllers.BaseController',
		'application.models.*',
		'application.components.*',
        'application.modules.admin.models.*',
        'application.modules.admin.components.*',
        'application.components.AuxiliaryFunctions',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
        'admin' => array(
            'layoutPath' => 'protected/views/layouts',
            'layout'     => 'main',
        ),
	),

	// application components
	'components' => array(
		'clientScript' => array(
			'scriptMap' => array(
				'forAutocompliter.js' => '/js/forAutocompliter.js',
			)
		),
        'iwi' => array(
            'class' => 'application.extensions.iwi.IwiComponent',
            // GD or ImageMagick
            'driver' => 'GD',
            // ImageMagick setup path
            //'params'=>array('directory'=>'C:/ImageMagick'),
        ),
//		'session' => array(
//			'cookieMode'	=> 'allow',
//			'cookieParams'	=> array(
//				 'domain'	=> 'domitorg.dev.com.ua',
//				 'httponly' => true,
//			),
//		),
		'user'=>array(
            'class' => 'WebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
//        'user'=>array(
//            'class' => 'WebUser',
//            // …
//        ),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
        'authManager' => array(
            // Будем использовать свой менеджер авторизации
            'class' => 'PhpAuthManager',
            // Роль по умолчанию. Все, кто не админы, модераторы и юзеры — гости.
            'defaultRoles' => array('guest'),
        ),
        'db'=>array(
			'connectionString'  => 'mysql:host=mysql.9787399585.myjino.ru;dbname=9787399585',
            'emulatePrepare'    => true,
            'username'          => '9787399585',
            'password'          => 'kG8jn4kuJZ',
            'charset'           => 'utf8',
            'autoConnect'       => false,
		),
        'db1'=>array(
            'class'             => 'CDbConnection',
			'connectionString'  => 'mysql:host=mysql.9787399585.myjino.ru;dbname=9787399585',
            'emulatePrepare'    => true,
            'username'          => '9787399585',
            'password'          => 'kG8jn4kuJZ',
            'charset'           => 'utf8',
            'autoConnect'       => false,
        ),
//		'db'=>array(
//			'connectionString'  => 'mysql:host=localhost;dbname=my',
//            'emulatePrepare'    => true,
//            'username'          => 'root',
//            'password'          => '',
//            'charset'           => 'utf8',
//            'autoConnect'       => false,
//		),
//        'db1'=>array(
//            'class'             => 'CDbConnection',
//			'connectionString'  => 'mysql:host=localhost;dbname=my',
//            'emulatePrepare'    => true,
//            'username'          => 'root',
//            'password'          => '',
//            'charset'           => 'utf8',
//            'autoConnect'       => false,
//        ),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class' =>'CLogRouter',
			'routes' =>array(
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
        'request' => array(
//            'baseUrl' => 'http://388491.worldo10.web.hosting-test.net/',
//            'baseUrl' => 'http://vitacod',
            'baseUrl' => 'http://9787399585.myjino.ru/public/',
        ),
    ),

    'params'=>require(dirname(__FILE__).'/params.php'),
);