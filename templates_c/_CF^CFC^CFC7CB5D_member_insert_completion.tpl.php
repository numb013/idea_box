<?php /* Smarty version 2.6.9, created on 2015-06-22 14:03:41
         compiled from C:%5CApache+Software+Foundation%5CApache2.2%5Chtdocs%5Cmailing_list/templates/admin/member_insert_completion.tpl */ ?>
<html>
  <head>
    <title><?php echo @ADMIN_TITLE; ?>
</title>
    <meta http-equiv="Content-Language" content="ja">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="robots" content="noindex,nofollow,noarchive">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <link rel="stylesheet" href="./_design/styles/core.css" type="text/css">
    <title>個別登録完了画面</title>
    <meta http-equiv="Content-Language" content="ja">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  </head>
  <body>
    <div id="body">
      <!-- コンテンツヘッダー部 start -->
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <!-- コンテンツヘッダー部  end  -->
      <div id="bodyContainer">
        <h3>個別登録完了</h3>
        <p class="message">個別登録が完了しました。</p>
        <a href="<?php echo @URL_ROOT_HTTPS; ?>
/tcm-admin/group_list.php">承認待ちグループ一覧へ</a><br><br>
        <a href="<?php echo @URL_ROOT_HTTPS; ?>
/tcm-admin/group_approval_list.php">承認済みグループ一覧へ</a><br><br>
        <a href="<?php echo @URL_ROOT_HTTPS; ?>
/tcm-admin/group_non_admitted_list.php">非承認グループ一覧へ</a>
      </div>
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