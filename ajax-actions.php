<?php

function austeve_get_post_ajax() {
	check_ajax_referer( "austevegetpost" );
	if( $_POST[ 'postId' ] !== 'undefined' )
	{
		$postId = $_POST[ 'postId' ];
		echo apply_filters('the_content', get_post_field('post_content', $postId));
		die();
	}
	echo "ERROR: There was a problem retrieving the post. Please refresh and try again.";
	die();
}
add_action( 'wp_ajax_austeve_get_post', 'austeve_get_post_ajax' );
add_action( 'wp_ajax_nopriv_austeve_get_post', 'austeve_get_post_ajax' );

?>