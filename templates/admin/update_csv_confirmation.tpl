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
      <div id="bodyContainer_ken">
        </form>
      </div>
      <!-- コンテンツヘッダー部  end  -->
      <div id="bodyContainer">
        <h3>アップロード確認画面</h3>
        {include file="admin/_error_msg.tpl"}
        {if !strlen($error_map)}
        <form action="approval.php" method="POST" name="approval_form">
          <table class="table" width="95%">
            <tr>
              <th width="10%">登録日</th>
              <th width="10%">メーリスグループ</th>
              <th width="10%">社名</th>
              <th width="10%">氏名</th>
              <th width="10%">研修日</th>
              <th width="10%">研修コード</th>
              <th width="10%">テーブルID</th>
              <th width="10%">メールアドレス</th>
              <th width="10%">備考</th>
            </tr>
            {foreach item="csv_map" from=$update_csv_list key=item_key}
              <tr>
                <td><center>{$csv_map.8|escape|date_format:"%Y-%m-%d"}</center></td>
                <td><center>{$csv_map.7|escape}</center></td>
                <td><center>{$csv_map.0|escape}</center></td>
                <td><center>{$csv_map.1|escape}</center></td>
                <td><center>{$csv_map.2|escape}</center></td>
                <td><center>{$csv_map.3|escape}</center></td>
                <td><center>{$tablecodeDef->getStringByValue($csv_map.4)|escape}</center></td>
                <td><center>{$csv_map.5|escape}</center></td>
                <td><center>{$csv_map.6|escape}</center></td>
              </tr>
            {/foreach}
          </table>
        </form>
        <form action="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/update_csv.php" method="post">
          <input type="submit" value="登録" class="button">
          <input type="hidden" name="mode" value="completion">
          <input type="hidden" name="post_key" value="{$post_key|escape}">
        </form>
        {/if}
        <form action="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/update_csv.php" method="post">
          <input type="submit" value="戻る" class="button">
          <input type="hidden" name="mode" value="back">
        </form>
      </div>
      <br>
      <br>
    </div>
    <!-- メニュー部 start -->
    {include file="admin/_menu.tpl"}
    <!-- メニュー部  end  -->
  </body>
</html>
