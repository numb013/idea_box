<?php /* Smarty version 2.6.9, created on 2018-03-13 04:11:34
         compiled from /xampp/htdocs/mailing_list/templates/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/xampp/htdocs/mailing_list/templates/index.tpl', 38, false),)), $this); ?>
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

        <!-- Nav -->
          <nav id="nav">
            <ul class="links">
              <li class="active"><a href="index.html">投稿ページ</a></li>
              <li><a href="list.html">アイデア一覧</a></li>
            </ul>
          </nav>

        <!-- Footer -->
          <div id="idea_post">
            <section>
              <form method="post" action="#">
                <div class="field">
                  <label for="name">タイトル</label>
                  <input type="text" name="titel" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['titel'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
                </div>
                <div class="field">
                  <label for="message">内容・説明</label>
                  <textarea cols="27" rows="3" name="message"><?php echo ((is_array($_tmp=$this->_tpl_vars['input_map']['message'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea>
                </div>
                <ul class="actions">
                  <li><input type="submit" value="投稿する" /></li>
                </ul>
              </form>
            </section>
            <section class="split contact">
              <section class="idea_bar">
                  <h3><span style="color: #af0000">▶</span>最新アイデア</h3>
              </section>
              <a href="detail.html">
                <section>
                  <h3>ウォーターサーバー設置</h3>
                  <p>テキストテキストテキストテキストテキストテキスト</p>
                  <p>2018-03-10</p>
                </section>
              </a>
              <a href="detail.html">
                <section>
                  <h3>ウォーターサーバー設置</h3>
                  <p>テキストテキストテキストテキストテキストテキスト</p>
                  <p>2018-03-10</p>
                </section>
              </a>
              <a href="detail.html">
                <section>
                  <h3>ウォーターサーバー設置</h3>
                  <p>テキストテキストテキストテキストテキストテキスト</p>
                  <p>2018-03-10</p>
                </section>
              </a>
            </section>

            </section>
          </div>

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