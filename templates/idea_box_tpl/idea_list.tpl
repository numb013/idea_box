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
                <li class='active'><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_box_php/idea_list.php">アイデア一覧</a></li>
                <li><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_box_php/idea_admin.php">管理画面</a></li>
              </ul>
            </nav>
        <!-- Footer -->
          <footer id="idea_post">
            <section class="split contact">
              {foreach item="idea_map" from=$idea_list}
                <div class="list_box">
                  <a href="{$smarty.const.URL_ROOT_HTTPS}/idea_box_php/idea_detail.php?id={$idea_map.id|escape}">
                    <section>
                      <h3 class="under_line">・{$idea_map.title|escape}</h3>
                      <p>{$idea_map.body|truncate:100:'...'}</p>
                      <p class="date">{$idea_map.created_at|escape|date_format:"%Y-%m-%d"}</p>   
                      {if $idea_map.shain_id == "5"}
                        <p><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_box_php/idea_edit.php?id={$idea_map.id|escape}">編集</a></p>
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