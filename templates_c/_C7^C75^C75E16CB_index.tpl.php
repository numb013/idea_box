<?php /* Smarty version 2.6.9, created on 2015-06-15 14:24:45
         compiled from C:%5CApache+Software+Foundation%5CApache2.2%5Chtdocs%5Cmailing_list/templates/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'C:\\Apache Software Foundation\\Apache2.2\\htdocs\\mailing_list/templates/index.tpl', 64, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>メーリングリスト登録フォーム</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex,nofollow,noarchive">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<link rel="stylesheet" type="text/css" href="./css/jquery.mobile-1.1.2.css" />
<link rel="stylesheet" type="text/css" href="./css/jqm-datebox.min.css" />
<link rel="stylesheet" type="text/css" href="./css/modal.css" />
<link rel="stylesheet" type="text/css" href="./css/modal-multi.css" />
<link rel="apple-touch-icon" href="./css/images/fb_mark.png">
<script type="text/javascript" src="./js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="./js/jquery.mobile-1.1.0.min.js"></script>
<script type="text/javascript" src="./js/jqm-datebox.core.min.js"></script>
<script type="text/javascript" src="./js/jqm-datebox.mode.calbox.min.js"></script>
<script type="text/javascript" src="./js/jqm-datebox.mode.datebox.min.js"></script>
<script type="text/javascript" src="./js/jqm-datebox.mode.flipbox.min.js"></script>
<script type="text/javascript" src="./js/modal.js"></script>
<script type="text/javascript" src="./js/modal-multi.js"></script>
<script src="./js/jquery.mobile.datebox.i8n.jp.js"></script>
<script src="./js/late_text.js"></script>
<script src="./js/early_radio.js"></script>

<!--
  <script type="text/javascript" src="./js/jquery-1.7.1.min.js"></script>
  <script type="text/javascript" src="./js/jquery-ui.js"></script>
  <script type="text/javascript" src="./js/jquery.ui.datepicker-ja.min.js"></script>
  <link rel="stylesheet" type="text/css" href="./css/jquery-ui.css" />

  <link rel="stylesheet" type="text/css" href="./css/jquery-ui.css" />
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>

 <script>
  $(function() {
    $.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
    $( "#datepicker" ).datepicker();
  });
 </script>
-->


</head>
<body>
 <div id="home" data-role="page">
  <div data-role="header">
  <h1>メーリングリスト登録フォーム</h1>
  </div><!-- /header -->
  <div data-role="content">	
    <h4><span style="color:red">※</span>は必須入力項目です。</h4>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_error_msg.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><br>
    <form action="<?php echo @URL_ROOT_HTTPS; ?>
/form_confirmation.php" method="post" data-ajax="false">
    <table class="form">
      <tr>
        <th>
          社名<span style="color:red">&nbsp;※</span>
        </th>
      </tr>
      <tr>
        <td id="type_1">
          <input type="text" name="company" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['company'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
        </td>
      </tr>
      <tr>
        <th>氏名<span style="color:red">&nbsp;※</span></th></tr>
      <tr>
        <td><input type="text" name="member_name" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['member_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
      </tr>
      <tr>
        <th>研修日<span style="color:red">&nbsp;※</span></th></tr>
      <tr>
        <td><input name="training_datetime" id="mode2" type="text" data-role="datebox" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['training_datetime'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" data-options='{"mode":"datebox", "useNewStyle":true, "focusMode":true}' /></td>
      </tr>
      <tr>
        <th>研修コード<span style="color:red">&nbsp;※</span></th></tr>
      <tr>
        <td><?php echo $this->_tpl_vars['trainingcodeDef']->getSelectTags('training_code',null,$this->_tpl_vars['input_map']['training_code'],"選択してください"); ?>
</td>
      </tr>
      <tr>
        <th>テーブルID<span style="color:red">&nbsp;※</span></th></tr>
      <tr>
        <td><?php echo $this->_tpl_vars['tablecodeDef']->getSelectTags('table_code',null,$this->_tpl_vars['input_map']['table_code'],"選択してください"); ?>
</td>
      </tr>
      <tr>
        <th>メールアドレス<span style="color:red">&nbsp;※</span></th></tr>
      <tr>
        <td><input type="text" name="mail_address" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['mail_address'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
      </tr>
      <tr>
        <th>備考テキスト</th></tr>
      <tr>
        <td><textarea cols="27" rows="3" name="memo"><?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['memo'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea><br /></td>
      </tr>
    </table>
  <input type="hidden" value="confirmation" name="mode">
  <div class="button_1">
    <input type="submit" value="入力内容確認" class="button">
  </div>
  </form>
  </div><!-- /content -->
</div><!-- /page -->
</body>
</html>