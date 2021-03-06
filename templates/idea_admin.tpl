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
                <li class='active'><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_admin.php">管理画面</a></li>
                <li><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_total.php">集計</a></li>
              </ul>
            </nav>
        <!-- Footer -->
          <footer id="idea_post">
            <section class="split contact">
              <section class="contact">
                <h3>アイデア一覧検索</h3>
                <div class="search_box">
                  <form action="{$smarty.const.URL_ROOT_HTTPS}/idea_admin.php" method="post" enctype="multipart/form-data">
                    <table class="form" width="90%">
                      <tr>
                        <th class="ken">社員</th>
                        <td>
                          {html_options name='shain_id' options=$shain_arry selected=$select separator='<br />'}
                        </td>
                      </tr>
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

              <div style="padding: 0px 20px;">
                <p class="message">{$count_idea}</p>
              </div>

              {foreach item="idea_map" from=$idea_list}
                <div class="list_box">
                  <a href="{$smarty.const.URL_ROOT_HTTPS}/idea_detail.php?id={$idea_map.id|escape}">
                    <section>
                      <h3 class="under_line">・{$idea_map.title|escape}</h3>
                      <p>{$idea_map.body|mb_strimwidth:0:100:'...'}</p>
                     <p>
                        {if ($idea_map.approval_flag == 1)}
                          <span style="color:#f00">●承認済み</span>
                        {else}
                          ×未承認
                        {/if}
                      </p>
                      <p class="date">{$idea_map.insert_datetime|escape|date_format:"%Y-%m-%d"}</p>
                      <p><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_edit.php?id={$idea_map.id|escape}&status=admin_edit">編集</a></p>
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
  </body>
</html>