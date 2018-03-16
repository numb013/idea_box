<?php
error_reporting(E_ALL & ~E_NOTICE);

require_once("./_module/requires.php");
require_once("./login_check.php");
require_once("_define/TableCodeDef.php");  // テーブルID

require_once("_define/TrainingCodeDef.php");  // 研修コード

mb_language("Japanese");
mb_internal_encoding("UTF-8");

session_start();



/**-------------------------------------------------------------------------------------------------
  初期処理
--------------------------------------------------------------------------------------------------*/

$smarty = new ChildSmarty();

$util = new Util();

$dbFunctions = new DBFunctions();

$tablecodeDef = new TableCodeDef();
$smarty->assign("tablecodeDef", $tablecodeDef);

$trainingcodeDef = new TrainingCodeDef();
$smarty->assign("trainingcodeDef", $trainingcodeDef);



/**-----------------------------------------------------------------------------------------------
  CSV処理
------------------------------------------------------------------------------------------------*/

if ($_POST["mode"] == "download") {

  $input_map["approval_status"] = $_GET["approval_status"];
  $input_map["group_id"]        = $_POST["group_check"];

  // データを取得
  $arg_map = $input_map;

  $dbFunctions->executeBegin();
  for ($i = 0; $i < count($input_map["group_id"]); $i++) {
    $arg_map["group_id"] = $input_map["group_id"][$i];
    $sql = getSqlSelectMember($arg_map);
    $csv_member_list[] = $dbFunctions->getListIncludeMap($sql);
  }

  $dbFunctions->executeCommit();

  $csv_data.= 社名.",";
  $csv_data.= 氏名.",";
  $csv_data.= 研修日.",";
  $csv_data.= 研修コード.",";
  $csv_data.= テーブルID.",";
  $csv_data.= メールアドレス.",";
  $csv_data.= 備考テキスト;
  $csv_data.= "\n";

  $dbFunctions->executeBegin();
  for ($i = 0 ; $i < count($csv_member_list); $i++) {
    for ($j = 0; $j < count($csv_member_list[$i]); $j++) {
      $date = $csv_member_list[$i][$j]["training_datetime"];
      $training_datetime = date("Y-m-d", strtotime($date));
      $table_code = $tablecodeDef->getStringByValue($csv_member_list[$i][$j]["table_code"]);
      $training_code = $trainingcodeDef->getStringByValue($csv_member_list[$i][$j]["training_code"]);

      $csv_data.= "\"" .$csv_member_list[$i][$j]["company"]."\",";
      $csv_data.= "\"" .$csv_member_list[$i][$j]["member_name"]."\",";
      $csv_data.="\"" .$training_datetime."\","; 
      $csv_data.="\"" .$training_code."\","; 
      $csv_data.="\"" .$table_code."\",";
      $csv_data.= "\"" .$csv_member_list[$i][$j]["mail_address"]."\",";
      $csv_data.= "\"\t" .str_replace("\"", "\"\"", $csv_member_list[$i][$j]["memo"])."\",";
      $csv_data.="\n";
    }
  }
  $dbFunctions->executeCommit();

  $csv_file = "csv_". date("ymd") .".csv";
  $csv_data = mb_convert_encoding ( $csv_data , "sjis-win" , "utf-8" );
  header("Content-Type: application/octet-stream");
  header("Content-Disposition: attachment; filename={$csv_file}");
  echo($csv_data);
  exit();
  header("Location: ".URL_ROOT."/tcm-admin/group_list.php?page=".$page);
  exit();

} else if ($_GET["mode"] == "download") {

  $input_map["group_id"] = $_GET["group_id"];
  $input_map["approval_status"] = $_GET["approval_status"];

    // データを取得
  $arg_map = $input_map;

  $arg_map["group_id"] = $input_map["group_id"];
  $sql = getSqlSelectMember($arg_map);
  $csv_member_list = $dbFunctions->getListIncludeMap($sql);

  $csv_data.= 社名.",";
  $csv_data.= 氏名.",";
  $csv_data.= 研修日.",";
  $csv_data.= 研修コード.",";
  $csv_data.= テーブルID.",";
  $csv_data.= メールアドレス.",";
  $csv_data.= 備考テキスト;
  $csv_data.= "\n";

  $dbFunctions->executeBegin();
  for ($i = 0 ; $i < count($csv_member_list); $i++) {
    $date = $csv_member_list[$i]["training_datetime"];
    $training_datetime = date("Y-m-d", strtotime($date));
    $table_code = $tablecodeDef->getStringByValue($csv_member_list[$i]["table_code"]);
    $training_code = $trainingcodeDef->getStringByValue($csv_member_list[$i]["training_code"]);

    $csv_data.= "\"" .$csv_member_list[$i]["company"]."\",";
    $csv_data.= "\"" .$csv_member_list[$i]["member_name"]."\",";
    $csv_data.="\"" .$training_datetime."\","; 
    $csv_data.="\"" .$training_code."\","; 
    $csv_data.="\"" .$table_code."\",";
    $csv_data.= "\"" .$csv_member_list[$i]["mail_address"]."\",";
    $csv_data.= "\"\t" .str_replace("\"", "\"\"", $csv_member_list[$i]["memo"])."\",";
    $csv_data.="\n";
  }
  $dbFunctions->executeCommit();

  $csv_file = "csv_". date("ymd") .".csv";
  $csv_data = mb_convert_encoding ( $csv_data , "sjis-win" , "utf-8" );

  header("Content-Type: application/octet-stream");
  header("Content-Disposition: attachment; filename={$csv_file}");
  echo($csv_data);
  exit();
  header("Location: ".URL_ROOT."/tcm-admin/group_list.php?page=".$page);
  exit();
}



/**-------------------------------------------------------------------------------------------------
  SQL文
--------------------------------------------------------------------------------------------------*/

function getSqlSelectMember($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  member.group_id, ";
  $sql.= "  member.member_id, ";
  $sql.= "  company, ";
  $sql.= "  member_name, ";
  $sql.= "  training_datetime, ";
  $sql.= "  training_code, ";
  $sql.= "  member.insert_datetime, ";
  $sql.= "  group1.insert_datetime, ";
  $sql.= "  group1.table_code, ";
  $sql.= "  mail_address, ";
  $sql.= "  memo, ";
  $sql.= "  member.approval_status, ";
  $sql.= "  member.delete_flag ";
  $sql.= "FROM ";
  $sql.= " group1, member ";
  $sql.= "WHERE ";
  if (strlen($arg_map["group_id"])) {
    $sql.= "  member.group_id = ".intval($arg_map["group_id"])." AND ";
  }
  if (strlen($arg_map["approval_status"] == "1")) {
    $sql.= "  member.approval_status = ".intval($arg_map["approval_status"])." AND ";
  }
  if (strlen($arg_map["approval_status"] == "2")) {
    $sql.= "  member.approval_status = ".intval($arg_map["approval_status"])." AND ";
  }
  if (strlen($arg_map["approval_status"] == "3")) {
    $sql.= "  member.approval_status = ".intval($arg_map["approval_status"])." AND ";
  }
  $sql.= " member.delete_flag = '0' AND ";
  $sql.= " group1.group_id = member.group_id";

  return $sql;
}

?>
