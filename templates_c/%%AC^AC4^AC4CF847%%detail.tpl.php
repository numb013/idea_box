<?php /* Smarty version 2.6.9, created on 2018-03-15 18:00:21
         compiled from /var/www/html/data/mailing_list/templates/detail.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/var/www/html/data/mailing_list/templates/detail.tpl', 37, false),)), $this); ?>
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
    <link rel="stylesheet" type="text/css" href="./css/main.css" />
    <noscript><link rel="stylesheet" href="./css/noscript.css" /></noscript>
  </head>




<body class="is-loading">
    <!-- Wrapper -->
      <div id="wrapper" class="fade-in">
        <!-- Header -->
          <header id="header">
            <a href="index.html" class="logo">IDEA BOX</a>
          </header>

          <nav id="nav">
            <ul class="links">
              <li><a href="<?php echo @URL_ROOT_HTTPS; ?>
/index.php">投稿ページ</a></li>
              <li><a href="<?php echo @URL_ROOT_HTTPS; ?>
/list.php">アイデア一覧</a></li>
            </ul>
          </nav>
        <!-- Footer -->
          <footer id="idea_post">
            <section class="split contact">
              <section class="alt">
                <h2 style="border-bottom: 1px solid #717981;"><?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h2>
                <p style="font-size: 20px; margin-top:15px"><?php echo ((is_array($_tmp=$this->_tpl_vars['idea_map']['body'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</p>
              </section>
            </section>
          </footer>
        <!-- Copyright -->
          <div id="copyright">
            <ul><li>&copy; Untitled</li><li>Design: <a href="https://html5up.net">HTML5 UP</a></li></ul>
          </div>

      </div>

    <!-- Scripts -->
    <script type="text/javascript" src="./js/jquery.min.js"></script>
    <script type="text/javascript" src="./js/jquery.scrollex.min.js"></script>
    <script type="text/javascript" src="./js/jquery.scrolly.min.js"></script>
    <script type="text/javascript" src="./js/skel.min.js"></script>
    <script type="text/javascript" src="./js/util.js"></script>
    <script type="text/javascript" src="./js/main.js"></script>
  </body>
</html>