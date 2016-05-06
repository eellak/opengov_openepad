<?php
require('client.inc.php');

require_once(INCLUDE_DIR.'class.ticket.php');
require_once(INCLUDE_DIR.'class.utils.php');
require_once(INCLUDE_DIR.'class.config.php');


include(CLIENTINC_DIR.'formheader.inc.php');




$id=$_REQUEST['id'];

//$query=" SELECT DISTINCT ticket.ticket_id,lock_id,ticketID,ticket.dept_id,ticket.topic_id,ticket.helptopic,ticket.yphresia,ticket.staff_id,subject,name,lastname,email,dept_name ,ticket.status,ticket.source,isoverdue,isanswered, ticket.created,pri.* ,count(attach.attach_id) as attachments, LEFT(message.message,40) as message ,count(attach.attach_id) as attachments, IF(ticket.reopened is NULL,ticket.created,ticket.reopened) as effective_date FROM ost_ticket ticket LEFT JOIN ost_department dept ON ticket.dept_id=dept.dept_id LEFT JOIN ost_ticket_priority pri ON ticket.priority_id=pri.priority_id LEFT JOIN ost_ticket_message message ON (ticket.ticket_id=message.ticket_id ) LEFT JOIN ost_ticket_lock tlock ON ticket.ticket_id=tlock.ticket_id AND tlock.expire>NOW() LEFT JOIN ost_ticket_attachment attach ON ticket.ticket_id=attach.ticket_id";
$query="SELECT t.created,lastmessage, lastresponse ,name,lastname,t.yphresia,t.helptopic, m.message , dept.dept_name  FROM `ost_ticket` t LEFT JOIN `ost_ticket_message` m ON t.ticket_id = m.ticket_id LEFT JOIN `ost_department` dept ON t.dept_id=dept.dept_id "; // WHERE t.ticket_id=".$id;
$query.=" WHERE t.publish=2 AND t.ticket_id=".$id;
//$query.=" GROUP BY ticket.ticket_id ORDER BY ticket.closed DESC, ticket.created DESC";


$ticket_res = db_query($query);



$row = db_fetch_array($ticket_res);
	


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

<div>

<a href="javascript:history.back(-1);">Επιστροφή</a>
<div class="pz_view_messagetitle">Μήνυμα #1254</div>
<div class="pz_view_container">

<div class="pz_view_row">

    <div class="pz_view_title">Ημερομηνία</div>
    <div class="pz_view_data"><?=Format::db_date($row['created'])?></div>

</div>


<div class="pz_view_row">

    <div class="pz_view_title">Αποστολέας</div>
    <div class="pz_view_data"><?=$citizenname?></div>

</div>

<div class="pz_view_row">

    <div class="pz_view_title">Λόγος Επικοινωνίας</div>
    <div class="pz_view_data"><?=$topic?></div>

</div>

<div class="pz_view_row">

    <div class="pz_view_title">Φορέας</div>
    <div class="pz_view_data"><?=$foreas?></div>

</div>

<div class="pz_view_row">

    <div class="pz_view_title">Υπηρεσία</div>
    <div class="pz_view_data"><?=$yphresia?></div>

</div>

<div class="pz_view_row">
<!-- Line-->
<hr/>
</div>

<div class="pz_view_row">


	<?=$row["message"] ?>


</div>



<div class="pz_view_row">
<!-- Line-->
<hr/>
</div>

</div>


</div>

<?

include(CLIENTINC_DIR.'footer2.inc.php');

?>