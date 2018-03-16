<html>
  <head>
    <title>{$smarty.const.ADMIN_TITLE}</title>
    <meta http-equiv="Content-Language" content="ja">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="robots" content="noindex,nofollow,noarchive">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <link rel="stylesheet" href="./_design/styles/core.css" type="text/css">
    <title>編集完了画面</title>
    <meta http-equiv="Content-Language" content="ja">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  </head>
  <body>
    <div id="body">
      <!-- コンテンツヘッダー部 start -->
      {include file="admin/_header.tpl"}
      <!-- コンテンツヘッダー部  end  -->
      <div id="bodyContainer">
        <h3>編集完了</h3>
        <p class="message">編集が完了しました。</p>
        <a href="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/group_list.php">承認待ちグループ一覧へ</a><br><br>
        <a href="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/group_approval_list.php">承認済みグループ一覧へ</a><br><br>
        <a href="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/group_non_admitted_list.php">非承認グループ一覧へ</a><br><br>
        <a href="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/member_non_admitted_list.php">非承認グループ一覧へ</a>
      </div>
    </div>
    <!-- メニュー部 start -->
    {include file="admin/_menu.tpl"}
    <!-- メニュー部  end  -->
  </body>
</html>