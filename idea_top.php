<?php

ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );
error_reporting(E_ALL & ~E_NOTICE);
require_once("tcm-admin/_module/requires.php");
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

if ($mode == "back") {
/**-----------------------------------------------------------------------------------------------
  戻る
------------------------------------------------------------------------------------------------*/
  $user_map["shain_id"] = $_SESSION["login_map"]["shain_id"];
  // 戻った時に入力情報をセッションから取得
  $input_map = $_SESSION["input_map"];
  $smarty->assign("user_map", $user_map);
  $smarty->assign("input_map", $input_map);
  $smarty->display(TEMPLATE_DIR."/idea_top.tpl");
  exit();

} else {
/**-----------------------------------------------------------------------------------------------
  初期処理
------------------------------------------------------------------------------------------------*/
  $_SESSION["input_map"] = null;

  //$arg_map["offset"] = ($page - 1) * ADMIN_COUNT_PAGE;
  $arg_map["limit"]  = 5;
  
  $sql = getSqlSelectIdea($arg_map);
  $idea_list = $dbFunctions->getListIncludeMap($sql);
  
  $smarty->assign("idea_list", $idea_list);
  $smarty->display(TEMPLATE_DIR."/idea_top.tpl");
  exit();

}

function getSqlSelectIdea($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "id,";
  $sql.= "user_id,";
  $sql.= "title,";
  $sql.= "body, ";
  $sql.= "created_at ";
  $sql.= "FROM ";
  $sql.= "ideas ";
  $sql.= "WHERE ";
  $sql.= "approval_flag = '1' AND ";
  $sql.= "delete_flag = '0' ";
  $sql.= "ORDER BY created_at DESC ";
  $sql.= "LIMIT ".intval($arg_map["limit"])." OFFSET ".intval($arg_map["offset"]);
  return $sql;
}



?>