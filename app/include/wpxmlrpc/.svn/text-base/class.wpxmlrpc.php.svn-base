<?php
/*
//---------------------------------------------------------------------------------
Class Name:    	wpxmlrpc
Description:    Wordpress specific XML-RPC extension
Version:        0.1
Author:         draseis protypes efarmoges developers
App URI:     	
NOTES:			The meta data manipulating methods, require the openpad_xml_rpc_ext.php wordpress plug in to be installed in the wordpress install that is to be used
//---------------------------------------------------------------------------------
 */
require_once dirname(__FILE__)."/xmlrpc-2.2.1/lib/xmlrpc.inc"; 
 


class wpxmlrpc
{
	private $basicauth_enabled;
	private $basicauth_user;
	private $basicauth_pass;
	private $service_url;
	private $service_user;
	private $service_pass;
	private $debuglevel;
	private $blogid;
	private $xr;


// Initialization 
	public function __construct($basicauth_enabled,$basicauth_user,$basicauth_pass,$service_url,$service_user,$service_pass,$debuglevel,$blogid) {
		$this->basicauth_enabled=$basicauth_enabled;
		$this->basicauth_user=$basicauth_user;
		$this->basicauth_pass=$basicauth_pass;
		$this->service_url=$service_url;
		$this->service_user=$service_user;
		$this->service_pass=$service_pass;
		$this->debuglevel=$debuglevel;
		$this->blogid=$blogid;   
		$this->xr = new xmlrpc_client ( $this->service_url);
		$this->xr->setDebug($this->debuglevel);
		if ($this->basicauth_enabled)
		{
			$this->xr->setCredentials($this->basicauth_user,$this->basicauth_pass,0);
		}   
	}

	private function filtererrors($resp)
	{
		if (!$resp) { print "<p>IO error: ".$this->xr->errstr."</p>"; exit; }
		if ($resp->faultCode()) {
			print "<p>There was an error: " . $resp->faultCode() . " " .
				$resp->faultString() . "</p>";
			exit;
		}
		return php_xmlrpc_decode($resp->value());	
	}


// Post methods
	public function createPost($title,$category,$content,$publish)
	{
		$req = new xmlrpcmsg('blogger.newPost');
		$req->addParam ( new xmlrpcval ( 1, 'int')); // dummy, this xml-rpc method needs it
		$req->addParam ( new xmlrpcval ( $this->blogid, 'int')); // blog_id
		$req->addParam ( new xmlrpcval ( $this->service_user, 'string' )); // username
		$req->addParam ( new xmlrpcval ( $this->service_pass, 'string' )); // password
		$req->addParam ( new xmlrpcval ( '<title>'.$title.'</title><category>'.$category.'</category>'.$content, 'string')); //content
		$req->addParam ( new xmlrpcval ( $publish, 'int')); // publish
		return $this->filtererrors($this->xr->send($req));	
	}
	
	public function updatePost($postID,$title,$category,$content,$publish)
	{
		$req = new xmlrpcmsg('blogger.editPost');
		$req->addParam ( new xmlrpcval ( 1, 'int')); // dummy, this xml-rpc method needs it
		$req->addParam ( new xmlrpcval ( $postID, 'int')); // blog_id
		$req->addParam ( new xmlrpcval ( $this->service_user, 'string' )); // username
		$req->addParam ( new xmlrpcval ( $this->service_pass, 'string' )); // password
		$req->addParam ( new xmlrpcval ( '<title>'.$title.'</title><category>'.$category.'</category>'.$content, 'string')); //content
		$req->addParam ( new xmlrpcval ( $publish, 'int')); // publish
		return $this->filtererrors($this->xr->send($req));	
	}
	public function updatePost_openpad($postID,$title,$category,$content,$publish)
	{
		$req = new xmlrpcmsg('openpad.updatePost');
		$req->addParam ( new xmlrpcval ( 1, 'int')); // dummy, this xml-rpc method needs it
		$req->addParam ( new xmlrpcval ( $postID, 'int')); // blog_id
		$req->addParam ( new xmlrpcval ( $this->service_user, 'string' )); // username
		$req->addParam ( new xmlrpcval ( $this->service_pass, 'string' )); // password
		$req->addParam ( new xmlrpcval ( '<title>'.$title.'</title><category>'.$category.'</category>'.$content, 'string')); //content
		$req->addParam ( new xmlrpcval ( $publish, 'int')); // publish
		return $this->filtererrors($this->xr->send($req));	
	}

