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
                <h2 style="border-bottom: 1px solid #717981;">{$idea_map.title|escape}</h2>
                <p style="font-size: 20px;margin-top:15px;line-height: 36px;">{$idea_map.body|escape}</p>
                {if $idea_map.user_id == "5"}
                  <p><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_edit.php?id={$idea_map.id|escape}">編集</a></p>
                {/if}
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