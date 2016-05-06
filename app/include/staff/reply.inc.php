<?php
if(!defined('OSTSCPINC') or !$thisuser->canManageKb()) die('Access Denied');
$info=($errors && $_POST)?Format::input($_POST):Format::htmlchars($answer);
if($answer && $_REQUEST['a']!='add'){
    $title='Επεξεργασία Προτύπου Απάντησης';
    $action='update';
}else {
    $title='Προσθήκη Νέου Προτύπου Απάντησης';
    $action='add';
    $info['isenabled']=1;
}
?>
<div>

    <?if($errors['err']) {?>
        <p align="center" id="errormessage"><?=$errors['err']?></p>
    <?}elseif($msg) {?>
        <p align="center" id="infomessage"><?=$msg?></p>
    <?}elseif($warn) {?>
        <p id="warnmessage"><?=$warn?></p>
    <?}?>
</div>
<div class="msg"><?=$title?></div>
<table width="100%" border="0" cellspacing=1 cellpadding=2>
    <form action="kb.php" method="POST" name="group">
    <input type="hidden" name="a" value="<?=$action?>">
    <input type="hidden" name="id" value="<?=$info['premade_id']?>">
    <tr><td width=80px>Τίτλος:</td>
        <td><input type="text" size=45 name="title" value="<?=$info['title']?>">
            &nbsp;<font class="error">*&nbsp;<?=$errors['title']?></font>
        </td>
    </tr>
    <tr>
        <td>Κατάσταση:</td>
        <td>
            <input type="radio" name="isenabled"  value="1"   <?=$info['isenabled']?'checked':''?> /> Ενεργό
            <input type="radio" name="isenabled"  value="0"   <?=!$info['isenabled']?'checked':''?> />Εκτός Λειοτυργίας
            &nbsp;<font class="error">&nbsp;<?=$errors['isenabled']?></font>
        </td>
    </tr>
    <tr><td valign="top">Κατηγορία:</td>
        <td>Ο φορέας υπό τον οποίο το πρότυπο απάντησης θα είναι διαθέσιμο.&nbsp;<font class="error">&nbsp;<?=$errors['depts']?></font><br/>
            <select name=dept_id>
                <option value=0 selected>Όλοι οι φορείς</option>
                <?
                $depts= db_query('SELECT dept_id,dept_name FROM '.DEPT_TABLE.' ORDER BY dept_name');
                while (list($id,$name) = db_fetch_row($depts)){
                    $ck=($info['dept_id']==$id)?'selected':''; ?>
                    <option value="<?=$id?>" <?=$ck?>><?=$name?></option>
                <?
                }?>
            </select>
        </td>
    </tr>
    <tr><td valign="top">Απάντηση:</td>
        <td>Πρότυπο Απάντησης - Υποστηρίζονται μεταβλητές σε επίπεδο μηνύματος.&nbsp;<font class="error">*&nbsp;<?=$errors['answer']?></font><br/>
            <textarea name="answer" id="answer" cols="90" rows="9" wrap="soft" style="width:80%"><?=$info['answer']?></textarea>
        </td>
    </tr>
    <tr>
        <td nowrap>&nbsp;</td>
        <td><br>
            <input class="button" type="submit" name="submit" value="Αποστολή">
            <input class="button" type="reset" name="reset" value="Καθαρισμός">
            <input class="button" type="button" name="cancel" value="Ακύρωση" onClick='window.location.href="kb.php"'>
        </td>
    </tr>
    </form>
</table>
