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
    <link rel="stylesheet" type="text/css" href="css/idea_css/idea_main.css" />
    <noscript><link rel="stylesheet" href="css/idea_css/noscript.css" /></noscript>
    <script type="text/javascript" src="js/idea_js/jquery.min.js"></script>
    <script type="text/javascript" src="js/idea_js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/idea_js/jquery.ui.datepicker-ja.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/idea_css/jquery-ui.css" />
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
                <li><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_admin.php">管理画面</a></li>
                <li class='active'><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_total.php">集計</a></li>
              </ul>
            </nav>
        <!-- Footer -->
          <footer id="idea_post">
            <section class="split contact">
              <section class="contact">
                <h3>修正検索</h3>
                <div class="search_box">
                  <form action="{$smarty.const.URL_ROOT_HTTPS}/idea_total.php" method="post" enctype="multipart/form-data">
                    <table class="form" width="90%">
                      <tr>
                        <th class="ken">指定日</th>
                        <td>
                          <input type="text" class="datepicker" id="datepicker1" name="insert_datetime_1" size="13" value={$input_map.insert_datetime_1|escape}>&nbsp;～
                          <input type="text" class="datepicker" id="datepicker2" name="insert_datetime_2" size="13" value={$input_map.insert_datetime_2|escape}>
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

              {foreach item="shain_idea_count_map" from=$shain_idea_count}
                <div class="list_box">
                  <a href="#">
                    <section>
                        {if ($shain_idea_count_map.idea_count == '0')}
                          <h3 class="under_line">
                        {else}
                          <h3 class="under_line" style="color:#f00;">
                        {/if}
                      件数:{$shain_idea_count_map.idea_count|escape} {$shain_idea_count_map.name|escape} 
                      </h3>
                    </section>
                  </a>
                </div>
              {/foreach}
            </section>
          </footer>
  </body>
</html>