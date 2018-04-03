<?php /* Smarty version 2.6.9, created on 2018-03-30 13:46:00
         compiled from /var/www/html/data/idea_box/templates/idea_box_tpl/idea_admin.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', '/var/www/html/data/idea_box/templates/idea_box_tpl/idea_admin.tpl', 54, false),array('modifier', 'escape', '/var/www/html/data/idea_box/templates/idea_box_tpl/idea_admin.tpl', 60, false),array('modifier', 'truncate', '/var/www/html/data/idea_box/templates/idea_box_tpl/idea_admin.tpl', 83, false),array('modifier', 'date_format', '/var/www/html/data/idea_box/templates/idea_box_tpl/idea_admin.tpl', 91, false),)), $this); ?>
<!DOCTYPE HTML>
<!--
  Massively by HTML5 UP
  html5up.net | @ajlkn
  Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
  <head>
    <title>アイデアBOX｜フジボウル</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" type="text/css" href="../css/idea_css/idea_main.css" />
    <noscript><link rel="stylesheet" href="../css/idea_css/noscript.css" /></noscript>
    <script type="text/javascript" src="../js/idea_js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/idea_js/jquery-ui.js"></script>
    <script type="text/javascript" src="../js/idea_js/jquery.ui.datepicker-ja.min.js"></script>
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
/idea_box_php/idea_top.php">投稿ページ</a></li>
                <li><a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_box_php/idea_list.php">アイデア一覧</a></li>
                <li class='active'><a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_box_php/idea_admin.php">管理画面</a></li>
                <li><a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_box_php/idea_total.php">集計</a></li>
              </ul>
            </nav>
        <!-- Footer -->
          <footer id="idea_post">
            <section class="split contact">
              <section class="contact">
                <h3>アイデア一覧検索</h3>
                <div class="search_box">
                  <form action="<?php echo @URL_ROOT_HTTPS; ?>
/idea_box_php/idea_admin.php" method="post" enctype="multipart/form-data">
                    <table class="form" width="90%">
                      <tr>
                        <th class="ken">社員</th>
                        <td>
                          <?php echo smarty_function_html_options(array('name' => 'shain_id','options' => $this->_tpl_vars['shain_arry'],'selected' => $this->_tpl_vars['select'],'separator' => '<br />'), $this);?>

                        </td>
                      </tr>
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

              <div style="padding: 0px 20px;">
                <p class="message"><?php echo $this->_tpl_vars['count_idea']; ?>
</p>
              </div>

              <?php $_from = $this->_tpl_vars['idea_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['idea_map']):
?>
                <div class="list_box">
                  <a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_box_php/idea_detail.php?id=<?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
                    <section>
                      <h3 class="under_line">・<?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h3>
                      <p><?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['body'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 100, '...') : smarty_modifier_truncate($_tmp, 100, '...')); ?>
</p>
                     <p>
                        <?php if (( $this->_tpl_vars['idea_map']['approval_flag'] == 1 )): ?>
                          <span style="color:#f00">●承認済み</span>
                        <?php else: ?>
                          ×未承認
                        <?php endif; ?>
                      </p>
                      <p class="date"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['idea_map']['insert_datetime'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</p>
                      <p><a href="<?php echo @URL_ROOT_HTTPS; ?>
/idea_box_php/idea_edit.php?id=<?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
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
    <script type="text/javascript" src="../js/jquery.scrollex.min.js"></script>
    <script type="text/javascript" src="../js/jquery.scrolly.min.js"></script>
    <script type="text/javascript" src="../js/skel.min.js"></script>
    <script type="text/javascript" src="../js/util.js"></script>
    <script type="text/javascript" src="../js/main.js"></script>
  </body>
</html>