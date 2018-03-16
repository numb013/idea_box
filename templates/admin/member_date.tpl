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
        <h3>メンバー詳細</h3>
        {include file="admin/_error_msg.tpl"}
        <table class="form"  width="50%">
          <tr>
            <th width="40%">グループ名</th>
            <td>{$group_name_map.group_name|escape}</td>
          </tr>
          <tr>
            <th width="40%">社名</th>
            <td>{$group_member_map.company|escape}</td>
          </tr>
          <tr>
            <th width="40%">氏名</th>
            <td>{$group_member_map.member_name|escape}</td>
          </tr>
          <tr>
            <th width="40%">研修日</th>
            <td>{$group_member_map.training_datetime|date_format:"%Y-%m-%d"}</td>
          </tr>
          <tr>
            <th width="40%">研修コード</th>
            <td>{$trainingcodeDef->getStringByValue($group_member_map.training_code)|escape}</td>
          </tr>
          <tr>
            <th width="40%">テーブルID</th>
            <td>{$tablecodeDef->getStringByValue($group_member_map.table_code)|escape}</td>
          </tr>
          <tr>
            <th width="40%">メールアドレス</th>
            <td>{$group_member_map.mail_address|escape}</td>
          </tr>
          <tr>
            <th width="40%">備考テキスト</th>
            <td>{$group_member_map.memo|escape|nl2br}</td>
          </tr>
        </table>
        <br><br>
        <div>
          <a href="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/group_member_list.php?group_id={$group_member_map.group_id|escape}&approval_status={$approval_status|escape}&number={$page|escape}">戻る</a>
        </div>
      </div>
    </div>
    <!-- メニュー部 start -->
    {include file="admin/_menu.tpl"}
    <!-- メニュー部  end  -->
  </body>
</html>