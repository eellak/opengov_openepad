<?php
if(!defined('OSTADMININC') || !$thisuser->isadmin()) die('Access Denied');

$rep=null;
$newuser=true;
if($staff && $_REQUEST['a']!='new'){
    $rep=$staff->getInfo();
    $title='Update: '.$rep['firstname'].' '.$rep['lastname'];
    $action='update';
    $pwdinfo='To reset the password enter a new one below';
    $newuser=false;
}else {
    $title='Νέος Χρήστης';
    $pwdinfo='Προσωρινός κωδικός απαιτείται';
    $action='create';
    $rep['resetpasswd']=isset($rep['resetpasswd'])?$rep['resetpasswd']:1;
    $rep['isactive']=isset($rep['isactive'])?$rep['isactive']:1;
    $rep['dept_id']=$rep['dept_id']?$rep['dept_id']:$_GET['dept'];
    $rep['isvisible']=isset($rep['isvisible'])?$rep['isvisible']:1;
}
$rep=($errors && $_POST)?Format::input($_POST):Format::htmlchars($rep);

//get the goodies.
$groups=db_query('SELECT group_id,group_name FROM '.GROUP_TABLE);
$depts= db_query('SELECT dept_id,dept_name FROM '.DEPT_TABLE);

?>
<div class="msg"><?=$title?></div>
<table width="100%" border="0" cellspacing=0 cellpadding=0>
<form action="admin.php" method="post">
 <input type="hidden" name="do" value="<?=$action?>">
 <input type="hidden" name="a" value="<?=Format::htmlchars($_REQUEST['a'])?>">
 <input type="hidden" name="t" value="staff">
 <input type="hidden" name="staff_id" value="<?=$rep['staff_id']?>">
 <tr><td>
    <table width="100%" border="0" cellspacing=0 cellpadding=2 class="tform">
        <tr class="header"><td colspan=2>Λογαριασμός Χρήστη</td></tr>
        <tr class="subheader"><td colspan=2>Πληροφορίες Λογαριασμού</td></tr>
        <tr>
            <th>Όνομα Χρήστη:</th>
            <td><input type="text" name="username" value="<?=$rep['username']?>">
                &nbsp;<font class="error">*&nbsp;<?=$errors['username']?></font></td>
        </tr>
        <tr>
            <th>Φορείς:</th>
            <td>
                <select name="dept_id">
                    <option value=0>Επιλογή Φορέα</option>
                    <?
                    while (list($id,$name) = db_fetch_row($depts)){
                        $selected = ($rep['dept_id']==$id)?'selected':''; ?>
                        <option value="<?=$id?>"<?=$selected?>><?=$name?> Dept</option>
                    <?
                    }?>
                </select>&nbsp;<font class="error">*&nbsp;<?=$errors['dept']?></font>
            </td>
        </tr>
        <tr>
            <th>Ομάδα χρήστη:</th>
            <td>
                <select name="group_id">
                    <option value=0>Select Group</option>
                    <?
                    while (list($id,$name) = db_fetch_row($groups)){
                        $selected = ($rep['group_id']==$id)?'selected':''; ?>
                        <option value="<?=$id?>"<?=$selected?>><?=$name?></option>
                    <?
                    }?>
                </select>&nbsp;<font class="error">*&nbsp;<?=$errors['group']?></font>
            </td>
        </tr>
        <tr>
            <th>Όνοματεπώνυμο (Όνομα,Επίθετο):</th>
            <td>
                <input type="text" name="firstname" value="<?=$rep['firstname']?>">&nbsp;<font class="error">*</font>
                &nbsp;&nbsp;&nbsp;<input type="text" name="lastname" value="<?=$rep['lastname']?>">
                &nbsp;<font class="error">*&nbsp;<?=$errors['name']?></font></td>
        </tr>
        <tr>
            <th>Email:</th>
            <td><input type="text" name="email" size=25 value="<?=$rep['email']?>">
                &nbsp;<font class="error">*&nbsp;<?=$errors['email']?></font></td>
        </tr>
        <tr>
            <th>Τηλέφωνο εργασίας:</th>
            <td>
                <input type="text" name="phone" value="<?=$rep['phone']?>" >&nbsp;Ext&nbsp;
                <input type="text" name="phone_ext" size=6 value="<?=$rep['phone_ext']?>" >
                    &nbsp;<font class="error">&nbsp;<?=$errors['phone']?></font></td>
        </tr>
        <tr>
            <th>Κινητό Τηλέφωνο:</th>
            <td>
                <input type="text" name="mobile" value="<?=$rep['mobile']?>" >
                    &nbsp;<font class="error">&nbsp;<?=$errors['mobile']?></font></td>
        </tr>
        <tr>
            <th valign="top">Υπογραφή:</th>
            <td><textarea name="signature" cols="21" rows="5" style="width: 60%;"><?=$rep['signature']?></textarea></td>
        </tr>
        <tr>
            <th>Κωδικός:</th>
            <td>
                <i><?=$pwdinfo?></i>&nbsp;&nbsp;&nbsp;<font class="error">&nbsp;<?=$errors['npassword']?></font> <br/>
                <input type="password" name="npassword" AUTOCOMPLETE=OFF >&nbsp;
            </td>
        </tr>
        <tr>
            <th>Κωδικός (επιβεβαίωση):</th>
            <td class="mainTableAlt"><input type="password" name="vpassword" AUTOCOMPLETE=OFF >
                &nbsp;<font class="error">&nbsp;<?=$errors['vpassword']?></font></td>
        </tr>
        <tr>
            <th>Αναγκαστική αλλαγή κωδικού:</th>
            <td>
                <input type="checkbox" name="resetpasswd" <?=$rep['resetpasswd'] ? 'checked': ''?>>Απαιτείται αλλαγή κωδικού κατά την επόμενη είσοδο</td>
        </tr>
        <tr class="header"><td colspan=2>Δικαιώμτα Λογαριασμού, κατάσταση &amp; Ρυθμίσεις</td></tr>
        <tr class="subheader"><td colspan=2>
            Τα δικαιώμτα χρηστών εππηρεάζονται από την ομάδα στην οποία ανήκουν. <b>Ο λογαριασμός Διαχειριστή δεν περιορίζεται από τις ρυθμίσεις ομάδας.</b></td>
        </tr> 
        <tr><th><b>Κατάσταση Λογαριασμού</b></th>
            <td>
                        <input type="radio" name="isactive"  value="1" <?=$rep['isactive']?'checked':''?> /><b>Ενεργός</b>
                        <input type="radio" name="isactive"  value="0" <?=!$rep['isactive']?'checked':''?> /><b>Κλειδωμένος</b>
                        &nbsp;&nbsp;
            </td>
        </tr>
        <tr><th><b>Τύπος Χρήστη</b></th>
            <td class="mainTableAlt">
                        <input type="radio" name="isadmin"  value="1" <?=$rep['isadmin']?'checked':''?> /><font color="red"><b>Διαχειριστής</b></font>
                        <input type="radio" name="isadmin"  value="0" <?=!$rep['isadmin']?'checked':''?> /><b>Μέλος</b>
                        &nbsp;&nbsp;
            </td>
        </tr>
        <tr><th>Εμφάνιση σε κατάλογο</th>
            <td>
               <input type="checkbox" name="isvisible" <?=$rep['isvisible'] ? 'checked': ''?>>Εμφάνιση χρήστη στον κατάλογο μελών
            </td>
        </tr>
        <tr><th>Λειτουργία διακοπών</th>
            <td class="mainTableAlt">
             <input type="checkbox" name="onvacation" <?=$rep['onvacation'] ? 'checked': ''?>>
                ο Χρήστης είναι σε λειτουργία διακοπών. (<i>Δεν ανατίθενται μηνύματα ή ειδοποιήσεις</i>)
                &nbsp;<font class="error">&nbsp;<?=$errors['vacation']?></font>
            </td>
        </tr>
    </table>
   </td></tr>
   <tr><td style="padding:5px 0 10px 210px;">
        <input class="button" type="submit" name="submit" value="Αποστολή">
        <input class="button" type="reset" name="reset" value="Καθαρσιμός">
        <input class="button" type="button" name="cancel" value="Ακύρωση" onClick='window.location.href="admin.php?t=staff"'>
    </td></tr>
  </form>
</table>
