<?php
include_once(INCLUDE_DIR.'wpxmlrpc/class.wpxmlrpc.php');
class wordpressXMLRPC
{
	private $wpx;
	public function __construct() {
  	$this->wpx= new wpxmlrpc(true,'if','if','http://83.212.121.173/drasi3/archive/xmlrpc.php','admin','archive',0,0);

//$this->wpx= new wpxmlrpc("http://83.212.121.173/drasi3/archive/xmlrpc.php","admin","archive");

	}
	public function test($id)
	{
		$sql='select * from '.TICKET_TABLE.' where ticket_id='.$id;
		if(($res=db_query($sql)) && db_num_rows($res))
            var_dump(db_fetch_row($res));
			
	}
	private function isNewPostID($id)
	{
		$sql="select * from ost_wordpress_ids where id_type='post' AND openpad_id=".$id;

		if ($res=db_query($sql))
		{
			$row=db_fetch_array($res);

            if ($row['wordpress_id'])
			{
				return false;
			}
			else
			{
				return true;	
			}
		}
		else
		{
			return false;	
		}
	}
	private function isNewCommentID($id)
	{
		$sql="select * from ost_wordpress_ids where id_type='comment' AND openpad_id=".$id;

		if ($res=db_query($sql))
		{
			$row=db_fetch_array($res);

            if ($row['wordpress_id'])
			{
				return false;
			}
			else
			{
				return true;	
			}
		}
		else
		{
			return false;	
		}
	}

	private function addCommentMeta($comment_id,$data)
	{
        $fields=array_keys($data);
		$values=array_values($data);
		for ($i=0;$i<count($fields);$i++)
		{
			$ret=$this->wpx->insertCommentMeta($comment_id,'openpad_'.$fields[$i],$values[$i]);
		}
	}
	private function addPostMeta($post_id,$data)
	{
        $fields=array_keys($data);
		$values=array_values($data);
		for ($i=0;$i<count($fields);$i++)
		{
			$ret=$this->wpx->insertPostMeta($post_id,'openpad_'.$fields[$i],$values[$i]);
		}
	}
	
	private function getPostTag($id)
	{
	$sql="SELECT * FROM `dict_foreis` WHERE `pb_id` = '".$id."'";

		if(($res=db_query($sql)) && db_num_rows($res))
		{
            $row=db_fetch_array($res);

			return $row['name'];
		}
		else
		{
			return '';	
		}
	}
	
