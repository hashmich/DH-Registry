<?php

//if(Configure::read('debug') > 0) {
	header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
//}

Configure::write('dhcr.baseUrl', env('DHCR_BASE_URL'));

Configure::write('App.reCaptchaPublicKey',  env('RECAPTCHA_PUBLIC_KEY'));
Configure::write('App.reCaptchaPrivateKey', env('RECAPTCHA_PRIVATE_KEY'));



Configure::write('App.defaultEmail', array(env('APP_MAIL_DEFAULT_FROM') => 'DH Course Registry'));
Configure::write('App.defaultCc', env('APP_MAIL_DEFAULT_CC'));
Configure::write('App.EmailSubjectPrefix', '[DH Course Registry]');

// send an update reminder after this period, make traffic-light display according to this setting
Configure::write('App.CourseWarnPeriod', (60*60*24*300));

// show yellow on public listing some weeks after reminder email
Configure::write('App.CourseYellow', Configure::read('App.CourseWarnPeriod') + 60*60*24*7*4);
// show red
Configure::write('App.CourseRed', Configure::read('App.CourseWarnPeriod') + 60*60*24*7*26);

// stop displaying course on homepage
Configure::write('App.CourseExpirationPeriod', (60*60*24*7*70));
// courses not updated for this period will be hidden at all, for archival purposes
Configure::write('App.CourseArchivalPeriod', (60*60*24*365*2));



Configure::write('App.mapApiKey', env('MAP_API_KEY'));


/** 
* This constant is used by the crontasks and email functions,
* which are required to render links in the email bodies. 
* As the cron is not being requested via the web, 
* Cake's Router will resolve the base URL to 'localhost'.
* Sometimes, it instead gets the server name instead of the domain name (user email system).

* We're not using Cake's 'App.FullBaseUrl', which would directly affect the Router::url('/', $full = true) output
*/
#TODO: align email templates with env('DHCR_BASE_URL')
Configure::write('App.consoleBaseUrl', 'https://dhcr.clarin-dariah.eu/ops');


Configure::write('List.subscribeURL', env('LIST_SUBSCRIBE_URL'));
Configure::write('List.unsubscribeURL', env('LIST_UNSUBRSCRIBE_URL'));
Configure::write('List.adminPwd', env('LIST_ADMIN_PWD'));


/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models/', '/next/path/to/models/'),
 *     'Model/Behavior'            => array('/path/to/behaviors/', '/next/path/to/behaviors/'),
 *     'Model/Datasource'          => array('/path/to/datasources/', '/next/path/to/datasources/'),
 *     'Model/Datasource/Database' => array('/path/to/databases/', '/next/path/to/database/'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions/', '/next/path/to/sessions/'),
 *     'Controller'                => array('/path/to/controllers/', '/next/path/to/controllers/'),
 *     'Controller/Component'      => array('/path/to/components/', '/next/path/to/components/'),
 *     'Controller/Component/Auth' => array('/path/to/auths/', '/next/path/to/auths/'),
 *     'Controller/Component/Acl'  => array('/path/to/acls/', '/next/path/to/acls/'),
 *     'View'                      => array('/path/to/views/', '/next/path/to/views/'),
 *     'View/Helper'               => array('/path/to/helpers/', '/next/path/to/helpers/'),
 *     'Console'                   => array('/path/to/consoles/', '/next/path/to/consoles/'),
 *     'Console/Command'           => array('/path/to/commands/', '/next/path/to/commands/'),
 *     'Console/Command/Task'      => array('/path/to/tasks/', '/next/path/to/tasks/'),
 *     'Lib'                       => array('/path/to/libs/', '/next/path/to/libs/'),
 *     'Locale'                    => array('/path/to/locales/', '/next/path/to/locales/'),
 *     'Vendor'                    => array('/path/to/vendors/', '/next/path/to/vendors/'),
 *     'Plugin'                    => array('/path/to/plugins/', '/next/path/to/plugins/'),
 * ));
 *
 */

/**
 * Custom Inflector rules can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. Make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */
 
 // load plugin routes in a specific order in the routes.php file
 CakePlugin::loadAll(array(
	array('routes' => true, 'bootstrap' => true, 'ignoreMissing' => true)
 ));
 
 

/**
 * You can attach event listeners to the request lifecycle as Dispatcher Filter. By default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 *		'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 *		'MyCacheFilter' => array('prefix' => 'my_cache_'), //  will use MyCacheFilter class from the Routing/Filter package in your app with settings array.
 *		'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 *		array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 *		array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
	'engine' => 'File',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));
CakeLog::config('error', array(
	'engine' => 'File',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));