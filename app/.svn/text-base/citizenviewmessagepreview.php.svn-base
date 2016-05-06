<?php
require('client.inc.php');

require_once(INCLUDE_DIR.'class.ticket.php');
require_once(INCLUDE_DIR.'class.utils.php');
require_once(INCLUDE_DIR.'class.config.php');


$id=$_REQUEST['id'];


$query="SELECT t.created,lastmessage, lastresponse , m.message FROM `ost_ticket` t INNER JOIN `ost_ticket_message` m ON t.ticket_id = m.ticket_id WHERE t.ticket_id=".$id;
$ticket_res = db_query($query);

while ($row = db_fetch_array($ticket_res)) {
	echo $row["message"];
 }

?>