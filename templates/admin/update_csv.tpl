<html>
  <head>
  <title>{$smarty.const.ADMIN_TITLE}</title>
  <meta http-equiv="Content-Language" content="ja">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="robots" content="noindex,nofollow,noarchive" />
  <meta http-equiv="Content-Style-Type" content="text/css">
  <link rel="stylesheet" href="./_design/styles/core.css" type="text/css">
  </head>
  <body>
    <div id="body">
      <!-- コンテンツヘッダー部 start -->
      {include file="admin/_header.tpl"}
      <!-- コンテンツヘッダー部  end  -->
      <div id="bodyContainer">
      <h3>アップロード登録</h3>
      {include file="admin/_error_msg.tpl"}
      <form action="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/update_csv.php" method="post" enctype="multipart/form-data">
        <input type="file" name="upload_file" size="30" /><br />
        <input type="hidden" name="mode" value="upload" /><br />
        <br />
        <input type="submit" value="アップロード" />
      </form>
      </div>
    </div>
    <!-- メニュー部 start -->
    {include file="admin/_menu.tpl"}
    <!-- メニュー部  end  -->
  </body>
</html>
