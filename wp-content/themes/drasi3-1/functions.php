<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);

// Names and stuff
define('URL',get_bloginfo('url'));
define('NAME',get_bloginfo('name'));
define('DESCRIPTION',get_bloginfo('description'));

// Define folder constants
define('ROOT', get_bloginfo('template_url'));
define('JS', ROOT . '/js');
define('IMG', ROOT . '/img');
define('DESIGN', ABSPATH.'/design'); /* config parameter*/

add_filter( 'the_content', 'mask_email' ); 

//@link http://codex.wordpress.org/Function_Reference/in_category#Testing_if_a_post_is_in_a_descendant_category
function post_is_in_descendant_category( $cats, $_post = null ){

	foreach ( (array) $cats as $cat ) {
		$descendants = get_term_children( (int) $cat, 'category');
		if ( $descendants && in_category( $descendants, $_post ) )
			return true;
	}
	return false;
}

 // @link http://wordpress.org/support/topic/272978
function is_descendant_category($cat_id){

	if ( is_category() ) {
		$cat = get_query_var('cat');
		$args = array(
			'include' => $cat,
			'hide_empty' => 0
		  );
		$categories = get_categories($args);
		if ( ($cat == $cat_id) || ($categories[0]->category_parent == $cat_id) ) {
		return true;
	  }
	  return false;
	}
}

/* Return Links to a Given RSS Feed ************************/
function getRSSFeed($url, $numitems = '5', $before='<li>', $after='</li>')
{
	if(!is_null($url)){	
		require_once(ABSPATH. "wp-includes/rss-functions.php");
		$rss = fetch_rss($url);
		if($rss)
			foreach(array_slice($rss->items,0,$numitems) as $item)
				echo "$before<a title=\"".$item['description']."\" href=\"".$item['link']."\" target=\"_blank\">".$item['title']."</a>$after";
		else
			echo "<!--An error occured! There is a possibility that your feed may be badly formatted.<br />-->";
	}
	else
		echo "<!--An error occured! No url was specified.-->";
}

/* Masks eMails in Content with Hex ************************/
function mask_email($text) {

	$lines=split("\n",stripslashes($text));
	foreach($lines as $theline){
		if(preg_match_all("/(mailto:[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5})/", $theline, $matches)){
			foreach($matches[1] as $key => $address)	{
				$at = '<img src="'.IMG.'/at_symbol.gif" class="mailmasker" />';
				$encoded_address = "mailto:".email_encode(substr($address,7));
				$theline = str_replace($address, $encoded_address, $theline);	
				$theline = str_replace("@", $at, $theline);
				//$theline = str_replace("edulll.gov.gr", "(-at-)edulllgov.gr", $theline);
			}
		}	
		$finaltext .= $theline;
	}
	return $finaltext;
}

function email_encode($email_address) {
	$encoded = bin2hex("$email_address");
	$encoded = chunk_split($encoded, 2, '%');
	$encoded = '%' . substr($encoded, 0, strlen($encoded) - 1);
	return $encoded;
}

function wp_exist_post($id) {
	global $wpdb;
	return $wpdb->get_row("SELECT * FROM wp_posts WHERE id = '" . $id . "'", 'ARRAY_A');
}

function show_filters($cat_id){
	echo '<ul>';
	
	$args=array(
	  'child_of' => $cat_id,
	  'hide_empty' => 0,
	  'orderby'  => 'count',
	  'order' => 'DESC'
	  );
	  
	  $incarr = array();
	
	 if(isset($_GET["i"])){
		$inc = mysql_real_escape_string( trim ($_GET["i"]));
		if (strlen($inc)!=0){
			$incarr = explode(',', $inc);
		}
	}
	
	if(isset($_GET["t"])){
		$type = '&t=OR';
	} else {
		$type = '';
	}
	
	$categories=  get_categories($args); 

	foreach ($categories as $category) {
	
		if($category->category_count > 0){
			
			if (in_array($category->cat_ID, $incarr)) {
				$option = '<li class="remove">';
				$newarr = $incarr;				
				foreach($newarr as $key => $value) {
					if($value == $category->cat_ID) { unset($newarr[$key]); }
					}
					$newarr = array_values($newarr);
					
			} else {
				$option = '<li class="add">';	
				$newarr = $incarr;
				array_push($newarr, $category->cat_ID);
			}
			$option .= '<a href="'.URL.'/?i='.implode(",", $newarr).$type.'">';
			$option .= $category->cat_name.'</a>';
			$option .= ' ('.$category->category_count.')';
			$option .= '</li>';
			
		} else {
			$option = '<li>'.$category->cat_name;
			//$option .= ' ('.$category->category_count.')';
			$option .= '</li>';
		}
		echo $option;
	}
	echo '</ul>';
}

