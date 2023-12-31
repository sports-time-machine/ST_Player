<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
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
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	// /P/ABCD3 のような、選手ID直打ちの場合のルーティング
	// 大文字のA-Z、数字の1-9から始まるときにマッチ
    // 大文字小文字区別なくアクセスできる
	Router::connect('/P/:player_id', array('controller' => 'Profiles', 'action' => 'view'), array('pass' => array('player_id'), 'player_id' => '[a-zA-Z0-9]+'));
	Router::connect('/p/:player_id', array('controller' => 'Profiles', 'action' => 'view'), array('pass' => array('player_id'), 'player_id' => '[a-zA-Z0-9]+'));
	// User.idでのアクセス
	Router::connect('/N/:user_id', array('controller' => 'Profiles', 'action' => 'viewId'), array('pass' => array('user_id')));
	Router::connect('/n/:user_id', array('controller' => 'Profiles', 'action' => 'viewId'), array('pass' => array('user_id')));
	// record_idでのアクセス
	Router::connect('/R/:record_id', array('controller' => 'Records', 'action' => 'view'), array('pass' => array('record_id')));
	Router::connect('/r/:record_id', array('controller' => 'Records', 'action' => 'view'), array('pass' => array('record_id')));
    
	//Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
  	Router::connect('/', array('controller' => 'users', 'action' => 'index2'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
	
/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
