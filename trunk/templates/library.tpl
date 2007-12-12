{if $Step == ""}
       <br><br> <center> Wchodzisz do starego budynku wykonanego z czerwonej cegly. Pomieszczenie jest ogromne, wija sie w nim korytarze i pomieszczenia, a wszedzie sa polki z 
       ksiegami. Tuz przy wejsciu stoi podstarzaly niziolek i widzac cie  mowi:<i>Witaj w Miejskiej Bibliotece. Sa tu pozostawione dziela przez mieszkancow Kara-Tur jak i
       przybyszow, mozesz takze i ty zostawic cos po sobie. </i>Po czym odszedl w swoja strone</center><br><Br>

    <table align="center">
        <tr>
            <td valign="top">
                <a href="library.php?step=tales">Opowiadania</a> ({$Amounttales} {$Tinfo1})<br />
                <a href="library.php?step=poetry">Poezje</a> ({$Amountpoetry} {$Tinfo2})<br /><br />
                <a href="library.php?step=rules">Zasady</a><br />
                <a href="library.php?step=add">Dodaj Prace</a><br />
                {if $Rank == "Admin" || $Rank == "Bibliotekarz"}
                    <a href="library.php?step=addtext">Sprawdz Dodawane</a>
                {/if}
            </td>
        </tr>
    </table>
{/if}

{if $Step == "add"}
    {$Addinfo}<br /><br />
    <form method="post" action="library.php?step=add&amp;step2=add">
        {$Ttype2}: <select name="type">
            {section name=library2 loop=$Ttype}
                <option value="{$Ttype[library2]}">{$Ttype[library2]}</option>
            {/section}
        </select><br />
        {$Ttitle2}: <input type="text" name="ttitle" /><br />
        {$Tbody2}: <br /><textarea name="body" rows="30" cols="60"></textarea><br />
        <input type="submit" value="{$Aadd}" />
    </form>
{/if}

{if $Step == "addtext"}
    Prace do dodania:
    <table width="100%">
        {section name=library3 loop=$Ttitle}
            <tr>
                <td>{$Ttitle[library3]} ({$Tauthor2}: {$Tauthor[library3]})</td>
                <td><a href="library.php?step=addtext&amp;action=modify&amp;text={$Tid[library3]}">{$Amodify}</a></td>
                <td><a href="library.php?step=addtext&amp;action=add&amp;text={$Tid[library3]}">{$Aadd}</a></td>
                <td><a href="library.php?step=addtext&amp;action=delete&amp;text={$Tid[library3]}">{$Adelete}</a></td>
            </tr>
        {/section}
    </table>
{/if}

{if $Step == 'tales' || $Step == 'poetry'}
    {if $Tamount == "0" && $Text == ""}
        <br /><br /><center>{$Noitems} {$Ttype} {$Inlib}</center>
    {/if}
    {if $Tamount > "0" && $Text == ""}
        {$Listinfo} {$Ttype}<br />
        {if $Author == ""}
            {$Sortinfo}:
            <form method="post" action="library.php?step={$Step}">
                <select name="sort">
                    <option value="author">{$Oauthor}</option>
                    <option value="id">{$Odate}</option>
                    <option value="title">{$Otitle}</option>
                </select><br />
                <input type="submit" value="{$Asort}" />
            </form>
        {/if}
        {if $Author == "" && ($Sort == "author" || $Sort == "")}
            <ul>
                {section name=library6 loop=$Tauthor}
                    <li><a href="library.php?step={$Step}&amp;author={$Tauthorid[library6]}">{$Tauthor[library6]}</a><br />
                    {$Ttype}: {$Ttexts[library6]}<br /><br /></li>
                {/section}
            </ul>
        {/if}
        {if $Author != "" || ($Sort != "" && $Sort != "author")}
            <ul>
                {section name=library4 loop=$Ttitle}
                    <li><a href="library.php?step={$Step}&amp;text={$Tid[library4]}">{$Ttitle[library4]}</a><br /> ({$Tauthor2}: <a href="view.php?view={$Tauthorid[library4]}">{$Tauthor[library4]}</a>)<br /> (<a href="library.php?step=comments&amp;text={$Tid[library4]}">{$Tcomments}</a>: {$Comments[library4]})<br /><br /></li>
                {/section}
            </ul>
        {/if}
    {/if}
    {if $Text != ""}
        {if $Rank == "Admin" || $Rank == "Bibliotekarz"}
            (<a href="library.php?step=addtext&amp;action=modify&amp;text={$Tid}">{$Amodify}</a>)<br />
        {/if}
        <b>{$Ttitle2}</b>:{$Ttitle}<br />
        <b>{$Tauthor2}</b>:<a href="view.php?view={$Tauthorid}">{$Tauthor}</a><br />
        <b>{$Tbody2}</b>:<br />
        {$Tbody}<br /><br />
        <a href="library.php?step=comments&amp;text={$Text}">{$Tcomments}</a>
    {/if}
{/if}

{if $Step == "comments"}
    {if $Amount == "0"}
        <center>{$Nocomments}</center>
    {/if}
    {if $Amount > "0"}
        {section name=library5 loop=$Tauthor}
            <b>{$Tauthor[library5]}</b> napisal(a): {if $Rank == "Admin" || $Rank == "Bibliotekarz"} (<a href="library.php?step=comments&amp;action=delete&amp;cid={$Cid[library5]}">{$Adelete}</a>) {/if}<br />
            {$Tbody[library5]}<br /><br />
        {/section}
    {/if}
    <br /><br /><center>
    <form method="post" action="library.php?step=comments&amp;action=add">
        {$Addcomment}:<textarea name="body" rows="20" cols="50"></textarea><br />
        <input type="hidden" name="tid" value="{$Text}" />
        <input type="submit" value="{$Aadd}" />
    </form></center>
{/if}

{if $Step == "rules"}
    1.Nie nalezy przeklinac w Tekstach(chyba ze zostanie to zezwolone przez Wladce)<br>
    2.Prace maja byc pisane z sensem, i tak aby dalo sie je odczytac.<br>
    3.Niewolno obrazac w jakimkolwiek utworze innego gracza.<br>
{/if}

{if $Action == "modify"}
<form method="post" action="library.php?step=addtext&amp;action=modify&amp;text={$Tid}">
    {$Ttype2}: <select name="type">
        <option value="{$Ttypet}" {if $Ttype == "tale"} selected="true" {/if}>{$Ttypet}</option>
        <option value="{$Ttypep}" {if $Ttype == "poetry"} selected="true" {/if}>{$Ttypep}</option>
    </select>
    <input type="hidden" name="tid" value="{$Tid}" /><br />
    {$Ttitle2}: <input type="text" name="ttitle" value="{$Ttitle}" /><br />
    {$Tbody2}: <br /><textarea name="body" rows="30" cols="60">{$Tbody}</textarea><br />
    <input type="hidden" name="tid" value="{$Tid}" />
    <input type="submit" value="{$Achange}" />
</form>
{/if}

{if $Step != ""}
    <br /><br /><a href="library.php">{$Aback}</a>
{/if}

