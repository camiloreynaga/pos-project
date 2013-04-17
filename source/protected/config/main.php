<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

const PATH_SEPARATOR = '/';

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Point Of Sales System',
    'theme'=>'asia',
    'language'=>'vi',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'ext.phpexcel.Classes.PHPExcel',
        'ext.giix-components.*', // giix components
        'ext.eexcelview.*',
        'ext.ebreadcrumbs.*'
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
                        'generatorPaths' => array(
                                'ext.giix-core', // giix generators
                        ),
		),
        'quanlychinhanh'=>array(
            'defaultController'=>'danhsach',
        ),

        'quanlynhanvien'=>array(
            'defaultController'=>'danhsach',
        ),
        
        'quanlybanhang'=>array(
            'defaultController'=>'danhsach',
        ),

        'quanlysanpham'=>array(
            'defaultController'=>'danhsach',
        ),

        'quanlynhacungcap'=>array(
            'defaultController'=>'danhsach',
        ),

        'quanlykhachhang'=>array(
            'defaultController'=>'danhsach',
        ),
        
        'quanlykhachhang'=>array(
            'defaultController'=>'danhsach',
        ),
                    
	),

	// application components
	'components'=>array(
        'session'=>array(
            'autoStart'=>true,
        ),
        'localtime'=>array(
            'class'=>'LocalTime',
        ),

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
           // 'class'=>'CWebUser',
           // 'autoUpdateFlash' => false, // add this line to disable the flash counter

        ),
        // Yii Booster config
        'bootstrap' => array(
            'class' => 'ext.bootstrap.components.Bootstrap',
            'responsiveCss' => true,
        ),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
            'showScriptName'=>false,

			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
	
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=pos_db',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',

            'enableProfiling'=>true,   // config to show log database
            'enableParamLogging'=>true,
        ),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(

			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
					//'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages

				/*array(
                    'class'=>'CWebLogRoute',
                    'categories'=>'system.db.CDbCommand',
                    'showInFireBug'=>true,
				),*/

			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);