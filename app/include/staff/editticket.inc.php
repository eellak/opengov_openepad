<script src="./js/jquery.validationEngine.js" type="text/javascript"></script>
<script src="./js/jquery.validationEngine-el.js" type="text/javascript"></script>
<script src="./js/jquery.ui.selectmenu.js" type="text/javascript"></script>
<script type="text/javascript" src="js/dropdowns.js"></script>


<?php


if(!defined('OSTSCPINC') || !is_object($ticket) || !is_object($thisuser) || !$thisuser->isStaff()) die('Access Denied');

if(!($thisuser->canEditTickets() || ($thisuser->isManager() && $ticket->getDeptId()==$thisuser->getDeptId()))) die('Access Denied. Perm error.');



if($_POST && $errors){
    $info=Format::input($_POST);
}else{



    $info=array('lastname'=>$ticket->getlastname(),
                'dimos_id'=>$ticket->getdimos_id(),
                'tk'=>$ticket->gettk(),
                'address'=>$ticket->getaddress(),
                'website'=>$ticket->getwebsite(),
                'idiotita'=>$ticket->getidiotita(),
                'phone_mobile'=>$ticket->getphone_mobile(),
                'communication_type'=>$ticket->getcommunication_type(),
                'yphresia'=>$ticket->getyphresia(),
                'yphresia_dimos_id'=>$ticket->getyphresia_dimos_id(),
                'email'=>$ticket->getEmail(),
                'name' =>$ticket->getName(),
                'phone'=>$ticket->getPhone(),
                'phone_ext'=>$ticket->getPhoneExt(),
                'pri'=>$ticket->getPriorityId(),
                'topicId'=>$ticket->getTopicId(),
                'topicId2'=>$ticket->getTopicId2(),
                'topic'=>$ticket->getHelpTopic(),
                'subject' =>$ticket->getSubject(),
                'duedate' =>$ticket->getDueDate()?(Format::userdate('m/d/Y',Misc::db2gmtime($ticket->getDueDate()))):'',
                'time'=>$ticket->getDueDate()?(Format::userdate('G:i',Misc::db2gmtime($ticket->getDueDate()))):'',
                );
    /*Note: Please don't make me explain how dates work - it is torture. Trust me! */
}

?>
<script type="text/javascript">
$(function() {

	prepareform(<?php echo $ticket->getTopicId(); ?>,<?php echo $ticket->getTopicId2(); ?>);

});

</script>
<div width="100%">
  <?if($errors['err']) {?>
  <p align="center" id="errormessage">
    <?=$errors['err']?>
  </p>
  <?}elseif($msg) {?>
  <p align="center" class="infomessage">
    <?=$msg?>
  </p>
  <?}elseif($warn) {?>
  <p class="warnmessage">
    <?=$warn?>
  </p>
  <?}?>
