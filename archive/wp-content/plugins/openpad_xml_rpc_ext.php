<?php
/*
Plugin Name:    OpenPad XML-RPC functions
Plugin URI:     ...	
Description:    OpenPad XML-RPC extension
Version:        0.1
Author:         Drasi 3 
Author URI:     ..
 */
 
add_filter( 'xmlrpc_methods', 'add_new_xmlrpc_methods' );
function add_new_xmlrpc_methods( $methods ) {
    $methods['openpad.createPostMeta'] = 'openpad_add_post_meta';
    $methods['openpad.updatePostMeta'] = 'openpad_update_post_meta';
    $methods['openpad.deletePostMeta'] = 'openpad_delete_post_meta';
    $methods['openpad.createCommentMeta'] = 'openpad_add_comment_meta';
    $methods['openpad.updateCommentMeta'] = 'openpad_update_comment_meta';
    $methods['openpad.deleteCommentMeta'] = 'openpad_delete_comment_meta';
    $methods['openpad.updatePost'] = 'openpad_update_post';
    $methods['openpad.addPostTags'] = 'openpad_add_post_tags';
    return $methods;
}


	function openpad_update_post($args) {

		

		$post_ID     = (int) $args[1];
		$username	= mysql_escape_string($args[2]);
		$password	= mysql_escape_string($args[3]);
		$content    = mysql_escape_string($args[4]);
		$publish     = $args[5];

		$user = wp_authenticate($username, $password);

		if (is_wp_error($user)) {
			$error = new IXR_Error(403, __('Bad login/pass combination.'));
			return $error;
		}

		wp_set_current_user( $user->ID );

		do_action('xmlrpc_call', 'blogger.editPost');

		$actual_post = wp_get_single_post($post_ID,ARRAY_A);

		if ( !$actual_post || $actual_post['post_type'] != 'post' )
			return new IXR_Error(404, __('Sorry, no such post.'));

		mysql_escape_string($actual_post);
		$post_status = ($publish) ? 'publish' : 'draft';
		if ( !current_user_can('edit_post', $post_ID) )
			return new IXR_Error(401, __('Sorry, you do not have the right to edit this post.'));

		extract($actual_post, EXTR_SKIP);

		if ( ('publish' == $post_status) && !current_user_can('publish_posts') )
			return new IXR_Error(401, __('Sorry, you do not have the right to publish this post.'));

		$post_title = xmlrpc_getposttitle($content);
		$post_category = xmlrpc_getpostcategory($content);
		$post_content = xmlrpc_removepostdata($content);

		$postdata = compact('ID', 'post_content', 'post_title', 'post_category', 'post_status', 'post_excerpt');

		$result = wp_update_post($postdata);

		if ( !$result )
			return new IXR_Error(500, __('For some strange yet very annoying reason, this post could not be edited.'));


		return true;
	}
	
function openpad_add_post_tags( $args ) {
		$blog_id	= (int) $args[0];
		$username	= mysql_escape_string($args[1]);
		$password	= mysql_escape_string($args[2]);
		$post_id		= $args[3];
		$tags		= $args[4];
		
		$user = wp_authenticate($username, $password);

		if (is_wp_error($user)) {
			$error = new IXR_Error(403, __('Bad login/pass combination.'));
			return $error;
		}
		
		wp_set_current_user( $user->ID );

    return wp_set_post_tags($post_id, $tags,false);


}

function openpad_add_post_meta( $args ) {
		$blog_id	= (int) $args[0];
		$username	= mysql_escape_string($args[1]);
		$password	= mysql_escape_string($args[2]);
		$post_id		= $args[3];
		$meta_key		= $args[4];
		$meta_value = $args[5];
		
		$user = wp_authenticate($username, $password);

		if (is_wp_error($user)) {
			$error = new IXR_Error(403, __('Bad login/pass combination.'));
			return $error;
		}

		wp_set_current_user( $user->ID );


    return add_post_meta($post_id, $meta_key, $meta_value, true) ;

}

function openpad_update_post_meta( $args ) {
		$blog_id	= (int) $args[0];
		$username	= mysql_escape_string($args[1]);
		$password	= mysql_escape_string($args[2]);
		$post_id		= $args[3];
		$meta_key		= $args[4];
		$meta_value = $args[5];
		
		$user = wp_authenticate($username, $password);

		if (is_wp_error($user)) {
			$error = new IXR_Error(403, __('Bad login/pass combination.'));
			return $error;
		}

		wp_set_current_user( $user->ID );

    return update_post_meta($post_id, $meta_key, $meta_value) ;

}

function openpad_delete_post_meta( $args ) {
		$blog_id	= (int) $args[0];
		$username	= mysql_escape_string($args[1]);
		$password	= mysql_escape_string($args[2]);
		$post_id		= $args[3];
		$meta_key		= $args[4];

		
		$user = wp_authenticate($username, $password);

		if (is_wp_error($user)) {
			$error = new IXR_Error(403, __('Bad login/pass combination.'));
			return $error;
		}

		wp_set_current_user( $user->ID );

		
    return delete_post_meta($post_id, $meta_key) ;

}

 
function openpad_add_comment_meta( $args ) {
		$blog_id	= (int) $args[0];
		$username	= mysql_escape_string($args[1]);
		$password	= mysql_escape_string($args[2]);
		$comment_id		= $args[3];
		$meta_key		= $args[4];
		$meta_value = $args[5];
		
		$user = wp_authenticate($username, $password);

		if (is_wp_error($user)) {
			$error = new IXR_Error(403, __('Bad login/pass combination.'));
			return $error;
		}

		wp_set_current_user( $user->ID );

	
    return add_comment_meta($comment_id, $meta_key, $meta_value, true) ;

}

function openpad_update_comment_meta( $args ) {
		$blog_id	= (int) $args[0];
		$username	= mysql_escape_string($args[1]);
		$password	= mysql_escape_string($args[2]);
		$comment_id		= $args[3];
		$meta_key		= $args[4];
		$meta_value = $args[5];
		
		$user = wp_authenticate($username, $password);

		if (is_wp_error($user)) {
			$error = new IXR_Error(403, __('Bad login/pass combination.'));
			return $error;
		}

		wp_set_current_user( $user->ID );


    return update_comment_meta($comment_id, $meta_key, $meta_value) ;

}

function openpad_delete_comment_meta( $args ) {
		$blog_id	= (int) $args[0];
		$username	= mysql_escape_string($args[1]);
		$password	= mysql_escape_string($args[2]);
		$comment_id		= $args[3];
		$meta_key		= $args[4];
		$meta_value = $args[5];
		
		$user = wp_authenticate($username, $password);

		if (is_wp_error($user)) {
			$error = new IXR_Error(403, __('Bad login/pass combination.'));
			return $error;
		}

		wp_set_current_user( $user->ID );



    return delete_comment_meta($comment_id, $meta_key) ;

}


?>