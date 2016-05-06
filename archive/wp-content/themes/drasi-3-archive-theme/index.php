<?php get_header(); ?>
<?php

$incarr = array();

	
	 if(isset($_GET["i"])){
		$inc = mysql_real_escape_string( trim ($_GET["i"]));
		$incarr = explode(',', $inc);
	}
	
	if(isset($_GET["t"])){
		 $argz = array( 
		 	'cat'      => implode(",", $incarr),
			'posts_per_page' => 20,
			'paged' => $page );
	} else {
		$argz = array( 
			'category__and' => $incarr, 
			'posts_per_page' => 20,
			'paged' => $page );
	}
	
 ?>
<div class="rcontainer archivez">
	<div class="rtop">
	
		<div class="rmaintitle">
			Τελευταία Μηνύματα
		</div>
		
		<?php include(DESIGN.'/rsidebar_share.php'); ?>
		
		<div class="single">
			<span class="rmain xplain">
			<?php
				$type = 'και';
				if(isset($_GET["t"])){
					$type = 'ή';
				}
				
				if (strlen($inc)==0){
					echo 'Εμφανίζονται όλες οι Προτάσεις';
				}else {
					echo 'Εμφανίζονται αποτελέσματα με τα ακόλουθα κριτήρια:<br />';
					$cnt = count($incarr);
					$size = $cnt;
					foreach($incarr as $key => $value) {
						echo '<span class="crit">'.get_cat_name( $value ).'</span>';
						if (($cnt != 1) && ($cnt != $size) ) { echo $type.'<br />'; }
						$cnt = $cnt -1 ;
					}
					}
				
				?>
			</span>
	
			<?php while (have_posts()) : if (have_posts()) :  the_post(); ?>
		
				<div class="rmaininfo">
					<a href="<?php the_permalink() ?>" rel="bookmark" ><?php the_title(); ?></a>
					<span class="commz"><?php comments_number('0 Σχόλια', '1 Σχόλιο', '% Σχόλια'); ?> </span>
				</div>
				<div class="rmain">
					<?php the_excerpt(); ?>
				</div>
			
			<?php else: endif; endwhile; ?>
			
			<div class="paginate">
				<?php if(function_exists('wp_pagenavi')) { wp_pagenavi();  } ?>
			</div>
			
		</div>
		<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer(); ?>

