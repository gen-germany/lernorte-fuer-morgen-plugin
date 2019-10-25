<?php
/**
 * Our custom dashboard page
 */

/** WordPress Administration Bootstrap */
require_once( ABSPATH . 'wp-load.php' );
require_once( ABSPATH . 'wp-admin/admin.php' );
require_once( ABSPATH . 'wp-admin/admin-header.php' );

$custom_post_type = 'kooperationspartner';
?>
<div class="wrap about-wrap">

	<h1><?php _e( 'Willkommen bei Lernorte für MorGEN' ); ?></h1>
	
<div class="about-text">
		<?php _e('Wir hoffen wir bringen dich hiermit schnell an den Start' ); ?>
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