</div>
<table width="100%" border="0" cellspacing=1 cellpadding=2>
  <form action="tickets.php?id=<?=$ticket->getId()?>" method="post">
    <input type='hidden' name='id' value='<?=$ticket->getId()?>'>
    <input type='hidden' name='a' value='update'>
    <tr>
      <td align="left" colspan=2 class="msg"> Update Ticket #
        <?=$ticket->getExtId()?>
        &nbsp;&nbsp;(<a href="tickets.php?id=<?=$ticket->getId()?>" style="color:black;">View Ticket</a>)<br></td>
    </tr>
    <tr>
      <td align="left" nowrap width="120"><b>Email Address:</b></td>
      <td><input type="text" id="email" name="email" size="25" value="<?=$info['email']?>">
        &nbsp;<font class="error"><b>*</b>&nbsp;
        <?=$errors['email']?>
        </font></td>
    </tr>
    <tr>
      <td align="left" ><b>First Name:</b></td>
      <td><input type="text" id="name" name="name" size="25" value="<?=$info['name']?>">
        &nbsp;<font class="error"><b>*</b>&nbsp;
        <?=$errors['name']?>
        </font></td>
    </tr>
    <tr>
      <td align="left" ><b>Last Name:</b></td>
      <td><input type="text" id="lastname" name="lastname" size="25" value="<?=$info['lastname']?>">
        &nbsp;<font class="error"><b>*</b>&nbsp;
        <?=$errors['lastname']?>
        </font></td>
    </tr>
    <tr>
      <td align="left" ><b>Δήμος:</b></td>
      
      <td>
      
      <input name="dimos" id="dimos"   size="80" type="text"  value="<?=Format::htmlchars(openPadUtils::getNameFrompb_id($ticket->getdimos_id()))?>" title="Δώστε την Πόλη ή τον Δήμο σας"/>
        <input type="hidden" name="dimos_id" id="dimos_id"  size="25" value="<?=$info['dimos_id']?>" />
        &nbsp;<font class="error"><b>*</b>&nbsp;
        <?=$errors['dimos_id']?>
        </font></td>
    </tr>
    <tr>
      <td align="left" ><b>ΤΚ:</b></td>
      <td><input type="text" id="tk" name="tk" size="25" value="<?=$info['tk']?>">
        &nbsp;<font class="error"><b>*</b>&nbsp;
        <?=$errors['tk']?>
        </font></td>
    </tr>
    <tr>
      <td align="left" ><b>Διεύθυνση:</b></td>
      <td><input type="text" id="address" name="address" size="25" value="<?=$info['address']?>">
        &nbsp;<font class="error"><b>*</b>&nbsp;
        <?=$errors['address']?>
        </font></td>
    </tr>
    <tr>
      <td align="left" ><b>Ιστοσελίδα:</b></td>
      <td><input type="text" id="website" name="website" size="25" value="<?=$info['website']?>">
        &nbsp;<font class="error"><b>*</b>&nbsp;
        <?=$errors['website']?>
        </font></td>
    </tr>
    <tr>
      <td align="left" ><b>Ιδιότητα:</b></td>
      <td><select name="idiotita" id="idiotita">
          <?php
                   $idiotites_i=0;
				   foreach($cfg->idiotites_array_values as $ivalue) {
				      if ($info['idiotita']==$cfg->idiotites_array_keys[$idiotites_i]) 
					  {
						echo '<option value="'.$cfg->idiotites_array_keys[$idiotites_i].'"  selected="selected">'.$ivalue.'</option>';	
						$idiotites_i++;
					  }	
					  else
					  {
						echo '<option value="'.$cfg->idiotites_array_keys[$idiotites_i].'">'.$ivalue.'</option>';	
						$idiotites_i++;
					  }
				   }
				 					    
				 ?>
        </select>
        &nbsp;<font class="error"><b>*</b>&nbsp;
        <?=$errors['idiotita']?>
        </font></td>
    </tr>
    <tr>
      <td align="left" ><b>Επιθυμητός Τρόπος Επικοινωνίας:</b></td>
      <td><select name="communication_type" id="communication_type">
          <?php

			 ?> 
          <option value="1" <?php if (($info['communication_type']=='Email') || ($info['communication_type']=='1')) {echo ' selected="selected" ';} ?>>Email</option>
          <option value="2"<?php if (($info['communication_type']=='SMS') || ($info['communication_type']=='2')){echo ' selected="selected" ';} ?>>SMS</option>
          <option value="3"<?php if (($info['communication_type']=='Post') || ($info['communication_type']=='3')){echo ' selected="selected" ';} ?>>Αλληλογραφία</option>
        </select>
        &nbsp;<font class="error"><b>*</b>&nbsp;
        <?=$errors['communication_type']?>
        </font></td>
    </tr>
    <tr>
      <td align="left" ><b>Υπηρεσία:</b></td>
      <td><input type="text" id="yphresia" name="yphresia" size="25" value="<?=$info['yphresia']?>">
        &nbsp;<font class="error"><b>*</b>&nbsp;
        <?=$errors['yphresia']?>
        </font></td>
    </tr>
    <tr>
      <td align="left" ><b>Δήμος Υπηρεσίας:</b></td>
      <td>
      <input name="yphresia_dimos" id="yphresia_dimos"   size="80" type="text"  value="<?=Format::htmlchars(openPadUtils::getNameFrompb_id($ticket->getyphresia_dimos_id()))?>" title="Δώστε την Πόλη ή τον Δήμο σας"/>
        <input type="hidden" name="yphresia_dimos_id" id="yphresia_dimos_id"  size="25" value="<?=$info['yphresia_dimos_id']?>" />      
        &nbsp;<font class="error"><b>*</b>&nbsp;
        <?=$errors['yphresia_dimos_id']?>
        </font></td>
    </tr>
    <tr>
      <td align="left"><b>Subject:</b></td>
      <td><input type="text" name="subject" size="35" value="<?=$info['subject']?>">
        &nbsp;<font class="error">*&nbsp;
        <?=$errors['subject']?>
        </font></td>
    </tr>
    <tr>
      <td align="left">Telephone:</td>
      <td><input type="text" name="phone" id="phone" size="25" value="<?=$info['phone']?>">
        &nbsp;Ext&nbsp;
        <input type="text" name="phone_ext" id="phone_ext" size="6" value="<?=$info['phone_ext']?>">
        &nbsp;<font class="error">&nbsp;
        <?=$errors['phone']?>
        </font></td>
    </tr>
    <tr>
      <td align="left">Mobile Phone:</td>
      <td><input type="text" name="phone_mobile" id="phone_mobile" size="25" value="<?=$info['phone_mobile']?>">
        &nbsp;<font class="error">&nbsp;
        <?=$errors['phone_mobile']?>
        </font></td>
    </tr>
    <tr height=1px>
      <td align="left" colspan=2 >&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">Due Date:</td>
      <td><i>Time is based on your time zone (GM
        <?=$thisuser->getTZoffset()?>
        )</i>&nbsp;<font class="error">&nbsp;
        <?=$errors['time']?>
        </font><br>
        <input id="duedate" name="duedate" value="<?=Format::htmlchars($info['duedate'])?>"
                onclick="event.cancelBubble=true;calendar(this);" autocomplete=OFF>
        <a href="#" onclick="event.cancelBubble=true;calendar(getObj('duedate')); return false;"><img src='images/cal.png'border=0 alt=""></a> &nbsp;&nbsp;
        <?php
             $min=$hr=null;
             if($info['time'])
                list($hr,$min)=explode(':',$info['time']);
                echo Misc::timeDropdown($hr,$min,'time');
            ?>
        &nbsp;<font class="error">&nbsp;
        <?=$errors['duedate']?>
        </font></td>
    </tr>
    <?
      $sql='SELECT priority_id,priority_desc FROM '.TICKET_PRIORITY_TABLE.' ORDER BY priority_urgency DESC';
      if(($priorities=db_query($sql)) && db_num_rows($priorities)){ ?>
    <tr>
      <td align="left">Priority:</td>
      <td><select name="pri">
          <?
                while($row=db_fetch_array($priorities)){ ?>
          <option value="<?=$row['priority_id']?>" <?=$info['pri']==$row['priority_id']?'selected':''?> >
          <?=$row['priority_desc']?>
          </option>
          <?}?>
        </select></td>
    </tr>
    <? }?>
    <?php
    $services= db_query('SELECT topic_id,topic,isactive FROM '.TOPIC_TABLE.' ORDER BY topic');
    if($services && db_num_rows($services)){ ?>
    <tr>
      <td align="left" valign="top">Help Topic:</td>
      <td><select size="200" name="topicId" id="topicId"  class="dropdown">

        </select>
        &nbsp;(optional)<font class="error">&nbsp;
        <?=$errors['topicId']?>
        </font></td>
    </tr>
    <?
    }?>
    <tr>
      <td align="left" valign="top">Help Topic 2:</td>
      <td><select name="topicId2" id="topicId2"  class="dropdown">
        </select>
        &nbsp;(optional)<font class="error">&nbsp;
        <?=$errors['topicId2']?>
        </font></td>
    </tr>
    <tr>
      <td align="left" valign="top"><b>Internal Note:</b></td>
      <td><i>Reasons for the edit.</i><font class="error"><b>*&nbsp;
        <?=$errors['note']?>
        </b></font><br/>
        <textarea name="note" cols="45" rows="5" wrap="soft"><?=$info['note']?>
