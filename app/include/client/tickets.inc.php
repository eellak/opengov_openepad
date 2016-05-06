<?php
if(!defined('OSTCLIENTINC') || !is_object($thisclient) || !$thisclient->isValid()) die('Kwaheri');

//Get ready for some deep shit.
$qstr='&'; //Query string collector
$status=null;
if($_REQUEST['status']) { //Query string status has nothing to do with the real status used below.
    $qstr.='status='.urlencode($_REQUEST['status']);
    //Status we are actually going to use on the query...making sure it is clean!
    switch(strtolower($_REQUEST['status'])) {
     case 'open':
     case 'closed':
        $status=$_REQUEST['status'];
        break;
     default:
        $status=''; //ignore
    }
}

//Restrict based on email of the user...STRICT!
$qwhere =' WHERE email='.db_input($thisclient->getEmail());

//STATUS
if($status){
    $qwhere.=' AND status='.db_input($status);    
}

$sortOptions=array('date'=>'ticket.created','ID'=>'ticketID','pri'=>'priority_id','dept'=>'dept_name');
$orderWays=array('DESC'=>'DESC','ASC'=>'ASC');

//Sorting options...
if($_REQUEST['sort']) {
        $order_by =$sortOptions[$_REQUEST['sort']];
}
if($_REQUEST['order']) {
    $order=$orderWays[$_REQUEST['order']];
}
if($_GET['limit']){
    $qstr.='&limit='.urlencode($_GET['limit']);
}

$order_by =$order_by?$order_by:'ticket.created';
$order=$order?$order:'DESC';
$pagelimit=$_GET['limit']?$_GET['limit']:PAGE_LIMIT;
$page=($_GET['p'] && is_numeric($_GET['p']))?$_GET['p']:1;

$qselect = 'SELECT ticket.ticket_id,ticket.ticketID,ticket.dept_id,isanswered,ispublic,subject,name,email '.
           ',dept_name,status,source,priority_id ,ticket.created ';
$qfrom=' FROM '.TICKET_TABLE.' ticket LEFT JOIN '.DEPT_TABLE.' dept ON ticket.dept_id=dept.dept_id ';
//Pagenation stuff....wish MYSQL could auto pagenate 
$total=db_count('SELECT count(*) '.$qfrom.' '.$qwhere);
$pageNav=new Pagenate($total,$page,$pagelimit);
$pageNav->setURL('view.php',$qstr.'&sort='.urlencode($_REQUEST['sort']).'&order='.urlencode($_REQUEST['order']));

//Ok..lets roll...create the actual query
$qselect.=' ,count(attach_id) as attachments ';
$qfrom.=' LEFT JOIN '.TICKET_ATTACHMENT_TABLE.' attach ON  ticket.ticket_id=attach.ticket_id ';
$qgroup=' GROUP BY ticket.ticket_id';
$query="$qselect $qfrom $qwhere $qgroup ORDER BY $order_by $order LIMIT ".$pageNav->getStart().",".$pageNav->getLimit();
//echo $query;
$tickets_res = db_query($query);
$showing=db_num_rows($tickets_res)?$pageNav->showing():"";
$results_type=($status)?ucfirst($status).' Μηνύματα':' Όλα τα μηνύματα';
$negorder=$order=='DESC'?'ASC':'DESC'; //Negate the sorting..
?>
<div class="mainformtitle">
	Προβολή Μηνυμάτων
</div>
<div class="rslider">
<div class="singlebig">
    <?if($errors['err']) {?>
        <p align="center" id="errormessage"><?=$errors['err']?></p>
    <?}elseif($msg) {?>
        <p align="center" id="infomessage"><?=$msg?></p>
    <?}elseif($warn) {?>
        <p id="warnmessage"><?=$warn?></p>
    <?}?>

 <div class="msg"><?=$showing?>&nbsp;&nbsp;<?=$results_type?></div>
 <p class="viewactions">
	            <a href="view.php?status=open"><img src="images/view_open_btn.gif" alt="Εκκρεμή Μηνύματα" border=0></a>            
            <a href="view.php?status=closed"><img src="images/view_closed_btn.gif" alt="Διεκπεραιωμένα Μηνύματα" border=0></a>            
            <a href=""><img src="images/refresh_btn.gif" alt="Ανανέωση" border=0></a>
