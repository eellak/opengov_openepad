<?php

   function DownloadUrl($Url)
   {
      if(!function_exists('curl_init'))
      {
         die('CURL is not installed!');
      }
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $Url);
      curl_setopt($ch, CURLOPT_REFERER, "http://dev.gov.gr/");
      curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, 120);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      $output = curl_exec($ch);
      curl_close($ch);
      return $output;
   }

if(!defined('OSTSCPINC') || !is_object($thisuser) || !$thisuser->isStaff()) die('Access Denied');
$info=($_POST && $errors)?Format::input($_POST):array(); //on error...use the post data
?>

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
<table width="80%" border="0" cellspacing=1 cellpadding=2>
  <form action="tickets.php" method="post" enctype="multipart/form-data">
    <input type='hidden' name='a' value='open'>
    <tr>
      <td align="left" colspan=2>Παρακαλώ συμπληρώστε τη φόρμα για να καταχωρήσετε ένα νέο μήνυμα.</td>
    </tr>
    <tr>
      <td align="left" nowrap width="20%"><b>Email :</b></td>
      <td><input type="text" id="email" name="email" size="25" value="<?=$info['email']?>">
        &nbsp;<font class="error"><b>*</b>&nbsp;
        <?=$errors['email']?>
        </font>
        <? if($cfg->notifyONNewStaffTicket()) {?>
        &nbsp;&nbsp;&nbsp;
        <input type="checkbox" name="alertuser" <?=(!$errors || $info['alertuser'])? 'checked': ''?>>
        Αποστολή ειδοποιήσης στον πολίτη.
        <?}?></td>
    </tr>
    <tr>
      <td align="left" ><b>Όνομα:</b></td>
      <td><input type="text" id="name" name="name" size="25" value="<?=$info['name']?>">
        &nbsp;<font class="error"><b>*</b>&nbsp;
        <?=$errors['name']?>
        </font></td>
    </tr>
    <tr>
      <td align="left" ><b>Επίθετο:</b></td>
      <td><input type="text" id="lastname" name="lastname" size="25" value="<?=$info['lastname']?>">
        &nbsp;<font class="error"><b>*</b>&nbsp;
        <?=$errors['lastname']?>
        </font></td>
    </tr>
    <tr>
      <td align="left" ><b>Δήμος:</b></td>
            <td><input name="dimos" id="dimos" type="text"  value="" title="Δώστε την Πόλη ή τον Δήμο σας"/>
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
      <td align="left" ><b>Κινητό Τηλέφωνο:</b></td>
      <td><input type="text" id="phone_mobile" name="phone_mobile" size="25" value="<?=$info['phone_mobile']?>">
        &nbsp;<font class="error"><b>*</b>&nbsp;
        <?=$errors['phone_mobile']?>
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
      <td align="left" ><b>Δημοσίευση Μηνύματος:</b></td>
      <td>
      <select name="publish" id="publish">
       <option value="1" <?php 
	   
	   if ($info['publish']==1) {echo ' selected ';}
	   ?> >Ναι</option>
       <option value="0" <?php 
	   if ($info['publish']==0) {echo ' selected ';}
	   ?> >Όχι</option>
     </select>
        &nbsp;<font class="error"><b>*</b>&nbsp;
        <?=$errors['publish']?>
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
      <td><input name="yphresia_dimos" id="yphresia_dimos" type="text"  value="" title="Δώστε την Πόλη ή τον Δήμο που εδρεύει η υπηρεσία"/>
        <input type="hidden" name="yphresia_dimos_id" id="yphresia_dimos_id"  size="25" value="<?=$info['yphresia_dimos_id']?>" />
        &nbsp;<font class="error"><b>*</b>&nbsp;
        <?=$errors['yphresia_dimos_id']?>
        </font></td>
    </tr>
    <tr>
      <td align="left">Τηλέφωνο:</td>
      <td><input type="text" name="phone" size="25" value="<?=$info['phone']?>">
        &nbsp;Κωδικός Περιοχής&nbsp;
        <input type="text" name="phone_ext" size="6" value="<?=$info['phone_ext']?>">
        <font class="error">&nbsp;
        <?=$errors['phone']?>
        </font></td>
    </tr>
    <tr height=2px>
      <td align="left" colspan=2 >&nbsp;</td>
    </tr>
    <tr>
      <td align="left"><b>Πηγή Μηνύματος:</b></td>
      <td><select name="source">
          <option value="" selected >Select Source</option>
          <option value="Phone" <?=($info['source']=='Phone')?'selected':''?>>Phone</option>
          <option value="Email" <?=($info['source']=='Email')?'selected':''?>>Email</option>
          <option value="Other" <?=($info['source']=='Other')?'selected':''?>>Other</option>
        </select>
        &nbsp;<font class="error"><b>*</b>&nbsp;
        <?=$errors['source']?>
        </font></td>
    </tr>
    <tr>
      <td align="left"><b>Φορέας:</b></td>
      <td><select name="deptId">
          <option value="" selected >Επιλογή Φορέα</option>
          <?
                 $services= db_query('SELECT dept_id,dept_name FROM '.DEPT_TABLE.' ORDER BY dept_name');
                 while (list($deptId,$dept) = db_fetch_row($services)){
                    $selected = ($info['deptId']==$deptId)?'selected':''; ?>
          <option value="<?=$deptId?>"<?=$selected?>>
          <?=$dept?>
          </option>
          <?
                 }?>
        </select>
        &nbsp;<font class="error"><b>*</b>&nbsp;
        <?=$errors['deptId']?>
        </font></td>
    </tr>
    <tr>
      <td align="left"><b>Θέμα:</b></td>
      <td><input type="text" name="subject" size="35" value="<?=$info['subject']?>">
        &nbsp;<font class="error">*&nbsp;
        <?=$errors['subject']?>
        </font></td>
    </tr>
    <tr>
      <td align="left" valign="top"><b>Μήνυμα:</b></td>
      <td><i>Ορατό στον πολίτη.</i><font class="error"><b>*&nbsp;
        <?=$errors['issue']?>
        </b></font><br/>
        <?
            $sql='SELECT premade_id,title FROM '.KB_PREMADE_TABLE.' WHERE isenabled=1';
            $canned=db_query($sql);
            if($canned && db_num_rows($canned)) {
            ?>
        Πρότυπο Απάντησης:&nbsp;
        <select id="canned" name="canned"
                onChange="getCannedResponse(this.options[this.selectedIndex].value,this.form,'issue');this.selectedIndex='0';" >
          <option value="0" selected="selected">Επιλέξτε ένα πρότυπο απάντησης</option>
          <?while(list($cannedId,$title)=db_fetch_row($canned)) { ?>
          <option value="<?=$cannedId?>" >
          <?=Format::htmlchars($title)?>
          </option>
          <?}?>
        </select>
        &nbsp;&nbsp;&nbsp;
        <label>
          <input type='checkbox' value='1' name=append checked="true" />
          Προσθήκη</label>
        <?}?>
        <textarea name="issue" cols="55" rows="8" wrap="soft"><?=$info['issue']?>
