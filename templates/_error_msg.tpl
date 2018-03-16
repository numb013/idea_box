{if is_array($error_map)}
	<div class="error_box">
		{foreach from=$error_map item="msg"}
			<p class="error">{$msg|escape}</p>
		{/foreach}
	</div>
{/if}