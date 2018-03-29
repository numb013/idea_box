<?php
require_once("DefineParent.php");

class SettingMemberDef extends DefineParent {

  function SettingMember() {
  }

  var $value_list  = array(
                           "0",
                           "1",
                           "2",
                           "3"
                            );

  var $string_list = array(
                           "承認",
                           "保留",
                           "否定",
                           "放棄"
                           );
}
?>