</textarea></td>
    </tr>
    <?if($cfg->canUploadFiles()) {
        ?>
    <tr>
      <td>Attachment:</td>
      <td><input type="file" name="attachment">
        <font class="error">&nbsp;
        <?=$errors['attachment']?>
        </font></td>
    </tr>
    <?}?>
    <tr>
      <td align="left" valign="top">Εσωτερική Σημείωση:</td>
      <td><i>Προεραιτικό εσωτερικό σημείωνμα.</i><font class="error"><b>&nbsp;
        <?=$errors['note']?>
        </b></font><br/>
        <textarea name="note" cols="55" rows="5" wrap="soft"><?=$info['note']?>
</textarea></td>
    </tr>
    <tr>
      <td align="left" valign="top">Ημερομηνία Διευθέτησης:</td>
      <td><i>Η ώρα εξαρτάται από την ζώνη ώρας (GM
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
      <td align="left">Προτεραιότητα:</td>
      <td><select name="pri">
          <?
                $info['pri']=$info['pri']?$info['pri']:$cfg->getDefaultPriorityId();
                while($row=db_fetch_array($priorities)){ ?>
          <option value="<?=$row['priority_id']?>" <?=$info['pri']==$row['priority_id']?'selected':''?> >
          <?=$row['priority_desc']?>
          </option>
          <?}?>
        </select></td>
    </tr>
    <? }?>
    <?php
    $services= db_query('SELECT topic_id,topic FROM '.TOPIC_TABLE.' WHERE isactive=1 ORDER BY topic');
    if($services && db_num_rows($services)){ ?>
    <tr>
      <td align="left" valign="top">Λόγος Επικοινωνίας:</td>
      <td><select name="topicId">
          <option value="" selected >Επιλέξτε ένα</option>
          <?
                 while (list($topicId,$topic) = db_fetch_row($services)){
                    $selected = ($info['topicId']==$topicId)?'selected':''; ?>
          <option value="<?=$topicId?>"<?=$selected?>>
          <?=$topic?>
          </option>
          <?
                 }?>
        </select>
        &nbsp;<font class="error">&nbsp;
        <?=$errors['topicId']?>
        </font></td>
    </tr>
    <?
    }?>
    <tr>
      <td>Ανάθεση σε:</td>
      <td><select id="staffId" name="staffId">
          <option value="0" selected="selected">-Ανάθεση σε χρήστη-</option>
          <?
                    //TODO: make sure the user's group is also active....DO a join.
                    $sql=' SELECT staff_id,CONCAT_WS(", ",lastname,firstname) as name FROM '.STAFF_TABLE.' WHERE isactive=1 AND onvacation=0 ';
                    $depts= db_query($sql.' ORDER BY lastname,firstname ');
                    while (list($staffId,$staffName) = db_fetch_row($depts)){
                        $selected = ($info['staffId']==$staffId)?'selected':''; ?>
          <option value="<?=$staffId?>"<?=$selected?>>
          <?=$staffName?>
          </option>
          <?
                    }?>
        </select>
        <font class='error'>&nbsp;
        <?=$errors['staffId']?>
        </font> &nbsp;&nbsp;&nbsp;
        <input type="checkbox" name="alertstaff" <?=(!$errors || $info['alertstaff'])? 'checked': ''?>>
        Αποστολή ειδοποίησης στο χρήστη. </td>
    </tr>
    <tr>
      <td>Υπογραφή:</td>
      <td><?php
            $appendStaffSig=$thisuser->appendMySignature();
            $info['signature']=!$info['signature']?'none':$info['signature']; //change 'none' to 'mine' to default to staff signature.
            ?>
        <div style="margin-top: 2px;">
          <label>
            <input type="radio" name="signature" value="none" checked >
            Καμία</label>
          <?if($appendStaffSig) {?>
          <label>
            <input type="radio" name="signature" value="mine" <?=$info['signature']=='mine'?'checked':''?> >
            Η υπογραφή μου</label>
          <?}?>
          <label>
            <input type="radio" name="signature" value="dept" <?=$info['signature']=='dept'?'checked':''?> >
            Υπογραφή Φορέα (αν υπάρχει)</label>
        </div></td>
    </tr>
    <tr height=2px>
      <td align="left" colspan=2 >&nbsp;</td>
    </tr>
    <tr>
      <td></td>
      <td><input class="button" type="submit" name="submit_x" value="Υποβολή Μηνύματος">
        <input class="button" type="reset" value="Καθαρισμός">
        <input class="button" type="button" name="cancel" value="Ακύρωση" onClick='window.location.href="tickets.php"'></td>
    </tr>
  </form>
