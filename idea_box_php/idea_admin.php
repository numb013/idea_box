<?php

ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );


error_reporting(E_ALL & ~E_NOTICE);

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

$mode = $_POST["mode"];   // postデータを$modeに受け取る



/**-------------------------------------------------------------------------------------------------
  メイン処理
--------------------------------------------------------------------------------------------------*/

if ($mode == "back") {



/**-----------------------------------------------------------------------------------------------
  戻る
------------------------------------------------------------------------------------------------*/

  // 戻った時に入力情報をセッションから取得

  $user_map["shain_id"] = $_SESSION["login_map"]["shain_id"];
  // 戻った時に入力情報をセッションから取得
  $input_map = $_SESSION["input_map"];
  $smarty->assign("user_map", $user_map);
  $smarty->assign("input_map", $input_map);

  $smarty->display(TEMPLATE_DIR."/idea_box_tpl/idea_admin.tpl");
  exit();

} else {




/**-----------------------------------------------------------------------------------------------
  初期処理
------------------------------------------------------------------------------------------------*/

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
$search_flag = $_POST["search_flag"];
if ($search_flag == "1") {
  $input_map["shain_id"]      = $_POST["shain_id"]; 
  $input_map["insert_datetime_1"] = $_POST["insert_datetime_1"]; 
  $input_map["insert_datetime_2"] = $_POST["insert_datetime_2"]; 

  $_SESSION["shain_id"]      = $_POST["shain_id"]; 
  $_SESSION["insert_datetime_1"] = $_POST["insert_datetime_1"]; 
  $_SESSION["insert_datetime_2"] = $_POST["insert_datetime_2"]; 


$smarty->assign('select', $_POST["shain_id"]);
} else {
  $input_map["shain_id"]      = $_SESSION["shain_id"]; 
  $input_map["insert_datetime_1"] = $_SESSION["insert_datetime_1"]; 
  $input_map["insert_datetime_2"] = $_SESSION["insert_datetime_2"]; 
}


$smarty->assign("input_map", $input_map);
$arg_map = $input_map;

// データを取得
$arg_map["offset"] = ($page - 1) * ADMIN_COUNT_PAGE;
$arg_map["limit"]  = ADMIN_COUNT_PAGE;

$sql = getSqlSelectIdea($arg_map);
$idea_list = $dbFunctions->getListIncludeMap($sql);

// 件数取得 件数をrecord countに入れる
$arg_map = $input_map;
$sql = getSqlSelectCountIdea($arg_map);
$map = $dbFunctions->getMap($sql);


// 一件もデータがない時にメッセージ表示するためにアサイン
$smarty->assign("map", $map);

// ページングリンク
$paging_link = $util->getPagingLink($map["record_count"], $page, ADMIN_COUNT_PAGE, ADMIN_COUNT_LINK, URL_ROOT_HTTPS."/idea_admin.php", "");
$smarty->assign("paging_link", $paging_link);

// x件～x件 （x件中）
$count_idea = $util->getPagingInfo($map["record_count"], $page, ADMIN_COUNT_PAGE);
$smarty->assign("count_idea", $count_idea);

$sql = getSqlMsShain();
$ms_shain = $dbFunctions->getListIncludeMap($sql);



foreach ($ms_shain as $key => $value) {
  $shain_arry[null] = '選択してください';
  $shain_arry[$value['shain_id']] = $value['myoji'].$value['namae'];
}

$smarty->assign('shain_arry', $shain_arry);


$smarty->assign('approval', array(
       0 => '非承認',
       1 => '承認済み'));

// リストに表示するためアサイン
$smarty->assign("ms_shain", $ms_shain);
$smarty->assign("idea_list", $idea_list);
$smarty->assign("page", $page);
$smarty->display(TEMPLATE_DIR."/idea_box_tpl/idea_admin.tpl");
exit();

}
/**-------------------------------------------------------------------------------------------------
  SQL文
--------------------------------------------------------------------------------------------------*/


function getSqlMsShain() {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "shain_id, ";
  $sql.= "myoji, ";
  $sql.= "namae ";
  $sql.= "FROM ";
  $sql.= "ms_shain ";
  $sql.= " ORDER BY insert_datetime DESC ";
  return $sql;
}

function getSqlSelectCountIdea($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= " count(id) AS record_count ";
  $sql.= "FROM ";
  $sql.= "ideas ";
  $sql.= "WHERE ";
  if (strlen($arg_map["shain_id"])) {
    $sql .= "  shain_id ='".intval($arg_map["shain_id"])."' AND ";
  }
  if (strlen($arg_map["insert_datetime_1"]) && strlen($arg_map["insert_datetime_2"])) {
    $sql.= "  insert_datetime BETWEEN '" .mysql_escape_string($arg_map["insert_datetime_1"]). " 00:00:00' AND '".mysql_escape_string($arg_map["insert_datetime_2"])." 23:59:59 ' AND ";
  } else if (strlen($arg_map["insert_datetime_1"])) {
    $sql.= "'".mysql_escape_string($arg_map["insert_datetime_1"]). " 00:00:00' <= insert_datetime AND ";
  } else if (strlen($arg_map["insert_datetime_2"])) {
    $sql.= " insert_datetime <= '" . mysql_escape_string($arg_map["insert_datetime_2"]). " 23:59:59'AND ";
  }
  $sql.= " delete_flag = '0' ";

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
  if (strlen($arg_map["shain_id"])) {
    $sql .= "  shain_id ='".intval($arg_map["shain_id"])."' AND ";
  }

  if (strlen($arg_map["insert_datetime_1"]) && strlen($arg_map["insert_datetime_2"])) {
    $sql.= "  insert_datetime BETWEEN '" .mysql_escape_string($arg_map["insert_datetime_1"]). " 00:00:00' AND '".mysql_escape_string($arg_map["insert_datetime_2"])." 23:59:59 ' AND ";
  } else if (strlen($arg_map["insert_datetime_1"])) {
    $sql.= "'".mysql_escape_string($arg_map["insert_datetime_1"]). " 00:00:00' <= insert_datetime AND ";
  } else if (strlen($arg_map["insert_datetime_2"])) {
    $sql.= " insert_datetime <= '" . mysql_escape_string($arg_map["insert_datetime_2"]). " 23:59:59'AND ";
  }
  $sql.= "  delete_flag = '0' ";
  $sql.= " ORDER BY insert_datetime DESC ";
  $sql.= "LIMIT ".intval($arg_map["limit"])." OFFSET ".intval($arg_map["offset"]);

  return $sql;
}


?>