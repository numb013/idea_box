<html>
  <head>
  <title>{$smarty.const.ADMIN_TITLE}</title>
  <meta http-equiv="Content-Language" content="ja">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="robots" content="noindex,nofollow,noarchive">
  <meta http-equiv="Content-Style-Type" content="text/css">
  <link rel="stylesheet" href="./_design/styles/core.css" type="text/css">
  <script>

  function status1() {ldelim}
    res = confirm('ステータスを変更してもよろしいでしょうか？');
  if (res == true) {ldelim}
    document.group_member_list_form.action = 'status.php?mode=member_status&send=group_member_list&approval_status={$approval_status|escape}&number={$page|escape}';
    document.group_member_list_form.submit()
  {rdelim}
  {rdelim}

  function sakujyo() {ldelim}
    res = confirm('削除してもよろしいでしょうか？');
  if (res == true) {ldelim}
    document.group_member_list_form.action = 'delete.php?mode=member_sakujyo&send=group_member_list&approval_status={$approval_status|escape}&number={$page|escape}';
    document.group_member_list_form.submit()
  {rdelim}
  {rdelim}

  function member() {ldelim}
    document.group_member_list_form.action = 'member_insert.php?group_member=group_member&number={$page|escape}&group_id={$group_id|escape}&approval_status={$approval_status|escape}';
    document.group_member_list_form.submit()
  {rdelim}

  /* フォーム全体からチェックボックスだけ全選択/全解除処理をする例 */
  function chkAll_form(bool) {ldelim}
    var frm=document.group_member_list_form;
    for(var i=0; i<frm.length; i++) {ldelim}
      if (frm.elements[i].type=="checkbox"){ldelim}
        frm.elements[i].checked=bool;
      {rdelim}
    {rdelim}
  {rdelim}
  function clickDelete(id, group_id) {ldelim}
  var res;
  res = confirm("削除します。よろしいですか？");
  if (res == true) {ldelim}
    location.href = "{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/delete.php?mode=member_sakujyo&send=group_member_list&approval_status={$approval_status|escape}&number={$page|escape}&id=" + id  + "&group_id=" + group_id;
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
        <h3>グループ詳細</h3>
        <p>グループ名：{$group_name_map.group_name|escape}</p>
      </div>
      <!-- コンテンツヘッダー部  end  -->
      <div id="bodyContainer">
        <input type="button" value="メンバー追加" onclick="member()" />
        <h3>メンバー一覧</h3>
        {if !is_array($group_member_list)}
          <p class="message">メンバーはいません</p>
         <form action="group_member_list.php" method="POST" name="group_member_list_form">
              <input type="hidden" value={$approval_status_1|escape}  name="approval_status">
              <input type="hidden" value={$group_member_map.member_id|escape}  name="member_status_id[]">
              <input type="hidden" value={$group_member_map.group_id|escape}  name="group_id">
          </form>
        {else}
        {if ($approval_flag == 1)}
          <p>ステータス変更しました</p>
        {/if}
        <p class="message">{$count_item}</p>
        <p class="resultPage">{$paging_link}</p>
        <form action="group_member_list.php" method="POST" name="group_member_list_form">
          <table class="table" width="95%">
            <tr>
              <th>チェック</th>
              <th>登録日</th>
              <th>社名</th>
              <th>氏名</th>
              <th>メールアドレス</th>
              <th>詳細</th>
              <th>編集</th>
              <th>削除</th>
              <th>ステータス</th>
            </tr>
            {foreach item="group_member_map" from=$group_member_list}
              <tr>
                <td width="5%"><center><input type="checkbox" name="member_check[]" value={$group_member_map.member_id|escape}></center></td>
                <td width="15%"><center>{$group_member_map.insert_datetime|escape|date_format:"%Y-%m-%d"}</center></td>
                <td width="15%"><center>{$group_member_map.company|escape}</center></td>
                <td width="15%"><center>{$group_member_map.member_name|escape}</center></td>
                <td width="15%"><center>{$group_member_map.mail_address|escape}</center></td>
                <td width="5%"><center><a href="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/member_date.php?member_id={$group_member_map.member_id|escape}&group_id={$group_member_map.group_id|escape}&page={$number|escape}">詳細</a></center></td>
                <td width="5%"><center><a href="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/member_update.php?member_id={$group_member_map.member_id|escape}&page={$page|escape}&number={$number|escape}">編集</a></center></td>
                <td width="5%"><center><a href="#" onclick="clickDelete('{$group_member_map.member_id|escape}', '{$group_member_map.group_id|escape}'); return false;">削除</a></center></td>
              {if $approval_status == "2"}
                <td width="5%"><center>{$statustypeDef_2->getSelectTags("member_status[]", 90, $group_member_map.approval_status, "")}</center></td>
              {else}
              <td width="5%"><center>{$statustypeDef->getSelectTags("member_status[]", 90, $group_member_map.approval_status, "")}</center></td>
              {/if}
              </tr>
              <input type="hidden" value={$group_member_map.member_id|escape}  name="member_status_id[]">
              <input type="hidden" value={$group_member_map.group_id|escape}  name="group_id">
              <input type="hidden" value={$approval_status|escape}  name="approval">
            {/foreach}
            </tr>
          </table><br>
          <div id="status"><input type="button" value="ステータス変更" onclick="status1()" /></div>
          <input type="button" onclick="chkAll_form(true)" value="全選択" />
          <input type="button" onclick="chkAll_form(false)" value="全解除" /><br><br>
          <input type="button" value="削除" onclick="sakujyo()" />
        </form>
        {/if}
      </div>
      <div id="bodyContainer">
        <p class="resultPage">{$paging_link}</p>
        {if $setting == "1"}
          <a href="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/setting.php?page={$number|escape}">戻る</a>
        {elseif $approval_status == "1"}
          <a href="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/group_list.php?page={$number|escape}">戻る</a>
        {elseif $approval_status == "2"}
          <a href="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/group_approval_list.php?page={$number|escape}">戻る</a>
        {elseif $approval_status == "3"}
          <a href="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/group_non_admitted_list.php?page={$number|escape}">戻る</a>
        {/if}
      </div>
      <br>
    </div>
    <!-- メニュー部 start -->
    {include file="admin/_menu.tpl"}
    <!-- メニュー部  end  -->
  </body>
</html>
