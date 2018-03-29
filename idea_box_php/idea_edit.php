<?php
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );


//error_reporting(E_ALL & ~E_NOTICE);

require_once("../admin/_module/requires.php");


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
if (!empty($_POST["mode"])) {  // postデータを$modeに受け取る
  $mode = $_POST["mode"];
} else {
  $mode = '';
}

/**-------------------------------------------------------------------------------------------------
  メイン処理
--------------------------------------------------------------------------------------------------*/

if ($mode == "edit") {
/**-----------------------------------------------------------------------------------------------
  登録
------------------------------------------------------------------------------------------------*/

  $user_map["shain_id"] = $_SESSION["login_map"]["shain_id"];
  // 戻った時に入力情報をセッションから取得
  $input_map = $_SESSION["input_map"];
  $smarty->assign("user_map", $user_map);

  $input_map            = null;
  $input_map["id"]   = $_POST["id"];
  $input_map["title"]   = $_POST["title"];
  $input_map["body"]    = $_POST["body"];
  $input_map["approval_flag"]    = $_POST["approval_flag"];
  $input_map["update_datetime"] = date("Y/m/d H:i:s");
  $input_map["delete_flag"] = 0;

  $error_map = input_check($input_map);
  if (is_array($error_map)) {
    // エラー表示
    $smarty->assign("error_map", $error_map);
    $idea_map = $_SESSION["input_map"];
    $smarty->assign("idea_map", $idea_map);
    $smarty->assign('approval', array(
           0 => '非承認',
           1 => '承認済み'));
    $smarty->display(TEMPLATE_DIR."/idea_box_tpl/idea_edit.tpl");
    exit();
  } else {
    $arg_map  = $input_map;
    $sql = getSqlUpdateIdea($arg_map);
    $dbFunctions->mysql_query($sql);

    $arg_map["limit"]  = 5;
    $sql = getSqlSelectIdea($arg_map);
    $idea_list = $dbFunctions->getListIncludeMap($sql);

    $smarty->assign("idea_list", $idea_list);
    $smarty->display(TEMPLATE_DIR."/idea_box_tpl/idea_top.tpl");
    exit();
  }

} else {
  $arg_map["id"]  = $_GET["id"];
  $sql = getSqlSelectSinglIdea($arg_map);
  $idea_map = $dbFunctions->getListIncludeMap($sql);
  $idea_map = $idea_map[0];

    $_SESSION["input_map"] = $idea_map;
    $smarty->assign('approval', array(
           0 => '非承認',
           1 => '承認済み'));

  $smarty->assign("idea_map", $idea_map);
  $smarty->display(TEMPLATE_DIR."/idea_box_tpl/idea_edit.tpl");
  exit();
}


/**-------------------------------------------------------------------------------------------------
  SQL
--------------------------------------------------------------------------------------------------*/
function getSqlSelectIdea($arg_map){
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "id,";
  $sql.= "shain_id,";
  $sql.= "title,";
  $sql.= "body ";
  $sql.= "FROM ";
  $sql.= "ideas ";
  $sql.= "WHERE ";
  $sql.= "approval_flag = '1' AND ";
  $sql.= "delete_flag = '0' ";
  $sql.= "ORDER BY insert_datetime DESC ";
  $sql.= "LIMIT ".intval($arg_map["limit"]);

  return $sql;
}

function input_check($input_map) {
  $error_map = null;
  // タイトル
  if (!strlen($input_map["title"])) {
    $error_map["title"] = "タイトルを入力してください。";
  } else if (mb_strlen($input_map["title"]) > 50) {
    $error_map["title"] = "タイトルが長すぎます。";
  }
  // 内容
  if (!strlen($input_map["body"])) {
    $error_map["body"] = "内容を入力してください。";
  } else if (mb_strlen($input_map["body"]) > 200) {
    $error_map["body"] = "内容が長すぎます。";
  }
  if (is_array($error_map)) {
    return $error_map;
  } else {
    return "";
  }
}


function getSqlSelectSinglIdea($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "id,";
  $sql.= "shain_id,";
  $sql.= "title,";
  $sql.= "body, ";
  $sql.= "  approval_flag, ";
  $sql.= "insert_datetime ";
  $sql.= "FROM ";
  $sql.= "ideas ";
  $sql.= "WHERE ";
  $sql.= "id = ".$arg_map["id"]." AND ";
  $sql.= "delete_flag = '0' ";
  $sql.= "ORDER BY insert_datetime DESC ";
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