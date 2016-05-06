<?php
if(!defined('OSTCLIENTINC')) die('Kwaheri');

$e=Format::input($_POST['lemail']?$_POST['lemail']:$_GET['e']);
$t=Format::input($_POST['lticket']?$_POST['lticket']:$_GET['t']);
?>
<div class="mainformtitle">
	Σύνδεση
</div>
<div class="rslider">
<div class="singlebig">
    <?if($errors['err']) {?>
        <p align="center" id="errormessage"><?=$errors['err']?></p>
    <?}elseif($warn) {?>
        <p class="warnmessage"><?=$warn?></p>
    <?}?>


    <p align="center">
        Για να δείτε την κατάσταση του μηνύματος που έχετε υποβάλλει παρακαλούμε συμπληρώστε τον αριθμό του και το λογαριασμό  email που έχετε χρησιμοποιήσει<br/>
    </p>
 <br/>
 <br/>
    <span class="error"><?=Format::htmlchars($loginmsg)?></span>
    <form action="login.php" method="post">
    <table cellspacing="10" border="0" class="loginnew" align="center">
        <tr bgcolor="#EEEEEE"> 
            <td>E-Mail:</td><td><input type="text" name="lemail" size="25" value="<?=$e?>"></td>
            <td>Αριθμός Μηνύματος:</td><td><input type="text" name="lticket" size="10" value="<?=$t?>"></td>
            <td><input class="button" type="submit" value="Προβολή Κατάστασης"></td>
        </tr>
    </table>
    </form>
	</div>
</div>
