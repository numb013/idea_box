<?php
error_reporting(E_ALL & ~E_NOTICE);

require_once("./_module/requires.php");
require_once("./login_check.php");
require_once("_define/TableCodeDef.php");  // テーブルID
require_once("_define/TrainingCodeDef.php");  // 研修コード
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

$statustypeDef = new StatusTypeDef();
$smarty->assign("statustypeDef", $statustypeDef);

$trainingcodeDef = new TrainingCodeDef();
$smarty->assign("trainingcodeDef", $trainingcodeDef);



/**-------------------------------------------------------------------------------------------------
  リクエストより必要データ取得 & バリデーション
--------------------------------------------------------------------------------------------------*/

// ページ
$page          = $_GET["page"];
$status        = $_GET["status"];
$paging        = $_GET["paging"];
$approval_flag = $_GET["approval_flag"];

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

$smarty->assign("page", $page);



/**-------------------------------------------------------------------------------------------------
  メイン処理
--------------------------------------------------------------------------------------------------*/

// データを取得
$arg_map["offset"] = ($page - 1) * ADMIN_COUNT_PAGE;
$arg_map["limit"]  = ADMIN_COUNT_PAGE;

$sql = getSqlSelectMember($arg_map);
$member_list = $dbFunctions->getListIncludeMap($sql);

// 処理から遷移して現在のページにデータがなければページを１戻す
if (!is_array($member_list) AND $page >= 2 AND strlen($paging)) {

  $page = $page - 1;

  if ($paging == "status") {
    header("Location: ".URL_ROOT."/tcm-admin/member_non_admitted_list.php?status=1&approval_flag=".$approval_flag."&page=".$page."&paging=status");
    exit();
  } else if ($paging == "delete") {
    header("Location: ".URL_ROOT."/tcm-admin/member_non_admitted_list.php?page=".$page."&paging=delete");
    exit();
  }
}

// 件数取得 件数をrecord countに入れる
$arg_map = $input_map;
$sql = getSqlSelectCountMember($arg_map);
$map = $dbFunctions->getMap($sql);

// 一件もデータがない時にメッセージ表示するためにアサイン
$smarty->assign("map", $map);

// ページングリンク
$paging_link = $util->getPagingLink($map["record_count"], $page, ADMIN_COUNT_PAGE, ADMIN_COUNT_LINK, URL_ROOT_HTTPS."/tcm-admin/member_non_admitted_list.php", "");
$smarty->assign("paging_link", $paging_link);

// x件～x件 （x件中）
$count_item = $util->getPagingInfo($map["record_count"], $page, ADMIN_COUNT_PAGE);

$smarty->assign("count_item", $count_item);

// リストに表示するためアサイン
$smarty->assign("member_list", $member_list);
$smarty->assign("status", $status);
$smarty->assign("approval_flag", $approval_flag);

$smarty->display(TEMPLATE_DIR."/admin/member_non_admitted_list.tpl");

exit();



/**-------------------------------------------------------------------------------------------------
  SQL文
--------------------------------------------------------------------------------------------------*/

function getSqlSelectCountMember($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  count(member_id) AS record_count ";
  $sql.= "FROM ";
  $sql.= " member ";
  $sql.= "WHERE ";
  $sql.= "  delete_flag = '0' AND ";
  $sql.= "  approval_status = '3' ";

  return $sql;
}

function getSqlSelectMember($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  member.group_id, ";
  $sql.= "  member.member_id, ";
  $sql.= "  company, ";
  $sql.= "  member_name, ";
  $sql.= "  group_name, ";
  $sql.= "  member.insert_datetime, ";
  $sql.= "  group1.insert_datetime, ";
  $sql.= "  group1.table_code, ";
  $sql.= "  training_code, ";
  $sql.= "  mail_address, ";
  $sql.= "  member.approval_status, ";
  $sql.= "  member.delete_flag ";
  $sql.= "FROM ";
  $sql.= " group1, member ";
  $sql.= "WHERE ";
  $sql.= "  member.delete_flag = '0' AND ";
  $sql.= "  member.approval_status = '3' AND ";
  $sql.= "  group1.group_id = member.group_id ";
  $sql.= "ORDER BY member.insert_datetime DESC ";
  $sql.= "LIMIT ".intval($arg_map["limit"])." OFFSET ".intval($arg_map["offset"]);

  return $sql;
}

?>
