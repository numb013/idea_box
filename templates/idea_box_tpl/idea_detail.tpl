<!DOCTYPE HTML>
<!--
  Massively by HTML5 UP
  html5up.net | @ajlkn
  Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
  <head>
    {include file="idea_box_tpl/_header.tpl"}
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
                <li><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_box_php/idea_top.php">投稿ページ</a></li>
                <li><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_box_php/idea_list.php">アイデア一覧</a></li>
                <li><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_box_php/idea_admin.php">管理画面</a></li>
              </ul>
            </nav>
        <!-- Footer -->
          <footer id="idea_post">
            <section class="split contact">
              <section class="alt">
                <h2 style="border-bottom: 1px solid #717981;">{$idea_map.title|escape}</h2>
                <p style="font-size: 20px;margin-top:15px;line-height: 36px;">{$idea_map.body|escape}</p>
                {if $idea_map.shain_id == "5"}
                  <p><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_box_php/idea_edit.php?id={$idea_map.id|escape}">編集</a></p>
                {/if}
              </section>

            </section>
          </footer>
        <!-- Copyright -->
      </div>
  </body>
</html>