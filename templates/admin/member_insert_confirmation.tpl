<html>
  <head>
    <title>{$smarty.const.ADMIN_TITLE}</title>
    <meta http-equiv="Content-Language" content="ja">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="robots" content="noindex,nofollow,noarchive">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <link rel="stylesheet" href="./_design/styles/core.css" type="text/css">
  </head>
  <body>
    <div id="body">
    <!-- コンテンツヘッダー部 start -->
    {include file="admin/_header.tpl"}
    <div id="bodyContainer">
    <h3>入力確認</h3>
    <h4>以下の内容で登録します。よろしいでしょうか</h4>
    {include file="admin/_error_msg.tpl"}
      <table class="form">
        <tr>
          <th>社名</th>
          <td>{$input_map.company|escape}</td>
        </tr>
        <tr>
          <th>氏名</th>
          <td>{$input_map.member_name|escape}</td>
        </tr>
        <tr>
          <th>研修日</th>
          <td>{$input_map.training_datetime|escape}</td>
        </tr>
        <tr>
          <th>テーブルID</th>
          <td>{$trainingcodeDef->getStringByValue($input_map.training_code)|escape}</td>
        </tr>
        <tr>
          <th>テーブルID</th>
          <td>{$tablecodeDef->getStringByValue($input_map.table_code)|escape}</td>
        </tr>
        <tr>
          <th>メールアドレス</th>
          <td>{$input_map.mail_address|escape}</td>
        </tr>
        <tr>
          <th>備考テキスト</th>
          <td>{$input_map.memo|escape|nl2br}</td>
        </tr>
      </table>
      <br><br>
      <table>
        <tr>
          <form action="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/member_insert.php" method="post">
            <td>
              <input type="submit" value="登録" class="button">
            </td>
            <input type="hidden" name="mode" value="completion">
            <input type="hidden" value={$page|escape} name="number">
            <input type="hidden" value={$group_id|escape} name="group_id">
            <input type="hidden" value={$approval_status|escape} name="approval_status">
            <input type="hidden" value={$input_map.$approval_status|escape}  name="approval_1">
            <input type="hidden" name="post_key" value="{$post_key|escape}">
          </form>
          <form action="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/member_insert.php" method="post">
            <td>
              <input type="submit" value="戻る" class="button">
            </td>
            <input type="hidden" name="mode" value="back">
          </form>
        </tr>
      </table>
    <!-- メニュー部 start -->
    {include file="admin/_menu.tpl"}
    <!-- メニュー部  end  -->
  </body>
</html>