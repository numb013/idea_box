<?php

ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );


error_reporting(E_ALL & ~E_NOTICE);

require_once("./_module/requires.php");
require_once("./login_check.php");
require_once("./_define/TableCodeDef.php");  // テーブルID
require_once("./_define/TrainingCodeDef.php");  // 研修コード
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
$arg_map["limit"]  = 25;
$arg_map["id"]  = $_GET['id'];

$sql = getSqlSelectIdea($arg_map);
$idea_map = $dbFunctions->getListIncludeMap($sql);
$idea_map = $idea_map[0];

// リストに表示するためアサイン
$smarty->assign("idea_map", $idea_map);
$smarty->display(TEMPLATE_DIR."/admin/idea_detail.tpl");
exit();

/**-------------------------------------------------------------------------------------------------
  SQL文
--------------------------------------------------------------------------------------------------*/
function getSqlSelectIdea($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  id, ";
  $sql.= "  user_id, ";
  $sql.= "  title, ";
  $sql.= "  body, ";
  $sql.= "  created_at, ";
  $sql.= "  updated_at, ";
  $sql.= "  delete_flag ";
  $sql.= "FROM ";
  $sql.= "ideas ";
  $sql.= "WHERE ";
  $sql.= "  id = ".$arg_map["id"]. " AND";
  $sql.= "  delete_flag = '0' ";
  $sql.= " ORDER BY created_at DESC ";
  $sql.= "LIMIT ".intval($arg_map["limit"])." OFFSET ".intval($arg_map["offset"]);

  return $sql;
}


?>
