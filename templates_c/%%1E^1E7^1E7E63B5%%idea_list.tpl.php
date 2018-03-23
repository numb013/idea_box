<?php /* Smarty version 2.6.9, created on 2018-03-23 13:59:20
         compiled from /var/www/html/data/idea_box/templates/admin/idea_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/var/www/html/data/idea_box/templates/admin/idea_list.tpl', 60, false),)), $this); ?>
<html>
  <head>
  <title><?php echo @ADMIN_TITLE; ?>
</title>
  <meta http-equiv="Content-Language" content="ja">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="robots" content="noindex,nofollow,noarchive">
  <meta http-equiv="Content-Style-Type" content="text/css">
  <link rel="stylesheet" href="./_design/styles/core.css" type="text/css">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
  <script type="text/javascript" src="../js/jquery-ui.js"></script>
  <script type="text/javascript" src="../js/jquery.ui.datepicker-ja.min.js"></script>

  <script>
    $(function() {
      $.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
      $( "#datepicker1" ).datepicker();
      $( "#datepicker2" ).datepicker();
      $( "#datepicker3" ).datepicker();
      $( "#datepicker4" ).datepicker();
    });
  function check1(){
    var date  = new Date();
    var year  = date.getFullYear();
    var month = date.getMonth() + 1;
    var date  = date.getDate();
    if (month < 10) {
      month = "0" + month;
    }
    if (date < 10) {
      date = "0" + date;
    }
    var strDate = year + "-" + month + "-" + date;
    $("#datepicker1").val(strDate);
    $("#datepicker2").val(strDate);
  }
    function offradio() {
      var ElementsCount = document.sarch.seibetu.length;  // ラジオボタンの数
      for( i=0 ; i<ElementsCount ; i++ ) {
        document.sarch.seibetu[i].checked = false;
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


      <div id="bodyContainer">
      <div>
        <h3>商品一覧検索</h3>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/_error_msg.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <form action="<?php echo @URL_ROOT_HTTPS; ?>
/tcm-admin/idea_list.php" method="post" enctype="multipart/form-data">
          <table class="form" width="90%" id="teb">
            <tr>
              <th class = "ken">社員</th>
              <td>
                <input type="text" name="user_id" size="20" value=<?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['user_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
>
              </td>
            </tr>
            <tr>
              <th class = "ken">指定日</th>
              <td>
                <input type="text"  id="datepicker1" name="created_at_1" size="13" value=<?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['created_at_1'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
>&nbsp;～
                <input type="text"  id="datepicker2" name="created_at_2" size="13" value=<?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['created_at_2'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
>
              </td>
            </tr>
          </table>
          <div id="form_bottom">
            <input type="hidden" value="1" name="search_flag">
            <input type="submit" value="検索" class="button">
          </div>
        </form>
      </div>

      <!-- コンテンツヘッダー部  end  -->

        <h3>アイデア一覧</h3>
        <p class="message"><?php echo $this->_tpl_vars['count_idea']; ?>
</p>
        <p class="resultPage"><?php echo $this->_tpl_vars['paging_link']; ?>
</p>
        <form action="approval.php" method="POST" name="approval_form">
          <table class="table" width="95%">
            <tr>
              <th width="20%">タイトル</th>
              <th width="30%">内容</th>
              <th width="5%">承認</th>
              <th width="5%">編集</th>
              <th width="5%">詳細</th>
            </tr>
            <?php $_from = $this->_tpl_vars['idea_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item_key'] => $this->_tpl_vars['idea_map']):
?>
              <tr>
                <td><center><?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</center></td>
                <td><center><?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['body'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</center></td>
                <td><center>
                  <?php if (( $this->_tpl_vars['idea_map']['approval_flag'] == 1 )): ?>
                    承認済み
                  <?php else: ?>
                    未承認
                  <?php endif; ?>
                </center></td>
                <td><center><a href="<?php echo @URL_ROOT_HTTPS; ?>
/tcm-admin/idea_edit.php?id=<?php echo $this->_tpl_vars['idea_map']['id']; ?>
">編集</a></center></td>
                <td><center><a href="<?php echo @URL_ROOT_HTTPS; ?>
/tcm-admin/idea_detail.php?id=<?php echo $this->_tpl_vars['idea_map']['id']; ?>
">詳細</a></center></td>
              </tr>
            <?php endforeach; endif; unset($_from); ?>
          </table>
          <p class="resultPage"><?php echo $this->_tpl_vars['paging_link']; ?>
</p>
        </form>
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
