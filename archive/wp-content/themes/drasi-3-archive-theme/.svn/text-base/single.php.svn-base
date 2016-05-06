<?php get_header(); ?>
<div class="rcontainer">
	<div class="rtop">
	
	<?php if (have_posts()) :  the_post(); ?>

	<div class="rmaintitle">
			<?php the_title(); ?>
		</div>
		<?php include(DESIGN.'/rsidebar_share.php'); ?>
		
		<div class="single">
			<div class="rmaininfo">
				<?php
					$categories = get_the_category(); 
					foreach ($categories as $category){
						// Ministry
						if ($category->category_parent == 15){
							$ministry = '<a href="'.URL.'/?i='.$category->cat_ID.'">'.$category->cat_name.'</a>';
						}
						// Tropos Epikoinwnias
						if ($category->category_parent == 393){
							$contact = '<a href="'.URL.'/?i='.$category->cat_ID.'">'.$category->cat_name.'</a>';
						}
						// Idiotita
						if ($category->category_parent == 7){
							$aswhat = '<a href="'.URL.'/?i='.$category->cat_ID.'">'.$category->cat_name.'</a>';
						}
						// Anonymous
						if ($category->category_parent == 376){
							$anonym = '<a href="'.URL.'/?i='.$category->cat_ID.'">'.$category->cat_name.'</a>';
						}
						// Logos Epikoinwnias
						if ( ($category->category_parent == 381) ||($category->category_parent == 380) || ($category->category_parent == 379) ){
							$whyparent = '<a href="'.URL.'/?i='.$category->category_parent.'">'.get_cat_name( $category->category_parent).'</a>';
							$why = '('.$whyparent.') '.'<a href="'.URL.'/?i='.$category->cat_ID.'">'.$category->cat_name.'</a>';
						}
					}
					
					$date = get_post_meta($post->ID, 'openpad_eventdate', true);
					$foreas = get_post_meta($post->ID, 'openpad_yphresia', true);
					
					$name = get_post_meta($post->ID, 'openpad_name', true);
					$surname = get_post_meta($post->ID, 'openpad_lastname', true);
					$who = '('.$anonym.') '.$name.' '.$surname ;
				?>
				<span class="infodata">Υπουργείο</span>
					<span class="infodatacontent"><?php echo $ministry; ?>&nbsp;</span>
				<span class="infodata">Λόγος Επικοινωνίας</span>
					<span class="infodatacontent"><?php echo $why; ?>&nbsp;</span>
				<span class="infodata">Ημερομηνία</span>
					<span class="infodatacontent"><?php echo $date; ?>&nbsp;</span>
				<span class="infodata">Υπηρεσία</span>
					<span class="infodatacontent"><?php echo $foreas; ?>&nbsp;</span>
				<span class="infodata">Έδρα Υπηρεσίας</span>
					<span class="infodatacontent"><?php the_tags('',''); ?>&nbsp;</span>
				<hr/>
				<span class="infodata2">Υποβάλλων</span>
					<span class="infodatacontent"><?php echo $who; ?>&nbsp;</span>
				<span class="infodata2">Ιδιότητα</span>
					<span class="infodatacontent"><?php echo $aswhat; ?>&nbsp;</span>
				<span class="infodata2">Επικοινωνία</span>
					<span class="infodatacontent"><?php echo $contact; ?>&nbsp;</span>
			</div>
			<div class="rmain">
				<?php the_content(); ?>
			</div>
		</div>
		
		<?php else: endif; ?>
		<?php get_sidebar(); ?>
		<?php comments_template('', true); ?>
	</div>
</div>
<?php get_footer(); ?>