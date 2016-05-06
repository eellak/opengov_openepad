<?php

//edited file
// 

if(!defined('OSTSCPINC') || !@$thisuser->isStaff()) die('Access Denied');




$qstr='&'; //Query string collector
if($_REQUEST['status']) { //Query string status has nothing to do with the real status used below; gets overloaded.
    $qstr.='status='.urlencode($_REQUEST['status']);
}

//See if this is a search
$search=$_REQUEST['a']=='search'?true:false;
$searchTerm='';
//make sure the search query is 3 chars min...defaults to no query with warning message
if($search) {
  $searchTerm=$_REQUEST['query'];
  if( ($_REQUEST['query'] && strlen($_REQUEST['query'])<3) 
      || (!$_REQUEST['query'] && isset($_REQUEST['basic_search'])) ){ //
      $search=false; //
      $errors['err']='Οι όροι αναζήτησης πρέπει να περιέχουν τουλάχιστον 3 χαρακτήρες';
      $searchTerm='';
  }
}
$showoverdue=$showanswered=false;
$staffId=0; 

$status=null;
switch(strtolower($_REQUEST['status'])){ //Status is overloaded
    case 'open':
        $status='open';
        break;
    case 'closed':
        $status='closed';
        break;
    case 'overdue':
        $status='open';
        $showoverdue=true;
        $results_type='Εκπρόθεσμα Μηνύματα';
        break;
    case 'assigned':
        //$status='Open'; //
        $staffId=$thisuser->getId();
        break;
    case 'answered':
        $status='open';
        $showanswered=true;
        $results_type='Μηνύματα Υπο Επεξεργασία';
        break;
    default:
        if(!$search)
            $status='open';
}


if($stats) { 
    if(!$stats['open'] && (!$status || $status=='open')){
        if(!$cfg->showAnsweredTickets() && $stats['answered']) {
             $status='open';
             $showanswered=true;
             $results_type='Μηνύματα Υπο Επεξεργασία';
        }elseif(!$stats['answered']) { //no open or answered tickets (+-queue?) - show closed tickets.???
            $status='closed';
            $results_type='Κλειστά Μηνύματα';
        }
    }
}

$qwhere ='';

$depts=$thisuser->getDepts(); //
if(!$depts or !is_array($depts) or !count($depts)){
    
    $qwhere =' WHERE ticket.dept_id IN ( 0 ) ';
}else if($thisuser->isadmin()){
    $qwhere =' WHERE 1'; 
}else{
    $qwhere =' WHERE (ticket.dept_id IN ('.implode(',',$depts).') OR ticket.staff_id='.$thisuser->getId().')';
}

//STATUS
if($status){
    $qwhere.=' AND status='.db_input(strtolower($status));    
}

//Sub-statuses Trust me!
if($staffId && ($staffId==$thisuser->getId())) { //Staff's assigned tickets.
    $results_type='Μηνύματα που έχουν ανατεθεί';
    $qwhere.=' AND ticket.staff_id='.db_input($staffId);    
}elseif($showoverdue) { //overdue
    $qwhere.=' AND isoverdue=1 ';
}elseif($showanswered) { ////Answered
    $qwhere.=' AND isanswered=1 ';
}elseif(!$search && !$cfg->showAnsweredTickets() && !strcasecmp($status,'open')) {
    $qwhere.=' AND isanswered=0 ';
}
 

if(!$cfg->showAssignedTickets() && !$thisuser->isadmin()) {
    $qwhere.=' AND (ticket.staff_id=0 OR ticket.staff_id='.db_input($thisuser->getId()).' OR dept.manager_id='.db_input($thisuser->getId()).') ';
}


