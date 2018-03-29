<?php
function smarty_modifier_mobile($string, $char_set = "EUC-JP")
{
  return mb_convert_kana($string, "ka", $char_set);
}
?>