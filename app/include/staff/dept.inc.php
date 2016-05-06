<?php
if(!defined('OSTADMININC') || !$thisuser->isadmin()) die('Access Denied');
$info=null;
if($dept && $_REQUEST['a']!='new'){
    //Editing Department.
    $title='Update Department';
    $action='update';
    $info=$dept->getInfo();
}else {
    $title='Νέος Φορέας';
    $action='create';
    $info['ispublic']=isset($info['ispublic'])?$info['ispublic']:1;
    $info['ticket_auto_response']=isset($info['ticket_auto_response'])?$info['ticket_auto_response']:1;
    $info['message_auto_response']=isset($info['message_auto_response'])?$info['message_auto_response']:1;
}
$info=($errors && $_POST)?Format::input($_POST):Format::htmlchars($info);

?>
<div class="msg"><?=$title?></div>
<table width="100%" border="0" cellspacing=0 cellpadding=0>
 <form action="admin.php?t=dept&id=<?=$info['dept_id']?>" method="POST" name="dept">
 <input type="hidden" name="do" value="<?=$action?>">
 <input type="hidden" name="a" value="<?=Format::htmlchars($_REQUEST['a'])?>">
 <input type="hidden" name="t" value="dept">
 <input type="hidden" name="dept_id" value="<?=$info['dept_id']?>">
 <tr><td>
    <table width="100%" border="0" cellspacing=0 cellpadding=2 class="tform">
        <tr class="header"><td colspan=2>Φορέας</td></tr>
        <tr class="subheader"><td colspan=2 >Dept depends on email &amp; help topics settings for incoming tickets.</td></tr>
        <tr><th>Όνομα Φορέα:</th>
            <td><input type="text" name="dept_name" size=25 value="<?=$info['dept_name']?>">
                &nbsp;<font class="error">*&nbsp;<?=$errors['dept_name']?></font>
                    
            </td>
        </tr>
        <tr>
            <th>Email Φορέα:</th>
            <td>
                <select name="email_id">
                    <option value="">Επιλογή</option>
                    <?
                    $emails=db_query('SELECT email_id,email,name,smtp_active FROM '.EMAIL_TABLE);
                    while (list($id,$email,$name,$smtp) = db_fetch_row($emails)){
                        $email=$name?"$name &lt;$email&gt;":$email;
                        if($smtp)
                            $email.=' (SMTP)';
                        ?>
                     <option value="<?=$id?>"<?=($info['email_id']==$id)?'selected':''?>><?=$email?></option>
                    <?
                    }?>
                 </select>
                 &nbsp;<font class="error">*&nbsp;<?=$errors['email_id']?></font>&nbsp;(εξερχόμενο email)
            </td>
        </tr>    
        <? if($info['dept_id']) { //update 
            $users= db_query('SELECT staff_id,CONCAT_WS(" ",firstname,lastname) as name FROM '.STAFF_TABLE.' WHERE dept_id='.db_input($info['dept_id']));
            ?>
        <tr>
            <th>Διαχειριστής Φορέα:</th>
            <td>
                <?if($users && db_num_rows($users)) {?>
                <select name="manager_id">
                    <option value=0 >-------None-------</option>
                    <option value=0 disabled >Select Manager (optional)</option>
                     <?
                     while (list($id,$name) = db_fetch_row($users)){ ?>
                        <option value="<?=$id?>"<?=($info['manager_id']==$id)?'selected':''?>><?=$name?></option>
                     <?}?>
                     
                </select>
                 <?}else {?>
                       Δεν υπάρχουν χρήστες (Προσθήκη Χρηστών)
                       <input type="hidden" name="manager_id"  value="0" />
                 <?}?>
                    &nbsp;<font class="error">&nbsp;<?=$errors['manager_id']?></font>
            </td>
        </tr>
        <?}?>
        <tr><th>Τύπος Φορέα</th>
            <td>
                <input type="radio" name="ispublic"  value="1"   <?=$info['ispublic']?'checked':''?> />Εμφανής
                <input type="radio" name="ispublic"  value="0"   <?=!$info['ispublic']?'checked':''?> />Κρυφός
                &nbsp;<font class="error"><?=$errors['ispublic']?></font>
            </td>
        </tr>
        <tr>
            <th valign="top"><br/>Υπόγραφή Τμήματος:</th>
            <td>
                <i>Απαιτειται όταν ο Φορέας είναι Εμφανής</i>&nbsp;&nbsp;&nbsp;<font class="error"><?=$errors['dept_signature']?></font><br/>
                <textarea name="dept_signature" cols="21" rows="5" style="width: 60%;"><?=$info['dept_signature']?></textarea>
                <br>
                <input type="checkbox" name="can_append_signature" <?=$info['can_append_signature'] ?'checked':''?> > 
                μπορεί να συμπεριληφθεί στις απαντήσεις.&nbsp;(διαθέσιμο σαν επιλογή σε εμφανης φορείς)  
            </td>
        </tr>
        <tr><th>Πρότυπα Email :</th>
            <td>
                <select name="tpl_id">
                    <option value=0 disabled>Επιλογή Προτύπου</option>
                    <option value="0" selected="selected">System Default</option>
                    <?
                    $templates=db_query('SELECT tpl_id,name FROM '.EMAIL_TEMPLATE_TABLE.' WHERE tpl_id!='.db_input($cfg->getDefaultTemplateId()));
                    while (list($id,$name) = db_fetch_row($templates)){
                        $selected = ($info['tpl_id']==$id)?'SELECTED':''; ?>
                        <option value="<?=$id?>"<?=$selected?>><?=Format::htmlchars($name)?></option>
                    <?
                    }?>
                </select><font class="error">&nbsp;<?=$errors['tpl_id']?></font><br/>
                <i>Χρησιμοποιούνται για εξερχόμενα email, ειδοποιήσεις και σημειώσεις σε πολίτες και χρήστες του συστήματος.</i>
            </td>
        </tr>
        <tr class="header"><td colspan=2>Αυτόματες Απαντήσεις</td></tr>
        <tr class="subheader"><td colspan=2>
            Οι Γενική Ρύθμιση αυτόματης απάντησης στις Επιλογές Διαχειριστή Θα πρέπει να είναι Ενεργοποιημένες , για τη λειτουργία της αντίστοιχης 
            επιλογής σε επίπεδο τμήματος.
            
            </td>
        </tr>
        <tr><th>Νέο Μήνυμα:</th>
            <td>
                <input type="radio" name="ticket_auto_response"  value="1"   <?=$info['ticket_auto_response']?'checked':''?> />Ενεργό
                <input type="radio" name="ticket_auto_response"  value="0"   <?=!$info['ticket_auto_response']?'checked':''?> />Ανενεργό
            </td>
        </tr>
        <tr><th>Νέο Εσωτερικό Μήνυμα:</th>
            <td>
                <input type="radio" name="message_auto_response"  value="1"   <?=$info['message_auto_response']?'checked':''?> />Ενεργό
                <input type="radio" name="message_auto_response"  value="0"   <?=!$info['message_auto_response']?'checked':''?> />Ανενεργό
            </td>
        </tr>
        <tr>
            <th>Email Αυτόματης Απάντησης:</th>
            <td>
                <select name="autoresp_email_id">
                    <option value="0" disabled>Επιλέξτε</option>
                    <option value="0" selected="selected">Email Φορέα</option>
                    <?
                    $emails=db_query('SELECT email_id,email,name,smtp_active FROM '.EMAIL_TABLE.' WHERE email_id!='.db_input($info['email_id']));
                    if($emails && db_num_rows($emails)) {
                        while (list($id,$email,$name,$smtp) = db_fetch_row($emails)){
                            $email=$name?"$name &lt;$email&gt;":$email;
                            if($smtp)
                                $email.=' (SMTP)';
                            ?>
                            <option value="<?=$id?>"<?=($info['autoresp_email_id']==$id)?'selected':''?>><?=$email?></option>
                        <?
                        }
                    }?>
                 </select>
                 &nbsp;<font class="error">&nbsp;<?=$errors['autoresp_email_id']?></font>&nbsp;<br/>
                 <i>Διεύθυνση Email από την οποία θα στέλνονταί οι αυτόματες απαντήσεις , εφόσον είναι ενεργοποιημένες.</i>
            </td>
        </tr>
    </table>
    </td></tr>
    <tr><td style="padding:10px 0 10px 200px;">
        <input class="button" type="submit" name="submit" value="Υποβολή">
        <input class="button" type="reset" name="reset" value="Καθαρισμός">
        <input class="button" type="button" name="cancel" value="Ακύρωση" onClick='window.location.href="admin.php?t=dept"'>
    </td></tr>
    </form>
</table>
