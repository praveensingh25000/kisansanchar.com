<?php
 /**
 * Use the DS to separate the directories in other defines
 */
 if (!defined('CONFIG')) {
	define('CONFIG', basename(dirname(__FILE__)));
 }
 /**
 * Use the DS to separate the directories in other defines
 */
 if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
 }

 /**
 * The full path to the directory which holds "webapp", WITHOUT a trailing DS.
 *
 */
 if(!defined('DOC_ROOT')){
	define('DOC_ROOT', $_SERVER['DOCUMENT_ROOT'].'webapp/');
 }

 /**
 * The full path to the directory which holds "webapp", WITHOUT a trailing DS.
 *
 */
 $protocolArray = explode('/', $_SERVER['SERVER_PROTOCOL']);
 if(!defined('URL_SITE')){
	define('URL_SITE', strtolower($protocolArray[0]).'://'.$_SERVER['HTTP_HOST'].'/webapp');
 }

 /**
 * Inculding Global Constant
 *
 */
 require_once 'constants.php';

 /**
 * Inculding Global Function
 *
 */
 require_once 'functions.php';

 /**
 * Inculding Global connection
 *
 */
 require_once 'database.php';

 /**
 * Routes URL Setting
 *
 */
 require_once 'routes.php';