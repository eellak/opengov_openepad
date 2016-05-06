<?php
/*********************************************************************
    citizenform.php
/* custom  code
**********************************************************************/
require('client.inc.php');

define('SOURCE','Web'); //Ticket source.
$inc='';    //default include.
$errors=array();

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	//Ticket::create...checks for errors..
    if(($ticket=Ticket::create($_POST,$errors,SOURCE))){
	
        $msg='Επιτυχής Καταχώρηση Μηνύματος';         
        if($thisclient && $thisclient->isValid()) {//Logged in...simply view the newly created ticket.
        	header('Location: tickets.php?id='.$ticket->getExtId());
        }else {
	       require(CLIENTINC_DIR.'formheader2.inc.php');
	       //Thank the user and promise speedy resolution!
	       $inc='thankyou.inc.php';
	       require(CLIENTINC_DIR.$inc);
	       require(CLIENTINC_DIR.'footer2.inc.php'); 
	       exit();
       }
    }else{
        $errors['err']=$errors['err']?$errors['err']:'Αποτυχία Καταχώρησης Μηνύματος';
        print_r ($errors);
        exit();
    }
} //post
  
require(CLIENTINC_DIR.'formheader2.inc.php');
?>
<div class="mainformtitle">
	Υποβάλετε το μήνυμά σας
