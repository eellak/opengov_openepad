<?php
if(!defined('OSTADMININC') || !$thisuser->isadmin()) die('Access Denied');

$info=($errors && $_POST)?Format::input($_POST):Format::htmlchars($group);
if($group && $_REQUEST['a']!='new'){
    $title='Επεξεργασία Ομάδας: '.$group['group_name'];
    $action='update';
}else {
    $title='Προσθήκη Νέας Ομάδας';
    $action='create';
    $info['group_enabled']=isset($info['group_enabled'])?$info['group_enabled']:1; //Default to active 
}

?>
<table width="100%" border="0" cellspacing=0 cellpadding=0>
 <form action="admin.php" method="POST" name="group">
 <input type="hidden" name="do" value="<?=$action?>">
 <input type="hidden" name="a" value="<?=Format::htmlchars($_REQUEST['a'])?>">
 <input type="hidden" name="t" value="groups">
 <input type="hidden" name="group_id" value="<?=$info['group_id']?>">
 <input type="hidden" name="old_name" value="<?=$info['group_name']?>">
 <tr><td>
    <table width="100%" border="0" cellspacing=0 cellpadding=2 class="tform">
        <tr class="header"><td colspan=2><?=Format::htmlchars($title)?></td></tr>
        <tr class="subheader"><td colspan=2>
            Τα δικαιώμτα ομάδας που τίθενται εππρεάζουν όλα τα μέλη της ομάδας , αλλά δεν εππηρεάζουν τους Διαχειριστές Συστήματος ή Φορέων σε κάποιες περιπτώσεις 
            
            </td></tr>
        <tr><th>Όνομα Ομάδας:</th>
            <td><input type="text" name="group_name" size=25 value="<?=$info['group_name']?>">
                &nbsp;<font class="error">*&nbsp;<?=$errors['group_name']?></font>
                    
            </td>
        </tr>
        <tr>
            <th>Κατάσταση Ομάδας:</th>
            <td>
                <input type="radio" name="group_enabled"  value="1"   <?=$info['group_enabled']?'checked':''?> /> Ενεργή
                <input type="radio" name="group_enabled"  value="0"   <?=!$info['group_enabled']?'checked':''?> />Μη Ενεργή
                &nbsp;<font class="error">&nbsp;<?=$errors['group_enabled']?></font>
            </td>
        </tr>
        <tr><th valign="top"><br>Προσβάσιμοι Φορείς</th>
            <td class="mainTableAlt"><i>Επιλέξτε φορείς στους οποίου τα μέλη της ομάδας έχουν πρόσβαση (επιπλέον των τμημάτων στα οποία ανήκουν).</i>
                &nbsp;<font class="error">&nbsp;<?=$errors['depts']?></font><br/>
                <?
                //Try to save the state on error...
                $access=($_POST['depts'] && $errors)?$_POST['depts']:explode(',',$info['dept_access']);
                $depts= db_query('SELECT dept_id,dept_name FROM '.DEPT_TABLE.' ORDER BY dept_name');
                while (list($id,$name) = db_fetch_row($depts)){
                    $ck=($access && in_array($id,$access))?'checked':''; ?>
                    <input type="checkbox" name="depts[]" value="<?=$id?>" <?=$ck?> > <?=$name?><br/>
                <?
                }?>
                <a href="#" onclick="return select_all(document.forms['group'])">Select All</a>&nbsp;&nbsp;
                <a href="#" onclick="return reset_all(document.forms['group'])">Select None</a>&nbsp;&nbsp; 
            </td>
        </tr>
        <tr><th> <b>Δημιουργία</b> Μηνυμάτων</th>
            <td>
                <input type="radio" name="can_create_tickets"  value="1"   <?=$info['can_create_tickets']?'checked':''?> />Yes 
                <input type="radio" name="can_create_tickets"  value="0"   <?=!$info['can_create_tickets']?'checked':''?> />No
                &nbsp;&nbsp;<i>Δυνατότητα Δημιουργία μηνύματος για λογαριασμό των τελικών χρηστών!</i>
            </td>
        </tr>
        <tr><th> <b>Επεξεργασία</b> Μηνυμάτων</th>
            <td>
                <input type="radio" name="can_edit_tickets"  value="1"   <?=$info['can_edit_tickets']?'checked':''?> />Yes
                <input type="radio" name="can_edit_tickets"  value="0"   <?=!$info['can_edit_tickets']?'checked':''?> />No
                &nbsp;&nbsp;<i>Δυνατότητα επεξεργασίας μηνυμάτων. Ενεργό εκ των προτέρων σε Διαχειριστές Συστήματος  & Φορέων .</i>
            </td>
        </tr>
        <tr><th> <b>Κλείσιμο</b> Μηνυμάτων</th>
            <td>
                <input type="radio" name="can_close_tickets"  value="1" <?=$info['can_close_tickets']?'checked':''?> />Ναι
                <input type="radio" name="can_close_tickets"  value="0" <?=!$info['can_close_tickets']?'checked':''?> />Όχι
                &nbsp;&nbsp;<i><b>Για μαζικό κλείσιμο μόνο:</b> Οι χρήστες εξακολουθούν να  μπορούν να κλείσουν μεμονομένα μηνύματα , όταν έχει επιλεχθεί 'Όχι' </i>
            </td>
        </tr>
        <tr><th> <b>Μεταφορά</b> Μηνυμάτων</th>
            <td>
                <input type="radio" name="can_transfer_tickets"  value="1" <?=$info['can_transfer_tickets']?'checked':''?> />Ναι
                <input type="radio" name="can_transfer_tickets"  value="0" <?=!$info['can_transfer_tickets']?'checked':''?> />Όχι
                &nbsp;&nbsp;<i>Δυνατότητα μεταφοράς μηνυμάτων μεταξύ φορέων.</i>
            </td>
        </tr>
        <tr><th> <b>Διαγραφή</b> Μηνυμάτων</th>
            <td>
                <input type="radio" name="can_delete_tickets"  value="1"   <?=$info['can_delete_tickets']?'checked':''?> />Ναι
                <input type="radio" name="can_delete_tickets"  value="0"   <?=!$info['can_delete_tickets']?'checked':''?> />Όχι
                &nbsp;&nbsp;<i>Τα διαγραμμένα μηνύματα δεν μπορούν να ανακτηθούν!</i>
            </td>
        </tr>
        <tr><th>Αποκλεισμός Emails</th>
            <td>
                <input type="radio" name="can_ban_emails"  value="1" <?=$info['can_ban_emails']?'checked':''?> />Ναι
                <input type="radio" name="can_ban_emails"  value="0" <?=!$info['can_ban_emails']?'checked':''?> />όχι
                &nbsp;&nbsp;<i>Δυνατότητα προσθήκης/διαγραφής email απο την λίστα αποκλεισμένων.</i>
            </td>
        </tr>
        <tr><th>Διαχείριση Προτύπων</th>
            <td>
                <input type="radio" name="can_manage_kb"  value="1" <?=$info['can_manage_kb']?'checked':''?> />Ναι
                <input type="radio" name="can_manage_kb"  value="0" <?=!$info['can_manage_kb']?'checked':''?> />Όχι
                &nbsp;&nbsp;<i>Δυνατότητα προσθήκης/Ανανέωσης/Απενεργοποιήσης/Διαγραφής προτύπων απαντήσεων.</i>
            </td>
        </tr>
    </table>
    <tr><td style="padding-left:165px;padding-top:20px;">
        <input class="button" type="submit" name="submit" value="Υποβολή">
        <input class="button" type="reset" name="reset" value="Καθαρισμός">
        <input class="button" type="button" name="cancel" value="Ακύρωση" onClick='window.location.href="admin.php?t=groups"'>
        </td>
    </tr>
 </form>
</table>