	public function addPostTags($postID,$tags)
	{
 		$req = new xmlrpcmsg('openpad.addPostTags');
		$req->addParam ( new xmlrpcval ( $this->blogid, 'int')); // blog_id
		$req->addParam ( new xmlrpcval ( $this->service_user, 'string' )); // username
		$req->addParam ( new xmlrpcval ( $this->service_pass, 'string' )); // password
		$req->addParam ( new xmlrpcval ( $postID, 'int' )); // post_id
		$req->addParam ( new xmlrpcval ( $tags, 'string' )); // tags
		return $this->filtererrors($this->xr->send($req));		
	}


	public function deletePost($postID)
	{
		$req = new xmlrpcmsg('blogger.deletePost');
		$req->addParam ( new xmlrpcval ( 1, 'int')); // dummy, this xml-rpc method needs it
		$req->addParam ( new xmlrpcval ( $postID, 'int')); // blog_id
		$req->addParam ( new xmlrpcval ( $this->service_user, 'string' )); // username
		$req->addParam ( new xmlrpcval ( $this->service_pass, 'string' )); // password
		$req->addParam ( new xmlrpcval ( $publish, 'int')); // publish
		return $this->filtererrors($this->xr->send($req));	
	}
	
	public function changePostStatus($postID,$newStatus)
	{
		
	}
//Post meta fields methods
	public function insertPostMeta($postID,$metaField,$metaContent)
	{
 		$req = new xmlrpcmsg('openpad.createPostMeta');
		$req->addParam ( new xmlrpcval ( $this->blogid, 'int')); // blog_id
		$req->addParam ( new xmlrpcval ( $this->service_user, 'string' )); // username
		$req->addParam ( new xmlrpcval ( $this->service_pass, 'string' )); // password
		$req->addParam ( new xmlrpcval ( $postID, 'int' )); // post_id
		$req->addParam ( new xmlrpcval ( $metaField, 'string' )); // meta_key
		$req->addParam ( new xmlrpcval ( $metaContent, 'string' )); // meta_value
		return $this->filtererrors($this->xr->send($req));		
	}
	
	public function updatePostMeta($postID,$metaField,$metaContent)
	{
 		$req = new xmlrpcmsg('openpad.updatePostMeta');
		$req->addParam ( new xmlrpcval ( $this->blogid, 'int')); // blog_id
		$req->addParam ( new xmlrpcval ( $this->service_user, 'string' )); // username
		$req->addParam ( new xmlrpcval ( $this->service_pass, 'string' )); // password
		$req->addParam ( new xmlrpcval ( $postID, 'int' )); // post_id
		$req->addParam ( new xmlrpcval ( $metaField, 'string' )); // meta_key
		$req->addParam ( new xmlrpcval ( $metaContent, 'string' )); // meta_value
		return $this->filtererrors($this->xr->send($req));		
	}

	public function deletePostMeta($postID,$metaField)
	{
 		$req = new xmlrpcmsg('openpad.deletePostMeta');
		$req->addParam ( new xmlrpcval ( $this->blogid, 'int')); // blog_id
		$req->addParam ( new xmlrpcval ( $this->service_user, 'string' )); // username
		$req->addParam ( new xmlrpcval ( $this->service_pass, 'string' )); // password
		$req->addParam ( new xmlrpcval ( $postID, 'int' )); // post_id
		$req->addParam ( new xmlrpcval ( $metaField, 'string' )); // meta_key
		return $this->filtererrors($this->xr->send($req));		
	}
	
//Comment methods
	public function createComment($postID,$comment_parent,$author,$author_email,$author_url,$content)
	{
		$req = new xmlrpcmsg('wp.newComment');
		$req->addParam ( new xmlrpcval ( $this->blogid, 'int')); // blog_id
		$req->addParam ( new xmlrpcval ( $this->service_user, 'string' )); // username
		$req->addParam ( new xmlrpcval ( $this->service_pass, 'string' )); // password
		$req->addParam ( new xmlrpcval ($postID, 'int')); // post_id
		$struct = new xmlrpcval (
			array (
				"author" => new xmlrpcval ( $author, 'string' ), // author
				"author_email" => new xmlrpcval ( $author_email, 'string'), // author_email
				"author_url" => new xmlrpcval ( $author_url, 'string'), // author_url
				"author_parent" => new xmlrpcval ($comment_parent, 'int'), // comment_parent
				"content" => new xmlrpcval ( $content, 'string'), // content
			), "struct"
		);
		$req->addParam ( $struct );//content
		return $this->filtererrors($this->xr->send($req));		
	}
	
