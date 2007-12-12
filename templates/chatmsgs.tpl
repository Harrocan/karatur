<html>
<head>
<META HTTP-EQUIV=Refresh CONTENT="15;url=chatmsgs.php">
<meta http-equiv=Content-Type content=text/html; charset=iso-8859-2>
</head>
<body bgcolor=black text=#FFFC9F alink=red link=gold vlink=gold>

<table border="0">
<tr>
<td width="75%" valign="top" style="border-right-style: solid; border-right-color:#333333;">
<font face=verdana size=-2>
{section name=player loop=$Text}
    <b>{$Author[player]} {if $Showid == "1"}ID:{$Senderid[player]}{/if}</b>: {$Text[player]}<br>
{/section}
</td>
<font face=verdana size=-2>
{*<center><br><br><br>{$Player}<br>*}

<td valign="top">
	<table border="0" width="100%">
	{section name=male loop=$Chatid}
	<tr><td> <font face=verdana size=-2>
	<A href=view.php?view={$Chatid[male]} target="_top" style="font-style: italic; text-decoration: none;"><img src="./images/{$Chatgender[male]}" border="0"> {$Chatname[male]}</a>
	</td></tr>
	{/section}
	<tr><td style="border-top-style: solid; border-top-color:#333333;"> <font face=verdana size=-2>
		<b>{$Text1}</b> wypowiedzi
	</tr></td>
	<tr><td> <font face=verdana size=-2>
		<b>{$Online}</b> na czacie
	</tr></td>
	</table>
</td>
</tr>
</table>
</font>
</body>
</html>


