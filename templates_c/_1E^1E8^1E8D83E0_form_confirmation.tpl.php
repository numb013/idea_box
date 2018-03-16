<?php /* Smarty version 2.6.9, created on 2015-07-14 15:30:45
         compiled from C:%5CApache+Software+Foundation%5CApache2.2%5Chtdocs%5Cmailing_list/templates/form_confirmation.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'C:\\Apache Software Foundation\\Apache2.2\\htdocs\\mailing_list/templates/form_confirmation.tpl', 53, false),array('modifier', 'nl2br', 'C:\\Apache Software Foundation\\Apache2.2\\htdocs\\mailing_list/templates/form_confirmation.tpl', 65, false),)), $this); ?>
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

<script type="text/javascript" src="./js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="./js/jquery-ui.js"></script>
<script type="text/javascript" src="./js/jquery.ui.datepicker-ja.min.js"></script>
<link rel="stylesheet" type="text/css" href="./css/jquery-ui.css" />

<script>
  $(function() {
    $.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
    $( "#datepicker" ).datepicker();
  });

 function back() {
  document.form_back.submit()
 }
</script>

</head>
<body>
  <!-div id="home" data-role="page">
    <div data-role="header">
      <h1>メーリングリスト登録フォーム</h1>
    </div><!-- /header -->
    <div data-role="content">	
      <h4>以下の内容で送信します。よろしいでしょうか</h4>
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_error_msg.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <dl class="form">
      <dt>社名</dt>
      <dd><?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['company'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</dd>
      <dt>氏名</dt>
      <dd><?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['member_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</dd>
      <dt>研修日</dt>
      <dd><?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['training_datetime'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</dd>
      <dt>研修コード</dt>
      <dd><?php echo ((is_array($_tmp=$this->_tpl_vars['trainingcodeDef']->getStringByValue($this->_tpl_vars['input_map']['training_code']))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</dd>
      <dt>テーブルID</dt>
      <dd><?php echo ((is_array($_tmp=$this->_tpl_vars['tablecodeDef']->getStringByValue($this->_tpl_vars['input_map']['table_code']))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</dd>
      <dt>メールアドレス</dt>
      <dd><?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['mail_address'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</dd>
      <dt>備考テキスト</dt>
      <dd><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['input_map']['memo'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</dd>
      </dl>
      <br><br>

      <form action="<?php echo @URL_ROOT_HTTPS; ?>
/form_completion.php" method="POST" data-ajax="false">
        <input type="hidden" name="mode" value="completion">
        <input type="hidden" name="post_key" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['post_key'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
        <div class="button_1">
          <input type="submit" value="登録" class="button">
        </div>
      </form>
      <form action="<?php echo @URL_ROOT_HTTPS; ?>
/index.php" name="form_back" method="POST" data-ajax="false">
        <input type="hidden" name="mode" value="back">
        <div class="button_1">
          <input type="button" value="戻る" onclick="back()" />
        </div>
      </form>
    </div><!-- /content -->
  </div--><!-- /page -->
</body>
</html>