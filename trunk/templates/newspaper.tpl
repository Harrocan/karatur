{if $Step == "" && $Read == "" && $Comments == "" && $Step3 == ""}
<br><center>
<img src="images/gazeta_foto.jpg"><br><br>
    {$Paperinfo} {$Gamename} {$Paperinfo2}<br />
    {$Paperinfo3}<br /><br /><br />

    <table align="center">
        <tr>
            <td valign="top">
                <a href="newspaper.php?step=new">{$Anewpaper}</a><br />
                <a href="newspaper.php?step=archive">{$Aarchive}</a><br />
                <a href="newspaper.php?step=mail">{$Aredmail}</a><br />
                <a href="skarbiecburm.php"></a><br />
                {if $Rank == "Admin" || $Rank == "Redaktor" || $Rank == "Redaktor Naczelny"}
                    <br /><br /><a href="newspaper.php?step=redaction">{$Aredaction}</a><br />
                {/if}
            </td>
        </tr>
    </table>
{/if}

{if $Step == "new" || $Read != "" || $Step3 == 'S'}
<br><center>
<img src="images/gazeta_foto.jpg"><br><br>
    {$Readinfo}<br /><br /><br />
    <table align="center" width="80%">
        <tr>
            <td valign="top">
                <a href="newspaper.php?{$Newslink}&amp;step2=M">{$Anews}</a><br />
                <a href="newspaper.php?{$Newslink}&amp;step2=N">{$Anews2}</a><br />
                <a href="newspaper.php?{$Newslink}&amp;step2=O">{$Acourt}</a><br />
                <a href="newspaper.php?{$Newslink}&amp;step2=R">{$Aroyal}</a><br />
                <a href="newspaper.php?{$Newslink}&amp;step2=K">{$Aking}</a><br />
                <a href="newspaper.php?{$Newslink}&amp;step2=C">{$Achronicle} {$Gamename}</a><br />
            </td>
            <td valign="top">
                <a href="newspaper.php?{$Newslink}&amp;step2=S">{$Asensations}</a><br />
                <a href="newspaper.php?{$Newslink}&amp;step2=H">{$Ahumor}</a><br />
                <a href="newspaper.php?{$Newslink}&amp;step2=I">{$Ainter}</a><br />
                <a href="newspaper.php?{$Newslink}&amp;step2=A">{$Anews3}</a><br />
                <a href="newspaper.php?{$Newslink}&amp;step2=P">{$Apoetry}</a><br />
            </td>
        </tr>
    </table><br /><br />
    {if $Step3 == "S"}
        <form method="post" action="newspaper.php?step=redaction&amp;step3=release">
            <input type="submit" value="{$Apublic}" />
        </form><br /><br />
    {/if}
    {if $Step2 != ''}
        <table align="center" width="80%">
            {section name=newspaper loop=$Artid}
                <tr>
                    <td><b>{$Arttitle[newspaper]}</b> ({$Artauthor[newspaper]}) {if $Step3 == "S" && ($Rank == "Admin" || $Rank == "Redaktor" || $Rank == "Redaktor Naczelny")} <a href="newspaper.php?step=redaction&amp;step3=edit&amp;edit={$Artid[newspaper]}">{$Aedit}</a>&nbsp;&nbsp;&nbsp; <a href="newspaper.php?step=redaction&amp;step3=delete&amp;del={$Artid[newspaper]}">{$Adelete}</a>{/if}</td>
                </tr>
                <tr>
                    <td>{$Artbody[newspaper]}</td>
                </tr>
                <tr>
                    <td><br />{if $Step3 == ""} <a href="newspaper.php?comments={$Artid[newspaper]}">{$Acomment}</a> ({$Twrite} {$Artcomments[newspaper]} {$Tcomments}) {/if}<br /><br /></td>
                </tr>
                <tr>
                    <td><hr /></td>
                </tr>
            {/section}
        </table>
    {/if}
{/if}

{if $Step == "archive"}
<br><center>
<img src="images/gazeta_foto.jpg"><br><br>
    {$Archiveinfo}<br /><br />
    {if $Paperid > "0"}
        {section name=newspaper2 loop=$Paperid}
            <a href="newspaper.php?read={$Paperid[newspaper2]}">{$Anumber} {$Paperid[newspaper2]}</a><br />
        {/section}
    {/if}
{/if}

{if $Comments != ""}
    {if $Amount == "0"}
        <center>{$Nocomments}</center>
    {/if}
    {if $Amount > "0"}
        {section name=newspaper3 loop=$Tauthor}
            <b>{$Tauthor[newspaper3]}</b> {$Wrote}: {if $Rank == "Admin" || $Rank == "Redaktor" || $Rank == "Redaktor Naczelny"} (<a href="newspaper.php?comments={$Comments}&amp;action=delete&amp;cid={$Cid[newspaper4]}">{$Adelete}</a>) {/if}<br />
            {$Tbody[newspaper3]}<br /><br />
        {/section}
    {/if}
    <br /><br /><center>
    <form method="post" action="newspaper.php?comments={$Comments}&amp;action=add">
        {$Addcomment}:<textarea name="body" rows="20" cols="50"></textarea><br />
        <input type="hidden" name="tid" value="{$Comments}" />
        <input type="submit" value="{$Aadd}" />
    </form></center>
{/if}

