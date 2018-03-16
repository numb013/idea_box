<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>メーリングリスト登録フォーム</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex,nofollow,noarchive">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<link rel="stylesheet" type="text/css" href="./css/jquery.mobile-1.1.2.css" />
<link rel="stylesheet" type="text/css" href="./css/jqm-datebox.min.css" />
<link rel="stylesheet" type="text/css" href="./css/modal.css" />
<link rel="stylesheet" type="text/css" href="./css/modal-multi.css" />
<link rel="apple-touch-icon" href="./css/images/fb_mark.png">
<script type="text/javascript" src="./js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="./js/jquery.mobile-1.1.0.min.js"></script>
<script type="text/javascript" src="./js/jqm-datebox.core.min.js"></script>
<script type="text/javascript" src="./js/jqm-datebox.mode.calbox.min.js"></script>
<script type="text/javascript" src="./js/jqm-datebox.mode.datebox.min.js"></script>
<script type="text/javascript" src="./js/jqm-datebox.mode.flipbox.min.js"></script>
<script type="text/javascript" src="./js/modal.js"></script>
<script type="text/javascript" src="./js/modal-multi.js"></script>
<script src="./js/jquery.mobile.datebox.i8n.jp.js"></script>
<script src="./js/late_text.js"></script>
<script src="./js/early_radio.js"></script>

<script type="text/javascript" src="./js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="./js/jquery-ui.js"></script>
<script type="text/javascript" src="./js/jquery.ui.datepicker-ja.min.js"></script>
<link rel="stylesheet" type="text/css" href="./css/jquery-ui.css" />

<script>
  $(function() {ldelim}
    $.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
    $( "#datepicker" ).datepicker();
  {rdelim});

 function back() {ldelim}
  document.form_back.submit()
 {rdelim}
</script>

</head>
<body>
  <!-div id="home" data-role="page">
    <div data-role="header">
      <h1>メーリングリスト登録フォーム</h1>
    </div><!-- /header -->
    <div data-role="content">	
      <h4>以下の内容で送信します。よろしいでしょうか</h4>
      {include file="_error_msg.tpl"}
      <table class="form">
        <tr>
          <th>社名</th>
        </tr>
        <tr>
          <td>{$input_map.company|escape}</td>
        </tr>
        <tr>
          <th>氏名</th>
        </tr>
        <tr>
          <td>{$input_map.member_name|escape}</td>
        </tr>
        <tr>
          <th>研修日</th>
        </tr>
        <tr>
          <td>{$input_map.training_datetime|escape}</td>
        </tr>
        <tr>
        <tr>
          <th>研修コード</th>
        </tr>
          <td>{$trainingcodeDef->getStringByValue($input_map.training_code)|escape}</td>
        </tr>
        <tr>
          <th>テーブルID</th>
        </tr>
        <tr>
          <td>{$tablecodeDef->getStringByValue($input_map.table_code)|escape}</td>
        </tr>
        <tr>
          <th>メールアドレス</th>
        </tr>
        <tr>
          <td>{$input_map.mail_address|escape}</td>
        </tr>
        <tr>
          <th>備考テキスト</th>
        </tr>
        <tr>
          <td>{$input_map.memo|escape|nl2br}</td>
        </tr>
      </table>
      <br><br>

      <form action="{$smarty.const.URL_ROOT_HTTPS}/form_completion.php" method="POST" data-ajax="false">
        <input type="hidden" name="mode" value="completion">
        <input type="hidden" name="post_key" value="{$post_key|escape}">
        <div class="button_1">
          <input type="submit" value="登録" class="button">
        </div>
      </form>
      <form action="{$smarty.const.URL_ROOT_HTTPS}/index.php" name="form_back" method="POST" data-ajax="false">
        <input type="hidden" name="mode" value="back">
        <div class="button_1">
          <input type="button" value="戻る" onclick="back()" />
        </div>
      </form>
    </div><!-- /content -->
  </div--><!-- /page -->
</body>
</html>