$deep_search=false;
if($search):
    $qstr.='&a='.urlencode($_REQUEST['a']);
    $qstr.='&t='.urlencode($_REQUEST['t']);
    if(isset($_REQUEST['advance_search'])){ //advance search box!
        $qstr.='&advance_search=Search';
    }

    //query
    if($searchTerm){
        $qstr.='&query='.urlencode($searchTerm);
        $queryterm=db_real_escape($searchTerm,false); //escape the term ONLY...no quotes.
        if(is_numeric($searchTerm)){
            $qwhere.=" AND ticket.ticketID LIKE '$queryterm%'";
        }elseif(strpos($searchTerm,'@') && Validator::is_email($searchTerm)){ //pulling all tricks!
            $qwhere.=" AND ticket.email='$queryterm'";
        }else{
            
            $deep_search=true;
            if($_REQUEST['stype'] && $_REQUEST['stype']=='FT') { //Using full text on big fields.
                $qwhere.=" AND ( ticket.email LIKE '%$queryterm%'".
                            " OR ticket.name LIKE '%$queryterm%'".
                            " OR ticket.subject LIKE '%$queryterm%'".
                            " OR note.title LIKE '%$queryterm%'".
                            " OR MATCH(message.message)   AGAINST('$queryterm')".
                            " OR MATCH(response.response) AGAINST('$queryterm')".
                            " OR MATCH(note.note) AGAINST('$queryterm')".
                            ' ) ';
            }else{
                $qwhere.=" AND ( ticket.email LIKE '%$queryterm%'".
                            " OR ticket.name LIKE '%$queryterm%'".
                            " OR ticket.subject LIKE '%$queryterm%'".
                            " OR message.message LIKE '%$queryterm%'".
                            " OR response.response LIKE '%$queryterm%'".
                            " OR note.note LIKE '%$queryterm%'".
                            " OR note.title LIKE '%$queryterm%'".
                            ' ) ';
            }
        }
    }
    //department
    if($_REQUEST['dept'] && ($thisuser->isadmin() || in_array($_REQUEST['dept'],$thisuser->getDepts()))) {
    //This is dept based search..perm taken care above..put the sucker in.
        $qwhere.=' AND ticket.dept_id='.db_input($_REQUEST['dept']);
        $qstr.='&dept='.urlencode($_REQUEST['dept']);
    }
    
   
    //publish status
    if($_REQUEST['publishstatus'] &&  $_REQUEST['publishstatus']!='' ) {
    //This is publish status  based search..perm taken care above..put the sucker in.
    
    	
    	 
        $qwhere.=' AND ticket.publish='.db_input($_REQUEST['publishstatus']);
        $qstr.='&publishstatus='.urlencode($_REQUEST['publishstatus']);
    }
    	
    //topic
    if($_REQUEST['topicId'] &&  $_REQUEST['topicId']!='') {
    	
    //This is topic based search..perm taken care above..put the sucker in.
        $qwhere.=' AND ticket.topic_id='.db_input($_REQUEST['topicId']);
        $qstr.='&topic='.urlencode($_REQUEST['topicId']);
    }
    
    //dates
    $startTime  =($_REQUEST['startDate'] && (strlen($_REQUEST['startDate'])>=8))?strtotime($_REQUEST['startDate']):0;
    $endTime    =($_REQUEST['endDate'] && (strlen($_REQUEST['endDate'])>=8))?strtotime($_REQUEST['endDate']):0;
    if( ($startTime && $startTime>time()) or ($startTime>$endTime && $endTime>0)){
        $errors['err']='Entered date span is invalid. Selection ignored.';
        $startTime=$endTime=0;
    }else{
        //Have fun with dates.
        if($startTime){
            $qwhere.=' AND ticket.created>=FROM_UNIXTIME('.$startTime.')';
            $qstr.='&startDate='.urlencode($_REQUEST['startDate']);
                        
        }
        if($endTime){
            $qwhere.=' AND ticket.created<=FROM_UNIXTIME('.$endTime.')';
            $qstr.='&endDate='.urlencode($_REQUEST['endDate']);
        }
}

endif;

$sortOptions=array('date'=>'ticket.created','ID'=>'ticketID','pri'=>'priority_urgency','dept'=>'dept_name');
$orderWays=array('DESC'=>'DESC','ASC'=>'ASC');

