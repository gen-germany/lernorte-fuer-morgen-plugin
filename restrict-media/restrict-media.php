<?php

/*
 * Originally licensed under GPLv2+, Copyright 2015 Jam Việt, relicensed in the lernorte-fuer-morgen-plugin under the GPLv3.
 * Source: http://www.jamviet.com/2015/05/restrict-author-posting.html , https://plugins.trac.wordpress.org/browser/restrict-author-posting/trunk
 * For transparency reasons the initial commit in the lernorte-fuer-morgen git-repository for the file contains the relevant original source code and was stripped and modified by Felix Wolfsteller afterwards.

Header of file readme.txt

=== Restrict Author Posting ===
Contributors: mcjambi
Tags: restrict user, banned user, user role, posting to category, specific posting category,author role
Requires at least: 3.0
Tested up to: 4.8
Stable tag: 2.1.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate link: http://www.jamviet.com/2015/05/restrict-author-posting.html
*/

/* Restrict User using own Media except for admin */
function jamviet_restrict_author_file_in_media( $wp_query = array() ) {
  $user = wp_get_current_user();
  if ( in_array( 'administrator', (array) $user->roles ) ) {
    // The user has the "administrator" role, can see all media.
  }
  else {
    // This user shall see its own media items only.
    $user_id = get_current_user_id();
    $wp_query['author'] =  $user_id;
  }
  return $wp_query;
}
add_filter('ajax_query_attachments_args', 'jamviet_restrict_author_file_in_media');

