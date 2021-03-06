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
    <link rel="stylesheet" href="css/idea_css/idea_main.css" />
    <link rel="stylesheet" href="css/idea_css/noscript.css" /></noscript>
    <link rel="stylesheet" href="js/idea_js/idea_js/jquery.min.js"></script>
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
                <li><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_top.php">投稿ページ</a></li>
                <li class='active'><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_list.php">アイデア一覧</a></li>
                {if $admin_map.key == 1}
                  <li><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_admin.php">管理画面</a></li>
                {/if}
              </ul>
            </nav>
        <!-- Footer -->
          <footer id="idea_post">
            <section class="split contact">
              {foreach item="idea_map" from=$idea_list}
                <div class="list_box">
                  <a href="{$smarty.const.URL_ROOT_HTTPS}/idea_detail.php?id={$idea_map.id|escape}">
                    <section>
                      <h3 class="under_line">・{$idea_map.title|escape}</h3>
                      <p>{$idea_map.body|mb_strimwidth:0:100:'...'}</p>
                      <p class="date">{$idea_map.created_at|escape|date_format:"%Y-%m-%d"}</p>   
                      {if $idea_map.shain_id == $user_map.shain_id}
                        <p><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_edit.php?id={$idea_map.id|escape}">編集</a></p>
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
  </body>
</html>