	public function updateComment($commentID,$author,$author_email,$author_url,$content)
	{
		$req = new xmlrpcmsg('wp.editComment');
		$req->addParam ( new xmlrpcval ( $this->blogid, 'int')); // blog_id
		$req->addParam ( new xmlrpcval ( $this->service_user, 'string' )); // username
		$req->addParam ( new xmlrpcval ( $this->service_pass, 'string' )); // password
		$req->addParam ( new xmlrpcval ($commentID, 'int')); // comment_id
		$struct = new xmlrpcval (
			array (
				"author" => new xmlrpcval ( $author, 'string' ), // author
				"author_email" => new xmlrpcval ( $author_email, 'string'), // author_email
				"author_url" => new xmlrpcval ( $author_url, 'string'), // author_url
				"content" => new xmlrpcval ( $content, 'string'), // content
			), "struct"
		);
		$req->addParam ( $struct );//content
		return $this->filtererrors($this->xr->send($req));		
	}

	public function deleteComment($commentID)
	{
		$req = new xmlrpcmsg('wp.deleteComment');
		$req->addParam ( new xmlrpcval ( $this->blogid, 'int')); // blog_id
		$req->addParam ( new xmlrpcval ( $this->service_user, 'string' )); // username
		$req->addParam ( new xmlrpcval ( $this->service_pass, 'string' )); // password
		$req->addParam ( new xmlrpcval ($commentID, 'int')); // comment_id
		return $this->filtererrors($this->xr->send($req));		
	}

//Comment meta fields methods	
	public function insertCommentMeta($commentID,$metaField,$metaContent)
	{
		$req = new xmlrpcmsg('openpad.createCommentMeta');
		$req->addParam ( new xmlrpcval ( $this->blogid, 'int')); // blog_id
		$req->addParam ( new xmlrpcval ( $this->service_user, 'string' )); // username
		$req->addParam ( new xmlrpcval ( $this->service_pass, 'string' )); // password
		$req->addParam ( new xmlrpcval ( $commentID, 'int' )); // comment_id
		$req->addParam ( new xmlrpcval ( $metaField, 'string' )); // meta_key
		$req->addParam ( new xmlrpcval ( $metaContent, 'string' )); // meta_value
		return $this->filtererrors($this->xr->send($req));		
	}
	
	public function updateCommentMeta($commentID,$metaField,$metaContent)
	{
 		$req = new xmlrpcmsg('openpad.updateCommentMeta');
		$req->addParam ( new xmlrpcval ( $this->blogid, 'int')); // blog_id
		$req->addParam ( new xmlrpcval ( $this->service_user, 'string' )); // username
		$req->addParam ( new xmlrpcval ( $this->service_pass, 'string' )); // password
		$req->addParam ( new xmlrpcval ( $commentID, 'int' )); // comment_id
		$req->addParam ( new xmlrpcval ( $metaField, 'string' )); // meta_key
		$req->addParam ( new xmlrpcval ( $metaContent, 'string' )); // meta_value
		return $this->filtererrors($this->xr->send($req));		
	}

	public function deleteCommentMeta($commentID,$metaField)
	{
 		$req = new xmlrpcmsg('openpad.deleteCommentMeta');
		$req->addParam ( new xmlrpcval ( $this->blogid, 'int')); // blog_id
		$req->addParam ( new xmlrpcval ( $this->service_user, 'string' )); // username
		$req->addParam ( new xmlrpcval ( $this->service_pass, 'string' )); // password
		$req->addParam ( new xmlrpcval ( $commentID, 'int' )); // comment_id
		$req->addParam ( new xmlrpcval ( $metaField, 'string' )); // meta_key
		return $this->filtererrors($this->xr->send($req));				
	}

}
?>