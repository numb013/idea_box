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
        <h3>個別登録入力フォーム</h3>
        <h4><span style="color:red">※</span>は必須入力項目です。</h4>
        {include file="admin/_error_msg.tpl"}
        <form action="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/member_insert.php" method="post">
          <table class="form"  width="40%">
            <tr>
              <th width="8%">社名<span style="color:red">※</span></th>
              <td width="5%">
                <input type="text" name="company" value="{$input_map.company|escape}" size="25">
              </td>
            </tr>
            <tr>
              <th width="8%">氏名<span style="color:red">※</span></th>
              <td width="5%">
                <input type="text" name="member_name" value="{$input_map.member_name|escape}" size="25">
              </td>
            </tr>
            <tr>
              <th width="8%">研修日<span style="color:red">※</span></th>
              <td width="5%">
                <input type="text"  id="datepicker" name="training_datetime" size="13" value={$input_map.training_datetime|escape}>
              </td>
            </tr>
            <tr>
              <th>研修コード<span style="color:red">※</span></th>
              <td>{$trainingcodeDef->getSelectTags("training_code", null, $input_map.training_code, "選択してください")}</td>
            </tr>
            <tr>
              <th width="8%">テーブルID<span style="color:red">※</span></th>
              <td width="5%">{$tablecodeDef->getSelectTags("table_code", null, $input_map.table_code,"選択してください")}</td>
            </tr>
            <tr>
              <th width="8%">メールアドレス<span style="color:red">※</span></th>
              <td width="5%"><input type="text" name="mail_address" value="{$input_map.mail_address|escape}" size="25"></td>
            </tr>
            <tr>
              <th width="8%">備考テキスト</th>
              <td width="5%"><textarea cols="27" rows="3" name="memo">{$input_map.memo|escape}</textarea><br /></td>
            </tr>
          </table><br><br>
          <input type="hidden" value={$input_map.approval_status|escape} name="approval_status_1">
          <input type="hidden" value={$page|escape} name="number">
          <input type="hidden" value={$group_id|escape} name="group_id">
          <input type="hidden" value={$approval_status|escape} name="approval_status">
          <input type="hidden" value="confirmation" name="mode">
          <input type="submit" value="入力内容確認" class="button">
        </form>
        {if $approval_status == "1"}
          <a href="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/group_member_list.php?page={$page|escape}&approval_status={$approval_status|escape}&group_id={$group_id|escape}">戻る</a>
        {elseif $approval_status == "2"}
          <a href="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/group_member_list.php?page={$page|escape}&approval_status={$approval_status|escape}&group_id={$group_id|escape}">戻る</a>
        {elseif $approval_status == "3"}
          <a href="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/group_member_list.php?page={$page|escape}&approval_status={$approval_status|escape}&group_id={$group_id|escape}">戻る</a>
        {/if}
      </div>
    </div>
    <!-- メニュー部 start -->
    {include file="admin/_menu.tpl"}
    <!-- メニュー部  end  -->
  </body>
</html>