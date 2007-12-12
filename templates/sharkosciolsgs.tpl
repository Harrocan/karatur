<html>
<head>
<meta http-equiv="Refresh" content="15;url=sharkosciolsgs.php">
<meta http-equiv="Content-Type" content="text/html;" charset="iso-8859-2">
</head>
<body text="#FFFC9F" alink="red" link="gold" vlink="gold">
<font face="verdana" size="-2">

{section name=player loop=$Text}
    <b>{$Author[player]} {if $Showid == "1"}ID:{$Senderid[player]}{/if}</b>: {$Text[player]}<br>
{/section}

<font class="normal"><center><br><br><br>{$Player}<br>
Jest <b>{$Text1}</b> wypowiedzi. | <b>{$Online}</b> osob w swiatyni.<br>
</font>
</body>
</html>

