{if $Id==''}
<br><br>
Tutaj znajduj± siê kartoteki wszystkich tych, którzy przeskrobali. Czarno na bia³ym, bez owijania w bawe³nê ... o kim chcesz siê dowiedzieæ ?
<table border="0">
	<tr>
		<td width="30"><b>ID</b</td>
		<td width="150"><b>Imie</b</td>
		<td><b>Ilo¶æ</b></td>
	</tr>
	{section name=sk loop=$SkId}
	<tr>
		<td>{$SkId[sk]}</td>
		<td><a href=akta.php?id={$SkId[sk]}>{$SkName[sk]}</a></td>
		<td>{$SkIlosc[sk]}</td>
	</tr>
	{/section}
</table>
{else}
<br>
(<a href=akta.php> wróæ </a>)
<br><br>
<table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="2">
    <tr>
      <td valign="top" width="120px" align="right">
      Imie : <br>
      Email : <br>
      Ranga : <br>
      Wiek : <br>
      Logowañ : <br>
      IP : <br>
      Rasa : <br>
      Klasa : <br>
      Immunitet : <br>
      GG : <br>
      Bóstwo : <br>
      P³eæ : <br>
      </td>
      <td valign="top" width="200"> <a href=view.php?view={$Id}>{$Name}</a><br>{$Email}<br>{$Rank}<br>{$Age}<br>{$Logins}<br>{$Ip}<br>{$Rasa}<br>{$Klasa}<br>{$Immu}<br>{$GG}<br>
      {$Deity}<br>{$Gender}</td>
      <td width="100px" rowspan="1" valign="top"><img src=avatars/{$Avatar} style="max-height: 100px; max-width: 100px;"></td>
    </tr>
    <tr>
    <td colspan="3">
    {section name=a loop=$SkId}
    <table border="0" width="100%" style="border-bottom-style:solid; border-bottom-width: thin; border-top-style:solid; border-top-width: thin;">
    	<tr>
    		<td width="104px">Numer teczki : <b>{$SkId[a]}</b></td>
      		<td>Numer celi : <b>{$SkCela[a]}</b></td>
      		<td align="right" width="120px">{$SkData[a]}</td>
      		<td rowspan="2" align="right" valign="top" width="25px">{*<a href=akta.php?del={$SkId[a]}&id={$Id}><img src="images/del.gif" alt="Usuñ teczke" border="0"></a>*}</td>
    	</tr>
    	<tr>
    		<td colspan="2" valign="top">{$SkReason[a]}</td>
    		<td valign="top">Grzywna : {$SkCost[a]}{if $FreeId[a]!=0}<br>Wykupiony przez : <br>Id: {$FreeId[a]}<br><a href=view.php?view={$FreeId[a]}>Imie: {$FreeName[a]}</a><br>data: {$FreeDate[a]}{/if}</td>
    		
    	</tr>
    </table>
    {/section}
    </td>
    <td></td>
    </tr>
</table>

{/if}