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
    <link rel="stylesheet" href="js/idea_js/jquery-ui.js"></script>
    <link rel="stylesheet" href="js/idea_js/jquery.ui.datepicker-ja.min.js"></script>
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
                <li class='active'><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_top.php">投稿ページ</a></li>
                <li><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_list.php">アイデア一覧</a></li>
                {if $admin_map.key == 1}
                  <li><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_admin.php">管理画面</a></li>
                {/if}
              </ul>
            </nav>

        <!-- Footer -->
          <div id="idea_post">
            <section>
              {include file="_error_msg.tpl"}
              <form method="post" action="{$smarty.const.URL_ROOT_HTTPS}/idea_completion.php" data-ajax="false">
                <div class="field">
                  <label for="name">タイトル</label>
                  <input type="text" name="title" value="{$input_map.title|escape}">
                </div>
                <div class="field">
                  <label for="message">内容・説明</label>
                  <textarea cols="27" rows="3" name="body">{$input_map.body|escape}</textarea>
                </div>
                <ul class="actions">
                  <input type="hidden" value="save" name="mode">
                  <li>
                    <input type="submit" value="送信する" />
                  </li>
                </ul>
              </form>
            </section>
            <section class="split contact">
              <section class="idea_bar">
                  <h3><span style="color: #af0000">▶</span>最新アイデア</h3>
              </section>
              {foreach item="idea_map" from=$idea_list}
              <div class="list_box">
                <a href="{$smarty.const.URL_ROOT_HTTPS}/idea_detail.php?id={$idea_map.id|escape}">
                  <section>
                    <h3>{$idea_map.title|escape}</h3>
                    <p>{$idea_map.body|mb_strimwidth:0:100:'...'}</p>
                    <p class="date">{$idea_map.insert_datetime|escape|date_format:"%Y-%m-%d"}</p>
                    {if $idea_map.shain_id == $user_map.shain_id}
                      <p><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_edit.php?id={$idea_map.id|escape}">編集</a></p>
                    {/if}
                  </section>
                </a>
              </div>
              {/foreach}
            </section>
          </div>
      </div>
  </body>
</html>