{if $Step == 'redaction'}
    {if $Step3 == ""}
<br><center>
<img src="images/gazeta_foto.jpg"><br><br>
        {$Redactioninfo} {$Gamename}.<br /><br /><br />
        <table align="center" width="80%">
            <tr>
                <td>
                    <a href="newspaper.php?step=redaction&amp;step3=R">{$Aredaction}</a><br />
{if $Rank == "Admin" || $Rank == "Redaktor Naczelny"}
<br /><br /><a href="newspaper.php?step=redaction&amp;step3=S">{$Ashow}</a><br />
                                    {/if}                   
                </td>
            </tr>
        </table>
    {/if}
    {if $Step3 == "edit" || $Step3 == "R"}
<br><center>
<img src="images/gazeta_foto.jpg"><br><br>
        {$Youedit}<br /><br />
        {$Showmail}<br /><br />
        <form method="post" action="newspaper.php?step=redaction&amp;{if $Step3 == 'edit'}step3=edit&amp;edit={$Edit}{/if}{if $Step3 == "R"}step3=R{/if}">
            {$Mailtype}: <select name="mail">
                <option value="M" {if $Mtype == "M"} selected {/if}>{$Anews}</option>
                <option value="N" {if $Mtype == "N"} selected {/if}>{$Anews2}</option>
                <option value="O" {if $Mtype == "O"} selected {/if}>{$Acourt}</option>
                <option value="R" {if $Mtype == "R"} selected {/if}>{$Aroyal}</option>
                <option value="K" {if $Mtype == "K"} selected {/if}>{$Aking}</option>
                <option value="C" {if $Mtype == "C"} selected {/if}>{$Achronicle} {$Gamename}</option>
                <option value="S" {if $Mtype == "S"} selected {/if}>{$Asensations}</option>
                <option value="H" {if $Mtype == "H"} selected {/if}>{$Ahumor}</option>
                <option value="I" {if $Mtype == "I"} selected {/if}>{$Ainter}</option>
                <option value="A" {if $Mtype == "A"} selected {/if}>{$Anews3}</option>
                <option value="P" {if $Mtype == "P"} selected {/if}>{$Apoetry}</option>
            </select><br />
            {$Ttitle} <input type="text" name="mtitle" value="{$Mtitle}" /><br />
            {$Tbody} <br /><textarea name="mbody" rows="13" cols="55">{$Mbody}</textarea><br />
            <input type="submit" value="{$Ashow}" name="show" /> <input type="submit" name="sendmail" value="{$Asend}" />
        </form>
    {/if}
    {$Message}
{/if}

{if $Step == "mail"}
<br><center>
<img src="images/gazeta_foto.jpg"><br><br>
    {$Mailinfo}<br /><br />
    {$Showmail}<br /><br />
    <form method="post" action="newspaper.php?step=mail&amp;step3=add">
        {$Mailtype}: <select name="mail">
            <option value="M" {if $Mtype == "M"} selected {/if}>{$Anews}</option>
            <option value="N" {if $Mtype == "N"} selected {/if}>{$Anews2}</option>
            <option value="O" {if $Mtype == "O"} selected {/if}>{$Acourt}</option>
            <option value="R" {if $Mtype == "R"} selected {/if}>{$Aroyal}</option>
            {if $Rank == "Admin"}
                <option value="K" {if $Mtype == "K"} selected {/if}>{$Aking}</option>
            {/if}
            <option value="C" {if $Mtype == "C"} selected {/if}>{$Achronicle}</option>
            <option value="S" {if $Mtype == "S"} selected {/if}>{$Asensations}</option>
            <option value="H" {if $Mtype == "H"} selected {/if}>{$Ahumor}</option>
            <option value="I" {if $Mtype == "I"} selected {/if}>{$Ainter}</option>
            <option value="A" {if $Mtype == "A"} selected {/if}>{$Anews3}</option>
            <option value="P" {if $Mtype == "P"} selected {/if}>{$Apoetry}</option>
        </select><br />
        {$Ttitle} <input type="text" name="mtitle" value="{$Mtitle}" /><br />
        {$Tbody} <br /><textarea name="mbody" rows="13" cols="55">{$Mbody}</textarea><br />
        <input type="submit" value="{$Ashow}" name="show" /> <input type="submit" name="sendmail" value="{$Asend}" />
    </form>
    {$Message}
{/if}

{if $Step != "" || $Read != "" || $Comments != "" || $Step3 != ""}
    <br /><br /><a href="newspaper.php">{$Aback}</a>
{/if}
