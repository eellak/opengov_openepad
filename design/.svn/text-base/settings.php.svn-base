<?php
	global $root_img, $root_design, $root_url, $root_js;
		
   	$root_url = "http://83.212.121.173/drasi3"; /*config folder*/
	$root_design = $root_url.'/design';
	$root_img = $root_design.'/img';
	$root_js = $root_design.'/js';

	function get_navigation(){
	global $root_img, $root_design, $root_url, $root_js;
		$guide_url = '?page_id=15';
		$submit_url = 'app';
		$archive_url = 'archive';
	
		$home = '<li><a href="'.$root_url.'" '; /*config folder*/
		if (get_current() == ''){ $home .= 'class="current"'; }
		$home .= ' title="Αρχική Σελίδα">Αρχική</a></li>';
		$guide = '<li><a href="'.$root_url.'/'.$guide_url.'" '; /*config folder*/
		if (get_current() == $guide_url){ $guide .= 'class="current"'; }
		$guide .= ' title="Οδηγίες Συμμετοχής και Υπηρεσίες">Οδηγίες Συμμετοχής & Πληροφορίες </a></li>';
				
		echo $home.$guide.$submit.$archive;					
	}
	
	function get_home(){
	global $root_img, $root_design, $root_url, $root_js;
		$home1 = '<a href="'.$root_url.'/" '; /*config folder*/
		if (get_current() == ''){ $home .= 'class="current"'; }
		$home1 .= ' title="Αρχική Σελίδα">Δράση 3 - Πρότυπη πλατφόρμα καταγραφής προβλημάτων της Δημόσιας Διοίκησης</a>';
				

		
		echo $home1;					
	}
	
	
	function get_home_link(){
	global $root_img, $root_design, $root_url, $root_js;
		
		$home3 = '<a href="'.$root_url.'/" '; /*config folder*/
		if (get_current() == ''){ $home .= 'class="current"'; }
		$home3 .= ' title="Αρχική Σελίδα">Αρχική</a>';
				
		/*config , γινεται link με κατάλληλη ενημερωτική σελίδα */
		
		echo $home3;					
	}
	
	function get_home_root() {
	global $root_img, $root_design, $root_url, $root_js;
			
	    $home3 = $root_url.'/'; /*config folder*/
	
		echo $home3;
		
		}
	
	
	function get_current(){
		global $root_img, $root_design, $root_url, $root_js;
		$current_url=$_SERVER['REQUEST_URI'];
		if (strlen($current_url)==1 ){  
			return '';
		} else {
			$current = explode('/', substr( $current_url, 1));
			return $current[0];
		}
	}

	
?>
