<?php

require_once("./includes/head.php");
/*echo '
<!--Begin code for ConferenceRoom Applet-->
<table border=0 width=500 align=center><tr><td>
<applet archive="http://www.freejavachat.com/java/cr.zip" 
	codebase="http://www.freejavachat.com/java/" 
	name=cr 
	code="ConferenceRoom.class" 
	width=500 
	height=300> 
<param name=channel value=Karczma> 
<param name=showbuttonpanel value=true>
<param name=bg value=131313>
<param name=fg value=DEB887>
<param name=roomswidth value=0>
<param name=lurk value=false>
<param name=simple value=true>
<param name=restricted value=false>
<param name=showjoins value=true>
<param name=showserverwindow value=true>
<param name=nicklock value=false>
<param name=playsounds value=false>
<param name=onlyshowchat value=false>
<param name=showcolorpanel value=false>
<param name=floatnewwindows value=false>
<param name=timestamp value=false>
<param name=listtime value=0>
<param name=guicolors1 value="youColor=CF8B33;operColor=FF0000;voicecolor=006600;userscolor=000099">
<param name=guicolors2 value="inputcolor=000000;inputtextColor=FFFFFF;sessioncolor=131313;systemcolor=0000FF">
<param name=guicolors3 value="titleColor=131313;titletextColor=CF8B33;sessiontextColor=DEB887">
<param name=guicolors4 value="joinColor=009900;partColor=009900;talkcolor=CF8B33">
<param name=nick value=""> 
 This chat application requires Java support.<br> This chat also available via IRC at:<br> <a href="irc://irc.ircstorm.net:6667/">irc://irc.ircstorm.net:6667/</a>
Get your own <a href="http://www.freejavachat.com">Free Chat Rooms</a></applet> </td></tr></table>
<!--End code for ConferenceRoom Applet-->
<br><center><a href="http://www.freejavachat.com" 
>Free Chat</a> provided by freejavachat.com</center>


';*/
echo '
<iframe src="http://www.flash-chat.pl/chat.php?chatID=KTKarczma" width="500" height="450" frameborder="0" scrolling="no">Sorry, your browser does not support inline frames. Click <a href="http://www.flash-chat.pl/chat.php?chatID=KTKarczma" onClick="javascript:window.open("http://www.flash-chat.pl/chat.php?chatID=KTKarczma','flashchat_KTKarczma','width=500,height=450,menubar=no,statusbar=no"); return false;">here</a> to open chat in a new window.</iframe>
  ';

require_once("./includes/foot.php");

?>