</table>
<script type="text/javascript">
    
    var options = {
        script:"ajax.php?api=tickets&f=searchbyemail&limit=10&",
        varname:"input",
        json: true,
        shownoresults:false,
        maxresults:10,
        callback: function (obj) { document.getElementById('email').value = obj.id; document.getElementById('name').value = obj.info; return false;}
    };
    var autosug = new bsn.AutoSuggest('email', options);
</script> 
<script language="javascript" type="text/javascript">	
	    function load_dropdown(elementselector,codelevel1 , codelevel2) {

           var element=$(elementselector);

           var baseurl="<?php echo openPadUtils::$diavgeiaServiceUrl; ?>";
           var serviceurl=baseurl+"?codelevel1="+codelevel1+"&codelevel2="+codelevel2+"&callback=?";
           

           $.getJSON(serviceurl,
                    function(data){

                                   element.empty();
                  
                                   for(var i=0; i < data.length; i++) {
                                      
                                       element.append("<option value=\"" +data[i].id  +"\">" + data[i].name + "</option>");
                                      
                                   } 
                   
                                   element.selectmenu({style:'dropdown',menuWidth: 250});

            
                    });
       
        }
$(function() {

            //1. Load dropdowns
			load_dropdown('#region','regions','');
            load_dropdown('#dimos_id','municipalities','5001');
            
$('#region').change(function() {
					load_dropdown('#dimos_id','municipalities',$('#region').val());
					});

			
					
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