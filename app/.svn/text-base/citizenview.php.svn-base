<?php
/*********************************************************************
    citizenview.php
**********************************************************************/

require('client.inc.php');

require_once(INCLUDE_DIR.'class.ticket.php');
require_once(INCLUDE_DIR.'class.utils.php');
require_once(INCLUDE_DIR.'class.config.php');

include(CLIENTINC_DIR.'formheader.inc.php');


$qstr='&'; //Query string collector
if($_REQUEST['status']) { //Query string status has nothing to do with the real status used below; gets overloaded.
    $qstr.='status='.urlencode($_REQUEST['status']);
}

//See if this is a search
$search=$_REQUEST['a']=='search'?true:false;
$searchTerm='';

//See if this is a Filter
$filter=$_REQUEST['a']=='filter'?true:false;

//make sure the search query is 3 chars min...defaults to no query with warning message
if($search) {
  $searchTerm=$_REQUEST['query'];
  if( ($_REQUEST['query'] && strlen($_REQUEST['query'])<3) 
      || (!$_REQUEST['query'] && isset($_REQUEST['basic_search'])) ){ //W...
      $search=false; //Instead of an error page...default back to regular query..with no search.
      $errors['err']='Search term must be more than 3 chars';
      $searchTerm='';
  }
}
$showoverdue=$showanswered=false;
$staffId=0; //Nothing for now...TODO: Allow admin and manager to limit tickets to single staff level.
//Get status we are actually going to use on the query...making sure it is clean!
 $status='closed';
 $showoverdue=true;
   $results_type='Μηνύματα';


//  we need to switch queues on the fly! depending on stats fetched on the parent.
if($stats) { 
    if(!$stats['open'] && (!$status || $status=='open')){
        if(!$cfg->showAnsweredTickets() && $stats['answered']) {
             $status='open';
             $showanswered=true;
             $results_type='Μηνύματα Υπο Επεξεργασία';
        }elseif(!$stats['answered']) { //no open or answered tickets (+-queue?) 
            $status='closed';
            $results_type='Κλειστά Μηνύματα';
        }
    }
}


$qwhere.=' WHERE publish=2 '; 

if ($filter):

 $qstr.='&a='.urlencode($_REQUEST['a']);
 $qstr.='&t='.urlencode($_REQUEST['t']);
    
 	//department
    if($_REQUEST['dept'] ) {
   
        $qwhere.=' AND ticket.dept_id='.db_input($_REQUEST['dept']);
        $qstr.='&dept='.urlencode($_REQUEST['dept']);
    }
    
 	//topicid
 	if ($_REQUEST['topicid']) {

        $qwhere.=' AND ticket.topic_id='.db_input($_REQUEST['topicid']);
        $qstr.='&topicid='.urlencode($_REQUEST['topicid']);
 	}
    
 	//period
 	if ($_REQUEST['period']) {
 		if ($_REQUEST['period']>0)
 		{
 		
        $qwhere.=' AND ticket.created >= date_sub(curdate(), interval '.db_input($_REQUEST['period']).' day)';
        $qstr.='&period='.urlencode($_REQUEST['period']);
 		}
 	}
 	
