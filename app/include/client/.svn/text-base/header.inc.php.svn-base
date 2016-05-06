<?php
$title=($cfg && is_object($cfg))?$cfg->getTitle():'osTicket :: Support Ticket System';
header("Content-Type: text/html; charset=UTF-8\r\n");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title><?=Format::htmlchars($title)?></title>
    <link rel="stylesheet" href="./styles/main.css" media="screen">
    <link rel="stylesheet" href="./styles/colors.css" media="screen">
</head>
<body>
<div id="container">
    <div id="header">
        <p><span>ΣΥΣΤΗΜΑ</span>ΚΑΤΑΓΡΑΦΗΣ</p>
    </div>
    <ul id="nav">
         <?                    
         if($thisclient && is_object($thisclient) && $thisclient->isValid()) {?>
         <li><a class="log_out" href="logout.php">έξοδος</a></li>
         <li><a class="my_tickets" href="tickets.php">Μηνύματα που έχω υποβάλλει</a></li>
         <?}else {?>
         <li><a class="ticket_status" href="tickets.php">Κατάσταση Μηνύματος</a></li>
         <?}?>
         <li><a class="new_ticket" href="/app/citizenform.php" target="_blank">Nέο Μήνυμα</a></li> <?php /* config */?>
         <li><a class="home" href="/drasi3">Αρχική</a></li> 
         
    </ul>
    <div id="content">
