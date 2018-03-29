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


  $user_map["shain_id"] = $_SESSION["login_map"]["shain_id"];
  // 戻った時に入力情報をセッションから取得
  $input_map = $_SESSION["input_map"];
  $smarty->assign("user_map", $user_map);
  $smarty->assign("input_map", $input_map);





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
  $input_map["insert_datetime_1"] = $_POST["insert_datetime_1"]; 
  $input_map["insert_datetime_2"] = $_POST["insert_datetime_2"]; 

  $_SESSION["insert_datetime_1"] = $_POST["insert_datetime_1"]; 
  $_SESSION["insert_datetime_2"] = $_POST["insert_datetime_2"]; 

} else {
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

// 一件もデータがない時にメッセージ表示するためにアサイン
$smarty->assign("map", $map);


$sql = getSqlSelectIdeaGroupBy($arg_map);
$idea_order = $dbFunctions->getListIncludeMap($sql);


foreach ($idea_order as $key => $order_para) {
  $idea_data[$key]['idea_count'] = 0;
  foreach ($idea_list as $num => $list_para) {
    if ($order_para['shain_id'] == $list_para['shain_id']) {
      $idea_data[$key]['shain_id'] = $list_para['shain_id'];
      $idea_data[$key]['idea_count'] = $idea_data[$key]['idea_count'] + 1;
    }
  }
}
$sql = getSqlMsShain();
$ms_shain = $dbFunctions->getListIncludeMap($sql);
foreach ($ms_shain as $key => $shain_para) {
  foreach ($idea_data as $num => $idea_para) {
    if ($shain_para['shain_id'] == $idea_para['shain_id']) {
      $shain_idea_count[$key]['shain_id'] = $shain_para['shain_id'];
      $shain_idea_count[$key]['name'] = $shain_para['myoji'].$shain_para['namae'];
      $shain_idea_count[$key]['idea_count'] = $idea_para['idea_count'];
      break;
    } else {
      $shain_idea_count[$key]['shain_id'] = $shain_para['shain_id'];
      $shain_idea_count[$key]['name'] = $shain_para['myoji'].$shain_para['namae'];
      $shain_idea_count[$key]['idea_count'] = 0;
    }
  }
}

$smarty->assign('shain_idea_count', $shain_idea_count);
// リストに表示するためアサイン
// $smarty->assign("ms_shain", $ms_shain);
// $smarty->assign("idea_list", $idea_list);
// $smarty->assign("page", $page);
$smarty->display(TEMPLATE_DIR."/idea_box_tpl/idea_total.tpl");
exit();

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
  $sql.= " ORDER BY shain_id asc ";
  return $sql;
}




function getSqlSelectIdea($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  shain_id ";
  $sql.= "FROM ";
  $sql.= "ideas ";
  $sql.= "WHERE ";
  if (strlen($arg_map["insert_datetime_1"]) && strlen($arg_map["insert_datetime_2"])) {
    $sql.= "  insert_datetime BETWEEN '" .mysql_escape_string($arg_map["insert_datetime_1"]). " 00:00:00' AND '".mysql_escape_string($arg_map["insert_datetime_2"])." 23:59:59 ' AND ";
  } else if (strlen($arg_map["insert_datetime_1"])) {
    $sql.= "'".mysql_escape_string($arg_map["insert_datetime_1"]). " 00:00:00' <= insert_datetime AND ";
  } else if (strlen($arg_map["insert_datetime_2"])) {
    $sql.= " insert_datetime <= '" . mysql_escape_string($arg_map["insert_datetime_2"]). " 23:59:59'AND ";
  }
  $sql.= "  delete_flag = '0' ";
  // $sql.= "LIMIT ".intval($arg_map["limit"])." OFFSET ".intval($arg_map["offset"]);

  return $sql;
}


function getSqlSelectIdeaGroupBy($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  shain_id ";
  $sql.= "FROM ";
  $sql.= "ideas ";
  $sql.= "WHERE ";
  if (strlen($arg_map["insert_datetime_1"]) && strlen($arg_map["insert_datetime_2"])) {
    $sql.= "  insert_datetime BETWEEN '" .mysql_escape_string($arg_map["insert_datetime_1"]). " 00:00:00' AND '".mysql_escape_string($arg_map["insert_datetime_2"])." 23:59:59 ' AND ";
  } else if (strlen($arg_map["insert_datetime_1"])) {
    $sql.= "'".mysql_escape_string($arg_map["insert_datetime_1"]). " 00:00:00' <= insert_datetime AND ";
  } else if (strlen($arg_map["insert_datetime_2"])) {
    $sql.= " insert_datetime <= '" . mysql_escape_string($arg_map["insert_datetime_2"]). " 23:59:59'AND ";
  }
  $sql.= "  delete_flag = '0' ";
  $sql.= "Group by shain_id";

  return $sql;
}

?>