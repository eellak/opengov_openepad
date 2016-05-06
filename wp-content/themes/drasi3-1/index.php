<?php get_header(); ?>
	<!-- 
	SLIDER
	<div class="rslider">
		<div class="rtut">
		slider
		</div>
		<div class="ractions">
		actions
		</div>
	</div>
	-->
		
	<div class="rcontainer indexz">
		<?php
				$p_id = 2; //Intro Post ID
				$post_intro = get_post($p_id); 
				$content = explode('<!--more-->', $post_intro->post_content);
				$content_1 = apply_filters('the_content',   $content[0]);
				$content_2 = apply_filters('the_content',   $content[1]);
		?>
        
		
        <br />
		<div class="rtop">
			<div class="single">
				<div class="maintitle">
					<a href="<?php echo site_url();?>/app/"><?php echo $post_intro->post_title; ?></a>  
				</div>
				<div class="rmain">
					<?php 
						echo $content_1; 
						echo $content_2; 
					?>
				</div>    	
			</div>
			
			<?php get_sidebar(); ?>
		</div>
		
		<div class="rbottom">

        
			<div class="rbottomleft latezt">
	

<?php $link1 = get_site_url() ; ?>


<?php $rss = $link1.'/archive/?feed=rss2&x='.rand(5, 95) ;?>

				<span class="rbottomtitle">Tελευταία </span>
				<a class="rbottomtitle rzz" href="<?php echo $rss; ?>" target="_blank">&nbsp;</a>
				<ul>
				<?php 
					getRSSFeed($rss) ;
				?>
				<!-- TEMP -->
            
				<!-- /TEMP -->
				</ul>
				<div class="statz">
			
                    <div align="right">
                    <div id="readcomment">
                  <small>  Mπορείς να <b>διαβάσεις</b>  και να 
                    <b>σχολιάσεις</b> τα μηνύματα που έχουν υποβληθεί
                    </small>
                    <br /> 
                    </div>
                    
					<a href="<?php echo site_url(); ?>/archive"><b> περισσότερα &raquo;</b></a>
				</div>
                </div>
			</div>
			<div class="rbottommiddle">
				<span class="rbottomtitle">Ενημέρωση από την Υπηρεσία</span>
                
                <br />
               <font size="-1"><center>Συμπληρώσε τα παρακάτω στοιχεία για το μήνυμα που έχεις υποβάλλει </center> </font>
                <br />
			
				<form method="post" action="<?php echo URL; ?>/app/login.php" class="status_form">
					  <label for="lemail">eMail</label><br />
					  <input type="text" name="lemail"><br />
					  <label for="lticket">Αριθμός Μηνύματος #</label><br />
					  <input type="text" name="lticket"><br />
					  <input type="submit" value="Έλεγχος Kατάστασης">
				</form>
	
			</div>
			<div class="rbottomright linkz">
				<?php 
					$p_id = 7; //Intro Post ID
					$post_intro = get_post($p_id); 
					$content = apply_filters('the_content',  $post_intro->post_content);
				?>
					<span class="rbottomtitle"><?php echo $post_intro->post_title; ?></span>
					<?php echo $content; ?>
			</div>
		</div>
	</div>
<?php get_footer(); ?>
