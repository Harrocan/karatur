<br><br>
<script language="JavaScript" src="js/zgl.js"></script>
<form action="?action=send" method="post">
	<fieldset>
		<legend><strong>Formularz</strong></legend> 
		<table>
			<tr>
				<td>Dzia³</td>
				<td>
					<select name="type" onchange="desc(this)">
						<option value="">
						<option value="E">B³êdy/bugi gry
						<option value="V">Naruszenie regulaminu
						<option value="M">¦luby
						<option value="R">Rangi
						<option value="C">Opinie/rady/uwagi
						<option value="O">Inne
					</select>
				</td>
			</tr>
			<tr>
				<td>Temat</td>
				<td><input type="text" name="topic"></td>
			</tr>
			<tr>
				<td>Opis problemu</td>
			</tr>
			<tr>
				<td colspan=2>
					<textarea name="body" rows="8" cols="50"></textarea>
				</td>
			</tr>
		</table>
		<div name="desc" id="desc"></div>
		<br><br>
		<center><input type="submit" value="Wy¶lij do nas informacje"><input type="reset" value="Usuñ wszystkie informacje"></center>
	</fieldset>
</form>



