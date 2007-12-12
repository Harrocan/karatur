{if $ErrNo == 'E_USER_NOTICE'}
<div style="border-style:solid; border-width: thin; border-color:#5cc66d; margin:2px; padding:2px width:50%">{$ErrDesc}</div>
{elseif $ErrNo == 'E_USER_WARNING'}
<div style="border-style:solid; border-width: 2px; border-color:#e19708; margin:4px; padding:2px width:50%">
{$ErrDesc}<br><i>{$ErrFile}</i> at <b>{$ErrLine}</b></div>
{else}
<div style="border-style:solid; border-width: 4px; border-color:#cd0505; margin:4px; padding:2px width:50%">
{$ErrDesc}<br><i>{$ErrFile}</i> at <b>{$ErrLine}</b></div><br>
{/if}