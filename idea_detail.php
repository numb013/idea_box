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


  // 戻った時に入力情報をセッションから取得

  $user_map["shain_id"] = $_SESSION["login_map"]["shain_id"];
  // 戻った時に入力情報をセッションから取得
  $smarty->assign("user_map", $user_map);

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

  $arg_map["id"]  = $_GET["id"];
  $sql = getSqlSelectSinglIdea($arg_map);
  $idea_map = $dbFunctions->getListIncludeMap($sql);
  $idea_map = $idea_map[0];




  $smarty->assign("idea_map", $idea_map);
  $smarty->display(TEMPLATE_DIR."/idea_detail.tpl");
  exit();


function getSqlSelectSinglIdea($arg_map) {
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
  $sql.= "id = ".$arg_map["id"]." AND ";
  $sql.= "delete_flag = '0' ";
  $sql.= "ORDER BY insert_datetime DESC ";
  return $sql;
}

function getSqlSelectCountIdea($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= " count(id) AS record_count ";
  $sql.= "FROM ";
  $sql.= "ideas ";
  $sql.= "WHERE ";
  $sql.= " delete_flag = '0'";

  return $sql;
}

?>