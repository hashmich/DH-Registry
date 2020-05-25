<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
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
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	
	
Router::parseExtensions('json', 'xml');
	
$layoutRegex = 'iframe';


Router::connect('/:layout', array(
		'controller' => 'courses',
		'action' => 'index'
	),
	array(
		'layout' => $layoutRegex,
		'persist' => array('layout')
	)
);


Router::connect('/', array('controller' => 'courses', 'action' => 'index'));



/**
* ...and connect the rest of 'Pages' controller's URLs.
*/
Router::connect('/:layout/pages/*', array(
		'controller' => 'pages',
		'action' => 'display'
	),
	array('persist' => array('layout'))
);
Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

Router::connect('/:layout/about', array(
		'controller' => 'pages',
		'action' => 'display',
		'about'
	),
	array('persist' => array('layout'))
);
Router::connect('/about', array(
	'controller' => 'pages',
	'action' => 'display',
	'about'
));

Router::connect('/:layout/users/:action', array(
		'controller' => 'app_users'
	),
	array(
		'layout' => $layoutRegex,
		'persist' => array('layout')
	)
);

Router::connect('/:layout/:controller/:action/*', array(),
	array(
		'layout' => $layoutRegex,
		'persist' => array('layout')
	)
);

Router::connect('/:layout/:controller', array(),
	array(
		'layout' => $layoutRegex,
		'persist' => array('layout')
	)
);



// define the Cakeclient exceptions, before the plugin's routes load
//Router::connect('/courses', array('controller' => 'courses'));
Router::redirect('/courses', '/');
Router::connect('/index', array('controller' => 'courses', 'action' => 'index'));
Router::connect('/add', array('controller' => 'courses', 'action' => 'add'));
Router::connect('/statistic', array('controller' => 'courses', 'action' => 'statistic'));
Router::connect('/:action/*', array('controller' => 'courses'),
		array('action' => 'view|edit|delete|revalidate'));
//Router::connect('/courses/:action/*', array('controller' => 'courses', 'action' => ':action'));

//Router::connect('/admin/users/approve/*', array('controller' => 'users', 'action' => 'approve', 'plugin' => null));
//Router::connect('/moderator/users/approve/*', array('controller' => 'users', 'action' => 'approve', 'plugin' => null));

/**
* Load all plugin routes. See the CakePlugin documentation on
* how to customize the loading of plugin routes.
*/
//CakePlugin::routes();	// order matters:
CakePlugin::routes('Users');
CakePlugin::routes('Cakeclient');

/**
* Load the CakePHP default routes. Only remove this if you do not want to use
* the built-in default routes.
*/
require CAKE . 'Config' . DS . 'routes.php';
