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
  グループステータス変更
--------------------------------------------------------------------------------------------------*/

if ($_GET["mode"] == "status") {

  $input_map["group_status_id"] = $_POST["group_status_id"];
  $input_map["group_status"]    = $_POST["group_status"];
  $input_map["group_check"]     = $_POST["group_check"];
  $input_map["approval"]        = $_GET["approval"];
  $page                         = $_GET["number"];
  $arg_map["update_datetime"]   = $util->getYmdHis();

  $approval_flag = 0;

  //変更しようとしているステータスが一緒のステータスじゃなければを判定
  for ($i = 0; $i < count($input_map["group_status"]); $i++) {
    if ($input_map["group_status"][$i] != $input_map["approval"]) {
      $approval_flag = 1;
    }
  }

  //変更しようとしているステータスが一緒のステータスじゃなければ通る
  if ($approval_flag == 1) {

    //変更しようとしているグループのステータスが１(承認待ち)なら通る
    if ($input_map["approval"] == "1") {

      $dbFunctions->executeBegin();
      for ($i = 0 ; $i < count($input_map["group_status_id"]); $i++) {

        $arg_map["group_id"] = $input_map["group_status_id"][$i];

        //変更しようとしているステータスが３(非承認)なら通る
        if ($input_map["group_status"][$i] == "3") {

          //非承認に同じリスト名があるか判定するためにリスト名を取得
          $sql = getSqlSelectGroupName_1($arg_map);
          $group_name_map = $dbFunctions->getMap($sql);

          //非承認に同じリスト名があるか判定するためにgroup_idセレクト
          $arg_map["group_name"] = $group_name_map["group_name"];
          $sql = getSqlSelectGroupList($arg_map);
          $group_id_map_1 = $dbFunctions->getMap($sql);

          //非承認に同じリスト名があれば通る
          if (strlen($group_id_map_1)) {

            //変更するリストのメンバーをセレクト
            $arg_map["group_id_2"] = $input_map["group_status_id"][$i];
            $sql = getSqlSelectGroupMenber($arg_map);
            $group_members_list = $dbFunctions->getListIncludeMap($sql);

            //メンバーのgroup_idを変更
            $dbFunctions->executeBegin();
            for ($s = 0; $s < count($group_members_list); $s++) {
              $arg_map["member_id"] = $group_members_list[$s]["member_id"];
              $arg_map["group_id"]  = $group_id_map_1["group_id"];
              $sql = getSqlUpdeteStatusMember($arg_map);
              $dbFunctions->mysql_query($sql);
            }
            $dbFunctions->executeCommit();

            //リストを削除
            $arg_map["group_id_2"] = $input_map["group_status_id"][$i];
            $arg_map["approval_status"] = 1;
            $sql = getSqlDeleteGroup_1($arg_map);
            $dbFunctions->mysql_query($sql);

            //linuxの操作rmlstでリストを削除
            $list_name = $group_name_map["group_name"];

            $arg_map["group_name"] = $list_name; 
            $sql = getSqlSelectApproval($arg_map);
            $approval_map = $dbFunctions->getMap($sql);

            if(!is_array($approval_map)) {
              //コマンド例
              $rmlist = "sudo /usr/local/psa/bin/maillist -r ".$list_name." -domain ".DOMAIN;
              exec("$rmlist");
            }
          } else { //非承認に同じリスト名がなければ

            //グループをステータスが３に変更
            $arg_map["group_id"]        = $input_map["group_status_id"][$i];
            $arg_map["approval_status"] = $input_map["group_status"][$i];
            $sql = getSqlUpdeteStatus($arg_map);
            $dbFunctions->mysql_query($sql);

            $list_name = $arg_map["group_name"];

            //linuxの操作rmlstでリストを削除
            $list_name = $group_name_map["group_name"];

            $arg_map["group_name"] = $list_name; 
            $sql = getSqlSelectApproval($arg_map);
            $approval_map = $dbFunctions->getMap($sql);

            if(!is_array($approval_map)) {
              //コマンド例
              $rmlist = "sudo /usr/local/psa/bin/maillist -r ".$list_name." -domain ".DOMAIN;
              exec("$rmlist");
            }

            $sql = getSqlSelectMember_1($arg_map);
            $member_list = $dbFunctions->getListIncludeMap($sql);

            //メンバーをステータスが３に変更
            $dbFunctions->executeBegin();
            for ($j =0 ; $j < count($member_list); $j++) {
              $arg_map["member_id"]       = $member_list[$j]["member_id"]; 
              $arg_map["approval_status"] = $input_map["group_status"][$i];
              $sql = getSqlUpdeteMemberStatus($arg_map);
              $dbFunctions->mysql_query($sql);
            }
            $dbFunctions->executeCommit();
            }
          }
        $dbFunctions->executeCommit();
      }

    } else if ($input_map["approval"] == "2") { //変更しようとしているグループのステータスが2(承認済み)なら通る

      $dbFunctions->executeBegin();
      for ($i = 0 ; $i < count($input_map["group_status_id"]); $i++) {

        $arg_map["group_id"] = $input_map["group_status_id"][$i];

        if ($input_map["group_status"][$i] == "3") { //変更しようとしているステータスが３(非承認)なら通る

          //非承認に同じリスト名があるか判定するためにリスト名を取得
          $sql = getSqlSelectGroupName_1($arg_map);
          $group_name_map = $dbFunctions->getMap($sql);

          //非承認に同じリスト名があるか判定するためにgroup_idセレクト
          $arg_map["group_name"] = $group_name_map["group_name"];
          $sql = getSqlSelectGroupList($arg_map);
          $group_id_map_1 = $dbFunctions->getMap($sql);

          //非承認に同じリスト名があれば通る
          if (is_array($group_id_map_1)) {

            //変更するリストのメンバーをセレクト
            $arg_map["group_id_2"] = $input_map["group_status_id"][$i];
            $sql = getSqlSelectGroupMenber($arg_map);
            $group_members_list = $dbFunctions->getListIncludeMap($sql);

            $dbFunctions->executeBegin();
            //メンバーのgroup_idを変更
            for ($s = 0; $s < count($group_members_list); $s++) {
              $arg_map["member_id"] = $group_members_list[$s]["member_id"];
              $arg_map["group_id"]  = $group_id_map_1["group_id"];
              $sql = getSqlUpdeteStatusMember($arg_map);
              $dbFunctions->mysql_query($sql);
            }
            $dbFunctions->executeCommit();

            //リストを削除
            $arg_map["group_id_2"] = $input_map["group_status_id"][$i];
            $arg_map["approval_status"] = 2;
            $sql = getSqlDeleteGroup_1($arg_map);
            $dbFunctions->mysql_query($sql);

            //linuxの操作rmlstでリストを削除
            $list_name = $group_name_map["group_name"];

            //コマンド例
            $rmlist = "sudo /usr/local/psa/bin/maillist -r ".$list_name." -domain ".DOMAIN;
            exec("$rmlist");

          } else { //非承認に同じリスト名がなければ

            //linuxの操作rmlstでリストを削除
            $list_name = $group_name_map["group_name"];

            //コマンド例
            $rmlist = "sudo /usr/local/psa/bin/maillist -r ".$list_name." -domain ".DOMAIN;
            exec("$rmlist");

            //グループをステータスが３に変更
            $arg_map["group_id"]        = $input_map["group_status_id"][$i];
            $arg_map["approval_status"] = $input_map["group_status"][$i];
            $sql = getSqlUpdeteStatus($arg_map);
            $dbFunctions->mysql_query($sql);

            $sql = getSqlSelectMember_1($arg_map);
            $member_list = $dbFunctions->getListIncludeMap($sql);

            //メンバーをステータスが３に変更
            $dbFunctions->executeBegin();
            for ($j =0 ; $j < count($member_list); $j++) {
              $arg_map["member_id"]       = $member_list[$j]["member_id"]; 
              $arg_map["approval_status"] = $input_map["group_status"][$i];
              $sql = getSqlUpdeteMemberStatus($arg_map);
              $dbFunctions->mysql_query($sql);
            }
            $dbFunctions->executeCommit();
          }
        }
      }
      $dbFunctions->executeCommit();

    } else if ($input_map["approval"] == "3") {  //変更しようとしているグループのステータスが3(非承認)なら通る

      $dbFunctions->executeBegin();
      for ($i = 0 ; $i < count($input_map["group_status_id"]); $i++) {

        if ($input_map["group_status"][$i] == "1") { //変更しようとしているステータスが1(承認待ち)なら通る

          $arg_map["group_id"] = $input_map["group_status_id"][$i];
          $sql = getSqlSelectGroupName_1($arg_map);
          $group_name_map = $dbFunctions->getMap($sql);

          $arg_map["group_name"] = $group_name_map["group_name"];
          $sql = getSqlSelectGroupList_1($arg_map);
          $group_id_map = $dbFunctions->getMap($sql);

          if (!is_array($group_id_map)) { //承認待ちに同名のリストが無ければ通る

            //グループをステータスが1に変更
            $arg_map["group_id"]        = $input_map["group_status_id"][$i];
            $arg_map["approval_status"] = $input_map["group_status"][$i];
            $sql = getSqlUpdeteStatus($arg_map);
            $dbFunctions->mysql_query($sql);

            $list_name = $arg_map["group_name"];
            //ランダムパスワード生成
            $ar1 = range('a', 'z'); // アルファベット小文字を配列に
            $ar2 = range('A', 'Z'); // アルファベット大文字を配列に
            $ar3 = range(0, 9); // 数字を配列に
            $ar_all = array_merge($ar1, $ar2, $ar3); // すべて結合
            shuffle($ar_all); // ランダム順にシャッフル
            $arg_map["list_password"] = substr(implode($ar_all), 0, 16); // 先頭の16文字

            //コマンド例
            $newlist = "sudo /usr/local/psa/bin/maillist -c ".$list_name." -domain ".DOMAIN." -passwd ".$arg_map["list_password"]." -passwd_type plain -email ".HOST_ADDRESS;
            exec("$newlist");

            // config_list_input.txtをリストにインプットし設定変更
            $config_list = "sudo /usr/lib/mailman/bin/config_list -i ".FCE_ROOT."/idea_box/txt/config_list_input.txt ".$list_name;
            exec("$config_list");

            //パスワードをアップデート
            $sql = getSqlUpdeteListPass($arg_map);
            $dbFunctions->mysql_query($sql);

            //メンバーをステータスが1に変更
            $sql = getSqlSelectMember_1($arg_map);
            $member_list = $dbFunctions->getListIncludeMap($sql);
            $dbFunctions->executeBegin();
            for ($j =0 ; $j < count($member_list); $j++) {
              $arg_map["member_id"]       = $member_list[$j]["member_id"]; 
              $arg_map["approval_status"] = $input_map["group_status"][$i];
              $sql = getSqlUpdeteMemberStatus($arg_map);
              $dbFunctions->mysql_query($sql);
            }
            $dbFunctions->executeCommit();

          } else { //承認待ちに同名のリストがあれば通る

            //グループをステータスを削除
            $arg_map["approval_status"] = 3;
            $arg_map["group_id_2"]      = $input_map["group_status_id"][$i];
            $sql = getSqlDeleteGroup_1($arg_map);
            $dbFunctions->mysql_query($sql);

            $arg_map["group_id"] = $input_map["group_status_id"][$i];
            $sql = getSqlSelectMember_1($arg_map);
            $member_list = $dbFunctions->getListIncludeMap($sql);

            //メンバーをステータスが1に変更
            $dbFunctions->executeBegin();
            for ($j =0 ; $j < count($member_list); $j++) {
              $arg_map["group_id"]        = $group_id_map["group_id"];
              $arg_map["approval_status"] = 1;
              $arg_map["member_id"]       = $member_list[$j]["member_id"]; 
              $arg_map["approval_status"] = $input_map["group_status"][$i];
              $sql = getSqlUpdeteMemberStatus_1($arg_map);
              $dbFunctions->mysql_query($sql);
            }
            $dbFunctions->executeCommit();
          }
        }
        $dbFunctions->executeCommit();
      }
    }
  }

  //ステータスの変更がgroup_list.phpからなら
  if ($_GET["send"] == "group_list") {
    header("Location: ".URL_ROOT."/tcm-admin/group_list.php?status=1&approval_flag=".$approval_flag."&paging=status&page=".$page);
    exit();
  }

  //ステータスの変更がgroup_non_admitted_list.phpからなら
  if ($_GET["send"] == "group_non_admitted_list") {
    header("Location: ".URL_ROOT."/tcm-admin/group_non_admitted_list.php?status=1&approval_flag=".$approval_flag."&paging=status&page=".$page);
    exit();
  }

  //ステータスの変更がgroup_approval_list.phpからなら
  if ($_GET["send"] == "group_approval_list") {
    header("Location: ".URL_ROOT."/tcm-admin/group_approval_list.php?status=1&approval_flag=".$approval_flag."&paging=status&page=".$page);
    exit();
  }
}

