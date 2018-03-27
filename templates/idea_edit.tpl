<!DOCTYPE HTML>
<!--
  Massively by HTML5 UP
  html5up.net | @ajlkn
  Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
{include file="_header.tpl"}
<body class="is-loading">
    <!-- Wrapper -->
      <div id="wrapper" class="fade-in">
        <!-- Header -->
          <header id="header">
            <a href="index.html" class="logo">IDEA BOX</a>
          </header>

        {include file="_menu.tpl"}
        <!-- Footer -->
          <footer id="idea_post">
            <section class="split contact">
              <section class="alt">
                <form method="post" action="{$smarty.const.URL_ROOT_HTTPS}/idea_edit.php" data-ajax="false">
                  <div class="field">
                    <label for="name">タイトル</label>
                    <input type="text" name="title" value="{$idea_map.title|escape}">
                  </div>
                  <div class="field">
                    <label for="message">内容・説明</label>
                    <textarea cols="27" rows="10" name="body">{$idea_map.body|escape}</textarea>
                  </div>
                  <input type="hidden" name="id" value="{$idea_map.id|escape}">
                  <input type="hidden" value="edit" name="mode">
                  <input type="submit" value="編集する" />
                </form>
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