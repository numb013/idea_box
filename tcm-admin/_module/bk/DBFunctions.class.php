<?php
class dbFunctions {



  var $dbconn;
  var $sqlExecution;



  function dbFunctions() {
    $dbConnect          = new DBConnect();
    $this->dbconn       = $dbConnect->getDBConnect(SERVER, USERNAME, PASSWORD, DATABASE_NAME);
    $this->sqlExecution = new SqlExecution();
  }

  /**
   * 
   * @return void
   */
  function executeBegin() {
    $this->sqlExecution->mysql_query($this->dbconn, "BEGIN");
  }

  /**
   * 
   * @return void
   */
  function executeCommit() {
    $this->sqlExecution->mysql_query($this->dbconn, "COMMIT");
  }

  /**
   * 
   * @return void
   */
  function executeRollback() {
    $this->sqlExecution->mysql_query($this->dbconn, "ROLLBACK");
  }

  function mysql_query($sql) {
    $result = $this->sqlExecution->mysql_query($this->dbconn, $sql);
//    $result = $this->sqlExecution->mysql_query($this->dbconn, mb_convert_encoding($sql, "UTF-8", "EUC-JP"));
  }

  function mysql_query_mobile($sql) {
//    $result = $this->sqlExecution->mysql_query($this->dbconn, $sql);
    $result = $this->sqlExecution->mysql_query($this->dbconn, $sql);
  }

  function getMap($sql) {
    $res = $this->sqlExecution->mysql_query($this->dbconn, $sql);
    if (mysql_num_rows($res)) {
      $row = mysql_fetch_array($res, MYSQL_ASSOC);
      $field_array = array_keys($row);
      for ($cnt = 0; $cnt < count($field_array); $cnt++) {
//        $eval_str = "\$array"."[\"".$field_array[$cnt]."\"] = mb_convert_encoding(\$row[\"".$field_array[$cnt]."\"], \"EUC-JP\", \"UTF-8\");";
        $eval_str = "\$array"."[\"".$field_array[$cnt]."\"] = mb_convert_encoding(\$row[\"".$field_array[$cnt]."\"], \"UTF-8\", \"UTF-8\");";
        eval($eval_str);
      }
    }

    return $array;
  }

  function getList($sql) {
    $res = $this->sqlExecution->mysql_query($this->dbconn, $sql);
    $i = 0;
    while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
      if ($i == 0) {
        $field_array = array_keys($row);
      }
      for ($cnt = 0; $cnt < count($field_array); $cnt++) {
        $eval_str = "\$array[$i] = \$row[\"".$field_array[$cnt]."\"];";
        eval($eval_str);
      }
      $i++;
    }