/**-------------------------------------------------------------------------------------------------
  メンバーステータス変更
--------------------------------------------------------------------------------------------------*/

if ($_GET["mode"] == "member_status") {

  $id                            = $_POST["group_id"];
  $input_map["member_status_id"] = $_POST["member_status_id"];
  $input_map["member_status"]    = $_POST["member_status"];
  $input_map["approval"]         = $_POST["approval"];
  $page                          = $_GET["number"];
  $arg_map["update_datetime"]    = $util->getYmdHis();

  if (strlen($_POST["approval"])) {
    $input_map["approval"] = $_POST["approval"];
  }
  if (strlen($_GET["approval"])) {
    $input_map["approval"] = $_GET["approval"];
  }

  $approval_flag = 0;

  //変更しようとしているステータスが一緒のステータスじゃなければを判定
  for ($i = 0; $i < count($input_map["member_status"]); $i++) {
    if ($input_map["member_status"][$i] != $input_map["approval"]) {
      $approval_flag = 1;
    }
  }

  //変更しようとしているステータスが一緒のステータスじゃなければ通る
  if ($approval_flag == "1") {

    //変更しようとしているメンバーのステータスが1(承認待ち)なら通る
    if ($input_map["approval"] == "1") {
      $dbFunctions->executeBegin();
      for ($i = 0 ; $i < count($input_map["member_status_id"]); $i++) {

        //メンバーのステータスを3にする
        $arg_map["member_id"]       = $input_map["member_status_id"][$i];
        $arg_map["approval_status"] = $input_map["member_status"][$i];
        $arg_map["update_datetime"] = $util->getYmdHis();
        $sql = getSqlUpdeteMemberStatus($arg_map);
        $dbFunctions->mysql_query($sql);

        //変更したグループid取得
        $arg_map["member_id"] = $input_map["member_status_id"][$i];
        $sql = getSqlSelectGroupId_1($arg_map);
        $group_id_map = $dbFunctions->getMap($sql);

        //メンバーの人数確認
        $arg_map["group_id"] = $group_id_map["group_id"];
        $arg_map["approval_status"] = "1";
        $sql = getSqlSelectCountMember($arg_map);
        $member_count = $dbFunctions->getMap($sql);

        //リスト名取得
        $arg_map["group_id"] = $group_id_map["group_id"];
        $sql = getSqlGroupDate($arg_map);
        $group_data_map = $dbFunctions->getMap($sql);

        // メンバーが0になると通る
        if ($member_count["record_count"] == 0) {

          //グループのデータ取得
          $arg_map["group_id"] = $group_id_map["group_id"];
          $sql = getSqlGroupDate($arg_map);
          $group_data_map = $dbFunctions->getMap($sql);

          //非承認に同じグループ名がないか判定
          $arg_map["group_name"] = $group_data_map["group_name"];
          $sql = getSqlSelectGroupList($arg_map);
          $group_list_map = $dbFunctions->getMap($sql);

          //非承認に同じグループ名がなければとおるりステータスを3にする
          if (!is_array($group_list_map)) {

            $arg_map["group_id"] = $group_data_map["group_id"];
            $sql = getSqlDeleteGroup_2($arg_map);
            $dbFunctions->mysql_query($sql);

            //linuxの操作rmlstでリストを削除
            $list_name = $group_data_map["group_name"];

            $arg_map["group_name"] = $list_name; 
            $sql = getSqlSelectApproval($arg_map);
            $approval_map = $dbFunctions->getMap($sql);

            if(!is_array($approval_map)) {
              //コマンド例
              $rmlist = "sudo /usr/local/psa/bin/maillist -r ".$list_name." -domain ".DOMAIN;
              exec("$rmlist");
            }

          } else { //非承認に同じグループ名があればグループを削除

            $arg_map["group_id_1"] = $group_data_map["group_id"]; //変更されるid
            $arg_map["group_id_2"] = $group_list_map["group_id"];  //変更するid
            $arg_map["approval_status"] = 3;
            $sql = getSqlDeleteGroup_3($arg_map);
            $dbFunctions->mysql_query($sql);

            $arg_map["group_id_2"] = $group_data_map["group_id"];
            $arg_map["approval_status"] = 1;
            $sql = getSqlDeleteGroup_1($arg_map);

            $dbFunctions->mysql_query($sql);
          }
        }

      }
      $dbFunctions->executeCommit();

    } else if ($input_map["approval"] == "2") { //変更しようとしているメンバーのステータスが2(承認済み)なら通る

      for ($i = 0 ; $i < count($input_map["member_status"]); $i++) {

        //変更するステータスが3のとき通る
        if ($input_map["member_status"][$i] == "3")  {
          $arg_map["member_id"] = $input_map["member_status_id"][$i];
          $sql = getSqlSelectGroupId_1($arg_map);
          $group_id_map = $dbFunctions->getMap($sql);
          $arg_map["group_id"] = $group_id_map["group_id"];
          $sql = getSqlSelectGroupName_1($arg_map);
          $group_map = $dbFunctions->getMap($sql);

          $list_name    = $group_map["group_name"];
          $list_address = $group_id_map["mail_address"];
          //コマンド例
          $remove_members = " sudo /usr/local/psa/bin/maillist -u " .$list_name." -domain " .DOMAIN." -members del:".$list_address;
          exec("$remove_members");

          $arg_map["member_id"]       = $input_map["member_status_id"][$i];
          $arg_map["approval_status"] = $input_map["member_status"][$i];
          $arg_map["update_datetime"] = $util->getYmdHis();
          $sql = getSqlUpdeteMemberStatus($arg_map);

          $dbFunctions->mysql_query($sql);
        }
      }

    } else if ($input_map["approval"] == "3") { //変更しようとしているメンバーのステータスが3(非承認)なら通る

      for ($i = 0 ; $i < count($input_map["member_status_id"]); $i++) {

        if ($input_map["member_status"][$i] == "1") {  //変更するステータスが1(承認)のとき

          //メンバーのIDでグループIDを取ってくる
          $arg_map["member_id"] = $input_map["member_status_id"][$i];
          $sql = getSqlSelectGroupId_1($arg_map);
          $group_id_map = $dbFunctions->getMap($sql);

          //取得したグループIDでgroup_id,group_name,group_mailing_list_address取得
          $arg_map["group_id"] = $group_id_map["group_id"]; 
          $sql = getSqlSelectGroupName_1($arg_map);
          $group_name_map = $dbFunctions->getMap($sql);

          if (!is_array($group_name_map)) {

            $arg_map["group_id"] = $group_id_map["group_id"];
            $sql = getSqlSelectGroupName($arg_map);
            $group_name_map = $dbFunctions->getMap($sql);

            $arg_map["group_name"] = $group_name_map["group_name"];
            $sql = getSqlSelectGroupId($arg_map);
            $group_id_map_2 = $dbFunctions->getMap($sql);

          }

          //approval_status「1」に取得したgroup_nameで同じものがあるか判定するために
          $arg_map["group_name"]           = $group_name_map["group_name"]; 
          $arg_map["mailing_list_address"] = $group_name_map["mailing_list_address"]; 
          $arg_map["approval_status_1"] = "1"; 
          $sql = getSqlSelectGroupDeta($arg_map);

          $group_deta_map = $dbFunctions->getMap($sql);

          //承認待ちに同じリスト名があれば通る
          if (is_array($group_deta_map)) {

            //現在承認待ちにあるグループIDに書き換える
            $arg_map["group_id_1"]  = $group_deta_map["group_id"];
            $sql = getSqlUpdeteId_1($arg_map);
            $dbFunctions->mysql_query($sql);

            //変更するメンバーの非承認グループの人数が0かどうかを判定するため
            $arg_map["approval_status"] = "3";
            $sql = getSqlSelectCountMember($arg_map);
            $member_count = $dbFunctions->getMap($sql);

            if (is_array($member_count)) {

              //変更する非承認グループのメンバー人数が0になれば削除
              if ($member_count["record_count"] == "0") {
                $arg_map["update_datetime"] = $util->getYmdHis();
                $sql = getSqlDeleteGroup($arg_map);
                $dbFunctions->mysql_query($sql);
              }
            }
          } else { //承認待ちに同じリスト名がなければ通る

            //承認待ちにリストがなかったので新しくリストを作成する情報を取得
            if (strlen($group_id_map_2["group_id"])) {
             $arg_map["group_id"] = $group_id_map_2["group_id"];
            }

            $sql = getSqlGroupDate($arg_map);
            $group_list = $dbFunctions->getMap($sql);

            //承認待ちにリストを作るために最新のIDをとってくる
            $sql = getSqlSelectGroupId_MAX($arg_map);
            $group_id_map = $dbFunctions->getMap($sql);

            //承認待ちに新しくリストを作成
            $arg_map["insert_datetime"]      = $util->getYmdHis();
            $arg_map["group_id_1"]           = $group_id_map["max_id"]+1;
            $arg_map["group_name"]           = $group_list["group_name"];
            $arg_map["table_code"]           = $group_list["table_code"];
            $arg_map["mailing_list_address"] = $group_list["mailing_list_address"];
            $arg_map["approval_status"]      = "1";
            $arg_map["training_code"]        = $group_list["training_code"];
            $arg_map["training_datetime"]    = $group_list["training_datetime"];
            $arg_map["group_name"]           = $group_list["group_name"];

            $sql = getSqlInsertFrom1($arg_map);
            $dbFunctions->mysql_query($sql);

            $arg_map["group_id_1"]           = $group_id_map["max_id"]+1;
            $arg_map["update_datetime"]      = $util->getYmdHis();
            $arg_map["member_id"]            = $input_map["member_status_id"][$i];
            $sql = getSqlUpdeteMemberId($arg_map);
            $dbFunctions->mysql_query($sql);

            //変更するメンバーの非承認グループの人数が0かどうかを判定するため
            $arg_map["approval_status"] = "3";
            $sql = getSqlSelectCountMember($arg_map);
            $member_count = $dbFunctions->getMap($sql);

            if (is_array($member_count)) {
              //変更するメンバーの非承認グループの人数が0になれば削除
              if ($member_count["record_count"] == "0") {
                $arg_map["update_datetime"] = $util->getYmdHis();
                $sql = getSqlDeleteGroup($arg_map);
                $dbFunctions->mysql_query($sql);

              } else {

                $arg_map["group_name"] = $group_list["group_name"];
                $sql = getSqlSelectGroupList($arg_map);
                $group_id_map_1 = $dbFunctions->getMap($sql);

                $arg_map["group_id"] = $group_id_map_1["group_id"];
                $approval_status = 3;
                $sql = getSqlDeleteGroupId($arg_map);
                $dbFunctions->mysql_query($sql);

                $arg_map["group_id"] = $group_id_map_1["group_id"];
                $sql = getSqlSelectMember_1($arg_map);
                $member_id_list = $dbFunctions->getListIncludeMap($sql);

                $dbFunctions->executeBegin();
                for ($x = 0; $x < count($member_id_list); $x++) {
                  $arg_map["group_id"]  = $group_id_map["max_id"]+1;
                  $arg_map["member_id"] = $member_id_list[$x]["member_id"];
                  $arg_map["update_datetime"] = $util->getYmdHis();
                  $arg_map["approval_status"] = 3;
                  $sql = getSqlUpdateGroupId($arg_map);
                  $dbFunctions->mysql_query($sql);
                }
                $dbFunctions->executeCommit();
              } 
            }
          }
        }
      }
    }
  }

  //メンバー削除がgroup_member_list.phpなら
  if ($_GET["send"] == "group_member_list") {
    $approval_status = $_GET["approval_status"];
    header("Location: ".URL_ROOT."/tcm-admin/group_member_list.php?group_id=".$id."&approval_status=".$approval_status."&status=1&approval_flag=".$approval_flag."&page=".$page."&paging=status");
    exit();
  }

  //メンバー削除がmember_non_admitted_list.phpなら
  if ($_GET["send"] == "member_non_admitted_list") {
    header("Location: ".URL_ROOT."/tcm-admin/member_non_admitted_list.php?status=1&approval_flag=".$approval_flag."&page=".$page."&paging=status");
    exit();
  }

}



