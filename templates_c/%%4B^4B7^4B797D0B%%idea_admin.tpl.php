<?php /* Smarty version 2.6.9, created on 2018-03-27 19:48:17
         compiled from /var/www/html/data/idea_box/templates/idea_admin.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', '/var/www/html/data/idea_box/templates/idea_admin.tpl', 57, false),array('modifier', 'escape', '/var/www/html/data/idea_box/templates/idea_admin.tpl', 63, false),array('modifier', 'truncate', '/var/www/html/data/idea_box/templates/idea_admin.tpl', 85, false),array('modifier', 'date_format', '/var/www/html/data/idea_box/templates/idea_admin.tpl', 86, false),)), $this); ?>
<!DOCTYPE HTML>
<!--
  Massively by HTML5 UP
  html5up.net | @ajlkn
  Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
  <head>
    <title>Massively by HTML5 UP</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" type="text/css" href="./css/idea_main.css" />
    <noscript><link rel="stylesheet" href="./css/noscript.css" /></noscript>
  <script type="text/javascript" src="./js/jquery.min.js"></script>
  <script type="text/javascript" src="./js/jquery-ui.js"></script>
  <script type="text/javascript" src="./js/jquery.ui.datepicker-ja.min.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />

  <script>
    $(function() {
      $.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
      $( "#datepicker1" ).datepicker();
      $( "#datepicker2" ).datepicker();
    });
  </script>

  </head>
<body class="is-loading">
    <!-- Wrapper -->
      <div id="wrapper" class="fade-in">
        <!-- Header -->
          <header id="header">
            <a href="index.html" class="logo">IDEA BOX</a>
          </header>
          <!-- Nav -->
            <nav id="nav">
              <ul class="links">
                <li><a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_top.php">投稿ページ</a></li>
                <li><a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_list.php">アイデア一覧</a></li>
                <li class='active'><a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_admin.php">管理画面</a></li>
              </ul>
            </nav>
        <!-- Footer -->
          <footer id="idea_post">
            <section class="split contact">



              <section class="contact">
                <h3>商品一覧検索</h3>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/_error_msg.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <form action="<?php echo @URL_ROOT_HTTPS; ?>
/idea_admin.php" method="post" enctype="multipart/form-data">
                  <table class="form" width="90%" id="teb">
                    <tr>
                      <th class = "ken">社員</th>
                      <td>
                        <?php echo smarty_function_html_options(array('name' => 'shain_id','options' => $this->_tpl_vars['shain_arry'],'selected' => $this->_tpl_vars['select'],'separator' => '<br />'), $this);?>

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
                  <br>
                  <div id="form_bottom">
                    <input type="hidden" value="1" name="search_flag">
                    <input type="submit" value="検索" class="button">
                  </div>
                </form>
              </section>





              <?php $_from = $this->_tpl_vars['idea_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['idea_map']):
?>
                <div class="list_box">
                  <a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_detail.php?id=<?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
                    <section>
                      <h3 class="under_line">・<?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h3>
                      <p><?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['body'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 100, '...') : smarty_modifier_truncate($_tmp, 100, '...')); ?>
</p>
                      <p class="date"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['idea_map']['created_at'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</p>   
                        <p><a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_edit.php?id=<?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">編集</a></p>
                    </section>
                  </a>
                </div>
              <?php endforeach; endif; unset($_from); ?>
            </section>
          </footer>

          <div id="main">
          <section>
            <footer>
              <p class="message"><?php echo $this->_tpl_vars['count_idea']; ?>
</p>
              <div class="pagination">
                <p class="resultPage"><?php echo $this->_tpl_vars['paging_link']; ?>
</p>
              </div>
            </footer>
          </section>
          </div>

    <!-- Scripts -->
    <script type="text/javascript" src="./js/jquery.scrollex.min.js"></script>
    <script type="text/javascript" src="./js/jquery.scrolly.min.js"></script>
    <script type="text/javascript" src="./js/skel.min.js"></script>
    <script type="text/javascript" src="./js/util.js"></script>
    <script type="text/javascript" src="./js/main.js"></script>
  </body>
</html>