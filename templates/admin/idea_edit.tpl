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
        <h3>アイデア編集</h3>
          <form action="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/idea_edit.php" method="post">
            <table class="table" width="95%">
              <tr>
                <th>タイトル</th>
                <th>内容</th>
                <th>承認</th>
                <th>投稿日</th>
                <th>発案者</th>
                </tr>
                  <tr>
                    <td>
                      <input type="text" name="title" size="40" value={$idea_map.title|escape}>
                    </td>
                    <td>
                      <input type="text" name="body" size="40" value={$idea_map.body|escape}>
                    </td>
                    <td>
                      <center>{html_radios name='approval_flag' options=$approval selected=$idea_map.approval_flag}</center>
                    </td>
                    <td>
                      <center>{$idea_map.insert_datetime|escape|date_format:"%Y-%m-%d"}</center>
                    </td>
                    <td>
                      <center>{$idea_map.shain_id|escape}</center>
                    </td>
                  </tr>
                </tr>
              </table>
              <input type="hidden" name="id" value="{$idea_map.id|escape}">
              <input type="hidden" value="edit" name="mode">
              <input type="submit" value="編集" class="button">
            </form>
        <p><a href="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/idea_list.php?page={$page|escape}">戻る</a></p>
      </div>
      <br>
      <br>
      <br>
      <br>
      <br>
    </div>
    <!-- メニュー部 start -->
    {include file="admin/_menu.tpl"}
    <!-- メニュー部  end  -->
  </body>
</html>
