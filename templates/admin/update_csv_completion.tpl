<html>
  <head>
    <title>{$smarty.const.ADMIN_TITLE}</title>
    <meta http-equiv="Content-Language" content="ja">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="robots" content="noindex,nofollow,noarchive">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <link rel="stylesheet" href="./_design/styles/core.css" type="text/css">
    <title>個別登録完了画面</title>
    <meta http-equiv="Content-Language" content="ja">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  </head>
  <body>
    <div id="body">
      <!-- コンテンツヘッダー部 start -->
      {include file="admin/_header.tpl"}
      <!-- コンテンツヘッダー部  end  -->
      <div id="bodyContainer">
        <h3>アップロード登録完了</h3>
        <p class="message">アップロード登録が完了しました。</p>
        <a href="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/group_list.php">承認待ちグループ一覧へ</a>
      </div>
    </div>
  <!-- メニュー部 start -->
  {include file="admin/_menu.tpl"}
  <!-- メニュー部  end  -->
  </body>
</html>