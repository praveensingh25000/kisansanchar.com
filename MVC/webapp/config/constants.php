<?php
/**
 * Connectivity Detail
 *
 */
 if(!defined('DATABASE_HOST')){
	define('DATABASE_HOST', 'localhost');
 }

 if(!defined('DATABASE_USER')){
	define('DATABASE_USER', 'root');
 }

 if(!defined('DATABASE_PASSWORD')){
	define('DATABASE_PASSWORD', '');
 }

 if(!defined('DATABASE_NAME')){
	define('DATABASE_NAME', 'webapp');
 }

 /**
 * Timezone Setting Detail
 *
 */
 if(function_exists('date_default_timezone_set')){
    date_default_timezone_set('Asia/Calcutta'); 
 }

 /**
 * Current Time Setting Detail
 *
 */
 if(!defined('CURRENT_DATE')){ 
	define('CURRENT_DATE', Date('Y-m-d H:i:s'));
 }
?>