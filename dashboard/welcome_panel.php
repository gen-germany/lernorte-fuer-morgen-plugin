<?php
$custom_post_type_coop    = 'lernort';
$custom_post_type_event   = 'veranstaltung';
$custom_post_type_referee = 'referentn';

$current_user_id  = wp_get_current_user()->ID;
$lernorte = pods($custom_post_type_coop);
?>

<div class="getting-started">
  <h1 align=center><?php _e('Willkommen beim Verwaltungsbereich der LernOrte für MorGEN'); ?>
  <p  align=center><?php _e( 'Wir hoffen wir bringen dich hiermit schnell an den Start.' ); ?></p>
  <?php
    $lernorte->find(array(
        'limit' => 1,
        'where' => 't.post_author = ' . $current_user_id
      ));
    $lernorte->fetch();
    if( $lernorte->exists() ) {
    ?>
      <h2 align=center><?php _e("Du verwaltest: "); ?><?php echo $lernorte->display('post_title'); ?></h2>
   <?php
      } else {
   ?>
    <h3 align=center><?php _e("Dein Zugang ist noch nicht mit einem Bildungsanbieter verknüpft");?></h3>
    <br>
    <div align=center>
      <a class="page-title-action" href="/wp-admin/post-new.php?post_type=<?php echo $custom_post_type_coop; ?>"><?php echo _e('Bitte lege einen an'); ?></a>
    </div>
    <?php
      }
    ?>
</div>
