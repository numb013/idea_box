<?php
error_reporting(E_ALL & ~E_NOTICE);

require_once("_module/requires.php");
require_once("_define/TableCodeDef.php");  // テーブルID
require_once("_define/TrainingCodeDef.php");  // 研修コード
require_once("./login_check.php");

mb_language("Japanese");
mb_internal_encoding("utf-8");

session_start();



/**-------------------------------------------------------------------------------------------------
  初期処理
--------------------------------------------------------------------------------------------------*/

// クラスのインスタンス化
$smarty         = new ChildSmarty();
$util           = new Util();
$checkUtil      = new CheckUtil(); // チェック関数で
$dbFunctions    = new DBFunctions();

$tablecodeDef = new TableCodeDef();
$smarty->assign("tablecodeDef", $tablecodeDef);

$trainingcodeDef = new TrainingCodeDef();
$smarty->assign("trainingcodeDef", $trainingcodeDef);



/**-------------------------------------------------------------------------------------------------
  リクエストより必要データ取得 & バリデーション
--------------------------------------------------------------------------------------------------*/

$mode            = $_POST["mode"]; // postデータを$modeに受け取る
$group_member    = $_GET["group_member"];

/**-------------------------------------------------------------------------------------------------
  メイン処理
--------------------------------------------------------------------------------------------------*/
if ($group_member == "group_member") {

  $page                = $_GET["number"];

if (strlen($_GET["approval_status"])) {
  $approval_status = $_GET["approval_status"];
}
if (strlen($_POST["approval_status"])) {
  $approval_status = $_POST["approval_status"];
}

if (strlen($_GET["group_id"])) {
  $arg_map["group_id"] = $_GET["group_id"];
}
if (strlen($_POST["group_id"])) {
  $arg_map["group_id"] = $_POST["group_id"];
}

  $sql = getSqlSelectgroup_1($arg_map);
  $input_map  = $dbFunctions->getMap($sql);

  $smarty->assign("page", $page);
  $smarty->assign("group_id", $arg_map["group_id"]);
  $smarty->assign("approval_status", $approval_status);
  $smarty->assign("input_map", $input_map);
  $smarty->display(TEMPLATE_DIR."/admin/member_insert.tpl");
  exit();

} else if ($mode == "confirmation") {

  /**-----------------------------------------------------------------------------------------------
    入力確認
  ------------------------------------------------------------------------------------------------*/

  // 入力情報を受け取る
  $input_map                      = null;
  $input_map["company"]           = $_POST["company"];
  $input_map["member_name"]       = $_POST["member_name"];
  $input_map["training_datetime"] = $_POST["training_datetime"];
  $input_map["training_code"]     = $_POST["training_code"];
  $input_map["table_code"]        = $_POST["table_code"];
  $input_map["mail_address"]      = $_POST["mail_address"];
  $input_map["memo"]              = $_POST["memo"];
  $input_map["approval_status_1"] = $_POST["approval_status_1"];
  $page                           = $_POST["number"];
  $group_id                       = $_POST["group_id"];
  $approval_status                = $_POST["approval_status"];

  $_SESSION["company"]           = $input_map["company"];
  $_SESSION["member_name"]       = $input_map["member_name"];
  $_SESSION["training_datetime"] = $input_map["training_datetime"];
  $_SESSION["training_code"]     = $input_map["training_code"];
  $_SESSION["table_code"]        = $input_map["table_code"];
  $_SESSION["mail_address"]      = $input_map["mail_address"];
  $_SESSION["memo"]              = $input_map["memo"];
  $_SESSION["approval_status_1"] = $input_map["approval_status_1"];
  $_SESSION["page"]              = $page;
  $_SESSION["group_id"]          = $group_id;
  $_SESSION["approval_status"]   = $approval_status;

  // チェック関数へ
  $error_map = input_check($input_map);

  if (is_array($error_map)) {

    // エラー表示
    $smarty->assign("error_map", $error_map);
    $smarty->assign("page", $page);
    $smarty->assign("group_id", $group_id);
    $smarty->assign("approval_status", $approval_status);

    // 入力情報をそのまま表示
    $smarty->assign("input_map", $input_map);
    $smarty->display(TEMPLATE_DIR."/admin/member_insert.tpl");
    exit();

  } else {

    // セッションに格納
    $_SESSION["input_map"] = $input_map;
    // Confirmaitonに入力情報を確認表示
    $smarty->assign("input_map", $input_map);

    $smarty->assign("page", $page);
    $smarty->assign("group_id", $group_id);
    $smarty->assign("approval_status", $approval_status);

    // POSTキー
    $post_key = md5(uniqid(rand(), true));
    $_SESSION["post_key"] = $post_key;
    $smarty->assign("post_key", $post_key);

    $smarty->display(TEMPLATE_DIR."/admin/member_insert_confirmation.tpl");
    exit();

  }

} else if ($mode == "back") {

/**-----------------------------------------------------------------------------------------------
  戻る
------------------------------------------------------------------------------------------------*/

  // 戻った時に入力情報をセッションから取得
  $input_map = $_SESSION;

  $page            = $input_map["page"];
  $group_id        = $input_map["group_id"];
  $approval_status = $input_map["approval_status"];

  $smarty->assign("page", $page);
  $smarty->assign("group_id", $group_id);
  $smarty->assign("approval_status", $approval_status);
  $smarty->assign("input_map", $input_map);

  $smarty->display(TEMPLATE_DIR."/admin/member_insert.tpl");
  exit();

} else if ($mode == "completion") {



/**-----------------------------------------------------------------------------------------------
  登録
------------------------------------------------------------------------------------------------*/

  $post_key  = $_POST["post_key"];

  $page              = $_POST["number"];
  $group_id          = $_POST["group_id"];
  $approval_status_1 = $_POST["approval_status"];


  $input_map = $_SESSION["input_map"];
  $error_map = input_check($input_map);

  if (is_array($error_map)) {

    $util->echoString(E_AGAIN);
    exit();

  } else {

    if (!strlen($_SESSION["post_key"])) {

      $util->echoString(E_AGAIN);
      exit();

    } else if ($post_key == $_SESSION["post_key"]) {

      // セッションを書き換え
      $_SESSION["post_key"] = "unavailable";

      $datetime = $util->getYmdHis();
      $input_map["table_code_1"]        = $tablecodeDef->getStringByValue($input_map["table_code"]);
      $input_map["training_code_1"]     = $trainingcodeDef->getStringByValue($input_map["training_code"]);
      $input_map["training_datetime_1"] = str_replace("-", "", $input_map["training_datetime"]);
      $input_map["group_name"]          = "Challengemail". $input_map["training_datetime_1"]. "_". $input_map["table_code_1"]. "_". $input_map["training_code_1"];
      $input_map["approval_status_1"]   = $approval_status_1;

      $arg_map = $input_map;
      $sql = getSqlSelectgroup($arg_map);
      $group_id_map = $dbFunctions->getMap($sql);

      //承認待ちに同じリスト名がなければ
      if (!strlen($group_id_map["group_id"])) {

        $sql = getSqlSelectGroupId_1($arg_map);
        $group_id_map = $dbFunctions->getMap($sql);
        $input_map["group_id"] = $group_id_map["MAX(group_id)"]+1;

        //linuxの操作newlstでリストをつくり
        $list_name = $input_map["group_name"];
        //ランダムパスワード生成
        $ar1 = range('a', 'z'); // アルファベット小文字を配列に
        $ar2 = range('A', 'Z'); // アルファベット大文字を配列に
        $ar3 = range(0, 9); // 数字を配列に
        $ar_all = array_merge($ar1, $ar2, $ar3); // すべて結合
        shuffle($ar_all); // ランダム順にシャッフル
        $list_password = substr(implode($ar_all), 0, 16); // 先頭の16文字


        //コマンド例
        $newlist = "sudo /usr/local/psa/bin/maillist -c ".$list_name." -domain ".DOMAIN." -passwd ".$list_password." -passwd_type plain -email ".HOST_ADDRESS;
        exec("$newlist");

        // config_list_input.txtをリストにインプットし設定変更
        $config_list = "sudo /usr/lib/mailman/bin/config_list -i ".FCE_ROOT."/idea_box/txt/config_list_input.txt ".$list_name;
        exec("$config_list");

        $arg_map                         = $input_map;
        $arg_map["mailing_list_address"] = $arg_map["group_name"]. URL_ROOT_FCE;
        $arg_map["insert_datetime"]      = $datetime;
        $arg_map["update_datetime"]      = $datetime;
        $arg_map["approval_status"]      = 1;
        $arg_map["group_id"]             = $input_map["group_id"];
        $arg_map["delete_flag"]          = 0;
        $arg_map["list_password"]        = $list_password;

        //リスト作成
        $sql = getSqlInsertGroup($arg_map);

        $dbFunctions->mysql_query($sql);

        //メンバー作成
        $sql = getSqlInsertMember($arg_map);
        $dbFunctions->mysql_query($sql);

      } else { // 承認済み非承認に同じリスト名があれば

        if ($input_map["approval_status_1"] == "2") {

          $arg_map["group_id"] = $group_id_map["group_id"];
          $sql = getSqlSelectMember($arg_map);
          $member_list = $dbFunctions->getListIncludeMap($sql);

          for ($i = 0; $i < count($member_list); $i++) {
            if ($member_list[$i]["mail_address"] == $input_map["mail_address"]) {
              $error_map["error"] = "このグループ内に同じメールアドレスがありますので登録できません。";

              $post_key = "aaaa";
              $smarty->assign("post_key", $post_key);

              $smarty->assign("approval_status", $approval_status_1);
              $smarty->assign("group_id", $group_id);
              $smarty->assign("page", $page);
              $smarty->assign("input_map", $input_map);
              $smarty->assign("error_map", $error_map);
              $smarty->display(TEMPLATE_DIR."/admin/member_insert.tpl");
              exit();
            }
          }

          $arg_map                    = $input_map;
          $arg_map["group_id"]        = $group_id_map["group_id"];
          $arg_map["insert_datetime"] = $datetime;
          $arg_map["update_datetime"] = $datetime;
          $arg_map["approval_status"] = 1;
          $arg_map["delete_flag"]     = 0;
          $sql = getSqlInsertFrom2($arg_map);
          $dbFunctions->mysql_query($sql);

          $mail_address = $input_map["mail_address"];
          //linuxの操作でadd_membersでメンバー追加する
          $list_name = $input_map["group_name"];
          //コマンド例
          $list_member = "sudo /usr/local/psa/bin/maillist -u ".$list_name." -domain ".DOMAIN." -members add:".$mail_address;
          exec("$list_member");

          if (strlen($approval_status_1)) {
            header("Location: ".URL_ROOT."/tcm-admin/group_member_list.php?group_id=".$group_id."&approval_status=".$approval_status_1."&number=".$page);
          } else {
            $smarty->display(TEMPLATE_DIR."/admin/member_insert_completion.tpl");
            exit();
          }
        }

        if ($group_id_map["approval_status"] == 1) {

          $arg_map                    = $input_map;
          $arg_map["group_id"]        = $group_id_map["group_id"];
          $arg_map["insert_datetime"] = $datetime;
          $arg_map["update_datetime"] = $datetime;
          $arg_map["approval_status"] = 1;
          $arg_map["delete_flag"]     = 0;
          $sql = getSqlInsertMember($arg_map);
          $dbFunctions->mysql_query($sql);

        } else if ($group_id_map["approval_status"] == 3) {

          $arg_map["group_id"] = $group_id_map["group_id"];
          $arg_map["update_datetime"] = $datetime;
          $sql = getSqlUpdeteStatus($arg_map);
          $dbFunctions->mysql_query($sql);

          $arg_map                    = $input_map;
          $arg_map["group_id"]        = $group_id_map["group_id"];
          $arg_map["insert_datetime"] = $datetime;
          $arg_map["update_datetime"] = $datetime;
          $arg_map["approval_status"] = 1;
          $arg_map["delete_flag"]     = 0;
          $sql = getSqlInsertMember($arg_map);
          $dbFunctions->mysql_query($sql);

        }
      }

      if ($input_map["approval_status_1"] == "1" or $input_map["approval_status_1"] == "") {

        // メール送信
        $temp_map = null;
        $temp_map["member_name"] = mb_convert_encoding($input_map["member_name"], "utf-8");
        $mail_content = $util->setMailValue(PATH_ROOT."/tcm-admin/_mail/contact.txt", $temp_map);
        // ↓デバック用
        // $mail_content = mb_convert_encoding(str_replace("\n", "<br>", $mail_content), "EUC-JP", "SJIS");print($mail_content);exit();
        $mail_content = mb_convert_encoding($mail_content, "utf-8");
        $util->sendMail($input_map["mail_address"], "", "", "mail_master@training-c.co.jp" , "チャレンジメールへのご参加を受け付けました", $mail_content);

      }
    }
  }

 // メンバーの追加がgroup_member_list.phpからなら
 if (strlen($approval_status_1)) {
   header("Location: ".URL_ROOT."/tcm-admin/group_member_list.php?group_id=".$group_id."&approval_status=".$approval_status_1."&number=".$page);
 } else {
   $smarty->display(TEMPLATE_DIR."/admin/member_insert_completion.tpl");
   exit();
 }

} else {



/**-----------------------------------------------------------------------------------------------
  初期処理
------------------------------------------------------------------------------------------------*/

  $smarty->display(TEMPLATE_DIR."/admin/member_insert.tpl");
  exit();

}



