{if is_array($error_map)}
  <table class="form" width="90%">
  <tr>
    <td style="background-color:#f7f7f7;">
      <table class="no_table" border="0" cellpadding="0" cellspacing="0" bgcolor="#cccccc">
      <tr>
      <td width="20" style="background-color:#f7f7f7;">&nbsp;</td>
      <td width="100" valign="middle" style="background-color:#f7f7f7;">
      <img src="{$smarty.const.URL_ROOT_HTTPS}/admin/_design/images/error_arrow.gif" style="padding-left:30px; padding-right:40px; padding-top:10px; padding-bottom:10px;"/>
      </td>
      <td style="background-color:#f7f7f7; color:#FF0000; padding-top:10px; padding-bottom:10px;">
      <p class="error">
        {foreach from=$error_map item="msg"}
          {$msg|escape}<br>
        {/foreach}
      </p>
      </td>
      </tr>
      </table>
    </td>
  </tr>
  </table>
  <br>
{/if}