	private function getPostCategories($ticketid)
	{
		$sql='select * from '.TICKET_TABLE.' where ticket_id='.$ticketid;
		if(($res=db_query($sql)) && db_num_rows($res))
            $row=db_fetch_array($res);
		$cats='';

/*
376 - Είδος
    22 - Ανώνυμες
    30 - Επώνυμες
*/
		if ($row['name']=='' & $row['lastname']=='')
		{$cats='22,';} else {$cats='30,';}		
/*
7 - Ιδιότητα
    17 - Δημόσιος Υπάλληλος
    29 - Επιχείρηση
    377 - Ιδιώτης
*/
		if ($row['idiotita']=='1') $cats.='17,';		
		if ($row['idiotita']=='2') $cats.='377,';		
		if ($row['idiotita']=='3') $cats.='29,';		
/*

    379 - Θετική εμπειρία εξυπηρέτησης
    380 - Αρνητική εμπειρία εξυπηρέτησης
    381 - Ιδέα για βελτίωση

	1	Θετική εμπειρία εξυπηρέτησης
	2	Αρνητική εμπειρία εξυπηρέτησης
	3	Ιδέα για βελτίωση
*/

		if ($row['topic_id']=='1') $cats.='379,';		
		if ($row['topic_id']=='2') $cats.='380,';		
		if ($row['topic_id']=='3') $cats.='381,';		

/*
378 - Λόγος Επικοινωνίας
      11  382 - Καλή Διαδικασία
      12  383 - Εξυπηρέτηση Υπαλλήλου
      13  384 - Γνώση Υπαλλήλου στο αντικείμενο
      21  386 - Ταχύτητα εξυπηρέτησης
      22  385 - Ποιότητα εξυπηρέτησης
      23  387 - Προθυμία υπαλλήλου
      24  388 - Ικανότητες υπηρεσίας
      31  389 - Βελτίωση διαδικασίας
      32  390 - Βελτίωση οδηγιών
      33  391 - Θεσμικό πλαίσιο
      34  392 - Εκπαίδευση στελεχών
*/

		if ($row['topicId2']=='11') $cats.='382,';		
		if ($row['topicId2']=='12') $cats.='383,';		
		if ($row['topicId2']=='13') $cats.='384,';		
		if ($row['topicId2']=='21') $cats.='386,';		
		if ($row['topicId2']=='22') $cats.='385,';		
		if ($row['topicId2']=='23') $cats.='387,';		
		if ($row['topicId2']=='24') $cats.='388,';		
		if ($row['topicId2']=='31') $cats.='389,';		
		if ($row['topicId2']=='32') $cats.='390,';		
		if ($row['topicId2']=='33') $cats.='391,';		
		if ($row['topicId2']=='34') $cats.='392,';		

/*
393 - Τρόπος Ενημέρωσης
    396 - Αλληλογραφία
    394 - Με eMail
*/
		if ($row['communication_type']=='Post') $cats.='396,';		
		if ($row['communication_type']=='Email') $cats.='394,';		

/*
15 - Υπουργείο
  3  20 - Αγροτικής Ανάπτυξης και Τροφίμων
  5  24 - Δικαιοσύνης, Διαφάνειας και Ανθρωπίνων Δικαιωμάτων
  6  25 - Εθνικής Άμυνας
  10  28 - Εξωτερικών
  11  31 - Εργασίας και Κοινωνικής Ασφάλισης
  12  32 - Εσωτερικών, Αποκέντρωσης και Ηλεκτρονικής Διακυβέρνησης
  21  38 - Θαλάσσιων Υποθέσεων, Νήσων και Αλιείας
  15  40 - Οικονομικών
  8  41 - Παιδείας, Δια Βίου Μάθησης και Θρησκευμάτων
  16  42 - Περιβάλλοντος, Ενέργειας και Κλιματικής Αλλαγής
  18  43 - Περιφερειακής Ανάπτυξης και Ανταγωνιστικότητας
  17  44 - Πολιτισμού και Τουρισμού
  19  45 - Προστασίας του Πολίτη
  20  46 - Υγείας και Κοινωνικής Αλληλεγγύης
  14  47 - Υποδομών, Μεταφορών και Δικτύων
  0  18 - Χωρίς Υπουργείο / Δεν αφορά Υπουργείο
    16 - Υπουργός Επικρατείας
	
*/
		if ($row['dept_id']==3) $cats.='20';		
		if ($row['dept_id']==5) $cats.='24';		
		if ($row['dept_id']==6) $cats.='25';		
		if ($row['dept_id']==10) $cats.='28';		
		if ($row['dept_id']==11) $cats.='31';		
		if ($row['dept_id']==12) $cats.='32';		
		if ($row['dept_id']==21) $cats.='38';		
		if ($row['dept_id']==15) $cats.='40';		
		if ($row['dept_id']==8) $cats.='41';		
		if ($row['dept_id']==16) $cats.='42';		
		if ($row['dept_id']==18) $cats.='43';		
		if ($row['dept_id']==17) $cats.='44';		
		if ($row['dept_id']==19) $cats.='45';		
		if ($row['dept_id']==20) $cats.='46';		
		if ($row['dept_id']==14) $cats.='47';		
		if ($row['dept_id']==0) $cats.='18';		

	return $cats;
	}


