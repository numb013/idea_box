<?php
error_reporting(E_ALL & ~E_NOTICE);

require_once("./_module/requires.php");
require_once("./login_check.php");
require_once("_define/TableCodeDef.php");  // テーブルID
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



/**-------------------------------------------------------------------------------------------------
  リクエストより必要データ取得 & バリデーション
--------------------------------------------------------------------------------------------------*/

$input_map["group_id"] = $_GET["group_id"];

// ページ
$page = $_GET["page"];

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

$smarty->assign("page", $page);



/**-------------------------------------------------------------------------------------------------
  グループ削除実行
--------------------------------------------------------------------------------------------------*/

if ($_GET["mode"] == "sakujyo") {

  $input_map["group_id"]      = $_GET["group_id"];
  $input_map["group_check"]   = $_POST["group_check"];
  $page                       = $_GET["number"];
  $arg_map["update_datetime"] = $util->getYmdHis();

  //削除がチェック無しの単体だった場合通る
  if (strlen($input_map["group_id"])) {

    //グループのdelete_flagに1
    $arg_map["group_id"] = $input_map["group_id"];
    $sql = getSqlUpdeteDelete($arg_map);
    $dbFunctions->mysql_query($sql);

    $sql = getSqlSelectListMember($arg_map);
    $member_list = $dbFunctions->getListIncludeMap($sql);

    //linuxの操作rmlstでリストを削除
    $list_name = $member_list[0]["group_name"];

    $arg_map["group_name"] = $list_name; 
    $sql = getSqlSelectApproval($arg_map);
    $approval_map = $dbFunctions->getMap($sql);

    if(!is_array($approval_map)) {
      //コマンド例
      $rmlist = "sudo /usr/local/psa/bin/maillist -r ".$list_name." -domain ".DOMAIN;
      exec("$rmlist");
    }

    //メンバーのdelete_flagに1
    $dbFunctions->executeBegin();
    for ($j =0 ; $j < count($member_list); $j++) {
      $arg_map["member_id"] = $member_list[$j]["member_id"]; 
      $sql = getSqlUpdeteMemberDelete($arg_map);
      $dbFunctions->mysql_query($sql);
    }
    $dbFunctions->executeCommit();

  }

  //チェックで複数のリストを削除する場合通る
  if (is_array($input_map["group_check"])) {


    $dbFunctions->executeBegin();
    for ($i = 0; $i < count($input_map["group_check"]); $i++) {

      //グループのdelete_flagに1
      $arg_map["group_id"] = $input_map["group_check"][$i];
      $sql = getSqlUpdeteDelete($arg_map);
      $dbFunctions->mysql_query($sql);

      $sql = getSqlSelectListMember($arg_map);
      $member_list = $dbFunctions->getListIncludeMap($sql);

      //linuxの操作rmlstでリストを削除
      $list_name = $member_list[0]["group_name"];

      $arg_map["group_name"] = $list_name; 
      $sql = getSqlSelectApproval($arg_map);
      $approval_map = $dbFunctions->getMap($sql);

      if(!is_array($approval_map)) {
        //コマンド例
        $rmlist = "sudo /usr/local/psa/bin/maillist -r ".$list_name." -domain ".DOMAIN;
        exec("$rmlist");
      }

      //メンバーのdelete_flagに1
      for ($j =0 ; $j < count($member_list); $j++) {
        $arg_map["member_id"] = $member_list[$j]["member_id"]; 
        $sql = getSqlUpdeteMemberDelete($arg_map);
        $dbFunctions->mysql_query($sql);
      }
    }
    $dbFunctions->executeCommit();
  }


  //group_list.phpからの削除の場合通る
  if ($_GET["send"] == "group_list") {
    header("Location: ".URL_ROOT."/tcm-admin/group_list.php?page=".$page."&paging=delete");
    exit();
  }

  //group_non_admitted_list.phpからの削除の場合通る
  if ($_GET["send"] == "group_non_admitted_list") {
    header("Location: ".URL_ROOT."/tcm-admin/group_non_admitted_list.php?page=".$page."&paging=delete");
    exit();
  }

  //group_approval_list.phpからの削除の場合通る
  if ($_GET["send"] == "group_approval_list") {
    header("Location: ".URL_ROOT."/tcm-admin/group_approval_list.php?page=".$page."&paging=delete");
    exit();
  }

}



