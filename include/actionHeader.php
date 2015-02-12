<?php
/******************************************
* @Created on JAN 26, 2014
* @Package: Rand
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

@ob_start();
@session_start();

ini_set("display_errors","2");
ERROR_REPORTING(0);
//ERROR_REPORTING(E_ALL);

ini_set('max_execution_time', '8000');
ini_set('memory_limit', '11500000000000M');

$pagename = basename($_SERVER['PHP_SELF']);

require_once('connect.php');
require_once($DOC_ROOT.'classes/database.class.php');
require_once($DOC_ROOT.'classes/language.class.php');
require_once($DOC_ROOT.'classes/admin.class.php');
require_once($DOC_ROOT.'classes/user.class.php');
require_once($DOC_ROOT.'classes/search.class.php');
require_once($DOC_ROOT.'classes/analysis.class.php');
require_once($DOC_ROOT.'classes/message.class.php');
require_once($DOC_ROOT.'classes/project.class.php');
require_once($DOC_ROOT.'classes/videoembed.class.php');
require_once($DOC_ROOT.'classes/textsms.class.php');
require_once($DOC_ROOT.'classes/voice.audio.csv.upload.class.php');
require_once($DOC_ROOT.'classes/voice.audio.file.upload.class.php');
require_once($DOC_ROOT.'classes/voice.audio.send.sms.class.php');
require_once($DOC_ROOT.'classes/voice.audio.file.cdr.class.php');
require_once($DOC_ROOT.'classes/voice.ivr.survey.create.ivrname.class.php');
require_once($DOC_ROOT.'classes/voice.ivr.survey.audio.upload.class.php');
require_once($DOC_ROOT.'classes/voice.ivr.survey.audio.csv.upload.class.php');
require_once($DOC_ROOT.'classes/voice.ivr.survey.audio.sms.send.class.php');
require_once($DOC_ROOT.'classes/mailer.class.php');
require_once($DOC_ROOT.'classes/ps_pagination.php');
require_once($DOC_ROOT.'classes/ps_paginationArray.php');
$db = new db(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DB);
//getting all language variable
require($DOC_ROOT.'include/language.php');
require($DOC_ROOT.'include/functions.php');
require_once($DOC_ROOT.'include/setting.php');
?>