    return $array;
  }

  function getListIncludeMap($sql) {
    $res = $this->sqlExecution->mysql_query($this->dbconn, $sql);
    $i = 0;
    while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
      if ($i == 0) {
        $field_array = array_keys($row);
      }
      for ($cnt = 0; $cnt < count($field_array); $cnt++) {
        $eval_str = "\$array[$i]"."[\"".$field_array[$cnt]."\"] = \$row[\"".$field_array[$cnt]."\"];";
//        $eval_str = "\$array[$i]"."[\"".$field_array[$cnt]."\"] = mb_convert_encoding(\$row[\"".$field_array[$cnt]."\"], \"EUC-JP\", \"UTF-8\");";
        eval($eval_str);
      }
      $i++;
    }

    return $array;
  }



  function makeArrayForSelectBox($res) {
    $i = 0;
    while ($row = mysql_fetch_array($res, MYSQL_NUM)) {
      $array[$i][0] = $row[0];
      $array[$i][1] = $row[1];
      $i++;
    }

    return $array;
  }



  function getSelectBoxList($sql) {
    $res = $this->sqlExecution->mysql_query($this->dbconn, $sql);
    $i = 0;
    while ($row = mysql_fetch_array($res, MYSQL_NUM)) {
      $array[$i][0] = $row[0];
      $array[$i][1] = $row[1];
      $i++;
    }

    return $array;
  }



  function getMapMobile($sql) {
    $res = $this->sqlExecution->mysql_query($this->dbconn, $sql);
    if (mysql_num_rows($res)) {
      $row = mysql_fetch_array($res, MYSQL_ASSOC);
      $field_array = array_keys($row);
      for ($cnt = 0; $cnt < count($field_array); $cnt++) {
        $eval_str = "\$array"."[\"".$field_array[$cnt]."\"] = mb_convert_encoding(\$row[\"".$field_array[$cnt]."\"], \"SJIS\", \"UTF-8\");";

        eval($eval_str);
      }
    }

    return $array;
  }

  function getListMobile($sql) {
    $res = $this->sqlExecution->mysql_query($this->dbconn, $sql);
    $i = 0;
    while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
      if ($i == 0) {
        $field_array = array_keys($row);
      }
      for ($cnt = 0; $cnt < count($field_array); $cnt++) {
        $eval_str = "\$array[$i] = mb_convert_encoding(\$row[\"".$field_array[$cnt]."\"], \"SJIS\", \"UTF-8\");";
        eval($eval_str);
      }
      $i++;
    }

    return $array;
  }

  function getListIncludeMapMobile($sql) {
    $res = $this->sqlExecution->mysql_query($this->dbconn, $sql);
    $i = 0;
    while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
      if ($i == 0) {
        $field_array = array_keys($row);
      }
      for ($cnt = 0; $cnt < count($field_array); $cnt++) {
        $eval_str = "\$array[$i]"."[\"".$field_array[$cnt]."\"] = mb_convert_encoding(\$row[\"".$field_array[$cnt]."\"], \"SJIS\", \"UTF-8\");";
        eval($eval_str);
      }
      $i++;
    }

    return $array;
  }

  function getMapUser($sql) {
    $res = $this->sqlExecution->mysql_query($this->dbconn, $sql);
    if (mysql_num_rows($res)) {
      $row = mysql_fetch_array($res, MYSQL_ASSOC);
      $field_array = array_keys($row);
      for ($cnt = 0; $cnt < count($field_array); $cnt++) {
        $eval_str = "\$array"."[\"".$field_array[$cnt]."\"] = mb_convert_encoding(\$row[\"".$field_array[$cnt]."\"], \"UTF8\", \"EUC-JP\");";

        eval($eval_str);
      }
    }

    return $array;
  }

  function getListUser($sql) {
    $res = $this->sqlExecution->mysql_query($this->dbconn, $sql);
    $i = 0;
    while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
      if ($i == 0) {
        $field_array = array_keys($row);
      }
      for ($cnt = 0; $cnt < count($field_array); $cnt++) {
        $eval_str = "\$array[$i] = mb_convert_encoding(\$row[\"".$field_array[$cnt]."\"], \"UTF8\", \"EUC-JP\");";
        eval($eval_str);
      }
      $i++;
    }

    return $array;
  }

  function getListIncludeMapUser($sql) {
    $res = $this->sqlExecution->mysql_query($this->dbconn, $sql);
    $i = 0;
    while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
      if ($i == 0) {
        $field_array = array_keys($row);
      }
      for ($cnt = 0; $cnt < count($field_array); $cnt++) {
        $eval_str = "\$array[$i]"."[\"".$field_array[$cnt]."\"] = mb_convert_encoding(\$row[\"".$field_array[$cnt]."\"], \"UTF8\", \"EUC-JP\");";
        eval($eval_str);
      }
      $i++;
    }

    return $array;
  }

/**---------------------------------------------------------------------------------------------------------------------
  セレクトボックス
----------------------------------------------------------------------------------------------------------------------*/

  /**
   * クライアントセレクトボックス
   */
  function getSelectBoxMsClient() {
    $sql = "";
    $sql.= "SELECT ";
    $sql.= "  client_id, ";
    $sql.= "  client_name ";
    $sql.= "FROM ";
    $sql.= "  ms_client ";
    $sql.= "ORDER BY ";
    $sql.= "  client_id ";

    $res = $this->sqlExecution->mysql_query($this->dbconn, $sql);

    return $this->makeArrayForSelectBox($res);
  }
  
  function closeDBConnect() {
    $dbConnect          = new DBConnect();
    $dbConnect->closeDBConnect();
  }
}
?>