<?php
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
if (!empty($_POST["mode"])) {  // postデータを$modeに受け取る
  $mode = $_POST["mode"];
} else {
  $mode = '';
}


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
  $smarty->assign("admin_map", $admin_map);
  // 戻った時に入力情報をセッションから取得
  $smarty->assign("user_map", $user_map);


/**-------------------------------------------------------------------------------------------------
  メイン処理
--------------------------------------------------------------------------------------------------*/

  $page = $_GET["page"];

  if ($page == "") {
    $page = 1;
  }

if ($mode == "edit") {
/**-----------------------------------------------------------------------------------------------
  登録
------------------------------------------------------------------------------------------------*/
  $input_map            = null;
  $input_map["id"]   = $_POST["id"];
  $input_map["title"]   = $_POST["title"];
  $input_map["body"]    = $_POST["body"];
  $input_map["approval_flag"]    = $_POST["approval_flag"];
  $input_map["update_datetime"] = date("Y/m/d H:i:s");
  $input_map["delete_flag"] = $_POST["delete_flag"][0] ? $_POST["delete_flag"][0] : 0;

  $error_map = input_check($input_map);
  if (is_array($error_map)) {
    // エラー表示
    $smarty->assign("error_map", $error_map);
    $idea_map = $_SESSION["input_map"];
    $smarty->assign("idea_map", $idea_map);
    $smarty->assign('approval', array(
           0 => '非承認',
           1 => '承認済み'));
    $smarty->display(TEMPLATE_DIR."/idea_edit.tpl");
    exit();
  } else {
    $arg_map  = $input_map;
    $sql = getSqlUpdateIdea($arg_map);



    $dbFunctions->mysql_query($sql);

    $arg_map["offset"] = ($page - 1) * ADMIN_COUNT_PAGE;
    $arg_map["limit"]  = ADMIN_COUNT_PAGE;


    if ($_SESSION["status"] == 'admin_edit') {

      $arg_map["admin"] = 1;

      $sql = getSqlSelectIdea($arg_map);
      $idea_list = $dbFunctions->getListIncludeMap($sql);
      $sql = getSqlSelectCountIdea($arg_map);
      $map = $dbFunctions->getMap($sql);


      // x件～x件 （x件中）
      $count_idea = $util->getPagingInfo($map["record_count"], $page, ADMIN_COUNT_PAGE);
      // ページングリンク
      $paging_link = $util->getPagingLink($map["record_count"], $page, ADMIN_COUNT_PAGE, ADMIN_COUNT_LINK, URL_ROOT_HTTPS."/idea_admin.php", "");


      $smarty->assign("count_idea", $count_idea);
      $smarty->assign("paging_link", $paging_link);
      $smarty->assign("idea_list", $idea_list);
      $smarty->display(TEMPLATE_DIR."/idea_admin.tpl");


    } else {

      $arg_map["admin"] = 0;
      $sql = getSqlSelectIdea($arg_map);
      $idea_list = $dbFunctions->getListIncludeMap($sql);
      $sql = getSqlSelectCountIdea($arg_map);
      $map = $dbFunctions->getMap($sql);

      // x件～x件 （x件中）
      $count_item = $util->getPagingInfo($map["record_count"], $page, ADMIN_COUNT_PAGE);
      // ページングリンク
      $paging_link = $util->getPagingLink($map["record_count"], $page, ADMIN_COUNT_PAGE, ADMIN_COUNT_LINK, URL_ROOT_HTTPS."/idea_list.php", "");

      $smarty->assign("count_idea", $count_idea);
      $smarty->assign("paging_link", $paging_link);
      $smarty->assign("idea_list", $idea_list);

      $smarty->display(TEMPLATE_DIR."/idea_list.tpl");
    }
    unset($_SESSION["status"]);
    exit();




  }

} else {
  if ($_GET["status"] == 'admin_edit') {
    $_SESSION["status"] = $_GET["status"];
  }

  $arg_map["id"]  = $_GET["id"];
  $sql = getSqlSelectSinglIdea($arg_map);
  $idea_map = $dbFunctions->getListIncludeMap($sql);
  $idea_map = $idea_map[0];

    $_SESSION["input_map"] = $idea_map;
    $smarty->assign('approval', array(
           0 => '非承認',
           1 => '承認済み'));

    $smarty->assign('delete', array(
           1 => '削除する'));

  $smarty->assign("idea_map", $idea_map);
  $smarty->display(TEMPLATE_DIR."/idea_edit.tpl");
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
  if ($arg_map["admin"] == 0) {
    $sql.= "approval_flag = '1' AND ";
  }
  $sql.= "delete_flag = '0' ";
  $sql.= "ORDER BY insert_datetime DESC ";
  $sql.= "LIMIT ".intval($arg_map["limit"]);


  return $sql;
}


function getSqlSelectCountIdea($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= " count(id) AS record_count ";
  $sql.= "FROM ";
  $sql.= "ideas ";
  $sql.= "WHERE ";
  if ($arg_map["admin"] == 0) {
    $sql.= "approval_flag = '1' AND ";
  }
  $sql.= " delete_flag = '0'";

  return $sql;
}


function input_check($input_map) {
  $error_map = null;
  // タイトル
  if (!strlen($input_map["title"])) {
    $error_map["title"] = "タイトルを入力してください。";
  }
  // 内容
  if (!strlen($input_map["body"])) {
    $error_map["body"] = "内容を入力してください。";
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
  $sql.= "  title = '".mysql_escape_string($arg_map["title"])."'  ,";
  $sql.= "  body = '".mysql_escape_string($arg_map["body"])."'  ,";
  $sql.= "  approval_flag = '".intval($arg_map["approval_flag"])."'  ,";
  $sql.= "  delete_flag = '".intval($arg_map["delete_flag"])."'  ,";
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."'  ";
  $sql.= "WHERE ";
  $sql.= "  id = ".intval($arg_map["id"])." AND ";
  $sql.= "  delete_flag = 0";
  return $sql;
}



?>