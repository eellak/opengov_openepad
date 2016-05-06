<?php get_header(); ?>
<div class="rcontainer pagez">
	<div class="rtop">
	
	<?php if (have_posts()) :  the_post(); ?>

		<div class="rmaintitle">
			<?php the_title(); ?>
		</div>
		<?php include(DESIGN.'/rsidebar_share.php'); ?>
		
		<div class="single">
			<!--
			<div class="rmaininfo">
			info
			</div>-->
			<div class="rmain">
				<?php the_content(); ?>
			</div>
		</div>
		
		<?php else: endif; ?>
		<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer(); ?>