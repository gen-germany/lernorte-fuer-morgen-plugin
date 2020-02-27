<?php

// Remove fields from Admin profile page
function lfm_remove_personal_options( $subject ) {
  $subject = preg_replace('#<tr class="user-rich-editing-wrap(.*?)</tr>#s', '', $subject, 1); // Remove the "Visual Editor" field
  $subject = preg_replace('#<tr class="user-comment-shortcuts-wrap(.*?)</tr>#s', '', $subject, 1); // Remove the "Keyboard Shortcuts" field
  $subject = preg_replace('#<tr class="user-syntax-highlighting-wrap(.*?)</tr>#s', '', $subject, 1); // Remove the "Syntax code highlight " field
  #<tr class="show-admin-bar(.*?)</tr>#s', '', $subject, 1); // Remove the "Toolbar" field
  $subject = preg_replace('#<h2>'.__("Name").'</h2>#s', '', $subject, 1); // Remove the "Name" title
  $subject = preg_replace('#<tr class="user-display-name-wrap(.*?)</tr>#s', '', $subject, 1); // Remove the "Display name publicly as" field
  $subject = preg_replace('#<tr class="user-language-wrap(.*?)</tr>#s', '', $subject, 1); // Remove the "Language" field
  $subject = preg_replace('#<tr class="user-nickname-wrap(.*?)</tr>#s', '', $subject, 1); // Remove the "Nickname" field
  $subject = preg_replace('#<tr class="user-url-wrap(.*?)</tr>#s', '', $subject, 1); // Remove the "Website" field
  $subject = preg_replace('#<h2>'.__("About Yourself").'</h2>#s', '', $subject, 1); // Remove the "About Yourself" title
  $subject = preg_replace('#<tr class="user-description-wrap(.*?)</tr>#s', '', $subject, 1); // Remove the "Biographical Info" field
  $subject = preg_replace('#<tr class="user-profile-picture(.*?)</tr>#s', '', $subject, 1); // Remove the "Profile Picture" field

  return $subject;
}

function lfm_profile_subject_start() {
  $user = wp_get_current_user();
  if ( in_array( 'administrator', (array) $user->roles ) ) {
    // hide nothing from admin
  }
  else {
    ob_start( 'lfm_remove_personal_options' );
  }
}

function lfm_profile_subject_end() {
  $user = wp_get_current_user();
  $user = wp_get_current_user();
  if ( in_array( 'administrator', (array) $user->roles ) ) {
    // hide nothing from admin
  }
  if ( ! current_user_can('manage_options') ) {
    ob_end_flush();
  }
}

add_action( 'admin_head',   'lfm_profile_subject_start' );
add_action( 'admin_footer', 'lfm_profile_subject_end' );

?>
