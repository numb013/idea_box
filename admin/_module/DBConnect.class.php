<?php
class DBConnect {

  var $dbconn;

  function DBConnect() {
  }

  /**
   * データベース接続オブジェクトを作成し返します。
   */
  function getDBConnect($server, $username, $password, $database_name) {
//$server = $server.":3307";
    $this->dbconn = mysql_connect($server, $username, $password);
    mysql_query("SET NAMES utf8", $this->dbconn);
    mysql_select_db($database_name, $this->dbconn);
    return $this->dbconn;
  }

  function closeDBConnect() {
    if ($this->dbconn != null) {
      mysql_close($this->dbconn);
    }
  }

}
?>