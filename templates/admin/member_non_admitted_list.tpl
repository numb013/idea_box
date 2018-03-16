<html>
  <head>
  <title>{$smarty.const.ADMIN_TITLE}</title>
  <meta http-equiv="Content-Language" content="ja">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="robots" content="noindex,nofollow,noarchive">
  <meta http-equiv="Content-Style-Type" content="text/css">
  <link rel="stylesheet" href="./_design/styles/core.css" type="text/css">

  <script type="text/javascript">

  function clickDelete(id, group_id) {ldelim}
  var res;
  res = confirm("削除します。よろしいですか？");
  if (res == true) {ldelim}
    location.href = "{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/delete.php?mode=member_sakujyo&number={$page|escape}&send=member_non_admitted_list&id=" + id + "&group_id=" + group_id;
  {rdelim}
  {rdelim}
 
  function status1() {ldelim}
    res = confirm('ステータスを変更してもよろしいでしょうか？');
  if (res == true) {ldelim}
    document.approval_form.action = 'status.php?mode=member_status&send=member_non_admitted_list&approval=3&number={$page|escape}';
    document.approval_form.submit()
  {rdelim}
  {rdelim}

  function sakujyo() {ldelim}
    res = confirm('削除してもよろしいでしょうか？');
  if (res == true) {ldelim}
    document.approval_form.action = 'delete.php?mode=member_sakujyo&send=member_non_admitted_list&number={$page|escape}';
    document.approval_form.submit()
  {rdelim}
  {rdelim}

  /* フォーム全体からチェックボックスだけ全選択/全解除処理をする例 */
  function chkAll_form(bool) {ldelim}
    var frm=document.approval_form;
    for(var i=0; i<frm.length; i++) {ldelim}
      if (frm.elements[i].type=="checkbox"){ldelim}
        frm.elements[i].checked=bool;
      {rdelim}
    {rdelim}
  {rdelim}

  </script>
  </head>
  <body>
    <div id="body">
      <!-- コンテンツヘッダー部 start -->
      {include file="admin/_header.tpl"}
      <div id="bodyContainer_ken">
        </form>
      </div>
      <!-- コンテンツヘッダー部  end  -->
      <div id="bodyContainer">
        <h3>非承認メンバー一覧</h3>
        {if !is_array($member_list)}
          <p class="message">非承認メンバーはいません</p>
        {else}
        {if ($approval_flag == 1)}
          <p>ステータス変更しました</p>
        {/if}
        <p class="message">{$count_item}</p>
        <p class="resultPage">{$paging_link}</p>
        <form action="approval.php" method="POST" name="approval_form">
          <table class="table" width="95%">
            <tr>
              <th>チェック</th>
              <th>登録日</th>
              <th>メーリストグループ</th>
              <th>社名</th>
              <th>氏名</th>
              <th>研修日</th>
              <th>研修日コード</th>
              <th>テーブルID</th>
              <th>メールアドレス</th>
              <th>編集</th>
              <th>削除</th>
              <th>ステータス</th>
            </tr>
            {foreach item="member_map" from=$member_list key=item_key}
              <tr>
                <td><center><input type="checkbox" name="member_check[]" value={$member_map.member_id|escape}></center></td>
                  <td width="10%"><center>{$member_map.insert_datetime|escape|date_format:"%Y-%m-%d"}</center></td>
                  <td width="10%"><center>{$member_map.group_name|escape}</center></td>
                  <td width="10%"><center>{$member_map.company|escape}</center></td>
                  <td width="10%"><center>{$member_map.member_name|escape}</center></td>
                  <td width="10%"><center>{$member_map.insert_datetime|escape|date_format:"%Y-%m-%d"}</center></td>
                  <td><center>{$trainingcodeDef->getStringByValue($member_map.training_code)|escape}</center></td>
                  <td><center>{$tablecodeDef->getStringByValue($member_map.table_code)|escape}</center></td>
                  <td width="10%"><center>{$member_map.mail_address|escape}</center></td>
                  <td><center><a href="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/member_update.php?member_id={$member_map.member_id|escape}&approval_status={$member_map.approval_status|escape}&number={$page|escape}&hishounin=1&member_non=1">編集</a></center></td>
                <td><center><a href="#" onclick="clickDelete('{$member_map.member_id}', '{$member_map.group_id|escape}'); return false;">削除</a></center></td>
                <td><center>{$statustypeDef->getSelectTags("member_status[]", 90, $member_map.approval_status, "")}</center></td>
              </tr>
              <input type="hidden" value={$member_map.member_id|escape}  name="member_status_id[]">
              <input type="hidden" value={$member_map.group_id|escape}  name="group_id">
            {/foreach}
          </table>
          <p class="resultPage">{$paging_link}</p>
          <div id="status"><input type="button" value="ステータス変更" onclick="status1()" /></div>
          <input type="button" onclick="chkAll_form(true)" value="全選択" />
          <input type="button" onclick="chkAll_form(false)" value="全解除" /><br><br>
          <input type="button" value="削除" onclick="sakujyo()" />
        </form>
        {/if}
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
