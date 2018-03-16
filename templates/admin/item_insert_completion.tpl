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
        <h3>商品登録</h3>
        <p class="message">商品が完了しました。</p>
        <a href="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/item_list.php">商品一覧ページへ</a><br><br>
        <a href="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/item_insert.php">商品登録へ</a><br><br>
        <a href="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/group_non_admitted_list.php">非承認グループ一覧へ</a>
      </div>
    </div>
    <!-- メニュー部 start -->
    {include file="admin/_menu.tpl"}
    <!-- メニュー部  end  -->
  </body>
</html>
