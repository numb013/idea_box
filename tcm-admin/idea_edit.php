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

if ($_GET['id']) {

  // データを取得
  $arg_map["offset"] = ($page - 1) * ADMIN_COUNT_PAGE;
  $arg_map["limit"]  = 25;
  $arg_map["id"]  = $_GET['id'];

  $sql = getSqlSelectIdea($arg_map);
  $idea_map = $dbFunctions->getListIncludeMap($sql);
  $idea_map = $idea_map[0];

  // リストに表示するためアサイン
  $smarty->assign("idea_map", $idea_map);
  $smarty->assign('approval', array(
       0 => '非承認',
       1 => '承認済み'));

  $smarty->display(TEMPLATE_DIR."/admin/idea_edit.tpl");
  exit();

} elseif ($_POST['id']) {
    $input_map            = null;
    $input_map["id"]   = $_POST["id"];
    $input_map["title"]   = $_POST["title"];
    $input_map["body"]    = $_POST["body"];
    $input_map["approval_flag"] = $_POST["approval_flag"];
    $input_map["update_datetime"] = date("Y/m/d H:i:s");
    $input_map["delete_flag"] = 0;



    $arg_map  = $input_map;
    $sql = getSqlUpdateIdea($arg_map);
    $dbFunctions->mysql_query($sql);

    // データを取得
    $arg_map["offset"] = ($page - 1) * ADMIN_COUNT_PAGE;
    $arg_map["limit"]  = 25;

    $sql = getSqlSelectIdeaAll($arg_map);
    $idea_list = $dbFunctions->getListIncludeMap($sql);

    // 件数取得 件数をrecord countに入れる
    $arg_map = $input_map;
    $sql = getSqlSelectCountIdea($arg_map);
    $map = $dbFunctions->getMap($sql);
    // 一件もデータがない時にメッセージ表示するためにアサイン
    $smarty->assign("map", $map);

    // ページングリンク
    $paging_link = $util->getPagingLink($map["record_count"], $page, 25, ADMIN_COUNT_LINK, URL_ROOT_HTTPS."/tcm-admin/idea_list.php", "");
    $smarty->assign("paging_link", $paging_link);

    // x件～x件 （x件中）
    $count_idea = $util->getPagingInfo($map["record_count"], $page, 25);
    $smarty->assign("count_idea", $count_idea);

    $smarty->assign('approval', array(
           0 => '非承認',
           1 => '承認済み'));

    // リストに表示するためアサイン
    $smarty->assign("idea_list", $idea_list);
    $smarty->assign("page", $page);

    $smarty->display(TEMPLATE_DIR."/admin/idea_list.tpl");
    exit();
}


/**-------------------------------------------------------------------------------------------------
  SQL文
--------------------------------------------------------------------------------------------------*/

function getSqlSelectCountIdea($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= " count(id) AS record_count ";
  $sql.= "FROM ";
  $sql.= "ideas ";
  $sql.= "WHERE ";
  $sql.= " delete_flag = '0' ";

  return $sql;
}
function getSqlSelectIdeaAll($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  id, ";
  $sql.= "  shain_id, ";
  $sql.= "  title, ";
  $sql.= "  body, ";
  $sql.= "  approval_flag, ";
  $sql.= "  insert_datetime, ";
  $sql.= "  update_datetime, ";
  $sql.= "  delete_flag ";
  $sql.= "FROM ";
  $sql.= "ideas ";
  $sql.= "WHERE ";
  $sql.= "  delete_flag = '0' ";
  $sql.= " ORDER BY insert_datetime DESC ";
  $sql.= "LIMIT ".intval($arg_map["limit"])." OFFSET ".intval($arg_map["offset"]);

  return $sql;
}


function getSqlSelectIdea($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  id, ";
  $sql.= "  shain_id, ";
  $sql.= "  title, ";
  $sql.= "  body, ";
  $sql.= "  approval_flag, ";
  $sql.= "  insert_datetime, ";
  $sql.= "  update_datetime, ";
  $sql.= "  delete_flag ";
  $sql.= "FROM ";
  $sql.= "ideas ";
  $sql.= "WHERE ";
  $sql.= "  id = ".$arg_map["id"]. " AND";
  $sql.= "  delete_flag = '0' ";
  $sql.= " ORDER BY insert_datetime DESC ";
  $sql.= "LIMIT ".intval($arg_map["limit"])." OFFSET ".intval($arg_map["offset"]);

  return $sql;
}


function getSqlUpdateIdea($arg_map) {
  $sql = "";
  $sql.= "UPDATE ideas SET ";
  $sql.= "  title = '".$arg_map["title"]."'  ,";
  $sql.= "  body = '".$arg_map["body"]."'  ,";
  $sql.= "  approval_flag = '".$arg_map["approval_flag"]."'  ,";
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."'  ";
  $sql.= "WHERE ";
  $sql.= "  id = ".intval($arg_map["id"])." AND ";
  $sql.= "  delete_flag = '0'";
  return $sql;
}


?>
