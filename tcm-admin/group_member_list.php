<?php
error_reporting(E_ALL & ~E_NOTICE);

require_once("./_module/requires.php");
require_once("./login_check.php");
require_once("_define/TableCodeDef.php");  // テーブルID
require_once("_define/TrainingCodeDef.php");  // 研修コード
require_once("./_define/StatusTypeDef_2.php");//ステータス
require_once("./_define/StatusTypeDef_1.php");//ステータス
require_once("./_define/StatusTypeDef.php");//ステータス

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

$statustypeDef_2 = new StatusTypeDef_2();
$smarty->assign("statustypeDef_2", $statustypeDef_2);

$statustypeDef_1 = new StatusTypeDef_1();
$smarty->assign("statustypeDef_1", $statustypeDef_1);

$statustypeDef = new StatusTypeDef();
$smarty->assign("statustypeDef", $statustypeDef);

$trainingcodeDef = new TrainingCodeDef();
$smarty->assign("trainingcodeDef", $trainingcodeDef);



/**-------------------------------------------------------------------------------------------------
  リクエストより必要データ取得 & バリデーション
--------------------------------------------------------------------------------------------------*/

$group_id        = $_GET["group_id"];
$number          = $_GET["number"];
$approval_status = $_GET["approval_status"];
$status          = $_GET["status"];
$approval_flag   = $_GET["approval_flag"];
$paging          = $_GET["paging"];
$page            = $_GET["page"];

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

if (strlen($group_id)) {



/**-------------------------------------------------------------------------------------------------
  メイン処理
--------------------------------------------------------------------------------------------------*/

  // 件数取得 件数をrecord countに入れる
  $arg_map = $input_map;
  $arg_map["group_id"]        = $group_id;
  $arg_map["approval_status"] = $approval_status;
  $approval_status_1          = $approval_status;


  $sql = getSqlSelectCountMember($arg_map);
  $map = $dbFunctions->getMap($sql);

  // 一件もデータがない時にメッセージ表示するためにアサイン
  $smarty->assign("map", $map);

  // ページングリンク
  $paging_link = $util->getPagingLink($map["record_count"], $page, ADMIN_COUNT_PAGE, ADMIN_COUNT_LINK, URL_ROOT_HTTPS."/tcm-admin/group_member_list.php", "&group_id=$group_id&approval_status=$approval_status&number=$number");

  $smarty->assign("paging_link", $paging_link);

  // x件～x件 （x件中）
  $count_item = $util->getPagingInfo($map["record_count"], $page, ADMIN_COUNT_PAGE);
  $smarty->assign("count_item", $count_item);

  // データを取得
  $arg_map["offset"] = ($page - 1) * ADMIN_COUNT_PAGE;
  $arg_map["limit"]  = ADMIN_COUNT_PAGE;

  $arg_map["approval_status"] = $approval_status;

  $sql = getSqlSelectMember($arg_map);
  $group_member_list = $dbFunctions->getListIncludeMap($sql);

  // 処理から遷移して現在のページにデータがなければページを１戻す
  if (!is_array($group_member_list) AND $page >= 2 AND strlen($paging)) {
    $page = $page - 1;

    if ($paging == "status") {
      $approval_status = $_GET["approval_status"];
      header("Location: ".URL_ROOT."/tcm-admin/group_member_list.php?group_id=".$group_id."&approval_status=".$approval_status."&status=1&approval_flag=".$approval_flag."&page=".$page."&paging=status");
      exit();
    } else if ($paging == "delete") {
      $approval_status = $_GET["approval_status"];
      header("Location: ".URL_ROOT."/tcm-admin/group_member_list.php?group_id=".$group_id."&approval_status=".$approval_status."&page=".$page."&paging=delete");
      exit();
    }
  }

  $sql = getSqlSelectName($arg_map);
  $group_name_map = $dbFunctions->getMap($sql);
  $approval_status = $group_member_list[0]["approval_status"];

  // リストに表示するためアサイン
  $smarty->assign("page", $page);
  $smarty->assign("number", $number);
  $smarty->assign("group_id", $group_id);
  $smarty->assign("group_member_list", $group_member_list);
  $smarty->assign("group_name_map", $group_name_map);
  $smarty->assign("approval_status", $approval_status);
  $smarty->assign("approval_status_1", $approval_status_1);
  $smarty->assign("status", $status);
  $smarty->assign("setting", $setting);
  $smarty->assign("approval_flag", $approval_flag);

  $smarty->display(TEMPLATE_DIR."/admin/group_member_list.tpl");
  exit();

}



/**-------------------------------------------------------------------------------------------------
  SQL文
--------------------------------------------------------------------------------------------------*/

function getSqlSelectCountMember($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  count(group_id) AS record_count ";
  $sql.= "FROM ";
  $sql.= "member ";
  $sql.= "WHERE ";
  if (strlen($arg_map["group_id"])) {
    $sql.= "  group_id = ".intval($arg_map["group_id"])." AND ";
  }
  if (strlen($arg_map["approval_status"] == "1")) {
    $sql.= "  approval_status = ".intval($arg_map["approval_status"])." AND ";
  }
  if (strlen($arg_map["approval_status"] == "2")) {
    $sql.= "  approval_status = ".intval($arg_map["approval_status"])." AND ";
  }
  if (strlen($arg_map["approval_status"] == "3")) {
    $sql.= "  approval_status = ".intval($arg_map["approval_status"])." AND ";
  }
  $sql.= "delete_flag = '0'";
  return $sql;
}

function getSqlSelectMember($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  member.group_id, ";
  $sql.= "  member.member_id, ";
  $sql.= "  company, ";
  $sql.= "  member_name, ";
  $sql.= "  member.insert_datetime, ";
  $sql.= "  group1.insert_datetime AS group_insert_datetime, ";
  $sql.= "  group1.table_code, ";
  $sql.= "  group1.training_datetime, ";
  $sql.= "  mail_address, ";
  $sql.= "  training_code, ";
  $sql.= "  memo, ";
  $sql.= "  member.approval_status, ";
  $sql.= "  member.delete_flag ";
  $sql.= "FROM ";
  $sql.= "group1, member ";
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
  $sql.= "  member.delete_flag = '0' AND ";
  $sql.= "  group1.group_id = member.group_id ";
  $sql.= "LIMIT ".intval($arg_map["limit"])." OFFSET ".intval($arg_map["offset"]);

  return $sql;
}

function getSqlSelectName($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group_name ";
  $sql.= "FROM ";
  $sql.= "group1 ";
  $sql.= "WHERE ";
  if (strlen($arg_map["group_id"])) {
    $sql.= "  group_id = ".intval($arg_map["group_id"])." AND ";
  }
  $sql.= "  delete_flag = '0'";

  return $sql;
}

?>