</div>
<div class="rslider">

	<script src="./js/jquery.validationEngine.js" type="text/javascript"></script>
	<script src="./js/jquery.validationEngine-el.js" type="text/javascript"></script>
	<script src="./js/jquery.ui.selectmenu.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/citizenform.js"></script>
	<script type="text/javascript">
	$(function() {

		prepareform();
		$("#citizenform").validationEngine(); // Magic. Do not touch.

	if (name.length<3) name="Ανώνυμος"; // drunk, fix later

	$('#citizenform').submit(function() {
		var topic=$("#topicId option:selected").text();
		var name=$("#name").val()+" " +$("#lastname").val() ;
		var legalname=$("#legalname").val() ;
		if (name.length<3) name="Ανώνυμος";
		if (legalname.length>2) name=legalname;
		
		  $('#subject').val(topic + " απο " + name  );
		 
		  return true;
		});
	});

	</script>

	<div class="singlebig">
		<form class="form" id="citizenform" class="gen_forms" action="citizenform.php" method="post" enctype="multipart/form-data">
					
					
						<div class="report_row">
						   
				       	<input type="hidden" name="form_id" id="form_id" value="">
						</div>
						
						 <div class="report_left">
			                
                            <!-- email -->	 
				            <div class="report_row">
					            <h4>E-mail<span class="example">  (Υποχρεωτικό πεδίο)</span></h4>
					            <input type="text" id="email" name="email" value=""  class="text long validate[required,custom[email]]" title="Δώστε την ηλεκτρονική σας διεύθυνση (email)"/>				
				            </div>
							
							 <!-- Ιδιότητα -->
					        <div class="report_row">
					           
                               <h4>Ιδιότητα<span class="example"> (Με την οποία υποβάλλετε το μήνυμα)  </span></h4>
					           <select name="idiotita" id="idiotita" class="dropdown" title="Επιλέξετε από την λίστα">
										         <?php
								                   $idiotites_i=0;
								                   foreach($cfg->idiotites_array_values as $ivalue) {
								                      echo '<option value="'.$cfg->idiotites_array_keys[$idiotites_i].'">'.$ivalue.'</option>';   
								                      $idiotites_i++;                     
								                   }
								                                        
								                 ?>
																	        
						       </select>				
				               </div>
				               
                            <!-- Namedata -->
                            <div class="report_row" id="namedata_default">
					            <h4><a href="#" id="namedata_toggle" class="show-more">Επιθυμώ Επώνυμη Επικοινωνία: </a></h4>
						        
				            </div>
                            
				            <div class="report_row hide namedataedit" id="namedata_edit" >
					            <div class="date-box">
						           <div id="physicalpersondata"> 
                                    <h4>Όνομα<span class="example"> </span></h4>
					                <input type="text" id="name" name="name" value=""  class="text long" title="Συμπληρώστε το όνομα σας"/>			
                                    <h4>Επώνυμο<span class="example">  </span></h4>
					                <input type="text" id="lastname" name="lastname" value=""  class="text long" title="Συμπληρώστε το επώνυμο σας"/>			
					                </div>
					                <div id="legalpersondata" >
					                 <h4>Επωνυμία<span class="example"> </span></h4>
					                <input type="text" id="legalname" name="legalname" value=""  class="text long" title="Συμπληρώστε την επωνυμία της επιχείρησης"/>			
					                </div>
                                    <h4>Δημος<span class="example">  </span></h4>
					                <input type="text" id="dimos" name="dimos" value=""  class="text long" title="Δώστε την Πόλη ή τον Δήμο της μόνιμης κατοικίας σας"/>			

					            </div>
					            
					               <div id="demographicdata" class="date-box">
						            
                                    <h4>Φύλο<span class="example"> </span></h4>
                                     <select name="sexId" id="sexId" class="dropdown">
									        	<option value="0" selected>Δεν επιθυμώ να δήλώσω</option>
										        <option value="1">Ανδρας</option>
                                                <option value="2">Γυναίκα</option>
										        
									        </select>
					                			
                                    <h4>Ηλικία<span class="example">  </span></h4>
                                    <select name="agerangeId" id="agerangeId" class="dropdown">
									        	<option value="0" selected>Δεν επιθυμώ να δήλώσω</option>
										        <option value="1">16-30</option>
                                                <option value="2">30-45</option>
										        <option value="3">45-60</option>
										        <option value="4">60+</option>
									        </select>
					                			
                                    <h4>Εκπαίδευση<span class="example">  </span></h4>
					                <select name="educationId" id="educationId" class="dropdown">
					                			<option value="0" selected>Δεν επιθυμώ να δήλώσω</option>
									        	<option value="1">Απόφοιτος Λυκείου</option>
										        <option value="2">Πανεπιστήμιακές Σπουδές </option>
                                                <option value="3">Μεταπτυχιακές Σπουδές</option>
										        <option value="4">Κάτοχος Διδακτορικού</option>
									        </select>

					            </div>
					            
                            </div>
                           
                            <!-- Λόγος Επικοινωνίας -->		    	
							<div class="report_row">
					           
                               <h4>Λόγος Επικοινωνίας<span class="example"> </span></h4>		        
									      
									        <select name="topicId" id="topicId" class="dropdown">
									        </select>
									        
									         <select name="topicId2" id="topicId2" class="dropdown">
									        </select>
							</div>

                            <!-- message -->
                            <div class="report_row">
					        <h4>Περιγραφή<span class="example">  (Υποχρεωτικό πεδίο)</span></h4>
					        <textarea id="message" name="message"  rows="10" class="textarea long" onblur="$('#message').validationEngine('hidePrompt');" onclick="$('#message').validationEngine('showPrompt', 'Συμπληρώστε το μήνυμα σας με πεζούς ελληνικούς χαρακτήρες', 'load',true)" ></textarea>				
                            </div>

                             <!-- publish -->
                            <div class="report_row">
					        <h4>Επιθυμώ να δημοσιευθεί<span class="example">  
					        &nbsp;<input name="publish" id="publish" type="checkbox" value="1" checked="checked" style="clear:both;width: auto;" title="Επιλέξτε αν το μήνυμα σας θέλετε να εμφανίζεται δημόσια"/>
					        </span></h4>
					         		
                            </div>

       
							</div> <!-- report_left -->

                            <div class="report_right">
								
				                <div class="report_row">
					                <h4>Επιλέξτε το Υπουργείο που αφορά το μήνυμά σας</h4>
				                </div>
				

				                <!-- Department -->
				                <div id="divdept" class="report_row">
					    
                                    <h4>Υπουργείο</h4>
                                    <select name="deptId" id="deptId" class="dropdown long3"  title="Επιλέξτε το υπουργείο στο οποίο απευθήνεται το μήνυμα">
						            </select>
					    
                                </div>

                                 <!-- Υπηρεσία -->
				                <div id="divyphrsia" class="report_row">
					    
                                    <h4>Υπηρεσία ή Φορέας του Υπουργείου</h4>
                                     <input name="yphresia" id="yphresia" type="text" class="text long" onblur="$('#yphresia').validationEngine('hidePrompt');" onclick="$('#yphresia').validationEngine('showPrompt', 'Πληκρολογήστε την υπηρεσία ή επιλέξτε από την αναδυόμενη λίστα', 'load',true)"  value="" title="Δώστε την υπηρεσία που αφορά το μήνυμα σας"/>
                                  
                                </div>

                                 <!-- Πόλη Υπηρεσίας -->
				                <div id="divyphresia_dimos" class="report_row">
					    
                                    <h4>Εδρα Υπηρεσίας</h4>
                                     <input name="yphresia_dimos" id="yphresia_dimos" type="text"  class="text long"  onblur="$('#yphresia_dimos').validationEngine('hidePrompt');" onclick="$('#yphresia_dimos').validationEngine('showPrompt', 'Πληκρολογήστε τον δήμο που εδρεύει η υπηρεσία ή επιλέξτε από την αναδυόμενη λίστα', 'load',true)"  value="" title="Δώστε την Πόλη ή τον Δήμο που εδρεύει η υπηρεσία"/>
                           
					    
                                </div>

                                 <!-- Τρόπος Επικοινωνίας -->
                                <div id="divcommunication_type" class="report_row">
                                    
                                       <h4>Με ποιον τρόπο επιθυμώ να ενημερωθώ</h4>    
									      
										      <select name="communication_type" id="communication_type" class="dropdown customicons">
										      	<option value="1" class="email">με Email</option>
										        <option value="2" class="mobile">με μήνυμα (Κινητό τηλέφωνο)</option>
										        <option value="3" class="post">Αλληλογραφία</option>
											  </select>
									          
									         	 <div id="divcommunication_type_extra" class="report_row">
									          		<span id="pnl_phone">
									          			<h4>Τηλέφωνο<span class="example"> </span></h4>
										          		<input name="phone" id="phone" type="text" class="text long"  value="" title="Δώστε το τηλέφωνο σας"/>
												       											       
									          		</span>
									          		
											         <span id="pnl_address">
											         	<h4>Διεύθυνση<span class="example"> </span></h4>
												        <input name="address" id="address" type="text" class="text long"  value="" title="Δώστε την διεύθυνση σας "/>
												        <h4>Τ.Κ<span class="example"> </span></h4>
												        <input name="tk" id="tk" type="text" class="text short"  value="" title="Δώστε τον ταχυδρομικό κωδικό της περιοχής σας "/>
												        
											        
											        </span>
												</div>
                                
                                </div>


				        
				        <div class="report_row">
					        <input name="submit" id="submit" type="submit" value="Υποβολή" class="btn_submit" title="Υποβολή Μηνύματος" /> 
				        </div>

			        </div> <!-- div.report_right -->
             		   
	        
									      
				<!--  Hidden fileds [Begin] -->
				<input type="hidden" name="subject" id="subject" value="Νεό Μήνυμα - Kανάλι Web" />
				<input type="hidden" name="yphresia_id" id="yphresia_id" value="0" />
				<input type="hidden" name="dimos_id" id="dimos_id" value="0" />
				<input type="hidden" name="yphresia_dimos_id" id="yphresia_dimos_id" value="0" />
				<!--  Hidden fileds [End] --> 
                           
                        						      
					</form>

									
	</div>
</div>
<?require(CLIENTINC_DIR.'footer2.inc.php'); ?>
