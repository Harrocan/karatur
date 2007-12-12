<form method="POST" action="?">
Podaj date zdarzenia : <select name="date">
	{html_options options=$Dates}
</select><br/>
Podaj tre¶æ zdarzenia :<br/>
<textarea name="body" style="width:100%;height:100px"></textarea><br/>
<input type="submit" value="dalej" />
</form>