	public function updateWordPressPost($id,$newstatus)
	{

		if ($this->isNewPostID($id))
		{	
		$sql='select * from '.TICKET_TABLE.' where ticket_id='.$id;
		if(($res=db_query($sql)) && db_num_rows($res))
            $ticket_row=db_fetch_array($res);	
		$sql='select * from ost_ticket_message where ticket_id='.$id;
		if(($res=db_query($sql)) && db_num_rows($res))
            $message_row=db_fetch_array($res);

			if ($newstatus==2)
			{
				$postID=$this->wpx->createPost($ticket_row['yphresia'].' - '.$ticket_row['helptopic'],$this->getPostCategories($id),$message_row['message'],1);
				$ret=$this->wpx->addPostTags($postID,$this->getPostTag($ticket_row['yphresia_dimos_id']));
				$this->addPostMeta($postID,$ticket_row);
			if ($postID>0)
			{
				$sql="INSERT INTO `openpad`.`ost_wordpress_ids` (
					`ID` ,
					`id_type` ,
					`wordpress_id` ,
					`openpad_id`
					)
					VALUES (
					NULL , 'post', '".$postID."', '".$id."'
					);";	
				db_query($sql);	
			}
			}
		}
		else
		{
			
		$sql="select * from ost_wordpress_ids where id_type='post' AND openpad_id=".$id;
		if ($res=db_query($sql))
			$wp_row=db_fetch_array($res);
			$oldPostID=$wp_row['wordpress_id'];
		
		$sql='select * from '.TICKET_TABLE.' where ticket_id='.$id;
		if(($res=db_query($sql)) && db_num_rows($res))
            $ticket_row=db_fetch_array($res);

		$sql='select * from ost_ticket_message where ticket_id='.$id;
		if(($res=db_query($sql)) && db_num_rows($res))
            $message_row=db_fetch_array($res);

			if ($newstatus==2)
			{			 
				$ret=$this->wpx->updatePost_openpad($oldPostID,$ticket_row['yphresia'].' - '.$ticket_row['helptopic'],$this->getPostCategories($id),$message_row['message'],1);
				$ret=$this->wpx->addPostTags($oldPostID,$this->getPostTag($ticket_row['yphresia_dimos_id']));
			}
			if ($newstatus==3)
			{		
				$ret=$this->wpx->updatePost_openpad($oldPostID,$ticket_row['yphresia'].' - '.$ticket_row['helptopic'],$this->getPostCategories($id),$message_row['message'],0);
				$ret=$this->wpx->addPostTags($oldPostID,$this->getPostTag($ticket_row['yphresia_dimos_id']));
			}
			$this->addPostMeta($oldPostID,$ticket_row);
			
		}
	}
	public function createWordPressComment_response($id)
	{

		$sql='select * from '.TICKET_RESPONSE_TABLE.' where response_id='.$id;
		if(($res=db_query($sql)) && db_num_rows($res))
            $response_row=db_fetch_array($res);	
	
		$sql='select * from '.TICKET_TABLE.' where ticket_id='.$response_row['ticket_id'];
		if(($res=db_query($sql)) && db_num_rows($res))
            $ticket_row=db_fetch_array($res);
		$sql="select * from ost_wordpress_ids where id_type='post' AND openpad_id=".$response_row['ticket_id'];
		if ($res=db_query($sql))
			$wp_row=db_fetch_array($res);
			$oldPostID=$wp_row['wordpress_id'];	
			//        $commentID=$wpx->createComment($postID,0,"some author","someemail@somedomain.com","someurl.com","Comment Content, random:".rand());
				$commentID=$this->wpx->createComment($oldPostID,0,"SYSTEM","info@openepad.gov.gr","www.openepad.gov.gr",$response_row['response']);
				$ret=$this->wpx->insertCommentMeta($commentID,'openpad_comment_type','response');
				$this->addCommentMeta($commentID,$response_row);
				$this->addCommentMeta($commentID,$ticket_row);				

	}
	
	public function createWordPressComment_message($id)
	{
		$sql='select * from '.TICKET_MESSAGE_TABLE.' where msg_id='.$id;
		if(($res=db_query($sql)) && db_num_rows($res))
            $message_row=db_fetch_array($res);	
		$sql='select * from '.TICKET_TABLE.' where ticket_id='.$message_row['ticket_id'];
		if(($res=db_query($sql)) && db_num_rows($res))
            $ticket_row=db_fetch_array($res);
		$sql="select * from ost_wordpress_ids where id_type='post' AND openpad_id=".$message_row['ticket_id'];
		if ($res=db_query($sql))
			$wp_row=db_fetch_array($res);
			$oldPostID=$wp_row['wordpress_id'];		
			//        $commentID=$wpx->createComment($postID,0,"some author","someemail@somedomain.com","someurl.com","Comment Content, random:".rand());
				//if oldPostID is NULL, then this is the first message so we are not posting anything
				if (isset($oldPostID))
				{
					$commentID=$this->wpx->createComment($oldPostID,0,"USER","info@openepad.gov.gr","www.openepad.gov.gr",$message_row['message']);
					$ret=$this->wpx->insertCommentMeta($commentID,'openpad_comment_type','message');
					$this->addCommentMeta($commentID,$message_row);
					$this->addCommentMeta($commentID,$ticket_row);
				}
	}
	
}


?>
