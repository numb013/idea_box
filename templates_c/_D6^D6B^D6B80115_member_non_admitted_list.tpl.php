<?php /* Smarty version 2.6.9, created on 2015-06-18 20:50:21
         compiled from C:%5CApache+Software+Foundation%5CApache2.2%5Chtdocs%5Cmailing_list/templates/admin/member_non_admitted_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'C:\\Apache Software Foundation\\Apache2.2\\htdocs\\mailing_list/templates/admin/member_non_admitted_list.tpl', 16, false),array('modifier', 'date_format', 'C:\\Apache Software Foundation\\Apache2.2\\htdocs\\mailing_list/templates/admin/member_non_admitted_list.tpl', 85, false),)), $this); ?>
<html>
  <head>
  <title><?php echo @ADMIN_TITLE; ?>
</title>
  <meta http-equiv="Content-Language" content="ja">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="robots" content="noindex,nofollow,noarchive">
  <meta http-equiv="Content-Style-Type" content="text/css">
  <link rel="stylesheet" href="./_design/styles/core.css" type="text/css">

  <script type="text/javascript">

  function clickDelete(id, group_id) {
  var res;
  res = confirm("削除します。よろしいですか？");
  if (res == true) {
    location.href = "<?php echo @URL_ROOT_HTTPS; ?>
/tcm-admin/delete.php?mode=member_sakujyo&number=<?php echo ((is_array($_tmp=$this->_tpl_vars['page'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
&send=member_non_admitted_list&id=" + id + "&group_id=" + group_id;
  }
  }
 
  function status1() {
    res = confirm('ステータスを変更してもよろしいでしょうか？');
  if (res == true) {
    document.approval_form.action = 'status.php?mode=member_status&send=member_non_admitted_list&approval=3&number=<?php echo ((is_array($_tmp=$this->_tpl_vars['page'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
';
    document.approval_form.submit()
  }
  }

  function sakujyo() {
    res = confirm('削除してもよろしいでしょうか？');
  if (res == true) {
    document.approval_form.action = 'delete.php?mode=member_sakujyo&send=member_non_admitted_list&number=<?php echo ((is_array($_tmp=$this->_tpl_vars['page'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
';
    document.approval_form.submit()
  }
  }

  /* フォーム全体からチェックボックスだけ全選択/全解除処理をする例 */
  function chkAll_form(bool) {
    var frm=document.approval_form;
    for(var i=0; i<frm.length; i++) {
      if (frm.elements[i].type=="checkbox"){
        frm.elements[i].checked=bool;
      }
    }
  }

  </script>
  </head>
  <body>
    <div id="body">
      <!-- コンテンツヘッダー部 start -->
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <div id="bodyContainer_ken">
        </form>
      </div>
      <!-- コンテンツヘッダー部  end  -->
      <div id="bodyContainer">
        <h3>非承認メンバー一覧</h3>
        <?php if (! is_array ( $this->_tpl_vars['member_list'] )): ?>
          <p class="message">非承認メンバーはいません</p>
        <?php else: ?>
        <?php if (( $this->_tpl_vars['approval_flag'] == 1 )): ?>
          <p>ステータス変更しました</p>
        <?php endif; ?>
        <p class="message"><?php echo $this->_tpl_vars['count_item']; ?>
</p>
        <p class="resultPage"><?php echo $this->_tpl_vars['paging_link']; ?>
</p>
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
            <?php $_from = $this->_tpl_vars['member_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item_key'] => $this->_tpl_vars['member_map']):
?>
              <tr>
                <td><center><input type="checkbox" name="member_check[]" value=<?php echo ((is_array($_tmp=$this->_tpl_vars['member_map']['member_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
></center></td>
                  <td width="10%"><center><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['member_map']['insert_datetime'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</center></td>
                  <td width="10%"><center><?php echo ((is_array($_tmp=$this->_tpl_vars['member_map']['group_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</center></td>
                  <td width="10%"><center><?php echo ((is_array($_tmp=$this->_tpl_vars['member_map']['company'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</center></td>
                  <td width="10%"><center><?php echo ((is_array($_tmp=$this->_tpl_vars['member_map']['member_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</center></td>
                  <td width="10%"><center><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['member_map']['insert_datetime'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</center></td>
                  <td><center><?php echo ((is_array($_tmp=$this->_tpl_vars['trainingcodeDef']->getStringByValue($this->_tpl_vars['member_map']['training_code']))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</center></td>
                  <td><center><?php echo ((is_array($_tmp=$this->_tpl_vars['tablecodeDef']->getStringByValue($this->_tpl_vars['member_map']['table_code']))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</center></td>
                  <td width="10%"><center><?php echo ((is_array($_tmp=$this->_tpl_vars['member_map']['mail_address'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</center></td>
                  <td><center><a href="<?php echo @URL_ROOT_HTTPS; ?>
/tcm-admin/member_update.php?member_id=<?php echo ((is_array($_tmp=$this->_tpl_vars['member_map']['member_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
&approval_status=<?php echo ((is_array($_tmp=$this->_tpl_vars['member_map']['approval_status'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
&number=<?php echo ((is_array($_tmp=$this->_tpl_vars['page'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
&hishounin=1&member_non=1">編集</a></center></td>
                <td><center><a href="#" onclick="clickDelete('<?php echo $this->_tpl_vars['member_map']['member_id']; ?>
', '<?php echo ((is_array($_tmp=$this->_tpl_vars['member_map']['group_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
'); return false;">削除</a></center></td>
                <td><center><?php echo $this->_tpl_vars['statustypeDef']->getSelectTags("member_status[]",90,$this->_tpl_vars['member_map']['approval_status'],""); ?>
</center></td>
              </tr>
              <input type="hidden" value=<?php echo ((is_array($_tmp=$this->_tpl_vars['member_map']['member_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
  name="member_status_id[]">
              <input type="hidden" value=<?php echo ((is_array($_tmp=$this->_tpl_vars['member_map']['group_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
  name="group_id">
            <?php endforeach; endif; unset($_from); ?>
          </table>
          <p class="resultPage"><?php echo $this->_tpl_vars['paging_link']; ?>
</p>
          <div id="status"><input type="button" value="ステータス変更" onclick="status1()" /></div>
          <input type="button" onclick="chkAll_form(true)" value="全選択" />
          <input type="button" onclick="chkAll_form(false)" value="全解除" /><br><br>
          <input type="button" value="削除" onclick="sakujyo()" />
        </form>
        <?php endif; ?>
      </div>
      <br>
      <br>
      <br>
      <br>
      <br>
    </div>
    <!-- メニュー部 start -->
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/_menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <!-- メニュー部  end  -->
  </body>
</html>