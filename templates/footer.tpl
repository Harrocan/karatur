			<div align="right">Wyswietlen: {$Pageviews}</div>		
		</div>
		<div class="kt_main_nav-after"></div>
	</div>
	<div class="sidebar_right">
		<div class="sidebar_right-before"></div>
		<div class="side-cont">
			<div style="text-align:center">Aktualne miejsce :<br><span id="foot_location_link">
			{if $Link!=''}<b><a href="city.php">{$SesLocation}</a></b>{else}{$SesLocation}{/if}
			</span>
			</div>
			<hr class="kt-line"/>
			<div style="overflow:hidden;width:145px">
			<script type="text/javascript"><!--
				OnetAdsClientId = 16724672;
				OnetAdsBoxWidth = 160;
				OnetAdsBoxHeight = 120;
				OnetAdsBoxFormat = "pion160row1";
				OnetAdsBackgroundColor = "000000";
				OnetAdsFillColor = "DEB887";
				OnetAdsTitleColor = "A24E4E";
				OnetAdsBorderColor = "DEB887";
				OnetAdsLinkColor = "FFFFFF";
				OnetAdsTextColor = "DEB887";
			//-->
			</script>
			<script type="text/javascript" src="http://boksy.onet.pl/_s/boksy.js"></script>&nbsp;
			</div>
			<hr class="kt-line"/>
			{php}
				global $__runTestModule;
				$testMod = $__runTestModule;
				if( $testMod['mode'] == 'right' ) {
					$modName = SqlExec( "SELECT `name` FROM modules WHERE id={$testMod['mid']}" );
					$modName = $modName -> fields['name'];
					echo "<div style='border-bottom:solid 1px;text-align:center;color:white'>Podglad modulu</div>";
					runModule( $modName, true );
					echo "<div style='border-top:solid 1px; width:140px;color:white'></div>";
					
				}
				$widgets = SqlExec( "SELECT m.* FROM modulesActive ma LEFT JOIN modules m ON ma.mod_id = m.id WHERE ma.where='sidebar_right' ORDER BY ma.position" );
				$widgets = $widgets -> GetArray();
				//qDebug( $widgets );
				foreach( $widgets as $widget ) {
					runModule( $widget['name'] );
					echo "<hr class=\"kt-line\"/>";
				}
				//print_r( $__runTestModule );
			{/php}
			{if $Qmsg!=''}
				<center><b>Szybka wiesc</b></center>
				{$Qmsg}
				<hr class="kt-line"/>
			{/if}
			{if $PlVote=='Y'}
			<table border="0" align="center" width="140px">
				<tr>
					<td colspan="2" align="center">
						<b>{$PollName}</b>
					</td>
				</tr>
			{section name=poll loop=$PollQuestion}
				<tr>
					<td height="20px" style="position:relative;border-bottom:solid 1px;margin-bottom:2px">
					{*assign value="`150*$Proc[poll]/100`" var='PollProc'*}
					<div style="position:relative">
						<span  style="position: absolute; z-index: 2; top:0px; left:0px">{$PollQuestion[poll]}</span><br>
						
						<img style="position: absolute; z-index: 1; top:0px; left:0px" src=images/bar.png width="{math equation="a*b/c" a=$Proc[poll] b=150 c=100}px" height="14px"/>
					</div>
					<div style="float:none;clear:both">&nbsp;</div>
					</td>
					<td valign="top" style="width:20px">{$PollValue[poll]}</td>
				</tr>
			{/section}
			</table>
			{/if}
			{if $PlVote=='N'}
			<form method="post" action="vote.php">
				<table border="0" align="center">
					<tr>
						<td colspan="2" align="center">{$PollName}</td>
					</tr>
					{section name=vote loop=$PollQuestion}
						<tr>
							<td><input type="radio" name="vote" value="{$smarty.section.vote.index}"></td>
							<td>{$PollQuestion[vote]}</td>
						</tr>
					{/section}
					<tr>
						<td colspan="2" align="center"><input type="submit" value="G³osuj !"></td>
					</tr>
			</table>
			</form>
			{/if}
			<center>[<a href="poll.php">archiwum</a>]</center>
		</div>
		<div class="sidebar_right-after"></div>
	</div>
	<table cellpadding="0" cellspacing="0" class="bar">
		<tr>
			<td class="bar-left"></td>
			<td class="bar-mid">
				&copy; 2006 Kara-Tur based on <a href="http://vallheru.sourceforge.net/index.php" target=_blank>Vallheru Team</a>
			</td>
			<td class="bar-right"></td>
		</tr>
	</table>
</div>
<img src="images/layout/owner.png" style="display:block; margin:3px auto 10px auto" />

<!-- (C) 2006-2007 Kara-Tur Team -->
<!-- gra powstala na podstawie kodu Vallheru Team wesja 0.6 i wyzsze -->
</body>                  
</html>

