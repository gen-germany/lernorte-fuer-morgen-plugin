<?php
$custom_post_type_coop    = 'bildungsanbieter';
$custom_post_type_event   = 'veranstaltung';
$custom_post_type_referee = 'referentn';

$current_user_id  = wp_get_current_user()->ID;
$bildungsanbieter = pods($custom_post_type_coop);
$bildungsanbieter->find(array(
  'limit' => 1,
  'where' => 't.post_author = ' . $current_user_id
));
$bildungsanbieter->fetch();
?>

<?php if( $bildungsanbieter->exists() ) { ?>
  <p>
    <?php _e("xyz Veranstaltungen"); ?>
  </p>
  <p>
    <?php _e("xyz ohne Bild! -> "); ?>
  </p>
  <a class="page-title-action" href="/wp-admin/post-new.php?post_type=<?php echo $custom_post_type_event; ?>"><?php echo _e('Veranstaltung erstellen'); ?></a>
<?php
  } else {
?>
  <h4 align=center><?php _e("Dein Zugang ist noch nicht mit einem Bildungsanbieter verknüpft");?></h4>
  <br/>
  <div align=center>
    <a class="page-title-action" href="/wp-admin/post-new.php?post_type=<?php echo $custom_post_type_coop; ?>"><?php echo _e('Bitte lege einen an'); ?></a>
  </div>
<?php
  }
?>
