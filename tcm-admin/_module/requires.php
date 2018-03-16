<?php
$string = dirname(dirname(__FILE__));

require_once($string."/_const/const.php");
require_once($string."/_const/config.php");
require_once($string."/_const/msg.php");
require_once($string."/_module/CheckUtil.class.php");
require_once($string."/_module/DBConnect.class.php");
require_once($string."/_module/DBFunctions.class.php");
require_once($string."/_module/error_handler.php");
require_once($string."/_module/Smarty/libs/Smarty.class.php");
require_once($string."/_module/ChildSmarty.class.php");
require_once($string."/_module/SqlExecution.class.php");
require_once($string."/_module/Util.class.php");
?>