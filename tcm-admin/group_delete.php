<?php
error_reporting(E_ALL & ~E_NOTICE);

require_once("./_module/requires.php");
require_once("./login_check.php");

mb_language("Japanese");
mb_internal_encoding("utf-8");

session_start();



/**-------------------------------------------------------------------------------------------------
  初期処理
--------------------------------------------------------------------------------------------------*/

$dbFunctions = new DBFunctions();



/**-------------------------------------------------------------------------------------------------
  リクエストより必要データ取得 & バリデーション
--------------------------------------------------------------------------------------------------*/

$group_id = $_GET["id"];

// ページ 削除したときに同じページを表示するため。
$page = $_GET["page"];
$page = intval($page);
if ($page == 0) {
  $page = 1;
}



/**-----------------------------------------------------------------------------------------------
  メイン処理
------------------------------------------------------------------------------------------------*/

// 情報テーブルに入力内容をUPDATE
$arg_map = null;
$arg_map["group_id"] = $group_id;

$sql = getSqlUpdateGroup($arg_map);
$dbFunctions->mysql_query($sql);
$arg_map = null;
$arg_map["group_id"] = $group_id;
$sql = getSqlUpdateItemMember($arg_map);
$dbFunctions->mysql_query($sql);

header("Location: ".URL_ROOT."/tcm-admin/group_list.php?page=".$page);

exit();



/**-------------------------------------------------------------------------------------------------
  SQL文
--------------------------------------------------------------------------------------------------*/

function getSqlUpdateGroup($arg_map) {
  $sql = "";
  $sql.= "UPDATE group1 SET ";
  $sql.= "  delete_flag = '1' ";
  $sql.= "WHERE ";
  $sql.= "  group_id =".intval($arg_map["group_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

function getSqlUpdateItemMember($arg_map) {
  $sql = null;
  $sql.= "UPDATE member SET ";
  $sql.= "  delete_flag = '1' ";
  $sql.= "WHERE ";
  $sql.= "  group_id =".intval($arg_map["group_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

?>