/**-------------------------------------------------------------------------------------------------
  メンバー削除実行
--------------------------------------------------------------------------------------------------*/

if ($_GET["mode"] == "member_sakujyo") {


  $input_map["member_id"]       = $_GET["id"];
  $input_map["member_check"]    = $_POST["member_check"];
  $input_map["approval_status"] = $_GET["approval_status"];
  $page                         = $_GET["number"];

  $arg_map["update_datetime"] = $util->getYmdHis();

  if (strlen($_GET["group_id"])) {
    $id_group_member = $_GET["group_id"];
  } else if (strlen($_POST["group_id"])) {
    $id_group_member = $_POST["group_id"];
  }

  //メンバー一人削除の場合通る
  if (strlen($input_map["member_id"])) {

    $arg_map["group_id"] = $input_map["group_id"];
    $sql = getSqlSelectGroupName_1($arg_map);

    $group_map = $dbFunctions->getMap($sql);

    if ($input_map["approval_status"] != 1) {

      //ここからメーリングリストのアドレス削除
      $arg_map["member_id"] = $input_map["member_id"];
      $sql = getSqlSelectMemberAddress($arg_map);
      $member_map = $dbFunctions->getMap($sql);

      $list_name    = $group_map["group_name"];
      $list_address = $member_map["mail_address"];

      //コマンド例
      $remove_members = " sudo /usr/local/psa/bin/maillist -u " .$list_name." -domain ".DOMAIN." -members del:".$list_address;
      exec("$remove_members");

      //メンバーのdelete_flagに1
      $arg_map["member_id"] = $input_map["member_id"];
      $sql = getSqlUpdeteMemberDelete($arg_map);
      $dbFunctions->mysql_query($sql);

    } else if ($input_map["approval_status"] == 1) {

      //ここからメーリングリストのアドレス削除
      $arg_map["member_id"] = $input_map["member_id"];
      $sql = getSqlSelectMemberAddress($arg_map);
      $member_map = $dbFunctions->getMap($sql);

      $list_name    = $group_map["group_name"];
      $list_address = $member_map["mail_address"];

      //メンバーのdelete_flagに1
      $arg_map["member_id"] = $input_map["member_id"];
      $sql = getSqlUpdeteMemberDelete($arg_map);
      $dbFunctions->mysql_query($sql);

    }

  }

  //チェックでメンバーを複数削除の場合通る
  if (is_array($input_map["member_check"])) {

    $dbFunctions->executeBegin();
    for ($i = 0; $i < count($input_map["member_check"]); $i++) {

    if ($input_map["approval_status"] == 2) {

      $arg_map["member_id"] = $input_map["member_check"][$i];
      $sql = getSqlSelectMemberAddress($arg_map);
      $group_id_map = $dbFunctions->getMap($sql);

      $arg_map["group_id"] = $group_id_map["group_id"];
      $sql = getSqlSelectGroupName_1($arg_map);
      $group_map = $dbFunctions->getMap($sql);

      $list_name    = $group_map["group_name"];
      $list_address = $group_id_map["mail_address"];

      //コマンド例
      $remove_members = " sudo /usr/local/psa/bin/maillist -u " .$list_name." -domain ".DOMAIN." -members del:".$list_address;
      exec("$remove_members");

      }

      //メンバーのdelete_flagに1
      $arg_map["member_id"] = $input_map["member_check"][$i];
      $sql = getSqlUpdeteMemberDelete($arg_map);
      $dbFunctions->mysql_query($sql);

    }
    $dbFunctions->executeCommit();

  }

  //group_member_list.phpからの削除の場合
  if ($_GET["send"] == "group_member_list") {
    $approval_status = $_GET["approval_status"];
    header("Location: ".URL_ROOT."/tcm-admin/group_member_list.php?group_id=".$id_group_member."&approval_status=".$approval_status."&page=".$page."&paging=delete");
    exit();
  }

  //member_non_admitted_list.phpからの削除の場合
  if ($_GET["send"] == "member_non_admitted_list") {
    header("Location: ".URL_ROOT."/tcm-admin/member_non_admitted_list.php?page=".$page."&paging=delete");
    exit();
  }

}