if($_REQUEST['sort']) {
    $order_by =$sortOptions[$_REQUEST['sort']];
}
if($_REQUEST['order']) {
    $order=$orderWays[$_REQUEST['order']];
}
if($_GET['limit']){
    $qstr.='&limit='.urlencode($_GET['limit']);
}
if(!$order_by && $showanswered) {
    $order_by='ticket.lastresponse DESC, ticket.created'; //No priority sorting for answered tickets.
}elseif(!$order_by && !strcasecmp($status,'closed')){
    $order_by='ticket.closed DESC, ticket.created'; //No priority sorting for closed tickets.
}


$order_by =$order_by?$order_by:'priority_urgency,effective_date DESC ,ticket.created';
$order=$order?$order:'DESC';
$pagelimit=$_GET['limit']?$_GET['limit']:$thisuser->getPageLimit();
$pagelimit=$pagelimit?$pagelimit:PAGE_LIMIT; //true default...if all fails.
$page=($_GET['p'] && is_numeric($_GET['p']))?$_GET['p']:1;


$qselect = 'SELECT DISTINCT ticket.ticket_id,lock_id,ticketID,ticket.dept_id,ticket.staff_id,subject,name,lastname,legalname,email,dept_name '.
           ',ticket.status,ticket.source,isoverdue,isanswered,ticket.created,pri.* ,count(attach.attach_id) as attachments '.
		   ',ticket.publish ';
$qfrom=' FROM '.TICKET_TABLE.' ticket '.
       ' LEFT JOIN '.DEPT_TABLE.' dept ON ticket.dept_id=dept.dept_id ';

if($search && $deep_search) {
    $qfrom.=' LEFT JOIN '.TICKET_MESSAGE_TABLE.' message ON (ticket.ticket_id=message.ticket_id )';
    $qfrom.=' LEFT JOIN '.TICKET_RESPONSE_TABLE.' response ON (ticket.ticket_id=response.ticket_id )';
    $qfrom.=' LEFT JOIN '.TICKET_NOTE_TABLE.' note ON (ticket.ticket_id=note.ticket_id )';
}

$qgroup=' GROUP BY ticket.ticket_id';

$total=db_count("SELECT count(DISTINCT ticket.ticket_id) $qfrom $qwhere");
//pagenate
$pageNav=new Pagenate($total,$page,$pagelimit);
$pageNav->setURL('tickets.php',$qstr.'&sort='.urlencode($_REQUEST['sort']).'&order='.urlencode($_REQUEST['order']));

$qselect.=' ,count(attach.attach_id) as attachments, IF(ticket.reopened is NULL,ticket.created,ticket.reopened) as effective_date';
$qfrom.=' LEFT JOIN '.TICKET_PRIORITY_TABLE.' pri ON ticket.priority_id=pri.priority_id '.
        ' LEFT JOIN '.TICKET_LOCK_TABLE.' tlock ON ticket.ticket_id=tlock.ticket_id AND tlock.expire>NOW() '.
        ' LEFT JOIN '.TICKET_ATTACHMENT_TABLE.' attach ON  ticket.ticket_id=attach.ticket_id ';

$query="$qselect $qfrom $qwhere $qgroup ORDER BY $order_by $order LIMIT ".$pageNav->getStart().",".$pageNav->getLimit();

$tickets_res = db_query($query);
$showing=db_num_rows($tickets_res)?$pageNav->showing():"";

if(!$results_type) { 
    $results_type=($search)?'Αποτελέσματα Αναζήτησης':(openPadUtils::getTranslation("status_plural",ucfirst($status))).' Μηνύματα';
}
$negorder=$order=='DESC'?'ASC':'DESC'; //Negate the sorting..

