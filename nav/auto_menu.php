<?php

/*
add_filter( 'wp_nav_menu_items', 'lfm_add_calendar_menu_items', 10, 2);
function lfm_add_calendar_menu_items ( $items, $args ) {
  $items .= '<li class="menu-item menu-item-has-children"><a href="">My menu entry</a></li>';
  return $items;
}*/

function lfm_add_calendar_items ( $items, $args) {
	// Only attach to main menu
	if ( 'primary-menu' !== $args->theme_location ) {
		return $items;
  }

  $initial_calendar_nav_parent_id = 9997771;
  $current_walk_id = $initial_calendar_nav_parent_id;

  $today_dt = new DateTime();
  $today_dt->modify( 'first of month' );

  $current_year = $today_dt->format( 'Y' );
	
	// Iterate over months, years, ...
  $items[] = (object) array(
    'title' => "Kalender",
    'ID'    => 'nav_cal',
    'db_id' => $initial_calendar_nav_parent_id,
    'current' => false,
    'target'  => '',
    'classes' => array( 'menu-item', 'menu-item-has-children' ),
    'url' => 'https://bog.us'
  );
  $items[] = (object) array(
    'title' => $current_year,
    'ID' => 'nav_current_year',
    'menu_item_parent' => $initial_calendar_nav_parent_id,
    'db_id' => $current_walk_id += 1,
    'current' => false,
    'target'  => '',
    'classes' => array( 'menu-item', 'menu-item-has-children' ),
    'url' => 'https://bog.us/me'
  );

  /*
  $items[] = (object) array(
    'title' => $today_dt->format( 'F' ),
    'ID' => 'nav_current_month',
    'menu_item_parent' => $current_walk_id,
    'db_id'   => $current_walk_id += 1,
    'current' => false,
    'target'  => '',
    'url' => 'https://bog.us/me/too'
  );
   */

  while ( $today_dt->format( 'Y' ) == $current_year ) {
    $items[] = (object) array(
      'title' => $today_dt->format( 'F' ),
      'ID' => 'nav_current_month',
      'menu_item_parent' => $current_walk_id,
      'db_id'   => $current_walk_id += 1,
      'current' => false,
      'target'  => '',
      'url' => 'https://bog.us/me/too'
    );
    $today_dt->modify( '+1 month' );
  }
  return $items;
}
add_filter( ' wp_nav_menu_objects', 'lfm_add_calendar_items', 10, 2 );

?>
