<?php
/*
Template Name: List Cats
*/
 get_header(); ?>
	<div class="single">
			<h3>Αρχείο Ιστοχώρου </h3>
			
			<div class="details">
				
			</div>
			<?php
				
				$categories=get_categories(array('hide_empty' => 0, 'parent'=> 0, 'exclude' => 1));
				foreach($categories as $category) { 
					//echo  $category->name.' <br />';  
					echo $category->cat_ID.' - '. $category->name.'<br />';  
					echo '<ul>';
						$categories2= get_categories(array('hide_empty' => 0, 'parent'=> $category->cat_ID));
						foreach($categories2 as $category2) { 
							echo $category2->cat_ID.' - '. $category2->name.'<br />';  
							echo '<ul>';
								$categories3= get_categories(array('hide_empty' => 0, 'parent'=> $category2->cat_ID));
								foreach($categories3 as $category3) { 
									echo $category3->cat_ID.' - '. $category3->name.'<br />';  
							
							}
							echo '</ul>';
						}
					echo '</ul>';
					echo '<br /><br />';
				} 
			?>
			
			<div class="cnt">
				<ul>
				<?php //$test = wp_list_categories('orderby=count&order=DESC&show_count=0&exclude=1&hide_empty=0&echo=0&title_li='); 
				//wp_list_categories('orderby=count&order=DESC&show_count=0&exclude=1&hide_empty=0&title_li=');
				?> 
				</ul>
			</div>
			
			

	</div>
</div>
<?php 
	get_sidebar(); 
	get_footer(); 
?>