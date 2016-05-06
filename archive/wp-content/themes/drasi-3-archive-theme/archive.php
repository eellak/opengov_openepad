<?php get_header(); ?>
<div class="rcontainer archivez">
	<div class="rtop">
	
		<div class="rmaintitle">
			Τελευταία Μηνύματα
		</div>
		
		<?php include(DESIGN.'/rsidebar_share.php'); ?>
		
		<div class="single">
	
			<?php if (have_posts()) :  the_post(); ?>
		
				<div class="rmaininfo">
				<?php the_title(); ?>
				</div>
				<div class="rmain">
					<?php the_excerpt(); ?>
				</div>
			
			<?php else: endif; ?>
			
			<div class="paginate">
				<?php if(function_exists('wp_pagenavi')) { wp_pagenavi();  } ?>
			</div>
			
		</div>
		<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer(); ?>

