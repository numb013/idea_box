<html>
 <head>
  <title>{$smarty.const.ADMIN_TITLE}</title>
  <meta http-equiv="Content-Language" content="ja">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="robots" content="noindex,nofollow,noarchive" />
  <meta http-equiv="Content-Style-Type" content="text/css">
  <meta http-equiv="Content-Script-Type" content="text/javascript">
  <link rel="stylesheet" href="./_design/styles/login.css" type="text/css">
  </head>
  <body id="login">
    <div id="head">
      <h1>管理者ログイン画面</h1>
    </div>
    <form id="login_form" action="{$smarty.const.URL_ROOT_HTTPS}/admin/login.php" method="post">
      <table class="form">
        <thead>
          <tr>
            <th colspan="2">
              IDとパスワードを入力してログインして下さい。<br>
              {if $error_flag eq 1}
              <font color="FF0000">ログインできません。</font>
              {/if}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>ログインID</th>
            <td><input type="text" name="login_id"></td>
          </tr>
          <tr>
            <th>パスワード</th>
            <td><input type="password" name="login_password"></td>
          </tr>
          </tbody>
          <tfoot>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" value="ログイン" class="button"></td>
          </tr>
        </tfoot>
      </table>
      <input type="hidden" name="mode" value="login">
    </form>
  </body>
</html>