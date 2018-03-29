<?php /* Smarty version 2.6.9, created on 2018-03-29 15:35:01
         compiled from /var/www/html/data/idea_box/templates/idea_box_tpl/idea_total.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/var/www/html/data/idea_box/templates/idea_box_tpl/idea_total.tpl', 38, false),)), $this); ?>
<!DOCTYPE HTML>
<!--
  Massively by HTML5 UP
  html5up.net | @ajlkn
  Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
  <head>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "idea_box_tpl/_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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
/idea_box_php/idea_top.php">投稿ページ</a></li>
                <li><a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_box_php/idea_list.php">アイデア一覧</a></li>
                <li><a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_box_php/idea_admin.php">管理画面</a></li>
                <li class='active'><a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_box_php/idea_total.php">集計</a></li>
              </ul>
            </nav>
        <!-- Footer -->
          <footer id="idea_post">
            <section class="split contact">
              <section class="contact">
                <h3>修正検索</h3>
                <div class="search_box">
                  <form action="<?php echo @URL_ROOT_HTTPS; ?>
/idea_box_php/idea_total.php" method="post" enctype="multipart/form-data">
                    <table class="form" width="90%">
                      <tr>
                        <th class="ken">指定日</th>
                        <td>
                          <input type="text" class="datepicker" id="datepicker1" name="insert_datetime_1" size="13" value=<?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['insert_datetime_1'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
>&nbsp;～
                          <input type="text" class="datepicker" id="datepicker2" name="insert_datetime_2" size="13" value=<?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['insert_datetime_2'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
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
                </div>
              </section>

              <?php $_from = $this->_tpl_vars['shain_idea_count']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['shain_idea_count_map']):
?>
                <div class="list_box">
                  <a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_box_php/idea_detail.php?id=<?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
                    <section>
                      <h3 class="under_line">件数:<?php echo ((is_array($_tmp=$this->_tpl_vars['shain_idea_count_map']['idea_count'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['shain_idea_count_map']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 </h3>
                    </section>
                  </a>
                </div>
              <?php endforeach; endif; unset($_from); ?>
            </section>
          </footer>
  </body>
</html>