$canDelete=$canClose=false;
$canDelete=$thisuser->canDeleteTickets();
$canClose=$thisuser->canCloseTickets();
$basic_display=!isset($_REQUEST['advance_search'])?true:false;

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
<!-- SEARCH FORM START -->
<div id='basic' style="display:<?=$basic_display?'block':'none'?>">
    <form action="tickets.php" method="get">
    <input type="hidden" name="a" value="search">
    <table>
        <tr>
            <td>Αναζήτηση: </td>
            <td><input type="text" id="query" name="query" size=30 value="<?=Format::htmlchars($_REQUEST['query'])?>"></td>
            <td><input type="submit" name="basic_search" class="button" value="Αναζήτηση">
             &nbsp;[<a href="#" onClick="showHide('basic','advance'); return false;">Προχωρημένο</a> ] </td>
        </tr>
    </table>
    </form>
</div>
<div id='advance' style="margin-bottom:12px;border:1px solid #ccc;display:<?=$basic_display?'none':'block'?>">
 <form action="tickets.php" method="get">
 <input type="hidden" name="a" value="search">
  <table>
    <tr>
        <td>Αναζήτηση: </td><td><input type="text" id="query" name="query" value="<?=Format::htmlchars($_REQUEST['query'])?>"></td>
        <td>Τύπος:</td>
       <td>       
        <select name="stype">
            <option value="LIKE" <?=(!$_REQUEST['stype'] || $_REQUEST['stype'] == 'LIKE') ?'selected':''?>>Με Ομοιότητα (%)</option>
            <option value="FT"<?= $_REQUEST['stype'] == 'FT'?'selected':''?>>Πλήρες Κείμενο</option>
        </select>
 

       </td>
       

    </table>
    <table>
    <tr>
     <td>Φορέας:</td>
        <td><select name="dept" style="width:250px;"><option value=0 >Όλοι οι Φορείς</option>
            <?
                $sql='SELECT dept_id,dept_name FROM '.DEPT_TABLE;
                if(!$thisuser->isadmin())
                    $sql.=' WHERE dept_id IN ('.implode(',',$thisuser->getDepts()).')';
                
                $depts= db_query($sql);
                while (list($deptId,$deptName) = db_fetch_row($depts)){
                $selected = ($_GET['dept']==$deptId)?'selected':''; ?>
                <option value="<?=$deptId?>"<?=$selected?>><?=$deptName?></option>
            <?
            }?>
            </select>
        </td>
        
      <td align="left" valign="top">Λόγος Επικοινωνίας:</td>
      <td><select name="topicId" style="width:250px;"> <option value="" >Όλοι οι Λόγοι Επικοινωνίας</option>
          <?
                //Showing only departments the user has access to...
                $sql='SELECT topic_id,topic,isactive FROM '.TOPIC_TABLE.' ORDER BY topic';
                
                $topics= db_query($sql);
                while (list($topicId,$topicName) = db_fetch_row($topics)){
                $selected = ($_GET['topicId']==$topicId)?'selected':''; ?>
                <option value="<?=$topicId?>"<?=$selected?>><?=$topicName?></option>
            <?
            }?>
            </select>
        </td>
        
    </tr>
    </table>
    <table>
    <tr>
        <td>Κατάσταση:</td><td>
        <select name="status">
            <option value='any' selected >Οποιαδήποτε Κατάσταση</option>
            <option value="open" <?=!strcasecmp($_REQUEST['status'],'Open')?'selected':''?>>Ανοιχτό</option>
            <option value="overdue" <?=!strcasecmp($_REQUEST['status'],'overdue')?'selected':''?>>Εκπρόθεσμο</option>
            <option value="closed" <?=!strcasecmp($_REQUEST['status'],'Closed')?'selected':''?>>Κλειστό</option>
        </select>
        </td>
        
         <td>Δημοσίευση:</td><td>
        <select name="publishstatus">
            <option value='' selected >Οποιαδήποτε Κατάσταση</option>
            <option value="0" <?=!strcasecmp($_REQUEST['publishstatus'],'0')?'selected':''?>>Μη δημοσιεύσιμο</option>
            <option value="1" <?=!strcasecmp($_REQUEST['publishstatus'],'1')?'selected':''?>>Πρός Έγκριση</option>
            <option value="2" <?=!strcasecmp($_REQUEST['publishstatus'],'2')?'selected':''?>>Εγκεκριμένο</option>
            <option value="3" <?=!strcasecmp($_REQUEST['publishstatus'],'3')?'selected':''?>>Αππορίφθηκε</option>
        </select>
        </td>
        
        
     </tr>
  
    </table>
    <div>
        &nbsp;Ημερομηνία (Από-Μέχρι):
        &nbsp;From&nbsp;<input id="sd" name="startDate" value="<?=Format::htmlchars($_REQUEST['startDate'])?>" 
                onclick="event.cancelBubble=true;calendar(this);" autocomplete=OFF>
            <a href="#" onclick="event.cancelBubble=true;calendar(getObj('sd')); return false;"><img src='images/cal.png'border=0 alt=""></a>
            &nbsp;&nbsp; to &nbsp;&nbsp;
            <input id="ed" name="endDate" value="<?=Format::htmlchars($_REQUEST['endDate'])?>" 
                onclick="event.cancelBubble=true;calendar(this);" autocomplete=OFF >
                <a href="#" onclick="event.cancelBubble=true;calendar(getObj('ed')); return false;"><img src='images/cal.png'border=0 alt=""></a>
            &nbsp;&nbsp;
    </div>
    <table>
    <tr>
     
       <td colspan="3">Ταξινόμηση ανά:</td><td>
        <? 
         $sort=$_GET['sort']?$_GET['sort']:'date';
        ?>
        <select name="sort">
    	    <option value="ID" <?= $sort== 'ID' ?'selected':''?>>Αριθμός Μηνύματος #</option>
            <option value="pri" <?= $sort == 'pri' ?'selected':''?>>Προτεραιότητα</option>
            <option value="date" <?= $sort == 'date' ?'selected':''?>>Ημερομηνία</option>
            <option value="dept" <?= $sort == 'dept' ?'selected':''?>>Φορέας</option>
        </select>
        <select name="order">
            <option value="DESC"<?= $_REQUEST['order'] == 'DESC' ?'selected':''?>>Φθίνουσα</option>
            <option value="ASC"<?= $_REQUEST['order'] == 'ASC'?'selected':''?>>Αύξουσα</option>
        </select>
       </td>
        <td>Αποτελέσματα ανά Σελίδα:</td><td>
        <select name="limit">
        <?
         $sel=$_REQUEST['limit']?$_REQUEST['limit']:20;
         for ($x = 5; $x <= 25; $x += 5) {?>
            <option  value="<?=$x?>" <?=($sel==$x )?'selected':''?>><?=$x?></option>
        <?}?>
        </select>
     </td>
     <td>
     <input type="submit" name="advance_search" class="button" value="Αναζήτηση"><br>
       &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
       <div style="float:right;">
       	[ <a href="#" onClick="showHide('advance','basic'); return false;"  >Βασικό</a> ]
       </div>
       
    </td>
  </tr>
 </table>
 </form>
