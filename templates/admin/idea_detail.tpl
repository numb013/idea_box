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
        <h3>アイデア詳細</h3>
          <table class="table" width="95%">
            <tr>
              <th>タイトル</th>
              <th>内容</th>
              <th>投稿日</th>
              <th>発案者</th>
              </tr>
                <tr>
                  <td width="10%"><center>{$idea_map.title|escape}</center></td>
                  <td width="10%"><center>{$idea_map.body|escape}</center></td>
                  <td width="10%"><center>{$idea_map.created_at|escape|date_format:"%Y-%m-%d"}</center></td>
                  <td width="10%"><center>{$idea_map.user_id|escape}</center></td>
                </tr>
              </tr>
            </table>
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