/**-------------------------------------------------------------------------------------------------
  SQL文
--------------------------------------------------------------------------------------------------*/

//グループ削除実行
function getSqlSelectGroupName($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group_name ";
  $sql.= " FROM ";
  $sql.= " group1 ";
  $sql.= "WHERE ";
  $sql.= "  group_id =".intval($arg_map["group_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}


//グループ削除実行
function getSqlUpdeteDelete($arg_map) {
  $sql = "";
  $sql.= "UPDATE group1 SET ";
  $sql.= "  delete_flag = '1' ,";
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."'  ";
  $sql.= "WHERE ";
  $sql.= "  group_id =".intval($arg_map["group_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

//グループ削除実行
function getSqlUpdeteMemberDelete($arg_map) {
  $sql = "";
  $sql.= "UPDATE member SET ";
  $sql.= "  delete_flag = '1', ";
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."' ";
  $sql.= "WHERE ";
  $sql.= "  member_id =".intval($arg_map["member_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}


//グループ削除実行
function getSqlSelectListMember($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  member.group_id, ";
  $sql.= "  member_id, ";
  $sql.= "  company, ";
  $sql.= "  member_name, ";
  $sql.= "  member.delete_flag , ";
  $sql.= "  member.approval_status , ";
  $sql.= "  group1.mailing_list_address , ";
  $sql.= "  group1.group_name ";
  $sql.= "FROM ";
  $sql.= "  group1, member ";
  $sql.= "WHERE ";
  $sql.= "  member.group_id = ".intval($arg_map["group_id"])." AND ";
//  $sql.= "  group1.delete_flag = '0' AND ";
  $sql.= "  group1.group_id = member.group_id";

  return $sql;
}

//メンバー削除実行
function getSqlDeleteMember_1($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  member_name, ";
  $sql.= "  approval_status , ";
  $sql.= "  mail_address ";
  $sql.= "FROM ";
  $sql.= "  member ";
  $sql.= "WHERE ";
  $sql.= "  member_id = ".intval($arg_map["member_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

//メンバー削除実行
function getSqlSelectMemberAddress($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group_id, ";
  $sql.= "  mail_address ";
  $sql.= "FROM ";
  $sql.= " member ";
  $sql.= "WHERE ";
  $sql.= "  member_id = ".intval($arg_map["member_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

//メンバー削除実行
function getSqlSelectGroupName_1($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group_id , ";
  $sql.= "  group_name , ";
  $sql.= "  mailing_list_address ";
  $sql.= "FROM ";
  $sql.= " group1 ";
  $sql.= "WHERE ";
  if (strlen($arg_map["approval_status_1"])) {
    $sql.= "  approval_status = '1' AND ";
  }
  $sql.= "  group_id = ".intval($arg_map["group_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

//メンバー削除実行
function getSqlSelectAddress($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group_id, ";
  $sql.= "  mail_address ";
  $sql.= "FROM ";
  $sql.= " member ";
  $sql.= "WHERE ";
  $sql.= "  member_id = ".intval($arg_map["group_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

//メンバー削除実行
function getSqlSelectId($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group_name ";
  $sql.= "FROM ";
  $sql.= "  group1 ";
  $sql.= "WHERE ";
  $sql.= "  group_id =".intval($arg_map["group_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

//グループ削除実行
function getSqlSelectApproval($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group_id, ";
  $sql.= "  group_name ";
  $sql.= "FROM ";
  $sql.= "  group1 ";
  $sql.= "WHERE ";
  $sql.= "  group_name = '".mysql_escape_string($arg_map["group_name"])."' AND ";
  $sql.= "  approval_status = '2' AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}
?>
