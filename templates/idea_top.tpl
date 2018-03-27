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
          <div id="idea_post">
            <section>
              {include file="_error_msg.tpl"}
              <form method="post" action="{$smarty.const.URL_ROOT_HTTPS}/form_completion.php" data-ajax="false">
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
                    <p>{$idea_map.body|truncate:150:'...':true}</p>
                    <p class="date">{$idea_map.created_at|escape|date_format:"%Y-%m-%d"}</p>
                    {if $idea_map.user_id == "5"}
                      <p><a href="{$smarty.const.URL_ROOT_HTTPS}/idea_edit.php?id={$idea_map.id|escape}">編集</a></p>
                    {/if}
                  </section>
                </a>
              </div>
              {/foreach}
            </section>
          </div>

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
<!--     <script type="text/javascript" src="./js/main.js"></script> -->
  </body>
</html>