<?php 			
 if($thisclient && is_object($thisclient) && $thisclient->isValid()) {?>
<a class="log_out" href="logout.php">Έξοδος</a> 
<?php  } ?>
 </p>
 
<center>
 <table width="100%" border="0" cellspacing=0 cellpadding=2>
    <tr><td>
     <table border="0" cellspacing=0 cellpadding=2 class="tgrid" align="center">
        <tr>
	        <th width="70" nowrap>
                <a href="view.php?sort=ID&order=<?=$negorder?><?=$qstr?>" title="Sort By Ticket ID <?=$negorder?>">Μήνυμα #</a></th>
	        <th width="100">
                <a href="view.php?sort=date&order=<?=$negorder?><?=$qstr?>" title="Sort By Date <?=$negorder?>">Δημιουργήθηκε</a></th>
            <?
			//commented out by stav on 15-06-2011
            //<th width="60">Κατάσταση</th>
			?>
            <th width="240">Θέμα</th>
            <th width="350">
                <a href="view.php?sort=dept&order=<?=$negorder?><?=$qstr?>" title="Sort By Category <?=$negorder?>">Φορέας</a></th>
        </tr>
        <?
        $class = "row1";
        $total=0;
        if($tickets_res && ($num=db_num_rows($tickets_res))):
            $defaultDept=Dept::getDefaultDeptName();
            while ($row = db_fetch_array($tickets_res)) {
                $dept=$row['ispublic']?$row['dept_name']:$defaultDept; //Don't show hidden/non-public depts.
                $subject=Format::htmlchars(Format::truncate($row['subject'],60));
                $ticketID=$row['ticketID'];
                if($row['isanswered'] && !strcasecmp($row['status'],'open')) {
                    $subject="<b>$subject</b>";
                    $ticketID="<b>$ticketID</b>";
                }
                ?>
            <tr class="<?=$class?> " id="<?=$row['ticketID']?>">
                <td align="center" title="<?=$row['email']?>" nowrap>
                    <a class="Icon <?=strtolower($row['source'])?>Ticket" title="<?=$row['email']?>" href="view.php?id=<?=$row['ticketID']?>">
                        <?=$ticketID?></a></td>
                <td nowrap>&nbsp;<?=Format::db_date($row['created'])?></td>
                <?
			//commented out by stav on 15-06-2011
            //<td>&nbsp;<?=ucfirst($row['status'])? //remove this space ></td>
            
            ?>
                <td>&nbsp;<a href="view.php?id=<?=$row['ticketID']?>"><?=$subject?></a>
                    &nbsp;<?=$row['attachments']?"<span class='Icon file'>&nbsp;</span>":''?></td>
                <td nowrap title='<?=$dept?>'>&nbsp;<?=str_replace('ΥΠΟΥΡΓΕΙΟ','Υπ. ',$dept)?></td>
            </tr>
            <?
            $class = ($class =='row2') ?'row1':'row2';
            } //end of while.
        else: //not tickets found!! ?> 
            <tr class="<?=$class?>"><td colspan=7><b>Δεν βρέθηκαν μηνύματα.</b></td></tr>
        <?
        endif; ?>
     </table>
    </td></tr>
    <tr><td>
    <?
    if($num>0 && $pageNav->getNumPages()>1){ //if we actually had any tickets returned?>
     <tr><td style="text-align:left;padding-left:20px">page:<?=$pageNav->getPageLinks()?>&nbsp;</td></tr>
    <?}?>
 </table></center>
	</div>
</div>
<?
