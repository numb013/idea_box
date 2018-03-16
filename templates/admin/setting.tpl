<html>
  <head>
  <title>{$smarty.const.ADMIN_TITLE}</title>
  <meta http-equiv="Content-Language" content="ja">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="robots" content="noindex,nofollow,noarchive">
  <meta http-equiv="Content-Style-Type" content="text/css">
  <link rel="stylesheet" href="./_design/styles/core.css" type="text/css">
  <script type="text/javascript">
  function setting() {ldelim}
    res = confirm('設定をを変更してもよろしいでしょうか？');
  if (res == true) {ldelim}
    document.setting_form.action = 'setting.php?mode=completion&send=1';
    document.setting_form.submit()
  {rdelim}
  {rdelim}
  </script>
  </head>
  <body>
    <div id="body">
      <!-- コンテンツヘッダー部 start -->
      {include file="admin/_header.tpl"}
      <!-- コンテンツヘッダー部  end  -->
      <div id="bodyContainer">
        <h3>管理者アドレス設定</h3>
        <form action="setting.php" method="POST" name="setting_form">
          <table class="table" width="80%">
            <tr>
              <th width="10%"  rowspan="4" >常にグループに含まれるメールアドレス</td>
              <td width="20%"  height="50px"><center>管理者１    <input type="text" name="manager_address1" size="50" value="{$setting_map.manager_address1|escape}"></center></td>
            </tr>
            <tr>
              <td width="20%"  height="50px"><center>管理者２    <input type="text" name="manager_address2" size="50" value="{$setting_map.manager_address2|escape}"></center></td>
            </tr>
            <tr>
              <td width="20%"  height="50px"><center>管理者３    <input type="text" name="manager_address3" size="50" value="{$setting_map.manager_address3|escape}"></center></td>
            </tr>
            <tr>
              <td width="20%"  height="50px"><center>管理者４    <input type="text" name="manager_address4" size="50" value="{$setting_map.manager_address4|escape}"></center></td>
            </tr>
          </table><br>
          <input type="button" value="管理者アドレス変更" onclick="setting()" />
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