/**-------------------------------------------------------------------------------------------------
  SQL文
--------------------------------------------------------------------------------------------------*/

//メンバー削除実行
function getSqlSelectMemberAddress($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  mail_address ";
  $sql.= " FROM ";
  $sql.= "  member ";
  $sql.= "WHERE ";
  $sql.= "  member_id = ".intval($arg_map["member_id"])." AND ";
  $sql.= " delete_flag = '0'";

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
  $sql.= "  group1 ";
  $sql.= "WHERE ";
  $sql.= "  group_id = ".intval($arg_map["group_id"])." AND ";
  $sql.= " delete_flag = '0'";

  return $sql;
}

//メンバー削除実行
function getSqlSelectGroupName($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group_id , ";
  $sql.= "  group_name , ";
  $sql.= "  mailing_list_address ";
  $sql.= "FROM ";
  $sql.= "  group1 ";
  $sql.= "WHERE ";
  $sql.= "  group_id = ".intval($arg_map["group_id"]);

  return $sql;
}


//グループステータス変更
function getSqlUpdeteStatus($arg_map) {
  $sql = "";
  $sql.= "UPDATE group1 SET ";
  $sql.= "  approval_status = ".intval($arg_map["approval_status"])." , ";
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."' ";
  $sql.= "WHERE ";
  $sql.= "  group_id = ".intval($arg_map["group_id"])." AND ";
  $sql.= " delete_flag = '0'";

  return $sql;
}

