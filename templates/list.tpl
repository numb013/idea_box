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
              <li><a href="{$smarty.const.URL_ROOT_HTTPS}/index.php">投稿ページ</a></li>
              <li class="active"><a href="{$smarty.const.URL_ROOT_HTTPS}/list.php">アイデア一覧</a></li>
            </ul>
          </nav>


        <!-- Footer -->
          <footer id="idea_post">
            <section class="split contact">
              {foreach item="idea_map" from=$idea_list}
                <div class="list_box">
                  <a href="{$smarty.const.URL_ROOT_HTTPS}/detail.php?id={$idea_map.id|escape}">
                    <section>
                      <h3 class="under_line">・{$idea_map.title|escape}</h3>
                      <p>{$idea_map.body|truncate:100:'...'}</p>
                      <p class="date">{$idea_map.created_at|escape|date_format:"%Y-%m-%d"}</p>   
                      {if $idea_map.user_id == "5"}
                        <p><a href="{$smarty.const.URL_ROOT_HTTPS}/edit.php?id={$idea_map.id|escape}">編集</a></p>
                      {/if}                 
                    </section>
                  </a>
                </div>
              {/foreach}
            </section>
          </footer>

          <div id="main">
          <section>
            <footer>
              <p class="message">{$count_item}</p>
              <div class="pagination">
                <p class="resultPage">{$paging_link}</p>
              </div>
            </footer>
          </section>
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