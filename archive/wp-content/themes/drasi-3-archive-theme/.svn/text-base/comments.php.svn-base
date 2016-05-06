<div id="comments">
	
	<?php 
		if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) { die ('Σφάλμα!'); }

		if (!empty($post->post_password)) { 
			if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie?>
				<p class="nocomments">Απαιτείται Κωδικός.<p>
			<?php
				return;
			}
		}
	?>

	<?php if (have_comments()) { ?>
		
		 <?php if ( ! empty($comments_by_type['comment']) ) { ?>


		
		<?php 
			$history = '';
			$commentz = '';
			foreach($comments_by_type['comment'] as $comment) { 
				if ($comment->user_id == 1){
					// Einai toy Admin // Istoriko Minimatos
				
					$history .= '<div class="historyitem"><span class="historymsg">'.$comment->comment_content.'</span><span class="moredata">';
					$history .= mysql2date("m/d/Y H:i", $comment->comment_date);
					$history .= '<span></div>';
					
				}else{
				/*
					[comment_ID] => 44 [comment_post_ID] => 354 [comment_author] => ονομα [comment_author_email] => kk@kk.gr [comment_author_url] => [comment_author_IP] => 84.205.227.22 [comment_date] => 2011-06-15 19:14:18 [comment_date_gmt] => 2011-06-15 16:14:18 [comment_content] => εξωτερικό σχόλιο [comment_karma] => 0 [comment_approved] => 1 [comment_agent] => Mozilla/5.0 (Macintosh; Intel Mac OS X 10_5_8) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.100 Safari/534.30 [comment_type] => [comment_parent] => 0 [user_id] => 0
				*/
					$commentz .= '<div id="comment-'.$comment->comment_ID.'" class="commnt"><span class="commentmsg">'.$comment->comment_content.'</span><span class="commentdata">';
					$commentz .= 'Απο <strong>';
					if(url_exists($comment->comment_author_url)){
						$commentz .= '<a href="'.$comment->comment_author_url.'" target="_blank" rel="nofollow">'.$comment->comment_author.'</a>';
					} else {
						$commentz .= $comment->comment_author;
					}
					$commentz .= '</strong><br />στις '.mysql2date("m/d/Y H:i", $comment->comment_date);
					$commentz .= '<span></div>';
				}
				
			}
		?>
		
		<div class="history">
			<span class="historytitle">Ιστορικό Μηνύματος</span>
			<?php echo $history; ?>
		</div>
		
		<div class="commentz">
			<span class="commentztitle">Σχόλια Επισκεπτών</span>
			<?php echo $commentz; ?>
		</div>
	<?php }  } ?>
	
	<?php if ('open' == $post->comment_status) { ?> 
	<div id="respond" class="form_land">	
		<div class="comment_form">
			<h3 class="comment_on">Σχολιάστε</h3>
			<form class="form" action="<?php echo URL; ?>/wp-comments-post.php" method="post" id="commentform">
			
				<?php if ( $user_ID ) { ?>
					<p>Συνδεδεμένος ως <a href="<?php echo URL; ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. 
						<a href="<?php echo URL; ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>">Αποσύνδεση &raquo;</a></p>
				<?php } else { ?>

					<p><label for="author">
						<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" tabindex="1" class="TextField" style="width: 210px;" />
						Όνομα (Υποχρεωτικό)
					</label></p>
							
					<p><label for="email">
						<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="2" class="TextField" style="width: 210px;" />
						eMail (Υποχρεωτικό) (Δεν Δημοσιεύεται)
					</label></p>
						
					<p><label for="url">
					<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" tabindex="3" class="TextField" style="width: 210px;" />
					Προσωπικός Ιστοχώρος/Ιστοσελίδα/Blog
					</label></p>

				<?php }?>	
				<p>
					<textarea name="comment" id="comment" rows="20" cols="70" tabindex="14" class="TextArea" ></textarea>
				</p>

				<p>
					<input name="SubmitComment" type="submit" class="SubmitComment"  title="Post Your Comment" value="Υποβολή του Σχολίου" alt="Υποβολή του Σχολίου" />
					<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
				</p>
				<?php do_action('comment_form', $post->ID); ?>
			</form>
		</div>
		<div class="comments_guide">

			</ol>
		</div>
	</div>
	<?php } ?>
		
</div>