//メンバーテータス変更
function getSqlSelectGroupId_MAX($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= " MAX(group_id) AS max_id ";
  $sql.= "FROM ";
  $sql.= "  group1 ";

  return $sql;
}

//メンバーテータス変更
function getSqlSelectGroupId_1($arg_map) {
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

//メンバーテータス変更
function getSqlSelectGroupId($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group_id ";
  $sql.= "FROM ";
  $sql.= " group1 ";
  $sql.= "WHERE ";
  $sql.= "  group_name = '".mysql_escape_string($arg_map["group_name"])."' AND ";
  $sql.= "  approval_status = '2' AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

//メンバーテータス変更
function getSqlUpdeteApprovalMember_1($arg_map) {
  $sql = "";
  $sql.= "UPDATE member SET ";
  $sql.= "  approval_status = '1' , ";
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."' ";
  $sql.= "WHERE ";
  $sql.= "  member_id = ".intval($arg_map["member_id_1"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

//メンバーテータス変更
function getSqlUpdeteId_1($arg_map) {
  $sql = "";
  $sql.= "UPDATE member SET ";
  $sql.= "  group_id = " .intval($arg_map["group_id_1"]).", ";
  $sql.= "  approval_status = '1' ,";
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."' ";
  $sql.= "WHERE ";
  $sql.= "  member_id = ".intval($arg_map["member_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

//グループステータス変更
function getSqlSelectMember_1($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  member_id ";
  $sql.= "FROM ";
  $sql.= " member ";
  $sql.= "WHERE ";
  $sql.= "  group_id = ".intval($arg_map["group_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

//メンバーステータス変更
function getSqlUpdeteMemberStatus($arg_map) {
  $sql = "";
  $sql.= "UPDATE member SET ";
  $sql.= "  approval_status = ".intval($arg_map["approval_status"])." , ";
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."' ";
  $sql.= "WHERE ";
  $sql.= "  member_id = ".intval($arg_map["member_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}


//メンバーステータス変更
function getSqlUpdeteMemberStatus_1($arg_map) {
  $sql = "";
  $sql.= "UPDATE member SET ";
  $sql.= "  group_id = ".intval($arg_map["group_id"])." , ";
  $sql.= "  approval_status = ".intval($arg_map["approval_status"])." , ";
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."' ";
  $sql.= "WHERE ";
  $sql.= "  member_id = ".intval($arg_map["member_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

//承認登録実行
function getSqlGroupDate($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group_id, ";
  $sql.= "  group_name, ";
  $sql.= "  table_code, ";
  $sql.= "  mailing_list_address, ";
  $sql.= "  training_datetime, ";
  $sql.= "  training_code ";
  $sql.= "FROM ";
  $sql.= " group1 ";
  $sql.= "WHERE ";
  $sql.= "  group_id = ".intval($arg_map["group_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

function getSqlInsertFrom1($arg_map) {
  $sql = "";
  $sql.= "INSERT INTO group1( ";
  $sql.= "  group_id, ";
  $sql.= "  group_name, ";
  $sql.= "  training_datetime, ";
  $sql.= "  training_code, ";
  $sql.= "  table_code, ";
  $sql.= "  mailing_list_address, ";
  $sql.= "  approval_status, ";
  $sql.= "  insert_datetime, ";
  $sql.= "  update_datetime, ";
  $sql.= "  delete_flag ";
  $sql.= ") ";
  $sql.= "VALUES ( ";
  $sql.= "  ".intval($arg_map["group_id_1"]).", ";
  $sql.= "  '".mysql_escape_string($arg_map["group_name"])."', ";
  $sql.= "  '".mysql_escape_string($arg_map["training_datetime"])."', ";
  $sql.= "  ".intval($arg_map["training_code"]).", ";
  $sql.= "  ".intval($arg_map["table_code"]).", ";
  $sql.= "  '".mysql_escape_string($arg_map["mailing_list_address"])."', ";
  $sql.= "  ".intval($arg_map["approval_status"]).", ";
  $sql.= "  '".mysql_escape_string($arg_map["insert_datetime"])."', ";
  $sql.= "  '".mysql_escape_string($arg_map["update_datetime"])."', ";
  $sql.= "  ".intval($arg_map["delete_flag"]);
  $sql.= ")";

  return $sql;
}

//承認登録実行
function getSqlUpdeteMemberId($arg_map) {
  $sql = "";
  $sql.= "UPDATE member SET ";
  $sql.= "  group_id = ".intval($arg_map["group_id_1"]).", ";
  $sql.= "  approval_status = '1' ," ;
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."' ";
  $sql.= "WHERE ";
  $sql.= "  member_id = ".intval($arg_map["member_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

//メンバーステータス変更
function getSqlSelectGroupDeta($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group_id , ";
  $sql.= "  group_name ,";
  $sql.= "  mailing_list_address ";
  $sql.= "FROM ";
  $sql.= " group1 ";
  $sql.= "WHERE ";
  if (strlen($arg_map["approval_status_1"])) {
    $sql.= "  approval_status = '1' AND ";
  }
  $sql.= "  group_name = '".mysql_escape_string($arg_map["group_name"])."' AND ";
  $sql.= "  delete_flag = '0' ";

  return $sql;
}

function getSqlSelectCountMember($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  count(group_id) AS record_count ";
  $sql.= "FROM ";
  $sql.= " member ";
  $sql.= "WHERE ";
  if (strlen($arg_map["group_id"])) {
    $sql.= "  group_id = ".intval($arg_map["group_id"])." AND ";
  }
  $sql.= "  approval_status = ".intval($arg_map["approval_status"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

function getSqlDeleteGroup($arg_map) {
  $sql = "";
  $sql.= "UPDATE group1 SET ";
  $sql.= "  delete_flag = '1', ";
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."' ";
  $sql.= "WHERE ";
  $sql.= "  approval_status = '3' AND ";
  $sql.= "  group_id = ".intval($arg_map["group_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

function getSqlSelectGropId_2($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group_id ";
  $sql.= "FROM ";
  $sql.= " member ";
  $sql.= "WHERE ";
  $sql.= "  member_id = ".intval($arg_map["member_id"])." AND ";
//  $sql.= "  approval_status = '1' AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

function getSqlSelectGroupList($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group_id ";
  $sql.= "FROM ";
  $sql.= " group1 ";
  $sql.= "WHERE ";
  $sql.= "  group_name = '".mysql_escape_string($arg_map["group_name"])."' AND ";
  $sql.= "  approval_status = '3' AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

function getSqlSelectGroupMenber($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  member_id ";
  $sql.= "FROM ";
  $sql.= " member ";
  $sql.= "WHERE ";
  $sql.= "  group_id = ".intval($arg_map["group_id_2"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

function getSqlUpdeteStatusMember($arg_map) {
  $sql = "";
  $sql.= "UPDATE member SET ";
  $sql.= "  approval_status = '3' , ";
  $sql.= "  group_id = ".intval($arg_map["group_id"]).", ";
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."' ";
  $sql.= "WHERE ";
  $sql.= "  member_id = ".intval($arg_map["member_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

function getSqlDeleteGroup_1($arg_map) {
  $sql = "";
  $sql.= "UPDATE group1 SET ";
  $sql.= "  delete_flag = '1', ";
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."' ";
  $sql.= "WHERE ";
  $sql.= "  approval_status = ".intval($arg_map["approval_status"])." AND ";
  $sql.= "  group_id = ".intval($arg_map["group_id_2"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

function getSqlDeleteGroup_2($arg_map) {
  $sql = "";
  $sql.= "UPDATE group1 SET ";
  $sql.= "  approval_status = '3' , ";
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."' ";
  $sql.= "WHERE ";
  $sql.= "  group_id = ".intval($arg_map["group_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

function getSqlDeleteGroup_3($arg_map) {
  $sql = "";
  $sql.= "UPDATE member SET ";
  $sql.= "  group_id = ".intval($arg_map["group_id_2"]).", ";
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."' ";
  $sql.= "WHERE ";
  $sql.= "  approval_status = ".intval($arg_map["approval_status"])." AND ";
  $sql.= "  group_id = ".intval($arg_map["group_id_1"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

//グループステータス変更
function getSqlSelectMember_2($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group_id ";
  $sql.= "FROM ";
  $sql.= " member ";
  $sql.= "WHERE ";
  $sql.= "  approval_status = '3' AND ";
  $sql.= "  group_id = ".intval($arg_map["group_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

function getSqlUpdateGroupId($arg_map) {
  $sql = "";
  $sql.= "UPDATE member SET ";
  $sql.= "  group_id = ".intval($arg_map["group_id"]).", ";
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."' ";
  $sql.= "WHERE ";
  $sql.= "  approval_status = ".intval($arg_map["approval_status"])." AND ";
  $sql.= "  member_id = ".intval($arg_map["member_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

function getSqlUpdeteListPass($arg_map) {
  $sql = "";
  $sql.= "UPDATE group1 SET ";
  $sql.= "  list_password = '".mysql_escape_string($arg_map["list_password"])."', ";
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."' " ;
  $sql.= "WHERE ";
  $sql.= "  group_id = '".intval($arg_map["group_id"])."' AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

function getSqlDeleteGroupId($arg_map) {
  $sql = "";
  $sql.= "UPDATE group1 SET ";
  $sql.= "  delete_flag = '1', ";
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."' ";
  $sql.= "WHERE ";
  $sql.= "  approval_status = ".intval($arg_map["approval_status"])." AND ";
  $sql.= "  group_id = ".intval($arg_map["group_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

function getSqlSelectGroupList_1($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group_id ";
  $sql.= "FROM ";
  $sql.= " group1 ";
  $sql.= "WHERE ";
  $sql.= "  group_name = '".mysql_escape_string($arg_map["group_name"])."' AND ";
  $sql.= "  approval_status = '1' AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

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