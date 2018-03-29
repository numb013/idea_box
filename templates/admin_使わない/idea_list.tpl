<html>
  <head>
  <title>{$smarty.const.ADMIN_TITLE}</title>
  <meta http-equiv="Content-Language" content="ja">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="robots" content="noindex,nofollow,noarchive">
  <meta http-equiv="Content-Style-Type" content="text/css">
  <link rel="stylesheet" href="./_design/styles/core.css" type="text/css">
  <script type="text/javascript" src="../js/jquery.min.js"></script>
  <script type="text/javascript" src="../js/jquery-ui.js"></script>
  <script type="text/javascript" src="../js/jquery.ui.datepicker-ja.min.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />

  <script>
    $(function() {ldelim}
      $.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
      $( "#datepicker1" ).datepicker();
      $( "#datepicker2" ).datepicker();
    {rdelim});
  </script>

  </head>
  <body>
    <div id="body">
      <!-- コンテンツヘッダー部 start -->
      {include file="admin/_header.tpl"}
      <div id="bodyContainer">
      <div>

        <h3>商品一覧検索</h3>
        {include file="admin/_error_msg.tpl"}
        <form action="{$smarty.const.URL_ROOT_HTTPS}/admin/idea_list.php" method="post" enctype="multipart/form-data">
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
                <input type="text"  id="datepicker1" name="insert_datetime_1" size="13" value={$input_map.insert_datetime_1|escape}>&nbsp;～
                <input type="text"  id="datepicker2" name="insert_datetime_2" size="13" value={$input_map.insert_datetime_2|escape}>
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

      <!-- コンテンツヘッダー部  end  -->
        <h3>アイデア一覧</h3>
        <p class="message">{$count_idea}</p>
        <p class="resultPage">{$paging_link}</p>
        <form action="approval.php" method="POST" name="approval_form">
          <table class="table" width="95%">
            <tr>
              <th width="20%">タイトル</th>
              <th width="30%">内容</th>
              <th width="5%">承認</th>
              <th width="5%">投稿日</th>
              <th width="5%">編集</th>
              <th width="5%">詳細</th>
            </tr>
            {foreach item="idea_map" from=$idea_list key=item_key}
              <tr>
                <td><center>{$idea_map.title|escape}</center></td>
                <td><center>{$idea_map.body|escape}</center></td>
                <td><center>
                  {if ($idea_map.approval_flag == 1)}
                    承認済み
                  {else}
                    未承認
                  {/if}
                </center></td>
                <td><center>{$idea_map.insert_datetime|escape}</center></td>
                <td><center><a href="{$smarty.const.URL_ROOT_HTTPS}/admin/idea_edit.php?id={$idea_map.id}">編集</a></center></td>
                <td><center><a href="{$smarty.const.URL_ROOT_HTTPS}/admin/idea_detail.php?id={$idea_map.id}">詳細</a></center></td>
              </tr>
            {/foreach}
          </table>
          <p class="resultPage">{$paging_link}</p>
        </form>
      </div>
      <br>
      <br>
      <br>
      <br>
      <br>
    </div>
    <!-- メニュー部 start -->
    {include file="admin/_menu.tpl"}
    <!-- メニュー部  end  -->
  </body>
</html>

