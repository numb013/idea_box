<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


function smarty_modifier_yobi_tsuika($string)
{
  $string = preg_replace("/\-/", "/", $string);
  $return_string = $string;
  if (preg_match("/^[0-9]{4}\/[0-9]{2}\/[0-9]{2}$/", $string)) {
    $temp_array = explode("/", $string);
    if (checkdate($temp_array[1], $temp_array[2], $temp_array[0])) {
      $i = date("w", strtotime($string));
      $yobi_array = array("(日)", "(月)", "(火)", "(水)", "(木)", "(金)", "(土)");
      $yobi = $yobi_array[$i];
      $return_string = $yobi;
    }
  }
  return $return_string;
}



?>
