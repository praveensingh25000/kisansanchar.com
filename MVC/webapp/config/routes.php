<?php
/**
 * ADMIN VARIABLE Setting Detail
 *
 */
 if(!defined('ADMIN_VAR')){
	 if(in_array('admin',explode('/',$_SERVER['REQUEST_URI']))){
		define('ADMIN_VAR', 'admin');
	 }
 }

  /**
 * View folder name Setting Detail
 *
 */
 if(!defined('VIEW_VAR')){
	define('VIEW_VAR', 'view');
 }

 /**
 * Template Constant Setting Detail
 *
 */
  if(defined('ADMIN_VAR')){
	  if(file_exists(DOC_ROOT.ADMIN_VAR.DS.VIEW_VAR.DS.urlsegment(0).'.php')){
		  
		  if(!defined('CONTENT_FOR_HEADER')){
			define('CONTENT_FOR_HEADER', DOC_ROOT.ADMIN_VAR.DS.VIEW_VAR.DS.'layouts/adminHeader.php');
		  }
		  if(!defined('CONTENT_FOR_FOOTER')){
			define('CONTENT_FOR_FOOTER', DOC_ROOT.ADMIN_VAR.DS.VIEW_VAR.DS.'layouts/adminfooter.php');
		  }
		  if(!defined('CONTENT_FOR_LAYOUT')){
			define('CONTENT_FOR_LAYOUT',DOC_ROOT.ADMIN_VAR.DS.VIEW_VAR.DS.urlsegment(0).'.php');	
		  }		
		  
	  }else{
		  define('CONTENT_FOR_LAYOUT',DOC_ROOT.ADMIN_VAR.DS.VIEW_VAR.DS.'404.php');	
	  }
  }else{
	  if(file_exists(DOC_ROOT.DS.VIEW_VAR.DS.urlsegment(0).'.php')){

		  if(!defined('CONTENT_FOR_HEADER')){
			define('CONTENT_FOR_HEADER', DOC_ROOT.VIEW_VAR.DS.'layouts/frontHeader.php');
		  }
		  if(!defined('CONTENT_FOR_FOOTER')){
			define('CONTENT_FOR_FOOTER', DOC_ROOT.VIEW_VAR.DS.'layouts/frontFooter.php');
		  }
		  if(!defined('CONTENT_FOR_LAYOUT')){
			define('CONTENT_FOR_LAYOUT',DOC_ROOT.VIEW_VAR.DS.urlsegment(0).'.php');
		  }		  

	  }else{
		  define('CONTENT_FOR_LAYOUT',DOC_ROOT.VIEW_VAR.DS.'404.php');
	  }
  }
?>