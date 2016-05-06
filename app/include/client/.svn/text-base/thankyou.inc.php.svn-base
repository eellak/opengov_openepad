<?php
	if(!defined('OSTCLIENTINC') || !is_object($ticket)) die('Σφάλμα!'); //Say bye to our friend..
?>
<?if($errors['err']) {?>
	<div class="mainformtitle errormessage"><?=$errors['err']?></div>
<?}elseif($msg) {?>
   <div class="mainformtitle infomessage"><?=$msg?></div>
<?}elseif($warn) {?>
   <div class="mainformtitle warnmessage"><?=$warn?></div>
<?}?>

<div class="rslider">
	<div class="singlebig">
	<?if($errors['err']) { ?>
	
	<?}elseif($msg) {?>
		<p>Ευχαριστούμε για την επικοινωνία.</p>
		<p>Το μήνυμά  σας με αριθμό <strong><?=$ticket->getExtId()?></strong> υποβλήθηκε επιτυχώς και είναι  υπό επεξεργασία !    
		</p>
		<p>--</p>	  
		<?if($cfg->autoRespONNewTicket()){ ?>
        	<p>
            </p><? /*comment here */ ?>
		<?}
		} ?>
   </div>
</div>
<?
unset($_POST); //clear to avoid re-posting on back button??
?>




    