</textarea></td>
    </tr>
    <tr height=2px>
      <td align="left" colspan=2 >&nbsp;</td>
    </tr>
    <tr>
      <td></td>
      <td><input class="button" type="submit" name="submit_x" value="Update Ticket">
        <input class="button" type="reset" value="Reset">
        <input class="button" type="button" name="cancel" value="Cancel" onClick='window.location.href="tickets.php?id=<?=$ticket->getId()?>"'></td>
    </tr>
  </form>
</table>
<script language="javascript" type="text/javascript">	


$(function() {			
			
     $("#dimos,#yphresia_dimos,#yphresia").autocomplete({
                    source: function (request, response) {
						var serviceurl;
						
						 if (this.element.context.id=='yphresia') 
							 serviceurl="<?php echo openPadUtils::$diavgeiaServiceUrl; ?>?codelevel1=publicservices&callback=?&term="+request.term;
						 else
							 serviceurl="<?php echo openPadUtils::$diavgeiaServiceUrl; ?>?codelevel1=municipalities&callback=?&term="+request.term;					

                        $.ajax({
                            type: "GET",
                            url: serviceurl, 
                            dataType: "json",
                            contentType: "application/json; charset=utf-8",
                            success: function (data) {
                               
                                response($.map(data, function (item) {
                                   
                                    return {
                                         label: item.name,
                                            value: item.id
                                    }
                                }))
                            },
                          
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                alert(textStatus);
                            }
                        }); 
                    },
                    select: function(event, ui) {
						if (this.id=="yphresia_dimos")
						{
							$("#yphresia_dimos_id").val(ui.item.value);
							$("#yphresia_dimos").val(ui.item.label);
						}
						if (this.id=="dimos")
						{
							$("#dimos_id").val(ui.item.value);
							$("#dimos").val(ui.item.label);
						}
						if (this.id=="yphresia")
						{
							$("#yphresia").val(ui.item.label);
						}
						
					  return false;
                    },
                    keyup: function(event, ui) { 
 						if (this.id=="yphresia_dimos")
						{
                            $("#yphresia_dimos_id").val(0);
						}	
 						if (this.id=="dimos")
						{
                            $("#dimos_id").val(0);
						}	
					   return false;
                    },
                    minLength: 3
                });
});
			
			
			</script>