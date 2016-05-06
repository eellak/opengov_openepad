<?php if (is_single()){ ?>

<div class="sidewrapper">
	<div class="rsidebar returner">	
		<a href="<?php echo URL; ?>">&laquo; Επιστροφή</a>
	</div>
	<div class="rsidebar filterintro">
		<span><p>Παρακάτω μπορείτε να δείτε περισσότερα μηνύματα που αφορούν το ίδιο Υπουργείο.</p></span>
	</div>
	<div class="rsidebar lister">	
	
	</div>
</div>

<?php } else { ?>

<div class="sidewrapper">

	<div class="rsidebar filterintro">
		<span><p>Χρησιμοποιήστε τις παρακάτω επιλογές για να φιλτράρετε τα υποβληθέντα Μηνύματα. 
		Χρησιμοποιήστε το <img src="<?php echo IMG; ?>/plus.png" /> για να συμπεριλάβετε μια επιλογή και το 
		<img src="<?php echo IMG; ?>/minus.png" /> για να την αφαιρέσετε.</p>
		<p>Στην περίπτωση που δεν παρέχεται σύνδεσμος σημαίνει οτι στην κατηγορία αυτή δεν έχουν κατατεθεί ακόμη Μηνύματα.</p></span>
	</div>

	<div class="rsidebar lister">	
		<span class="rsidebartitle rbottomtitle">Υπουργείο</span>
		<?php show_filters(15); ?>

		<span class="rsidebartitle rbottomtitle">Λόγος Επικοινωνίας</span>
		<?php show_filters(378); ?>
		
		<span class="rsidebartitle rbottomtitle">Ιδιότητα</span>
		<?php show_filters(7); ?>
		
		<span class="rsidebartitle rbottomtitle">Τρόπος Επικοινωνίας</span>
		<?php show_filters(393 ); ?>
	</div>
	
	<div class="rsidebar">	
		<span class="rsidebartitle rbottomtitle">Έδρα Υπηρεσίας</span>
		<select name="tag-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
			<option value="#">Επιλέξτε</option>
			<?php dropdown_tag_cloud('number=0&order=asc'); ?>
		</select>
	</div>
	
</div>
<?php } ?>	
