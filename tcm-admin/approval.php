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
  メイン処理
--------------------------------------------------------------------------------------------------*/

//参加人数取得
if ($_GET["mode"] == "select") {

  $page                     = $_GET["number"];
  $input_map["group_id"]    = $_GET["group_id"];
  $input_map["group_check"] = $_POST["group_check"];

  //承認するリストが選ばれているか判定
  if ($input_map["group_check"] == "" && $input_map["group_id"] == "") {
    header("Location: ".URL_ROOT."/tcm-admin/group_list.php");
  }

  //単体のリストの承認か判定
  if (strlen($input_map["group_id"])) {
    $arg_map["group_id"] = $input_map["group_id"];
    $sql = getSqlSelectGroup($arg_map);
    $group_list = $dbFunctions->getListIncludeMap($sql);

    //人数を判定
    $sql = getSqlSelectMember($arg_map);
    $member_count = $dbFunctions->getMap($sql);
    $group_list[0]["group_number"] = $member_count["record_count"];
  }

  //複数のリストを承認しようとしているか
  if (is_array($input_map["group_check"])) {

    $dbFunctions->executeBegin();
    for ($i = 0; $i < count($input_map["group_check"]); $i++) {
      $arg_map["group_id"] = $input_map["group_check"][$i];
      $sql = getSqlSelectGroup($arg_map);
      $group_map = $dbFunctions->getMap($sql);
      $group_list[$i] = $group_map;

      //複数のリストの人数を判定
      $sql = getSqlSelectMember($arg_map);
      $member_count = $dbFunctions->getMap($sql);
      $group_list[$i]["group_number"] = $member_count["record_count"];

    }
    $dbFunctions->executeCommit();

  }

  // リストに表示するためアサイン
  $smarty->assign("group_list", $group_list);
  $smarty->assign("page", $page);

  $smarty->display(TEMPLATE_DIR."/admin/approval.tpl");
  exit();

}



/**-------------------------------------------------------------------------------------------------
  承認登録実行
--------------------------------------------------------------------------------------------------*/