</div>
<script type="text/javascript">

    var options = {
        script:"ajax.php?api=tickets&f=search&limit=10&",
        varname:"input",
        shownoresults:false,
        maxresults:10,
        callback: function (obj) { document.getElementById('query').value = obj.id; document.forms[0].submit();}
    };
    var autosug = new bsn.AutoSuggest('query', options);
</script>
<!-- SEARCH FORM END -->
<div style="margin-bottom:20px">
 <table width="100%" border="0" cellspacing=0 cellpadding=0 align="center">
    <tr>
        <td width="80%" class="msg" >&nbsp;<b><?=$showing?>&nbsp;&nbsp;&nbsp;<?=$results_type?></b></td>
        <td nowrap style="text-align:right;padding-right:20px;">
            <a href=""><img src="images/refresh.gif" alt="Refresh" border=0></a>
        </td>
    </tr>
 </table>
 <table width="100%" border="0" cellspacing=1 cellpadding=2>
    <form action="tickets.php" method="POST" name='tickets' onSubmit="return checkbox_checker(this,1,0);">
    <input type="hidden" name="a" value="mass_process" >
    <input type="hidden" name="status" value="<?=$statusss?>" >
    <tr><td>
       <table width="100%" border="0" cellspacing=0 cellpadding=2 class="dtable" align="center">
        <tr>
            <?if($canDelete || $canClose) {?>
	        <th width="8px">&nbsp;</th>
            <?}?>
	        <th width="70" >
                <a href="tickets.php?sort=ID&order=<?=$negorder?><?=$qstr?>" title="Sort By Ticket ID <?=$negorder?>">Μήνυμα</a></th>
	        <th width="70">
                <a href="tickets.php?sort=date&order=<?=$negorder?><?=$qstr?>" title="Ταξινόμηση με βάση την ημερομηνία <?=$negorder?>">Ημερομηνία</a></th>
	        <th width="280">Θέμα</th>
	        <th width="120">
                <a href="tickets.php?sort=dept&order=<?=$negorder?><?=$qstr?>" title="Ταξινόμηση με βάση τον φορέα  <?=$negorder?>">Φορέας</a></th>
	        <th width="70">
                <a href="tickets.php?sort=pri&order=<?=$negorder?><?=$qstr?>" title="Ταξινόμηση με βάση την προτεραιότητα  <?=$negorder?>">Προτεραιότητα</a></th>
            <th width="180" >Από</th>
        </tr>
        <?
        $class = "row1";
        $total=0;
        if($tickets_res && ($num=db_num_rows($tickets_res))):
            while ($row = db_fetch_array($tickets_res)) {
                $tag=$row['staff_id']?'assigned':'openticket';
                $flag=null;
                if($row['lock_id'])
                    $flag='locked';
                elseif($row['staff_id'])
                    $flag='assigned';
                elseif($row['isoverdue'])
                    $flag='overdue';
 
                $tid=$row['ticketID'];
                $subject = Format::truncate($row['subject'],120);
                $messagefrom = Format::truncate($row['name'].'&nbsp;'.$row['lastname'],80,strpos($row['name'].'&nbsp;'.$row['lastname'],'@'));
				//var_dump($row);
				if (!($row['legalname']==''))
				   $messagefrom = Format::truncate($row['legalname'],80,strpos($row['legalname'],'@'));
                $publishtitle='';
            switch ($row['publish']) {
						    case 0:
						        $publishtitle= "Το μήνυμα δεν θα δημοσιευτεί";
						        break;
						    case 1:
						        $publishtitle="Το μήνυμα απαιτεί έγκριση για να δημοσιευτεί";
						        break;
						    case 2:
						        $publishtitle= "Το μήνυμα έχει εγκριθεί για δημοσίευση";
						        break;
						    case 3:
						        $publishtitle= "Το μήνυμα έχει αππροιφθεί για δημοσίευση";
						        break;
						}
                if (($row['name']=='') && ($row['lastname']=='') && ($row['legalname']=='')) $messagefrom='Ανωνυμος';
				
               // if (strlen($messagefrom)<15) $messagefrom='Ανωνυμος';
                if(!strcasecmp($row['status'],'open') && !$row['isanswered'] && !$row['lock_id']) {
                    $tid=sprintf('<b>%s</b>',$tid);
                    //$subject=sprintf('<b>%s</b>',Format::truncate($row['subject'],40)); // Making the subject bold is too much for the eye
                }
                ?>
            <tr class="<?=$class?> " id="<?=$row['ticket_id']?>">
                <?if($canDelete || $canClose) {?>
                <td align="center" class="nohover">
                    <input type="checkbox" name="tids[]" value="<?=$row['ticket_id']?>" onClick="highLight(this.value,this.checked);">
                </td>
                <?}?>
                <td align="center" title="<?=$row['email']?>" nowrap>
                
                 <a class="Icon ticketPublish<?=strtolower($row['publish'])?>" title="<?=$publishtitle?>" 
                    href="tickets.php?id=<?=$row['ticket_id']?>">&nbsp;</a>
            
                  <a class="Icon <?=strtolower($row['source'])?>Ticket" title="<?=$row['source']?> Ticket: <?=$row['email']?>" 
                    href="tickets.php?id=<?=$row['ticket_id']?>"><?=$tid?></a>
                    
                </td>
                <td align="center" nowrap><?=Format::db_date($row['created'])?></td>
                <td><a <?if($flag) { ?> class="Icon <?=$flag?>Ticket" title="<?=ucfirst($flag)?> Ticket" <?}?> 
                    href="tickets.php?id=<?=$row['ticket_id']?>"><?=$subject?></a>
                    &nbsp;<?=$row['attachments']?"<span class='Icon file'>&nbsp;</span>":''?></td>
                <td nowrap><?=Format::truncate($row['dept_name'],50)?></td>
                <td class="nohover" align="center" style="background-color:<?=$row['priority_color']?>;"><?=$row['priority_desc']?></td>
                <td nowrap><?=$messagefrom ?>&nbsp;</td>
            </tr>
            <?
            $class = ($class =='row2') ?'row1':'row2';
            } //end of while.
        else: //not tickets found!! ?> 
            <tr class="<?=$class?>"><td colspan=8><b>Η αναζήτηση επέστρεψε 0 αποτελέσματα.</b></td></tr>
        <?
        endif; ?>
       </table>
    </td></tr>
    <?
    if($num>0){ //if we actually had any tickets returned.
    ?>
        <tr><td style="padding-left:20px">
            <?if($canDelete || $canClose) { ?>
            Επιλογή:
                <a href="#" onclick="return select_all(document.forms['tickets'],true)">Όλα</a>&nbsp;
                <a href="#" onclick="return reset_all(document.forms['tickets'])">Κανένα</a>&nbsp;
                <a href="#" onclick="return toogle_all(document.forms['tickets'],true)">Εναλλαγή</a>&nbsp;
            <?}?>
            σελίδα:<?=$pageNav->getPageLinks()?>
        </td></tr>
        <? if($canClose or $canDelete) { ?>
        <tr><td align="center"> <br>
            <?
            $status=$_REQUEST['status']?$_REQUEST['status']:$status;

            switch (strtolower($status)) {
                case 'closed': ?>
                    <input class="button" type="submit" name="reopen" value="Άνοιγμα εκ νέου"
                        onClick=' return confirm("Είστε σίγουρος/η ότι θέλετε να ανοίξετε τα επιλεγμένα μηνύματα;");'>
                    <?
                    break;
                case 'open':
                case 'answered':
                case 'assigned':
                    ?>
                    <!--
                    <input class="button" type="submit" name="overdue" value="Εκπρόθεσμο"
                        onClick=' return confirm("Είστε σίγουρος/η ότι θέλετε να μαρκάρετε τα επιλεγμένα μηνύματα ως εκπρόθεσμα;");'>
                    -->
                    <input class="button" type="submit" name="close" value="Κλείσιμο"
                        onClick=' return confirm("Είστε σίγουρος/η ότι θέλετε να κλείσετε τα επιλεγμένα μηνύματα;");'>
                    <?
                    break;
                default: //search??
                    ?> 
                    <input class="button" type="submit" name="close" value="Κλείσιμο"
                        onClick=' return confirm("Είστε σίγουρος/η ότι θέλετε να κλείσετε τα επιλεγμένα μηνύματα;");'>
                    <input class="button" type="submit" name="reopen" value="Άνοιγμα εκ νέου"
                        onClick=' return confirm("Είστε σίγουρος/η ότι θέλετε να ανοίξετε τα επιλεγμένα μηνύματα;");'>
            <?
            }
            if($canDelete) {?>
                <input class="button" type="submit" name="delete" value="Διαγραφή" 
                    onClick=' return confirm("Είστε σίγουρος/η ότι θέλετε να ΔΙΑΓΡΑΨΕΤΕ τα επιλεγμένα μηνύματα;");'>
            <?}?>
        </td></tr>
        <? }
    } ?>
    </form>
 </table>
</div>

<?
