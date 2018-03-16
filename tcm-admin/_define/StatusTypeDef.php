<?php
require_once("DefineParent.php");

class StatusTypeDef extends DefineParent {

  function StatusTypeDef() {
  }

  var $value_list  = array(
                           "1",
//                           "2",
                           "3"
                            );

  var $string_list = array(
                           "承認待ち",
//                           "承認済み",
                           "非承認"
                           );
}
?>