/**-------------------------------------------------------------------------------------------------
  関数
--------------------------------------------------------------------------------------------------*/

function input_check($input_map) {

  global $checkUtil;
  global $contactSelectDef;

  $error_map = null;

  // 社名
  if (!strlen($input_map["company"])) {
    $error_map["company"] = "社名を入力してください。";
  } else if (mb_strlen($input_map["company"]) > 50) {
    $error_map["company"] = "社名が長すぎます。";
  }
  // 氏名
  if (!strlen($input_map["member_name"])) {
    $error_map["member_name"] = "氏名を入力してください。";
  } else if (mb_strlen($input_map["member_name"]) > 50) {
    $error_map["member_name"] = "氏名が長すぎます。";
  }
  // 研修日
  if (!strlen($input_map["training_datetime"])) {
    $error_map["training_datetime"] = "研修日を入力してください。";
  } else if (strlen($input_map["training_datetime"])) {
    $yyyymmdd = "";
    $flag     = "";
    $yyyymmdd = explode("-", $input_map["training_datetime"]);

    if (count($yyyymmdd) != 3) {
      $error_map[] = "研修日の形式が不正です。";
    } else {
      for ($a =0; $a < count($yyyymmdd); $a++) {
        if ($checkUtil->checkHanSu($yyyymmdd[$a]) == "9") {
          $error_map[] = "研修日は半角数字と「-」で入力してください。";
          $flag = 1;
          break;
        }
      }
      if ($flag != 1) {
        if (!checkdate($yyyymmdd[1], $yyyymmdd[2], $yyyymmdd[0])) {
          $error_map[] = "研修日が不正です。";
        } else if (strlen($yyyymmdd[0]) > 4) {
          $error_map[] = "研修日が不正です。";
        } else if (strlen($yyyymmdd[1]) > 2) {
          $error_map[] = "研修日が不正です。";
        } else if (strlen($yyyymmdd[2]) > 2) {
          $error_map[] = "研修日が不正です。";
        }
      }
    }
  } else if (10 < strlen($input_map["training_datetime"])) {
    $error_map[] = "研修日が不正です。";
  }
  // 研修コード
  if (!strlen($input_map["training_code"])) {
    $error_map[training_code] = "研修コードを選択してください。";
  } else if ($input_map["training_code"] > 3) {
    $error_map[training_code] = "研修コードが不正です。";
  } else if ($input_map["training_code"] <= 0) {
    $error_map[training_code] = "研修コードが不正です。";
  }
  // テーブルID
  if (!strlen($input_map["table_code"])) {
    $error_map[table_code] = "テーブルIDを選択してください。";
  } else if ($input_map["table_code"] > 50) {
    $error_map[table_code] = "テーブルIDが不正です。";
  } else if ($input_map["table_code"] <= 0) {
    $error_map[table_code] = "テーブルIDが不正です。";
  }
  // メールアドレス
  if (!strlen($input_map["mail_address"])) {
    $error_map["mail_address"] = "メールアドレスを入力して下さい。";
  } else if ($checkUtil->checkMailForm($input_map["mail_address"]) == "9") {
    $error_map["mail_address"] = "メールアドレスの形式が不正です。";
  } else if (strlen($input_map["mail_address"]) > 100) {
    $error_map["mail_address"] = "メールアドレスが長すぎます。";
  }
  // 備考テキスト
  if (strlen($input_map["memo"]) > 3000) {
    $error_map["memo"] = "備考テキストが長すぎます。";
  }
  if (is_array($error_map)) {
    return $error_map;
  } else {
    return "";
  }
}



