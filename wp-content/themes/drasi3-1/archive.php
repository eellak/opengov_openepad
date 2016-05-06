<?php get_header(); ?>
<div class="archive">
	<h3><?php single_cat_title(); ?></h3>
	
	<ul class="archive">
		<?php while(have_posts()): if (have_posts()) :  the_post(); 
			$service = get_post_meta($post->ID, 'sup' , true); 
		?>
		<li>
			<div class="arch_title">
				<a href="<?php the_permalink() ?>" rel="bookmark" ><?php the_title(); ?></a> για "<?php echo $service; ?>"
			</div>
			<div class="arch_desc">
				<?php the_content('[ Διαβάστε Περισσότερα &raquo; ]'); ?>
			</div>
		</li>
		<?php else: endif; endwhile; ?>
	</ul>
	<?php if(function_exists('wp_pagenavi')) { wp_pagenavi();  } ?>

</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>