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
                <li><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_list.php">アイデア一覧</a></li>
                {if $admin_map.key == 1}
                  <li><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_admin.php">管理画面</a></li>
                {/if}
              </ul>
            </nav>
        <!-- Footer -->
          <footer id="idea_post">
            <section class="split contact">
              <section class="alt">
                {include file="_error_msg.tpl"}
                <form method="post" action="{$smarty.const.URL_ROOT_HTTPS}/idea_edit.php" data-ajax="false">
                  <div class="field">
                    <label for="name">タイトル</label>
                    <input type="text" name="title" value="{$idea_map.title|escape}">
                  </div>
                  <div class="field">
                    <label for="message">内容・説明</label>
                    <textarea cols="27" rows="10" name="body">{$idea_map.body|escape}</textarea>
                  </div>
                  {if $admin_map.key == 1}
                    <div class="field">
                      <center>※管理者のみ表示</center>
                    </div>
                    <div class="field">
                        <center>{html_radios name='approval_flag' options=$approval selected=$idea_map.approval_flag}</center>
                    </div>
                    <div class="field">
                        <center>
                        {html_checkboxes name='delete_flag' options=$delete}
                      </center>
                    </div>
                  {/if}
                  <input type="hidden" name="id" value="{$idea_map.id|escape}">
                  <input type="hidden" value="edit" name="mode">
                  <input type="submit" value="編集する" />
                </form>
              </section>
            </section>
          </footer>
      </div>
  </body>
</html>