if ($_POST["mode"] = "completion") {

  $input_map["group_id"]      = $_POST["group_id"];
  $input_map["group_name"]    = $_POST["group_name"];
  $arg_map["update_datetime"] = $util->getYmdHis();

  //承認するリストの数だけ回す
  $dbFunctions->executeBegin();
  for ($i = 0; $i < count($input_map["group_name"]); $i++) {
    $flag_list = 0;

    $arg_map["group_name"] = $input_map["group_name"][$i];
    $sql = getSqlSelectGroup_2($arg_map);
    $group_map = $dbFunctions->getMap($sql);

    $arg_map["group_id"] = $input_map["group_id"][$i];
    $sql = getSqlSelectMember_4($arg_map);
    $addmember_list_1 = $dbFunctions->getListIncludeMap($sql);

    //グループ内に承認するメンバーがいないとエラー出す
    if (!is_array($addmember_list_1)) {
      $error_map["error"] = "グループ内に承認するメンバーがいません。";
      $smarty->assign("error_map", $error_map);
      $smarty->display(TEMPLATE_DIR."/admin/approval.tpl");
      exit();
    }

    //承認済みにステータス２の同じグループ名があるか（あれば通る）
    if (is_array($group_map)) {

      $arg_map["group_id"] = $group_map["group_id"];
      $sql = getSqlSelectMember_3($arg_map);
      $addmember_list = $dbFunctions->getListIncludeMap($sql);

      $arg_map["group_id"] = $input_map["group_id"][$i];
      $sql = getSqlSelectMember_1($arg_map);
      $member_list = $dbFunctions->getListIncludeMap($sql);

      //同じメールアドレスがないか判定
      for ($r = 0; $r < count($member_list); $r++) {
        $address[$r] = $member_list[$r][mail_address];
      }
      $result = array_unique($address, SORT_REGULAR);

      if(count($address) != count($result)) {
        $error_map["error"] = $member_list[0]["group_name"]."のグループ内に同じメールアドレスがありますので登録できません。";
        $smarty->assign("error_map", $error_map);
        $smarty->display(TEMPLATE_DIR."/admin/approval.tpl");
        exit();
      }

      //承認グループにメンバーが0人ではなければ
      if (is_array($addmember_list)) {

        $dbFunctions->executeBegin();
        for ($n = 0; $n < count($member_list); $n++) {

          for ($k = 0; $k < count($addmember_list); $k++) {//
            $member_flag= 0;
            //同じアドレスのメンバーないかチョック
            if ($member_list[$n]["mail_address"] == $addmember_list[$k]["mail_address"]) {
              $member_flag= 1;
            }

            if ($member_flag == 0) {

              $list_name = $member_list[0]["group_name"];
              $name_list = $member_list[0]["mailing_list_address"];

              //リストのメンバーをすでに承認済みにある同じリスト名のidに変更しステータスを2(承認)
              $arg_map["group_map_id"] = $group_map["group_id"];
              $arg_map["member_id"]    = $member_list[$n]["member_id"];
              $sql = getSqlUpdeteMemberId_2($arg_map);
              $dbFunctions->mysql_query($sql);
              //コマンド例
              $list_member = "sudo /usr/local/psa/bin/maillist -u ".$list_name." -domain ".DOMAIN." -members add:".$member_list[$n]["mail_address"];
              exec($list_member);

              //現在承認済みにしたリストを削除
              $arg_map["group_id"] = $input_map["group_id"][$i];
              $sql = getSqlDeleteGroup($arg_map);
              $dbFunctions->mysql_query($sql);

            } else if ($member_flag == 1) {

              $error_map["error"] = $number."同じリスト内にすでに登録されたメールアドレスがありますので登録できません。";
              $smarty->assign("error_map", $error_map);
              $smarty->display(TEMPLATE_DIR."/admin/approval.tpl");
              exit();

            }
          }
        }//
        $dbFunctions->executeCommit();

      } else {      //承認グループのメンバーが0人なら通る

        $dbFunctions->executeBegin();
        for ($n = 0; $n < count($member_list); $n++) {

          //リストのメンバーをすでに承認済みにある同じリスト名のidに変更しステータスを2(承認)
          $arg_map["group_map_id"] = $group_map["group_id"];
          $arg_map["member_id"]    = $member_list[$n]["member_id"];
          $sql = getSqlUpdeteMemberId_2($arg_map);
          $dbFunctions->mysql_query($sql);
          //コマンド例
          $list_member = "sudo /usr/local/psa/bin/maillist -u ".$list_name." -domain ".DOMAIN." -members add:".$member_list[$n]["mail_address"];
          exec($list_member);

          //現在承認済みにしたリストを削除
          $arg_map["group_id"] = $input_map["group_id"][$i];
          $sql = getSqlDeleteGroup($arg_map);
          $dbFunctions->mysql_query($sql);

        }
        $dbFunctions->executeCommit();
      }

    } else { //承認済みにステータス２の同じグループ名がなければ

      //ここからメーリングリストに同じ名前のグループ名があるか確認するためにメーリングリストを配列にする記述
      $arg_map["group_id"] = $input_map["group_id"][$i];
      $sql = getSqlSelectGroup_1($arg_map);
      $group_name_map = $dbFunctions->getMap($sql);

      $lists = "sudo /usr/lib/mailman/bin/list_lists";
      ob_start(); //バッファリング開始
      $b = system($lists);
      $output = ob_get_contents();        //出力されるはずだったデータを取得
      ob_end_clean();                     //本来出力されるはずのデータをクリア(これをしないと実行終了時に出力されてしまう)
      $fp = fopen(URL_ROOT_MAILMAN."/txt/setting.txt" , "w");
      fwrite($fp, $output);
      fclose($fp);
      $text = file_get_contents(URL_ROOT_MAILMAN."/txt/setting.txt");
      $from = "matching mailing lists found:";
      $to = ",";
      $text = str_replace($from, $to, $text);
      $from = "[no description available]";
      $to = "";
      $text = str_replace($from, $to, $text);
      $from = " - ";
      $to = ",";
      $text = str_replace($from, $to, $text);
      $from = ",\n";
      $to = ",";
      $text = str_replace($from, $to, $text);
      $from = " ";
      $to   = "";
      $text = str_replace($from, $to, $text);
      $mailing_list_lists = explode(",", $text);

      file_put_contents(URL_ROOT_MAILMAN."/txt/setting.txt", $text);

      for($j = 1; $j < count($mailing_list_lists); $j++) {
        $name_list = $group_name_map["mailing_list_address"];
        $name_list = str_replace(URL_ROOT_FCE, "", $name_list);
        if ($mailing_list_lists[$j] == $name_list) {
          $flag_list = "1";
        }
      }

      if ($flag_list == "1") {  //メーリングリストに同じ名前があった場合通る

        $arg_map["group_id"] = $input_map["group_id"][$i];
        $sql = getSqlSelectMember_1($arg_map);
        $member_list = $dbFunctions->getListIncludeMap($sql);

        //同じメールアドレスがないか判定
        for ($r = 0; $r < count($member_list); $r++) {
          $address[$r] = $member_list[$r][mail_address];
        }
        $result = array_unique($address, SORT_REGULAR);
        if(count($address) != count($result)) {
          $error_map["error"] = $member_list[0]["group_name"]."のグループ内に同じメールアドレスがありますので登録できません。";
          $smarty->assign("error_map", $error_map);
          $smarty->display(TEMPLATE_DIR."/admin/approval.tpl");
          exit();
        }

        //グループをステータス２に変更する
        $arg_map["group_id"] = $input_map["group_id"][$i];
        $sql = getSqlUpdeteGroupId($arg_map);
        $dbFunctions->mysql_query($sql);

        for($c =0; $c < count($member_list); $c++) {
          $arg_map["group_id"] = $member_list[$c]["group_id"];
          $sql = getSqlUpdeteMemberId($arg_map);
          $dbFunctions->mysql_query($sql);


          $name_list = $member_list[0]["mailing_list_address"];
          $list_name = $member_list[$c]["group_name"];
          //コマンド例
          $list_member = "sudo /usr/local/psa/bin/maillist -u ".$list_name." -domain ".DOMAIN." -members add:".$member_list[$c]["mail_address"];
          exec($list_member);
        }

        //ここから管理者アドレスの追加
        $sql = getSqlSelectManagerAddress();
        $manager_map = $dbFunctions->getMap($sql);

        if (strlen($manager_map["manager_address1"])) {
          $list_member = "sudo /usr/local/psa/bin/maillist -u ".$list_name." -domain ".DOMAIN." -members add:".$manager_map["manager_address1"];
          exec($list_member);
        }
        if (strlen($manager_map["manager_address2"])) {
          $list_member = "sudo /usr/local/psa/bin/maillist -u ".$list_name." -domain ".DOMAIN." -members add:".$manager_map["manager_address2"];
          exec($list_member);
        }
        if (strlen($manager_map["manager_address3"])) {
          $list_member = "sudo /usr/local/psa/bin/maillist -u ".$list_name." -domain ".DOMAIN." -members add:".$manager_map["manager_address3"];
          exec($list_member);
        }
        if (strlen($manager_map["manager_address4"])) {
          $list_member = "sudo /usr/local/psa/bin/maillist -u ".$list_name." -domain ".DOMAIN." -members add:".$manager_map["manager_address4"];
          exec($list_member);
        }

      } else { //メーリングリストに同じリスト名がなかったら通る（承認から非承認して承認待ちにして承認しようとしてる場合）

        //メンバーをステータス２に変更する
        $arg_map["group_id"] = $input_map["group_id"][$i];
        $sql = getSqlSelectMember_1($arg_map);
        $member_list = $dbFunctions->getListIncludeMap($sql);

        //同じメールアドレスがないか判定
        for ($r = 0; $r < count($member_list); $r++) {
          $address[$r] = $member_list[$r][mail_address];
        }
        $result = array_unique($address, SORT_REGULAR);
        if(count($address) != count($result)) {
          $error_map["error"] = $member_list[0]["group_name"]."のグループ内に同じメールアドレスがありますので登録できません。";
          $smarty->assign("error_map", $error_map);
          $smarty->display(TEMPLATE_DIR."/admin/approval.tpl");
          exit();
        }

        //グループをステータス２に変更する
        $arg_map["group_id"] = $input_map["group_id"][$i];
        $sql = getSqlUpdeteGroupId($arg_map);
        $dbFunctions->mysql_query($sql);

        $name_list = $member_list[0]["mailing_list_address"];
        $list_name = $member_list[0]["group_name"];
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
        $config_list = "sudo /usr/lib/mailman/bin/config_list -i ".FCE_ROOT."/mailing_list/txt/config_list_input.txt ".$list_name;
        exec("$config_list");

        //パスワードをアップデート
        $sql = getSqlUpdeteListPass($arg_map);
        $dbFunctions->mysql_query($sql);

        //メンバーをステータス２に変更する
        for($c =0; $c < count($member_list); $c++) {
          $arg_map["group_id"] = $member_list[$c]["group_id"];
          $sql = getSqlUpdeteMemberId($arg_map);
          $dbFunctions->mysql_query($sql);
          //コマンド例
          $list_member = "sudo /usr/local/psa/bin/maillist -u ".$list_name." -domain ".DOMAIN." -members add:".$member_list[$c]["mail_address"];
          exec($list_member);
        }

        //ここから管理者アドレスの追加
        $sql = getSqlSelectManagerAddress();
        $manager_map = $dbFunctions->getMap($sql);

        if (strlen($manager_map["manager_address1"])) {
          $list_member = "sudo /usr/local/psa/bin/maillist -u ".$list_name." -domain ".DOMAIN." -members add:".$manager_map["manager_address1"];
          exec($list_member);
        }
        if (strlen($manager_map["manager_address2"])) {
          $list_member = "sudo /usr/local/psa/bin/maillist -u ".$list_name." -domain ".DOMAIN." -members add:".$manager_map["manager_address2"];
          exec($list_member);
        }
        if (strlen($manager_map["manager_address3"])) {
          $list_member = "sudo /usr/local/psa/bin/maillist -u ".$list_name." -domain ".DOMAIN." -members add:".$manager_map["manager_address3"];
          exec($list_member);
        }
        if (strlen($manager_map["manager_address4"])) {
          $list_member = "sudo /usr/local/psa/bin/maillist -u ".$list_name." -domain ".DOMAIN." -members add:".$manager_map["manager_address4"];
          exec($list_member);
        }
      }
    }
  }
  $dbFunctions->executeCommit();

  $smarty->display(TEMPLATE_DIR."/admin/approval_completion.tpl");
  exit();

}



