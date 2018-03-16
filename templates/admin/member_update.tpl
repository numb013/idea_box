<html>
  <head>
  <title>{$smarty.const.ADMIN_TITLE}</title>
  <meta http-equiv="Content-Language" content="ja">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="robots" content="noindex,nofollow,noarchive">
  <meta http-equiv="Content-Style-Type" content="text/css">
  <link rel="stylesheet" href="./_design/styles/core.css" type="text/css">
  <script type="text/javascript" src="../js/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" src="../js/jquery-ui.js"></script>
  <script type="text/javascript" src="../js/jquery.ui.datepicker-ja.min.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
  <script>
    $(function() {ldelim}
      $.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
      $( "#datepicker" ).datepicker();
    {rdelim});
  </script>
  </head>
  <body>
    <div id="body">
      <!-- コンテンツヘッダー部 start -->
      {include file="admin/_header.tpl"}
      <div id="bodyContainer">
        <h3>編集フォーム</h3>
        <h4><span style="color:red">※</span>は必須入力項目です。</h4>
        {include file="admin/_error_msg.tpl"}
        <form action="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/member_update.php" method="post">
          <table class="form">
            <tr>
              <th>社名<span style="color:red">※</span></th>
              <td>
                <input type="text" name="company" size="20" value={$input_map.company|escape}>
              </td>
            </tr>
            <tr>
              <th>氏名<span style="color:red">※</span></th>
              <td>
                <input type="text" name="member_name" size="20" value={$input_map.member_name|escape}>
              </td>
            </tr>
            <tr>
              <th>メールアドレス<span style="color:red">※</span></th>
                <td><input type="text" name="mail_address" value="{$input_map.mail_address|escape}" size="25"></td>
            </tr>
            <tr>
              <th>備考テキスト</th>
              <td><textarea cols="27" rows="3" name="memo">{$input_map.memo|escape}</textarea><br /></td>
            </tr>
          </table><br>
          <input type="hidden" value={$page|escape} name="page">
          <input type="hidden" value={$number|escape} name="number">
          <input type="hidden" value={$hishounin|escape} name="hishounin">
          <input type="hidden" value={$input_map.approval_status|escape} name="approval_status">
          <input type="hidden" value={$input_map.group_id|escape} name="group_id">
          <input type="hidden" value={$input_map.member_id|escape} name="member_id">
          <input type="hidden" value={$input_map.mail_address|escape} name="mail_address_1">
          <input type="hidden" value="confirmation" name="mode">
          <input type="submit" value="入力内容確認" class="button">
        </form>
      </div>
      <div id="bodyContainer">
        {if $hishounin == "1"}
        <a href="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/member_non_admitted_list.php?page={$number|escape}">戻る</a>
        {else}
        <a href="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/group_member_list.php?group_id={$input_map.group_id|escape}&approval_status={$input_map.approval_status|escape}&number={$number|escape}">戻る</a>
        {/if}
      </div>
    </div>
    <!-- メニュー部 start -->
    {include file="admin/_menu.tpl"}
    <!-- メニュー部  end  -->
  </body>
</html>