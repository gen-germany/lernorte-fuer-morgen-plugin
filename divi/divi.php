<?php

/**
 * Remove the Divi "Project" stuff from backend.
 */
add_filter( 'et_project_posttype_args', 'lfm_et_project_posttype_args', 10, 1 );
function lfm_et_project_posttype_args( $args ) {
	return array_merge( $args, array(
		'public'              => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => false,
		'show_in_nav_menus'   => false,
		'show_ui'             => false
	));
}

?>
