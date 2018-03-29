<?php
class SqlExecution {

  function SqlExecution() {
  }

  /**
   * クエリを実行します。
   */
  function mysql_query($connection, $query) {
    if (!$res = mysql_query($query, $connection)) {
      $array = debug_backtrace();
      for ($cnt = 0; $cnt < count($array); $cnt++) {
        print($array[$cnt]["file"]."(".$array[$cnt]["line"].")<br>");
      }
      print($query."<br>");
      mysql_query("ROLLBACK", $connection);
echo mysql_error($connection);
      trigger_error("", E_USER_ERROR);
    }
    return $res;
  }

}
?>