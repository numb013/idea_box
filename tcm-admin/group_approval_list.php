<?php
error_reporting(E_ALL & ~E_NOTICE);

require_once("./_module/requires.php");
require_once("./login_check.php");
require_once("_define/TableCodeDef.php");  // テーブルID
require_once("_define/TrainingCodeDef.php");  // 研修コード
require_once("./_define/StatusTypeDef_2.php");  //ステータス

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

$trainingcodeDef = new TrainingCodeDef();
$smarty->assign("trainingcodeDef", $trainingcodeDef);



/**-------------------------------------------------------------------------------------------------
  リクエストより必要データ取得 & バリデーション
--------------------------------------------------------------------------------------------------*/

// ページ
$page          = $_GET["page"];
$status        = $_GET["status"];
$approval_flag = $_GET["approval_flag"];
$paging        = $_GET["paging"];

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

// データを取得
$arg_map["offset"] = ($page - 1) * ADMIN_COUNT_PAGE;
$arg_map["limit"]  = ADMIN_COUNT_PAGE;

$sql = getSqlSelectGroup($arg_map);
$group_list = $dbFunctions->getListIncludeMap($sql);

// 処理から遷移して現在のページにデータがなければページを１戻す
if (!is_array($group_list) AND $page >= 2 AND strlen($paging)) {

  $page = $page - 1;

  if ($paging == "status") {
    header("Location: ".URL_ROOT."/tcm-admin/group_approval_list.php?status=1&approval_flag=".$approval_flag."&paging=status&page=".$page);
    exit();
  } else if ($paging == "delete") {
    header("Location: ".URL_ROOT."/tcm-admin/group_approval_list.php?page=".$page."&paging=delete");
    exit();
  }
}

// 件数取得 件数をrecord countに入れる
$arg_map = $input_map;
$sql = getSqlSelectCountGroup($arg_map);
$map = $dbFunctions->getMap($sql);

// 一件もデータがない時にメッセージ表示するためにアサイン
$smarty->assign("map", $map);

// ページングリンク
$paging_link = $util->getPagingLink($map["record_count"], $page, ADMIN_COUNT_PAGE, ADMIN_COUNT_LINK, URL_ROOT_HTTPS."/tcm-admin/group_approval_list.php", "");
$smarty->assign("paging_link", $paging_link);

// x件～x件 （x件中）
$count_item = $util->getPagingInfo($map["record_count"], $page, ADMIN_COUNT_PAGE);

$smarty->assign("count_item", $count_item);

//リストの参加人数取得
for ($i = 0; $i < count($group_list); $i++) {
  $arg_map["group_id"] = $group_list[$i]["group_id"];
  $sql = getSqlSelectCountMember($arg_map);
  $member_count = $dbFunctions->getMap($sql);
  $group_list[$i]["group_number"] = $member_count["record_count"];
}

$approval_status = $group_list[0]["approval_status"];

// リストに表示するためアサイン
$smarty->assign("group_list", $group_list);
$smarty->assign("approval_status", $approval_status);
$smarty->assign("status", $status);
$smarty->assign("approval_flag", $approval_flag);
$smarty->assign("page", $page);

$smarty->display(TEMPLATE_DIR."/admin/group_approval_list.tpl");

exit();



/**-------------------------------------------------------------------------------------------------
  SQL文
--------------------------------------------------------------------------------------------------*/

function getSqlSelectCountGroup($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= " count(group_id) AS record_count ";
  $sql.= "FROM ";
  $sql.= "group1 ";
  $sql.= "WHERE ";
  $sql.= " approval_status = '2' AND ";
  $sql.= " delete_flag = '0' ";

  return $sql;
}

function getSqlSelectGroup($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group_id, ";
  $sql.= "  group_name, ";
  $sql.= "  insert_datetime, ";
  $sql.= "  training_code, ";
  $sql.= "  table_code, ";
  $sql.= "  mailing_list_address, ";
  $sql.= "  approval_status, ";
  $sql.= "  delete_flag ";
  $sql.= "FROM ";
  $sql.= "group1 ";
  $sql.= "WHERE ";
  $sql.= " delete_flag = '0' AND ";
  $sql.= " approval_status = '2' ";
  $sql.= "ORDER BY insert_datetime DESC ";
  $sql.= "LIMIT ".intval($arg_map["limit"])." OFFSET ".intval($arg_map["offset"]);

  return $sql;
}

function getSqlSelectCountMember($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  count(group_id) AS record_count ";
  $sql.= "FROM ";
  $sql.= "member ";
  $sql.= "WHERE ";
  if (strlen($arg_map["group_id"])) {
    $sql.=  "  group_id = ".intval($arg_map["group_id"])." AND ";
  }
  $sql.= "  approval_status = '2' AND ";
  $sql.= "  delete_flag = '0' ";

  return $sql;
}

?>
