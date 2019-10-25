<?php
/**
 * Our custom dashboard page
 */

/** WordPress Administration Bootstrap */
require_once( ABSPATH . 'wp-load.php' );
require_once( ABSPATH . 'wp-admin/admin.php' );
require_once( ABSPATH . 'wp-admin/admin-header.php' );

$custom_post_type_coop    = 'kooperationspartner';
$custom_post_type_event   = 'veranstaltung';
$custom_post_type_referee = 'referentn';
?>
<div class="wrap about-wrap">

	<h1><?php _e( 'Willkommen bei Lernorte für MorGEN' ); ?></h1>
	
<div class="about-text">
		<?php _e('Wir hoffen wir bringen dich hiermit schnell an den Start' ); ?>
  </div>

  <div>
    <?php
      $current_user_id  = wp_get_current_user()->ID;
      $bildungsanbieter = pods($custom_post_type_coop);
      $bildungsanbieter->find(array(
          'limit' => 1,
          'where' => 't.post_author = ' . $current_user_id
        ));
      $bildungsanbieter->fetch();
      if( $bildungsanbieter->exists() ) {
    ?>
      <h3><?php _e("Dein Zugang ist mit folgendem Bildungsanbieter verknüpft:"); ?></h3>
    <?php
        echo $bildungsanbieter->display('post_title');
        echo $bildungsanbieter->display('permalink');
    ?>
    <div id="dashboard-widgets-wrap">
      <div id="dashboard-widgets" class="metabox-holder">
        <div id="postbox-container-1" class="postbox-container">
          <div id="normal-sortables" class="meta-box-sortables ui-sortable">
            <div class="postbox">
              <div title="Click to toggle" class="handlediv"><br></div>
              <h3 class="hndle"><span>Box Title</span></h3>
              <div class="inside">
                <a href="/wp-admin/post-new.php?post_type=<?php echo $custom_post_type_event; ?>"><?php echo _e('Veranstaltung erstellen'); ?></a>
              </div>
            </div>
            <div class="postbox">
              <div title="Click to toggle" class="handlediv"><br></div>
              <h3 class="hndle"><span>Box Title</span></h3>
              <div class="inside">
                <a href="/wp-admin/post-new.php?post_type=<?php echo $custom_post_type_referee; ?>"><?php echo _e('Referent*n anlegen'); ?></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
      } else {
    ?>
    <h3><?php e_("Dein Zugang ist noch nicht mit einem Bildungsanbieter verknüpft");?></h3>
    <a href="/wp-admin/post-new.php?post_type=<?php echo $custom_post_type_coop; ?>"><?php echo _e('Bitte lege einen an'); ?></a>
    <?php
      }
    ?>
  </div>
	
	<div class="changelog">
		<h3><?php _e( 'Morbi leo risus, porta ac consectetur' ); ?></h3>
	
		<div class="feature-section images-stagger-right">
			<img src="<?php echo esc_url( admin_url( 'images/screenshots/theme-customizer.png' ) ); ?>" class="image-50" />
			<h4><?php _e( 'Risus Consectetur Elit Sollicitudin' ); ?></h4>
			<p><?php _e( 'Cras mattis consectetur purus sit amet fermentum. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Vestibulum id ligula porta felis euismod semper. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Nulla vitae elit libero, a pharetra augue. Donec sed odio dui.' ); ?></p>
		</div>
	</div>

</div>
<?php include( ABSPATH . 'wp-admin/admin-footer.php' );
