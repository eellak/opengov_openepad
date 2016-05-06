<?php
if(!defined('OSTCLIENTINC') || !is_object($thisclient) || !is_object($ticket)) die('Kwaheri'); //bye..see ya
//Double check access one last time...
if(strcasecmp($thisclient->getEmail(),$ticket->getEmail())) die('Η πρόσβαση δεν είναι δυνατή');

$info=($_POST && $errors)?Format::input($_POST):array(); //Re-use the post info on error...savekeyboards.org

$dept = $ticket->getDept();
//Making sure we don't leak out internal dept names
$dept=($dept && $dept->isPublic())?$dept:$cfg->getDefaultDept();
//We roll like that...
?>
<div class="mainformtitle">
	Μήνυμα #<?=$ticket->getExtId()?> 
</div>
<div class="rslider">
<div class="singlebig">
	<p width=100% class="msg">Θέμα "<?=Format::htmlchars($ticket->getSubject())?>"
    &nbsp;<a href="view.php?id=<?=$ticket->getExtId()?>" title="Ανανέωση"><span class="Icon refresh">&nbsp;</span></a></p>
		
	<table align="center" class="infotable" cellspacing="1" cellpadding="3" width="100%" border=0>
		<tr>
			<th>Κατάσταση </th>
			<td><?=openPadUtils::getTranslation("status",$ticket->getStatus());?></td>
		</tr>
		<tr>
			<th>Φορέας</th>
			<td><?=Format::htmlchars($dept->getName())?></td>
		</tr>
		
		<tr>
			<th>Υπηρεσία</th>
			<td><?=Format::htmlchars($ticket->getyphresia()." (".Format::htmlchars(openPadUtils::getNameFrompb_id($ticket->getyphresia_dimos_id())).")")?></td>
		</tr>
		
		<tr>
			<th>Ημερομηνία Δημιουργίας</th>
			<td><?=Format::db_datetime($ticket->getCreateDate())?></td>
		</tr>
	</table>

	<table align="center" class="infotable" cellspacing="1" cellpadding="3" width="100%" border=0>
		<tr>
			<th width="100">Όνοματεπώνυμο</th>
			<td><?=Format::htmlchars($ticket->getName()." ".$ticket->getlastname())?></td>
		</tr>
		<tr>
			<th width="100">Ιδιότητα</th>
			<td><?=Format::htmlchars($cfg->idiotites_array_values[array_search($ticket->getidiotita(),$cfg->idiotites_array_keys)])?></td>
		</tr>
		 <tr>
			<th width="100">Δήμος</th>
			<td><?=Format::htmlchars(openPadUtils::getNameFrompb_id($ticket->getdimos_id()))?></td>
		</tr>
		<tr>
			<th width="100">Διεύθυνση</th>
			<td><?=Format::htmlchars($ticket->getaddress()." (T.K:".$ticket->gettk().")")?></td>
		</tr>
		<tr>
			<th width="100">eMail</th>
			<td><?=$ticket->getEmail()?></td>
		</tr>
		<tr>
			<th>Τηλέφωνο</th>
			<td><?=Format::phone($ticket->getPhoneNumber())?></td>
		</tr>
	</table>

<div class="spazer">
    <?if($errors['err']) {?>
        <p align="center" id="errormessage"><?=$errors['err']?></p>
    <?}elseif($msg) {?>
        <p align="center" id="infomessage"><?=$msg?></p>
    <?}?>
