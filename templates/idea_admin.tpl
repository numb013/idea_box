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
    <link rel="stylesheet" type="text/css" href="./css/idea_main.css" />
    <noscript><link rel="stylesheet" href="./css/noscript.css" /></noscript>
  <script type="text/javascript" src="./js/jquery.min.js"></script>
  <script type="text/javascript" src="./js/jquery-ui.js"></script>
  <script type="text/javascript" src="./js/jquery.ui.datepicker-ja.min.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />

  <script>
    $(function() {ldelim}
      $.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
      $( "#datepicker1" ).datepicker();
      $( "#datepicker2" ).datepicker();
    {rdelim});
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
                <li><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_top.php">投稿ページ</a></li>
                <li><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_list.php">アイデア一覧</a></li>
                <li class='active'><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_admin.php">管理画面</a></li>
              </ul>
            </nav>
        <!-- Footer -->
          <footer id="idea_post">
            <section class="split contact">



              <section class="contact">
                <h3>商品一覧検索</h3>
                {include file="admin/_error_msg.tpl"}
                <form action="{$smarty.const.URL_ROOT_HTTPS}/idea_admin.php" method="post" enctype="multipart/form-data">
                  <table class="form" width="90%" id="teb">
                    <tr>
                      <th class = "ken">社員</th>
                      <td>
                        {html_options name='shain_id' options=$shain_arry selected=$select separator='<br />'}
                      </td>
                    </tr>
                    <tr>
                      <th class = "ken">指定日</th>
                      <td>
                        <input type="text"  id="datepicker1" name="created_at_1" size="13" value={$input_map.created_at_1|escape}>&nbsp;～
                        <input type="text"  id="datepicker2" name="created_at_2" size="13" value={$input_map.created_at_2|escape}>
                      </td>
                    </tr>
                  </table>
                  <br>
                  <div id="form_bottom">
                    <input type="hidden" value="1" name="search_flag">
                    <input type="submit" value="検索" class="button">
                  </div>
                </form>
              </section>





              {foreach item="idea_map" from=$idea_list}
                <div class="list_box">
                  <a href="{$smarty.const.URL_ROOT_HTTPS}/idea_detail.php?id={$idea_map.id|escape}">
                    <section>
                      <h3 class="under_line">・{$idea_map.title|escape}</h3>
                      <p>{$idea_map.body|truncate:100:'...'}</p>
                      <p class="date">{$idea_map.created_at|escape|date_format:"%Y-%m-%d"}</p>   
                        <p><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_edit.php?id={$idea_map.id|escape}">編集</a></p>
                    </section>
                  </a>
                </div>
              {/foreach}
            </section>
          </footer>

          <div id="main">
          <section>
            <footer>
              <p class="message">{$count_idea}</p>
              <div class="pagination">
                <p class="resultPage">{$paging_link}</p>
              </div>
            </footer>
          </section>
          </div>

    <!-- Scripts -->
    <script type="text/javascript" src="./js/jquery.scrollex.min.js"></script>
    <script type="text/javascript" src="./js/jquery.scrolly.min.js"></script>
    <script type="text/javascript" src="./js/skel.min.js"></script>
    <script type="text/javascript" src="./js/util.js"></script>
    <script type="text/javascript" src="./js/main.js"></script>
  </body>
</html>