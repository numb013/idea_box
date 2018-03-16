<html>
  <head>
  <title>{$smarty.const.ADMIN_TITLE}</title>
  <meta http-equiv="Content-Language" content="ja">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="robots" content="noindex,nofollow,noarchive">
  <meta http-equiv="Content-Style-Type" content="text/css">
  <link rel="stylesheet" href="./_design/styles/core.css" type="text/css">
  <script type="text/javascript">
  function status1() {ldelim}
    res = confirm('ステータスを変更してもよろしいでしょうか？');
  if (res == true) {ldelim}
    document.approval_form.action = 'status.php?mode=status&approval=2&send=group_approval_list&number={$page|escape}';
    document.approval_form.submit()
  {rdelim}
  {rdelim}
  function sakujyo_link(group_id) {ldelim}
  var res;
  res = confirm("削除します。よろしいですか？");
  if (res == true) {ldelim}
    location.href = "{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/delete.php?mode=sakujyo&send=group_approval_list&number={$page|escape}&group_id=" + group_id;
  {rdelim}
  {rdelim}
  function sakujyo() {ldelim}
    res = confirm('削除してもよろしいでしょうか？');
  if (res == true) {ldelim}
    document.approval_form.action = 'delete.php?mode=sakujyo&send=group_approval_list&number={$page|escape}';
    document.approval_form.submit()
  {rdelim}
  {rdelim}
  function member_csv() {ldelim}
    document.approval_form.action = 'member_csv.php?approval_status={$approval_status|escape}';
    document.approval_form.submit()
  {rdelim}
  function one_member_csv(group_id) {ldelim}
  var res;
  res = confirm("CSVをダウンロードしてもよろしいですか？");
  if (res == true) {ldelim}
    location.href = "{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/member_csv.php?mode=download&approval_status={$approval_status|escape}&group_id=" + group_id;
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
        <h3>承認済みグループ一覧</h3>
        {if !is_array($group_list)}
          <p class="message">承認済みグループはございません</p>
        {else}
        {if ($approval_flag == 1)}
          <p>ステータス変更しました</p>
        {/if}
          <p class="message">{$count_item}</p>
          <p class="resultPage">{$paging_link}</p>
        <form action="approval.php" method="POST" name="approval_form">
          <table class="table" width="95%">
            <tr>
              <th width="5%">チェック</th>
              <th width="20%">メーリスグループ</th>
              <th width="22%">登録日</th>
              <th width="5%">参加人数</th>
              <th width="5%">研修コード</th>
              <th width="5%">テーブルID</th>
              <th width="33%">メーリスメールアドレス</th>
              <th width="7%">削除</th>
              <th width="10%">CSVダウンロード</th>
              <th width="10%">ステータス</th>
            </tr>
            {foreach item="group_map" from=$group_list key=item_key}
              <tr>
                <td><center><input type="checkbox" name="group_check[]" value={$group_map.group_id}></center></td>
                <td><center><a href="{$smarty.const.URL_ROOT_HTTPS}/tcm-admin/group_member_list.php?group_id={$group_map.group_id|escape}&approval_status={$approval_status|escape}&number={$page|escape}">{$group_map.group_name|escape}</a></center></td>
                <td><center>{$group_map.insert_datetime|escape|date_format:"%Y-%m-%d"}</center></td>
                <td><center>{$group_map.group_number|escape}</center></td>
                <td><center>{$trainingcodeDef->getStringByValue($group_map.training_code)|escape}</center></td>
                <td><center>{$tablecodeDef->getStringByValue($group_map.table_code)|escape}</center></td>
                <td><center>{$group_map.mailing_list_address|escape}</center></td>
                <td><center><a href="#" onclick="sakujyo_link('{$group_map.group_id|escape}')">削除</a></center></td>
                <td><center><a href="#" onclick="one_member_csv('{$group_map.group_id|escape}'); return false;">DL</a></center></td>
                <td><center>{$statustypeDef_2->getSelectTags("group_status[]", 90, $group_map.approval_status, "")}</center></td>
              </tr>
              <input type="hidden" value={$group_map.group_id|escape}  name="group_status_id[]">
            {/foreach}
          </table>
          <p class="resultPage">{$paging_link}</p>
          <div id="status"><input type="button" value="ステータス変更" onclick="status1()" /></div>
          <input type="button" onclick="chkAll_form(true)" value="全選択" />
          <input type="button" onclick="chkAll_form(false)" value="全解除" /><br><br>
          <input type="button" value="削除" onclick="sakujyo()" />
            <input type="hidden" name="mode" value="download">
            <input type="submit" value="csvダウンロード" onclick="member_csv()">
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