</div>


    <span class="Icon thread">Ιστορικό</span>
    <div id="ticketthread">
        <?
	    //get messages
        $sql='SELECT msg.*, count(attach_id) as attachments  FROM '.TICKET_MESSAGE_TABLE.' msg '.
            ' LEFT JOIN '.TICKET_ATTACHMENT_TABLE.' attach ON  msg.ticket_id=attach.ticket_id AND msg.msg_id=attach.ref_id AND ref_type=\'M\' '.
            ' WHERE  msg.ticket_id='.db_input($ticket->getId()).
            ' GROUP BY msg.msg_id ORDER BY created';
	    $msgres =db_query($sql);
	    while ($msg_row = db_fetch_array($msgres)):
		    ?>
		    <table align="center" class="message" cellspacing="0" cellpadding="1" width="100%" border=0>
		        <tr><th><?=Format::db_daydatetime($msg_row['created'])?></th></tr>
                <?if($msg_row['attachments']>0){ ?>
                <tr class="header"><td><?=$ticket->getAttachmentStr($msg_row['msg_id'],'M')?></td></tr> 
                <?}?>
                <tr class="info">
                    <td><?=Format::display($msg_row['message'])?></td></tr>
		    </table>
            <?
            //get answers for messages
            $sql='SELECT resp.*,count(attach_id) as attachments FROM '.TICKET_RESPONSE_TABLE.' resp '.
                ' LEFT JOIN '.TICKET_ATTACHMENT_TABLE.' attach ON  resp.ticket_id=attach.ticket_id AND resp.response_id=attach.ref_id AND ref_type=\'R\' '.
                ' WHERE msg_id='.db_input($msg_row['msg_id']).' AND resp.ticket_id='.db_input($ticket->getId()).
                ' GROUP BY resp.response_id ORDER BY created';
            //echo $sql;
		    $resp =db_query($sql);
		    while ($resp_row = db_fetch_array($resp)) {
                $respID=$resp_row['response_id'];
                $name=$cfg->hideStaffName()?'staff':Format::htmlchars($resp_row['staff_name']);
                ?>
    		    <table align="center" class="response" cellspacing="0" cellpadding="1" width="100%" border=0>
    		        <tr>
    			        <th><?=Format::db_daydatetime($resp_row['created'])?>&nbsp;-&nbsp;<?=$name?></th></tr>
                    <?if($resp_row['attachments']>0){ ?>
                    <tr class="header">
                        <td><?=$ticket->getAttachmentStr($respID,'R')?></td></tr>
                                    
                    <?}?>
			        <tr class="info">
				        <td> <?=Format::display($resp_row['response'])?></td></tr>
		        </table>
		    <?
		    } //endwhile...response loop.
            $msgid =$msg_row['msg_id'];
        endwhile; //message loop.
     ?>
    </div>


<div class="spazer">
    <?if($errors['err']) {?>
        <p align="center" id="errormessage"><?=$errors['err']?></p>
    <?}elseif($msg) {?>
        <p align="center" id="infomessage"><?=$msg?></p>
    <?}?>
</div>
	
    <div id="reply">
        <?if($ticket->isClosed()) {?>
        <div class="msg">Ticket will be reopened on message post</div>
        <?}?>
        <form action="view.php?id=<?=$id?>#reply" name="reply" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$ticket->getExtId()?>">
            <input type="hidden" name="respid" value="<?=$respID?>">
            <input type="hidden" name="a" value="postmessage">

                Εμπλουτίστε το αρχικό μήνυμά σας <br />
				
					<?if($errors['err']) {?>
						<p align="center" id="errormessage"><?=$errors['message']?></p>
					<?} ?>
				 <br />
                <textarea name="message" id="message" cols="60" rows="7" wrap="soft"><?=$info['message']?></textarea>
     
            <? if($cfg->allowOnlineAttachments()) {?>
   
                Attach File<br><input type="file" name="attachment" id="attachment" size=30px value="<?=$info['attachment']?>" /> 
                    <font class="error">&nbsp;<?=$errors['attachment']?></font>
 
            <?}?>
            <div align="actnewsum">
                <input class="button actnew" type='submit' value='Αποστολή Απάντησης' />
                <input class="button actnew" type='reset' value='Καθαρισμός' />
                <input class="button actnew" type='button' value='Ακύρωση' onClick='window.location.href="view.php"' />
            </div>
        </form>
    </div>

	</div>
</div>