function dropdown_tag_cloud( $args = '' ) {
	$defaults = array(
		'smallest' => 8, 'largest' => 22, 'unit' => 'pt', 'number' => 45,
		'format' => 'flat', 'orderby' => 'name', 'order' => 'ASC',
		'exclude' => '', 'include' => ''
	);
	$args = wp_parse_args( $args, $defaults );

	$tags = get_tags( array_merge($args, array('orderby' => 'count', 'order' => 'DESC')) ); // Always query top tags

	if ( empty($tags) )
		return;

	$return = dropdown_generate_tag_cloud( $tags, $args ); // Here's where those top tags get sorted according to $args
	if ( is_wp_error( $return ) )
		return false;
	else
		echo apply_filters( 'dropdown_tag_cloud', $return, $args );
}

function dropdown_generate_tag_cloud( $tags, $args = '' ) {
	global $wp_rewrite;
	$defaults = array(
		'smallest' => 8, 'largest' => 22, 'unit' => 'pt', 'number' => 45,
		'format' => 'flat', 'orderby' => 'name', 'order' => 'ASC'
	);
	$args = wp_parse_args( $args, $defaults );
	extract($args);

	if ( !$tags )
		return;
	$counts = $tag_links = array();
	foreach ( (array) $tags as $tag ) {
		$counts[$tag->name] = $tag->count;
		$tag_links[$tag->name] = get_tag_link( $tag->term_id );
		if ( is_wp_error( $tag_links[$tag->name] ) )
			return $tag_links[$tag->name];
		$tag_ids[$tag->name] = $tag->term_id;
	}

	$min_count = min($counts);
	$spread = max($counts) - $min_count;
	if ( $spread <= 0 )
		$spread = 1;
	$font_spread = $largest - $smallest;
	if ( $font_spread <= 0 )
		$font_spread = 1;
	$font_step = $font_spread / $spread;

	// SQL cannot save you; this is a second (potentially different) sort on a subset of data.
	if ( 'name' == $orderby )
		uksort($counts, 'strnatcasecmp');
	else
		asort($counts);

	if ( 'DESC' == $order )
		$counts = array_reverse( $counts, true );

	$a = array();

	$rel = ( is_object($wp_rewrite) && $wp_rewrite->using_permalinks() ) ? ' rel="tag"' : '';

	foreach ( $counts as $tag => $count ) {
		$tag_id = $tag_ids[$tag];
		$tag_link = clean_url($tag_links[$tag]);
		$tag = str_replace(' ', '&nbsp;', wp_specialchars( $tag ));
		$a[] = "\t<option value='$tag_link'>$tag ($count)</option>";
	}

	switch ( $format ) :
	case 'array' :
		$return =& $a;
		break;
	case 'list' :
		$return = "<ul class='wp-tag-cloud'>\n\t<li>";
		$return .= join("</li>\n\t<li>", $a);
		$return .= "</li>\n</ul>\n";
		break;
	default :
		$return = join("\n", $a);
		break;
	endswitch;

	return apply_filters( 'dropdown_generate_tag_cloud', $return, $tags, $args );
}


function the_category_filter($thelist,$separator=' ') {
	if(!defined('WP_ADMIN')) {
		//Category IDs to exclude
		$exclude = array(1);

		$exclude2 = array();
		foreach($exclude as $c) {
			$exclude2[] = get_cat_name($c);
		}

		$cats = explode($separator,$thelist);
		$newlist = array();
		foreach($cats as $cat) {
			$catname = trim(strip_tags($cat));
			if(!in_array($catname,$exclude2))
				$newlist[] = $cat;
		}
		return implode($separator,$newlist);
	} else {
		return $thelist;
	}
}
add_filter('the_category','the_category_filter', 10, 2);

add_action('admin_menu','wphidenag');
function wphidenag() {
remove_action( 'admin_notices', 'update_nag', 3 );
}

?>
