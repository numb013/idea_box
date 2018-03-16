<div id="header">
  <h1></h1>
  <p id="logout"><input type="button" value="ログアウト" onClick="location.href='{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/logout.php'"></p>
  <p id="user">ログインID: {$smarty.session.a.login_id|escape}</p>
</div>
