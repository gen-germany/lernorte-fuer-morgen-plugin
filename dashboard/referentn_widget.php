<?php

$custom_post_type_coop    = 'lernort';
$custom_post_type_event   = 'veranstaltung';
$custom_post_type_referee = 'referentn';

$current_user_id  = wp_get_current_user()->ID;
$lernort = pods($custom_post_type_coop);
$lernort->find(array(
  'limit' => 1,
  'where' => 't.post_author = ' . $current_user_id
));
$lernort->fetch();

if( $lernort->exists() ) {
    $query_params = array(
      'where' => 'lernort.ID = ' . $lernort->ID()
    );
    $referentn = pods( $custom_post_type_referee, $query_params );
  ?>
  <p>
    <?php
      /* TODO: Enhance translatability */
      _e("Dem Lernort sind ");
      echo $referentn->total();
      _e(" Referent*n zugeordnet."); ?>
  </p>
  <!--p>
    <?php _e("xyz ohne Bild! -> "); ?>
  </p-->
  <a class="page-title-action" href="/wp-admin/post-new.php?post_type=<?php echo $custom_post_type_referee; ?>">
    <?php echo _e('Referent*n erstellen'); ?>
  </a>
<?php
  } else {
?>
  <h4 align=center><?php _e("Dein Zugang ist noch nicht mit einem Lernort verknüpft");?></h4>
  <br/>
  <div align=center>
    <a class="page-title-action" href="/wp-admin/post-new.php?post_type=<?php echo $custom_post_type_coop; ?>">
      <?php echo _e('Bitte lege einen an'); ?>
    </a>
  </div>
<?php
  }
?>
