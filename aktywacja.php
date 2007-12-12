<?php
/***************************************************************************
 *                               aktywacja.php
 *                            -------------------
 *   copyright            : (C) 2004 Vallheru Team based on Gamers-Fusion ver 2.5
 *   email                : webmaster@uc.h4c.pl
 *
 ***************************************************************************/

/***************************************************************************
 *
 *       This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program; if not, write to the Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 ***************************************************************************/

//require 'libs/Smarty.class.php';
//require_once ('includes/config.php');

//$smarty = new Smarty;

//$smarty->compile_check = true;

require_once( "includes/preinit.php" );

if (isset ($_GET['kod'])) {
    if (!ereg("^[1-9][0-9]*$", $_GET['kod'])) {
        $smarty -> assign (array("Error" => "Zapomnij o tym.", "Meta" => ''));
        $smarty -> display ('error.tpl');
        $db -> Close();
        exit;
    }
    $aktiv = SqlExec("SELECT * FROM aktywacja WHERE aktyw=".$_GET['kod']);
    while (!$aktiv -> EOF) {
	    if ($_GET['kod'] == $aktiv -> fields['aktyw']) {
	    	$sql="INSERT INTO players (user, email, pass, refs) VALUES(".$db->qstr($aktiv -> fields['user']).",'".$aktiv -> fields['email']."','".$aktiv -> fields['pass']."',".$aktiv -> fields['refs'].")";
	        SqlExec($sql);
	        SqlExec("DELETE FROM aktywacja WHERE aktyw=".$_GET['kod']);
                $smarty -> assign("Meta", '');
                $smarty -> display ('activ.tpl');
            break;
	    }
	    $aktiv -> MoveNext();
    }
    $aktiv -> Close();
}

$db -> Close();
?>