/**-------------------------------------------------------------------------------------------------
  SQL文
--------------------------------------------------------------------------------------------------*/

//参加人数取得
function getSqlSelectMember($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  count(group_id) AS record_count ";
  $sql.= "FROM ";
  $sql.= " member ";
  $sql.= "WHERE ";
  if (strlen($arg_map["group_id"])) {
    $sql .= "  group_id = ".intval($arg_map["group_id"])." AND ";
  }
  $sql.= "  approval_status = '1' AND";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

//参加人数取得
function getSqlSelectGroup($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group_id, ";
  $sql.= "  group_name, ";
  $sql.= "  training_datetime, ";
  $sql.= "  training_code, ";
  $sql.= "  table_code, ";
  $sql.= "  approval_status, ";
  $sql.= "  mailing_list_address, ";
  $sql.= "  delete_flag ";
  $sql.= "FROM ";
  $sql.= " group1 ";
  $sql.= "WHERE ";
  if (strlen($arg_map["group_id"])) {
    $sql .= "  group_id = ".intval($arg_map["group_id"])." AND ";
  }
  $sql.= "  approval_status = '1' AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

//承認登録実行
function getSqlUpdeteGroupId($arg_map) {
  $sql = "";
  $sql.= "UPDATE group1 SET ";
  $sql.= "  approval_status = '2', ";
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."' ";
  $sql.= "WHERE ";
  $sql.= "  group_id = ".intval($arg_map["group_id"])." AND ";
  $sql.= "  approval_status = '1' AND";
  $sql.= "  delete_flag = '0'";
  return $sql;
}

//承認登録実行
function getSqlSelectMember_1($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group1.group_name, ";
  $sql.= "  group1.mailing_list_address, ";
  $sql.= "  member_id, ";
  $sql.= "  member.group_id, ";
  $sql.= "  company, ";
  $sql.= "  member_name, ";
  $sql.= "  mail_address, ";
  $sql.= "  member.approval_status, ";
  $sql.= "  member.delete_flag ";
  $sql.= "FROM ";
  $sql.= " group1,member ";
  $sql.= "WHERE ";
  $sql.= "  member.group_id = ".intval($arg_map["group_id"])." AND ";
  $sql.= "  group1.group_id = member.group_id AND ";
  $sql.= "  member.approval_status = '1' AND";
  $sql.= "  member.delete_flag = '0' ";

  return $sql;
}

//承認登録実行
function getSqlSelectMember_3($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  member_id, ";
  $sql.= "  group_id, ";
  $sql.= "  company, ";
  $sql.= "  member_name, ";
  $sql.= "  mail_address, ";
  $sql.= "  approval_status, ";
  $sql.= "  delete_flag ";
  $sql.= "FROM ";
  $sql.= " member ";
  $sql.= "WHERE ";
  $sql.= "  group_id = ".intval($arg_map["group_id"])." AND ";
  $sql.= "  approval_status = '2' AND";
  $sql.= "  delete_flag = '0' ";

  return $sql;
}

//承認登録実行
function getSqlSelectMember_4($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  member_id, ";
  $sql.= "  group_id, ";
  $sql.= "  company, ";
  $sql.= "  member_name, ";
  $sql.= "  mail_address, ";
  $sql.= "  approval_status, ";
  $sql.= "  delete_flag ";
  $sql.= "FROM ";
  $sql.= " member ";
  $sql.= "WHERE ";
  $sql.= "  group_id = ".intval($arg_map["group_id"])." AND ";
  $sql.= "  approval_status = '1' AND";
  $sql.= "  delete_flag = '0' ";

  return $sql;
}

//承認登録実行
function getSqlUpdeteMemberId($arg_map) {
  $sql = "";
  $sql.= "UPDATE member SET ";
  $sql.= "  approval_status = '2' , ";
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."' ";
  $sql.= "WHERE ";
  $sql.= "  group_id = ".intval($arg_map["group_id"])." AND ";
  $sql.= "  approval_status = '1' AND";
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

//承認登録実行
function getSqlUpdeteMemberId_2($arg_map) {
  $sql = "";
  $sql.= "UPDATE member SET ";
  $sql.= "  approval_status = '2' , ";
  $sql.= "  group_id = ".intval($arg_map["group_map_id"]).", ";
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."'  ";
  $sql.= "WHERE ";
  $sql.= "  member_id = ".intval($arg_map["member_id"])." AND ";
  $sql.= "  approval_status = '1' AND";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

//承認登録実行
function getSqlSelectGroup_1($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group_id, ";
  $sql.= "  group_name, ";
  $sql.= "  training_datetime, ";
  $sql.= "  table_code, ";
  $sql.= "  mailing_list_address, ";
  $sql.= "  approval_status, ";
  $sql.= "  training_code, ";
  $sql.= "  delete_flag ";
  $sql.= "FROM ";
  $sql.= "group1 ";
  $sql.= "WHERE ";
  $sql.= "  group_id = ".intval($arg_map["group_id"])." AND ";
  $sql.= "  delete_flag = '0' ";

  return $sql;
}

//承認登録実行
function getSqlSelectGroup_2($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  group_id, ";
  $sql.= "  group_name, ";
  $sql.= "  training_datetime, ";
  $sql.= "  table_code, ";
  $sql.= "  mailing_list_address, ";
  $sql.= "  approval_status, ";
  $sql.= "  training_code, ";
  $sql.= "  delete_flag ";
  $sql.= "FROM ";
  $sql.= "group1 ";
  $sql.= "WHERE ";
  $sql.= "  group_name ='".mysql_escape_string($arg_map["group_name"])."' AND ";
  $sql.= "  approval_status = '2' AND ";
  $sql.= "  delete_flag = '0' ";

  return $sql;
}

//承認登録実行テキスト管理者メール
function getSqlSelectManagerAddress() {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  manager_address1, ";
  $sql.= "  manager_address2, ";
  $sql.= "  manager_address3, ";
  $sql.= "  manager_address4 ";
  $sql.= "FROM ";
  $sql.= "setting ";
  $sql.= "WHERE ";
  $sql.= "  setting_id = '1' ";

  return $sql;
}

//承認登録実行
function getSqlDeleteGroup($arg_map) {
  $sql = "";
  $sql.= "UPDATE group1 SET ";
  $sql.= "  delete_flag = '1' , ";
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."'  ";
  $sql.= "WHERE ";
  $sql.= "  approval_status = '1' AND ";
  $sql.= "  group_id = ".intval($arg_map["group_id"])." AND ";
  $sql.= "  approval_status = '1' AND";
  $sql.= "  delete_flag = '0' ";

  return $sql;
}

function getSqlSelectSettingCode() {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  setting_pass_code, ";
  $sql.= "  setting_member_code ";
  $sql.= "FROM ";
  $sql.= " setting ";
  $sql.= "WHERE ";
  $sql.= "  setting_id = '1' ";

  return $sql;
}

?>