/**-------------------------------------------------------------------------------------------------
  SQL
--------------------------------------------------------------------------------------------------*/

function getSqlSelectgroup($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= " group_id, ";
  $sql.= " approval_status ";
  $sql.= "FROM ";
  $sql.= "  group1 ";
  $sql.= "WHERE ";
  $sql.= "  group_name = '".mysql_escape_string($arg_map["group_name"])."' AND ";
  if (strlen($arg_map["approval_status_1"])) {
    $sql.= "  approval_status = ".intval($arg_map["approval_status_1"])." AND ";
  } else {
    $sql.= "  approval_status != '2' AND ";
//    $sql.= "  approval_status = '1' AND ";
  }
  $sql.= "  delete_flag = '0'";

  return $sql;
}

function getSqlSelectgroup_1($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  training_datetime , ";
  $sql.= "  table_code ,";
  $sql.= "  approval_status , ";
  $sql.= "  training_code ";
  $sql.= "FROM ";
  $sql.= "  group1 ";
  $sql.= "WHERE ";
  if (strlen($arg_map["group_id"])) {
    $sql.= "  group_id = ".intval($arg_map["group_id"])." ";
  }

  return $sql;
}

function getSqlSelectMember($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= "  mail_address ";
  $sql.= "FROM ";
  $sql.= "  member ";
  $sql.= "WHERE ";
  $sql.= "  group_id = ".intval($arg_map["group_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}

function getSqlSelectGroupId_1($arg_map) {
  $sql = "";
  $sql.= "SELECT ";
  $sql.= " MAX(group_id) ";
  $sql.= "FROM ";
  $sql.= "  group1 ";

  return $sql;
}

function getSqlInsertGroup($arg_map) {
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
  $sql.= "  delete_flag, ";
  $sql.= "  list_password ";
  $sql.= ") ";
  $sql.= "VALUES ( ";
  $sql.= "  ".intval($arg_map["group_id"]).", ";
  $sql.= "  '".mysql_escape_string($arg_map["group_name"])."', ";
  $sql.= "  '".mysql_escape_string($arg_map["training_datetime"])."', ";
  $sql.= "  ".intval($arg_map["training_code"]).", ";
  $sql.= "  ".intval($arg_map["table_code"]).", ";
  $sql.= "  '".mysql_escape_string($arg_map["mailing_list_address"])."', ";
  $sql.= "  ".intval($arg_map["approval_status"]).", ";
  $sql.= "  '".mysql_escape_string($arg_map["insert_datetime"])."', ";
  $sql.= "  '".mysql_escape_string($arg_map["update_datetime"])."', ";
  $sql.= "  ".intval($arg_map["delete_flag"]).", ";
  $sql.= "  '".mysql_escape_string($arg_map["list_password"])."'";
  $sql.= ")";

  return $sql;
}

function getSqlInsertMember($arg_map) {
  $sql = "";
  $sql.= "INSERT INTO member ( ";
  $sql.= "  group_id, ";
  $sql.= "  company, ";
  $sql.= "  member_name, ";
  $sql.= "  mail_address, ";
  $sql.= "  memo, ";
  $sql.= "  approval_status, ";
  $sql.= "  insert_datetime, ";
  $sql.= "  update_datetime, ";
  $sql.= "  delete_flag ";
  $sql.= ") ";
  $sql.= "VALUES ( ";
  $sql.= "  ".intval($arg_map["group_id"]).", ";
  $sql.= "  '".mysql_escape_string($arg_map["company"])."', ";
  $sql.= "  '".mysql_escape_string($arg_map["member_name"])."', ";
  $sql.= "  '".mysql_escape_string($arg_map["mail_address"])."', ";
  $sql.= "  '".mysql_escape_string($arg_map["memo"])."', ";
  $sql.= "  ".intval($arg_map["approval_status"]).", ";
  $sql.= "  '".mysql_escape_string($arg_map["insert_datetime"])."', ";
  $sql.= "  '".mysql_escape_string($arg_map["update_datetime"])."', ";
  $sql.= "  ".intval($arg_map["delete_flag"]);
  $sql.= ")";

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
  $sql.= " setting_id = 1";

  return $sql;

}

//グループ削除実行
function getSqlUpdeteStatus($arg_map) {
  $sql = "";
  $sql.= "UPDATE group1 SET ";
  $sql.= "  approval_status = '1' ,";
  $sql.= "  update_datetime = '".mysql_escape_string($arg_map["update_datetime"])."'  ";
  $sql.= "WHERE ";
  $sql.= "  group_id =".intval($arg_map["group_id"])." AND ";
  $sql.= "  delete_flag = '0'";

  return $sql;
}
?>