<?php /* Smarty version 2.6.9, created on 2018-03-15 18:03:57
         compiled from /var/www/html/data/mailing_list/templates/admin/login.tpl */ ?>
<html>
 <head>
  <title><?php echo @ADMIN_TITLE; ?>
</title>
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
    <form id="login_form" action="<?php echo @URL_ROOT_HTTPS; ?>
/tcm-admin/login.php" method="post">
      <table class="form">
        <thead>
          <tr>
            <th colspan="2">
              IDとパスワードを入力してログインして下さい。<br>
              <?php if ($this->_tpl_vars['error_flag'] == 1): ?>
              <font color="FF0000">ログインできません。</font>
              <?php endif; ?>
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