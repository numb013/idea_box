<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty plugin
 *
 * Type:     modifier<br>
 * Name:     nl2br<br>
 * Date:     Feb 26, 2003
 * Purpose:  convert \r\n, \r or \n to <<br>>
 * Input:<br>
 *         - contents = contents to replace
 *         - preceed_test = if true, includes preceeding break tags
 *           in replacement
 * Example:  {$text|nl2br}
 * @link http://smarty.php.net/manual/en/language.modifier.nl2br.php
 *          nl2br (Smarty online manual)
 * @version  1.0
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @return string
 */
function smarty_modifier_get_yobi($string)
{
    if ($string == "0") {
      return "��";
      exit();
    } else if ($string == "1") {
      return "��";
      exit();
    } else if ($string == "2") {
      return "��";
      exit();
    } else if ($string == "3") {
      return "��";
      exit();
    } else if ($string == "4") {
      return "��";
      exit();
    } else if ($string == "5") {
      return "��";
      exit();
    } else if ($string == "6") {
      return "��";
      exit();
    }
}

/* vim: set expandtab: */

?>
