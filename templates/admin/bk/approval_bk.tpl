<html>
  <head>
  <title>{$smarty.const.ADMIN_TITLE}</title>
  <meta http-equiv="Content-Language" content="ja">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="robots" content="noindex,nofollow,noarchive">
  <meta http-equiv="Content-Style-Type" content="text/css">
  <link rel="stylesheet" href="./_design/styles/core.css" type="text/css">
  <script>
  function clickDelete(id, page) {ldelim}
  var res;
  res = confirm("削除します。よろしいですか？");
  if (res == true) {ldelim}
    location.href = "{$smarty.const.URL_ROOT_HTTPS}/admin/member_delete.php?id=" + id + "&page=" + page;
  {rdelim}
  {rdelim}
  //-->
  </script>
  </head>
  <body>
    <div id="body">
      <!-- コンテンツヘッダー部 start -->
      {include file="admin/_header.tpl"}
      <div id="bodyContainer">
        <h3>承認確認画面</h3>
          <p class="message">{$count_member}</p>
          <p class="resultPage">{$paging_link}</p>
          <form action="approval.php" name="approval_form" method="post">
          <table class="table" width="95%">
            <tr>
              <th>研修日</th>
              <th>メーリスグループ</th>
              <th>参加人数</th>
              <th>メーリスメールアドレス</th>
              </tr>
              {foreach item="group_list" from=$group_list}
                <tr>
                  <td width="10%"><center>{$group_list.training_datetime|escape|date_format:"%Y-%m-%d"}</center></td>
                  <td width="10%"><center>{$group_list.group_name|escape}</center></td>
                  <td width="10%"><center>{$group_list.group_number|escape}</center></td>
                  <td width="10%"><center>{$group_list.mailing_list_address|escape}</center></td>
                </tr>
                <input type="hidden" name="group_id[]" value={$group_list.group_id|escape}>
                <input type="hidden" name="group_name[]" value={$group_list.group_name|escape}>
              {/foreach}
              </tr>
            </table>
          <input type="hidden" name="mode" value="completion">
          <input type="submit" value="実行">
          </form>
        <p><a href="{$smarty.const.URL_ROOT_HTTPS}/admin/group_list.php?page={$page|escape}">戻る</a></p>
      </div>
      <br>
      <br>
      <br>
      <br>
      <br>
    </div>
    <!-- メニュー部 start -->
    {include file="admin/_menu.tpl"}
    <!-- メニュー部  end  -->
  </body>
</html>
