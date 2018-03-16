<?php
error_reporting(E_ALL & ~E_NOTICE);

require_once("./_module/requires.php");
require_once("./login_check.php");
require_once("_define/TableCodeDef.php");  // テーブルID
require_once("./_define/StatusTypeDef_1.php");//ステータス
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

$statustypeDef_1 = new StatusTypeDef_1();
$smarty->assign("statustypeDef_1", $statustypeDef_1);

$trainingcodeDef = new TrainingCodeDef();
$smarty->assign("trainingcodeDef", $trainingcodeDef);



/**-------------------------------------------------------------------------------------------------
  リクエストより必要データ取得 & バリデーション
--------------------------------------------------------------------------------------------------*/

$input_map["member_id"] = $_GET["member_id"];
$input_map["group_id"]  = $_GET["group_id"];

// ページ
$page = $_GET["page"];

if ($page == "") {
  $page = 1;
}

if ($page !== 0) {
  if (!is_numeric($page)) {
    $util->echoString(ページ表示できません);
    exit();
  }
}

if ($page < 0) {
  $util->echoString(ページ表示できません);
  exit();
}

if ($page == 0) {
  $page = 1;
}

if (strlen($page) >= 9 ) {
  $util->echoString(ページ表示できません);
  exit();
}



/**-------------------------------------------------------------------------------------------------
  メイン処理
--------------------------------------------------------------------------------------------------*/

$arg_map["member_id"] = $input_map["member_id"];
$sql = getSqlSelectMember($arg_map);
$group_member_map = $dbFunctions->getMap($sql);

$arg_map["group_id"] = $input_map["group_id"];
$sql = getSqlSelectName($arg_map);
$group_name_map  = $dbFunctions->getMap($sql);
$approval_status = $group_member_map["approval_status"];

// tplに表示するためアサイン
$smarty->assign("page", $page);
$smarty->assign("group_member_map", $group_member_map);
$smarty->assign("group_name_map", $group_name_map);
$smarty->assign("approval_status", $approval_status);

$smarty->display(TEMPLATE_DIR."/admin/member_date.tpl");

exit();



/**-------------------------------------------------------------------------------------------------
  SQL文
--------------------------------------------------------------------------------------------------*/

function getSqlSelectMember($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  member.group_id, ";
  $sql.= "  member.member_id, ";
  $sql.= "  group1.training_datetime, ";
  $sql.= "  company, ";
  $sql.= "  member_name, ";
  $sql.= "  member.insert_datetime, ";
  $sql.= "  group1.insert_datetime, ";
  $sql.= "  group1.table_code, ";
  $sql.= "  group1.training_code, ";
  $sql.= "  mail_address, ";
  $sql.= "  memo, ";
  $sql.= "  member.approval_status, ";
  $sql.= "  member.delete_flag ";
  $sql.= "FROM ";
  $sql.= "  group1, member ";
  $sql.= "WHERE ";
  if (strlen($arg_map["member_id"])) {
    $sql.=  "  member.member_id = ".intval($arg_map["member_id"])." AND ";
  }
  $sql.= " member.delete_flag = '0' AND ";
  $sql.= " group1.group_id = member.group_id";

  return $sql;
}

function getSqlSelectName($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group_name ";
  $sql.= "FROM ";
  $sql.= " group1 ";
  $sql.= "WHERE ";
  if (strlen($arg_map["group_id"])) {
    $sql.=  "  group_id = ".intval($arg_map["group_id"])." AND ";
  }
  $sql.= "  delete_flag = '0'";

  return $sql;
}

?>