endif; //if ($filter)


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
        }else{//Deep search!
            
            
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
    if($_REQUEST['dept'] ) {

        $qwhere.=' AND ticket.dept_id='.db_input($_REQUEST['dept']);
        $qstr.='&dept='.urlencode($_REQUEST['dept']);
    }
    //dates
    $startTime  =($_REQUEST['startDate'] && (strlen($_REQUEST['startDate'])>=8))?strtotime($_REQUEST['startDate']):0;
    $endTime    =($_REQUEST['endDate'] && (strlen($_REQUEST['endDate'])>=8))?strtotime($_REQUEST['endDate']):0;
    if( ($startTime && $startTime>time()) or ($startTime>$endTime && $endTime>0)){
        $errors['err']='Entered date span is invalid. Selection ignored.';
        $startTime=$endTime=0;
    }else{
   
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
$pagelimit=$_GET['limit']?$_GET['limit']:20;
$pagelimit=$pagelimit?$pagelimit:PAGE_LIMIT; //true default...if all fails.
$page=($_GET['p'] && is_numeric($_GET['p']))?$_GET['p']:1;

$qselect = 'SELECT DISTINCT ticket.ticket_id,lock_id,ticketID,ticket.dept_id,ticket.topic_id,ticket.helptopic,ticket.yphresia,ticket.staff_id,subject,name,lastname,email,dept_name '.
           ',ticket.status,ticket.source,isoverdue,isanswered, ticket.created,pri.* ,count(attach.attach_id) as attachments, LEFT(message.message,40) as message ';
$qfrom=' FROM '.TICKET_TABLE.' ticket '.
       ' LEFT JOIN '.DEPT_TABLE.' dept ON ticket.dept_id=dept.dept_id ';

if($search && $deep_search) {
    $qfrom.=' LEFT JOIN '.TICKET_MESSAGE_TABLE.' message ON (ticket.ticket_id=message.ticket_id )';
    $qfrom.=' LEFT JOIN '.TICKET_RESPONSE_TABLE.' response ON (ticket.ticket_id=response.ticket_id )';
    $qfrom.=' LEFT JOIN '.TICKET_NOTE_TABLE.' note ON (ticket.ticket_id=note.ticket_id )';
}

$qgroup=' GROUP BY ticket.ticket_id';
//get ticket count based on the query so far..
$total=db_count("SELECT count(DISTINCT ticket.ticket_id) $qfrom $qwhere");

//pagenate
$pageNav=new Pagenate($total,$page,$pagelimit,'citizenview.php');
$pageNav->setURL('citizenview.php',$qstr.'&sort='.urlencode($_REQUEST['sort']).'&order='.urlencode($_REQUEST['order']));
//

$qselect.=' ,count(attach.attach_id) as attachments, IF(ticket.reopened is NULL,ticket.created,ticket.reopened) as effective_date';
$qfrom.=' LEFT JOIN '.TICKET_PRIORITY_TABLE.' pri ON ticket.priority_id=pri.priority_id '.
        ' LEFT JOIN '.TICKET_MESSAGE_TABLE.' message ON (ticket.ticket_id=message.ticket_id )'.
        ' LEFT JOIN '.TICKET_LOCK_TABLE.' tlock ON ticket.ticket_id=tlock.ticket_id AND tlock.expire>NOW() '.
        ' LEFT JOIN '.TICKET_ATTACHMENT_TABLE.' attach ON  ticket.ticket_id=attach.ticket_id ';

$query="$qselect $qfrom $qwhere $qgroup ORDER BY $order_by $order LIMIT ".$pageNav->getStart().",".$pageNav->getLimit();

$tickets_res = db_query($query);
$showing=db_num_rows($tickets_res)?$pageNav->showing():"";

if(!$results_type) { 
    $results_type=($search)?'Αποτελέσματα Αναζήτησης':(openPadUtils::getTranslation("status_plural",ucfirst($status))).' Μηνύματα';
}
$negorder=$order=='DESC'?'ASC':'DESC'; 

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

<!-- FILTER FORM START -->
<div id='filter' style='display:block;'?>

<form id="filterform" name="filterform" action="citizenview.php" method="get">
 <input type="hidden" name="a" value="filter">
  <table>
  <tr>
 
   <td>Φορέας:</td>
        <td><select id="fdept" name="dept" style="width:250px;" onchange="applyFilters();"><option value=0 >Όλοι οι Φορείς</option>
            <?
                
                $sql='SELECT dept_id,dept_name FROM '.DEPT_TABLE;
                $depts= db_query($sql);
                
                while (list($deptId,$deptName) = db_fetch_row($depts)){
                $selected = ($_GET['dept']==$deptId)?'selected':''; ?>
                <option value="<?=$deptId?>"<?=$selected?>><?=$deptName?></option>
            <?
            }?>
            </select>
        </td>
        
    <td align="left" valign="top">Λόγος Επικοινωνίας:</td>
      <td><select id="ftopicid" name="topicid" onchange="applyFilters();">
          <option value="">Όλοι</option>
          <?
          		
          		$sql='SELECT topic_id,topic FROM '.TOPIC_TABLE.' WHERE isactive=1 ORDER BY topic';
    			$services= db_query($sql);
  
                 while (list($topicId,$topic) = db_fetch_row($services)){
                    $selected = ($_GET['topicid']==$topicId)?'selected':''; ?>
          <option value="<?=$topicId?>"<?=$selected?>><?=$topic?></option>
          <?
            }?>
        </select>
      </td>
      
       <td align="left" valign="top">Ημερομηνία :</td>
      <td><select id="fperiod" name="period" onchange="applyFilters();">
          <option value="0" <?=($_GET['period']==0)?'selected':''; ?> >Όλα</option>
          <option value="1" <?=($_GET['period']==1)?'selected':''; ?> >Σημερινά</option>
          <option value="7" <?=($_GET['period']==7)?'selected':''; ?> >Την τελευταία εβδομάδα</option>
          <option value="30" <?=($_GET['period']==30)?'selected':''; ?> >Τον τελευταίο μήνα</option>
            
       
        </select>
      </td>
      <td>
      	&nbsp;	 <a href="javascript:clearFilters();" title="Ακύρωση όλων των φίλτρων"><img src="./images/icons/clearfilters.png" alt="Clear" border=0></a>
      </td>
  </tr>
  </table>
  </form>
</div>
<!-- FILTER FORM END -->


<script type="text/javascript">

   function openDialog(id)
   {
	   $('#msgdialog').load('citizenviewmessagepreview.php?id='+id)
		.dialog({
			width : 600,
			height: 500,
			maxWidth: 800,
			maxHeight: 600,
			minWidth: 400,
			minHeight: 400,
			show: 'slide',
			autoOpen: false,
			closeOnEscape: true,
			title: 'Εμφάνιση Μηνύματος με αριθμό: #'+id
		});

		$('#msgdialog').dialog('open');
		
   }
    var options = {
        script:"ajax.php?api=tickets&f=search&limit=10&",
        varname:"input",
        shownoresults:false,
        maxresults:10,
        callback: function (obj) { document.getElementById('query').value = obj.id; document.forms[0].submit();}
    };
    var autosug = new bsn.AutoSuggest('query', options);

    function showHide(){

    	for (var i=0; i<showHide.arguments.length; i++){
            toggleLayer(showHide.arguments[i]);
    	}
        return false;
    }

    function toggleLayer(whichLayer) {
        var elem, vis;

        if( document.getElementById ) // this is the way the standards work
            elem = document.getElementById( whichLayer );
        else if( document.all ) // this is the way old msie versions work
            elem = document.all[whichLayer];
        else if( document.layers ) // this is the way nn4 works
            elem = document.layers[whichLayer];
      
        vis = elem.style;
        // if the style.display value is blank we try to figure it out here
        if(vis.display==''&&elem.offsetWidth!=undefined&&elem.offsetHeight!=undefined)
            vis.display = (elem.offsetWidth!=0&&elem.offsetHeight!=0)?'block':'none';
        vis.display = (vis.display==''||vis.display=='block')?'none':'block';
    }

    function applyFilters() {

    	$("#filterform").submit();
    }

    function setFilter(fname , fvalue)
    {
    	fname="#"+fname;

    	$(fname).val(fvalue);
    	$("#filterform").submit();
    	
    }

    function clearFilters()
    {
    	$("#fperiod").val(0);
    	$("#fdept").val(0);
    	$("#ftopicid").val('');
    	$("#filterform").submit();
    }
    
</script>
<!-- SEARCH FORM END -->

<!--  ITEMS DISPLAY START -->
<div style="margin-bottom:20px;margin-top:20px;">

<div class="pz_list">
		<div class="pz_top">
		<div class="pz_title">	
		&nbsp;<b><?=$showing?>&nbsp;&nbsp;&nbsp;<?=$results_type?></b>
		&nbsp;	 <a href="" title="Ανανέωση" ><img src="./images/icons/refresh.gif" alt="Refresh" border=0></a>
		
		</div>
			<!-- SEARCH FORM START -->
			<div id='basic' style="display:<?=$basic_display?'block':'none'?>">
			    <form action="citizenview.php" method="get">
			    <input type="hidden" name="a" value="search">
			    <table>
			        <tr>
			            <td>Αναζήτηση: </td>
			            <td><input type="text" id="query" name="query" size=30 value="<?=Format::htmlchars($_REQUEST['query'])?>"></td>
			            <td><input type="submit" name="basic_search" class="button" value="Αναζήτηση">
			             <!-- &nbsp;[<a href="#" onClick="showHide('basic','advance'); return false;">Προχωρημένο</a> ]  -->
			             </td> 
			            
			        </tr>
			    </table>
			    </form>
			</div>
			<div id='advance' style="display:<?=$basic_display?'none':'block'?>">
			 <form action="citizenview.php" method="get">
			 <input type="hidden" name="a" value="search">
			  <table>
			    <tr>
			        <td>Αναζήτηση: </td><td><input type="text" id="query" name="query" value="<?=Format::htmlchars($_REQUEST['query'])?>"></td>
			        <td>Φορέας:</td>
			        <td><select name="dept" style="width:250px;"><option value=0 >Όλοι οι Φορείς</option>
			            <?
			                //Showing only departments the user has access to
			                $sql='SELECT dept_id,dept_name FROM '.DEPT_TABLE;
			               
			                $depts= db_query($sql);
			                while (list($deptId,$deptName) = db_fetch_row($depts)){
			                $selected = ($_GET['dept']==$deptId)?'selected':''; ?>
			                <option value="<?=$deptId?>"<?=$selected?>><?=$deptName?></option>
			            <?
			            }?>
			            </select>
			        </td>
			        <td>Κατάσταση:</td><td>
			    
			        <select name="status">
			            <option value='any' selected >Οποιαδήποτε Κατάσταση</option>
			            <option value="open" <?=!strcasecmp($_REQUEST['status'],'Open')?'selected':''?>>Ανοιχτό</option>
			            <option value="overdue" <?=!strcasecmp($_REQUEST['status'],'overdue')?'selected':''?>>Εκπρόθεσμο</option>
			            <option value="closed" <?=!strcasecmp($_REQUEST['status'],'Closed')?'selected':''?>>Κλειστό</option>
			        </select>
			        </td>
			     </tr>
			    </table>
			    <div>
			        Ημερομηνία (Από-Μέχρι):
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
			       <td>Τύπος:</td>
			       <td>       
			        <select name="stype">
			            <option value="LIKE" <?=(!$_REQUEST['stype'] || $_REQUEST['stype'] == 'LIKE') ?'selected':''?>>Με Ομοιότητα (%)</option>
			            <option value="FT"<?= $_REQUEST['stype'] == 'FT'?'selected':''?>>Πλήρες Κείμενο</option>
			        </select>
			 
			
			       </td>
			       <td>Ταξινόμηση ανά:</td><td>
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
			         $sel=$_REQUEST['limit']?$_REQUEST['limit']:15;
			         for ($x = 5; $x <= 25; $x += 5) {?>
			            <option  value="<?=$x?>" <?=($sel==$x )?'selected':''?>><?=$x?></option>
			        <?}?>
			        </select>
			     </td>
			     <td>
			     <input type="submit" name="advance_search" class="button" value="Search"><br>
			       &nbsp;[ <a href="#" onClick="showHide('advance','basic'); return false;" >Βασικό</a> ]
			    </td>
			  </tr>
			 </table>
			 </form>
			</div>
		
		
		
		</div>

		<div class="pz_pagination">
				         Σελίδα:<?=$pageNav->getPageLinks()?>
		</div>
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
               
                if(!strcasecmp($row['status'],'open') && !$row['isanswered'] && !$row['lock_id']) {
                    $tid=sprintf('<b>%s</b>',$tid);
                    
                }
                
 $subject = Format::truncate($row['message'],80);
 $topic = Format::truncate($row['helptopic'],60) ;
 $foreas = Format::truncate($row['dept_name'],100);
 $yphresia=Format::truncate($row['yphresia'],100);
 $citizenname=Format::truncate($row['name'].'&nbsp;'.$row['lastname'],80,strpos($row['name'].'&nbsp;'.$row['lastname'],'@'));
 if ($row['name']=='' || $row['name']==null)
 {
 	$citizenname="Ανώνυμος";
 }

?>
		
		<div class="pz_item">
		
			<div class="pz_item_top">
				<span class="pz_date">
					<?=Format::db_date($row['created'])?>
				</span>
				<span class="pz_name">
					<?=$citizenname?>
				</span>
				<span class="pz_reason">
					
					<a href="javascript:setFilter('ftopicid','<?=$row['topic_id']?>')" title="Όλα τα μηνύματα αυτού του τύπου" >	<?=$topic?></a>
				</span>
				<span class="pz_more">
					<a href="citizenviewmessage.php?id=<?=$row['ticket_id']?>">Περισσότερα &raquo;</a>
				</span>
			</div>
			
			<div class="pz_item_bottom">
				<div class="pz_item_bottom_left">
					<span class="pz_ministry">
						<a href="javascript:setFilter('fdept','<?=$row['dept_id']?>')" title="Όλα τα μηνύματα αυτού του φορέα" >	<?=$foreas?></a>
					</span>
					<span class="pz_service">
						<a href="#" title="Πολεοδομία" >	<?=$yphresia?></a>
					</span>
				</div>
				<div class="pz_item_bottom_right">
					<span class="pz_message">
							<?=$subject?>
						<span class="pz_preview">[<a  href="javascript:openDialog(<?=$row['ticket_id']?>);">Προεπισκόπηση &raquo;</a>]</span>
					</span>
				</div>
			</div>
			
		</div>
		
		  <?
            $class = ($class =='row2') ?'row1':'row2';
            } //end of while.
        else: //not tickets found!! ?> 
            <tr class="<?=$class?>"><td colspan=8><b>Η αναζήτηση επέστρεψε 0 αποτελέσματα.</b></td></tr>
        <?
        endif; ?>
        
	
		<div class="pz_pagination">
		         Σελίδα:<?=$pageNav->getPageLinks()?>
		</div>
		
	</div>


 
</div>
<!--  ITEMS DISPLAY END -->

<div id='msgdialog'></div>


<?

include(CLIENTINC_DIR.'footer2.inc.php');

?>
