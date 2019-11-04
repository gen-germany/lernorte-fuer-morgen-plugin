<?php
$custom_post_type_coop    = 'bildungsanbieter';
$custom_post_type_event   = 'veranstaltung';
$custom_post_type_referee = 'referentn';

$current_user_id  = wp_get_current_user()->ID;
$bildungsanbieter = pods($custom_post_type_coop);
?>

<div class="getting-started">
  <h1 align=center><?php _e('Willkommen beim Verwaltungsbereich der LernOrte für MorGEN'); ?>
  <p  align=center><?php _e( 'Wir hoffen wir bringen dich hiermit schnell an den Start.' ); ?></p>
  <?php
    $bildungsanbieter->find(array(
        'limit' => 1,
        'where' => 't.post_author = ' . $current_user_id
      ));
    $bildungsanbieter->fetch();
    if( $bildungsanbieter->exists() ) {
    ?>
      <h2 align=center><?php _e("Du verwaltest: "); ?><?php echo $bildungsanbieter->display('post_title'); ?></h2>
   <?php
      } else {
   ?>
    <h3 align=center><?php _e("Dein Zugang ist noch nicht mit einem Bildungsanbieter verknüpft");?></h3>
    <br/>
    <div align=center>
      <a class="page-title-action" href="/wp-admin/post-new.php?post_type=<?php echo $custom_post_type_coop; ?>"><?php echo _e('Bitte lege einen an'); ?></a>
    </div>
    <?php
      }
    ?>
  <br/>
</div>
