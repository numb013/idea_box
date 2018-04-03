<?php


ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );

error_reporting(E_ALL & ~E_NOTICE);

// 設定に関するファイルを読み込む。
require_once("./admin/_module/requires.php");
// require_once("./login_check.php");


mb_language("Japanese");
mb_internal_encoding("utf-8");

session_start();


/**-------------------------------------------------------------------------------------------------
  初期処理
--------------------------------------------------------------------------------------------------*/

// クラスのインスタンス化
$smarty      = new ChildSmarty();
$util        = new Util();
$checkUtil   = new CheckUtil();   // チェック関数で
$dbFunctions = new DBFunctions();




/**-------------------------------------------------------------------------------------------------
  リクエストより必要データ取得 & バリデーション
--------------------------------------------------------------------------------------------------*/

$mode = $_POST["mode"];   // postデータを$modeに受け取る



/**-------------------------------------------------------------------------------------------------
  メイン処理
--------------------------------------------------------------------------------------------------*/

  $user_map["shain_id"] = $_SESSION["login_map"]["shain_id"];

  switch ($user_map["shain_id"]){
  case 5:
    $admin_map['key'] = 1;
    break;
  case 36:
    $admin_map['key'] = 1;
    break;
  case 1:
    $admin_map['key'] = 1;
    break;
  case 2:
    $admin_map['key'] = 1;
    break;
  case 3:
    $admin_map['key'] = 1;
    break;
  default:
    $admin_map['key'] = 0;
  }

  // 戻った時に入力情報をセッションから取得
  $input_map = $_SESSION["input_map"];
  $smarty->assign("admin_map", $admin_map);
  $smarty->assign("user_map", $user_map);
  $smarty->assign("input_map", $input_map);



/**-----------------------------------------------------------------------------------------------
  初期処理
------------------------------------------------------------------------------------------------*/
  $_SESSION["input_map"] = null;
  $page          = $_GET["page"];
  $status        = $_GET["status"];
  $approval_flag = $_GET["approval_flag"];
  $paging        = $_GET["paging"];

  if ($page == "") {
    $page = 1;
  }

  $arg_map["offset"] = ($page - 1) * ADMIN_COUNT_PAGE;
  $arg_map["limit"]  = ADMIN_COUNT_PAGE;
  
  $sql = getSqlSelectIdea($arg_map);
  $idea_list = $dbFunctions->getListIncludeMap($sql);
  $sql = getSqlSelectCountIdea($arg_map);
  $map = $dbFunctions->getMap($sql);

  // x件～x件 （x件中）
  $count_item = $util->getPagingInfo($map["record_count"], $page, ADMIN_COUNT_PAGE);
  $smarty->assign("count_item", $count_item);
  // ページングリンク
  $paging_link = $util->getPagingLink($map["record_count"], $page, ADMIN_COUNT_PAGE, ADMIN_COUNT_LINK, URL_ROOT_HTTPS."/idea_list.php", "");
//$paging_link = $util->getPagingLink($map["record_count"], $page, ADMIN_COUNT_PAGE, ADMIN_COUNT_LINK, URL_ROOT_HTTPS."/admin/group_list.php", "");
  $smarty->assign("paging_link", $paging_link);
  $smarty->assign("idea_list", $idea_list);
  $smarty->display(TEMPLATE_DIR."/idea_list.tpl");
  exit();



function getSqlSelectIdea($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "id,";
  $sql.= "shain_id,";
  $sql.= "title,";
  $sql.= "body, ";
  $sql.= "insert_datetime ";
  $sql.= "FROM ";
  $sql.= "ideas ";
  $sql.= "WHERE ";
  $sql.= "approval_flag = '1' AND ";
  $sql.= "delete_flag = '0' ";
  $sql.= "ORDER BY insert_datetime DESC ";
  $sql.= "LIMIT ".intval($arg_map["limit"])." OFFSET ".intval($arg_map["offset"]);

  return $sql;
}

function getSqlSelectCountIdea($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= " count(id) AS record_count ";
  $sql.= "FROM ";
  $sql.= "ideas ";
  $sql.= "WHERE ";
  $sql.= "approval_flag = '1' AND ";
  $sql.= " delete_flag = '0'";

  return $sql;
}

?>