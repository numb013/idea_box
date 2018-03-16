<?php
//$old_error_handler = set_error_handler("errorHandler");

/**
* エラーハンドラ関数
* 
* @param String $errno
* @param String $errstr
* @param String $errfile
* @param String $errline
* @return
*/
function errorHandler($errno, $errstr, $errfile, $errline) {
  switch ($errno) {
    case E_ERROR:
      $msg = sprintf("[%s] PHP ERROR in %s on line %s : %s\n", date("Y/m/d H:i:s"), $errfile, $errline, $errstr);
      error_log($msg, 3, LOG."/".date("Ym").".log");
      $_SESSION["error_msg"] = E_SERVER;
      header("Location: ".URL_ROOT."/error.php");
      exit;
      break;
    case E_WARNING:
      $msg = sprintf("[%s] PHP WARNING in %s on line %s : %s\n", date("Y/m/d H:i:s"), $errfile, $errline, $errstr);
      error_log($msg, 3, LOG."/".date("Ym").".log");
      break;
    case E_USER_ERROR:
      $msg = sprintf("[%s] Public Error in %s on line %s : %s\n", date("Y/m/d H:i:s"), $errfile, $errline, $errstr);
      error_log($msg, 3, LOG."/".date("Ym").".log");
      $_SESSION["error_msg"] = E_SERVER;
      header("Location: ".URL_ROOT."/error.php");
      exit;
      break;
    case E_NOTICE:
      break;
    default:
      $msg = sprintf("[%s] PHP LOG in %s on line %s : %s\n", date("Y/m/d H:i:s"), $errfile, $errline, $errstr);
      error_log($msg, 3, LOG."/".date("Ym").".log");
      break;
  }
}
?>
