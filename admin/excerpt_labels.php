<?php

/** Pretty hardcore, overwrite gettext translation function. */
function lfm_excerpt_label( $translation, $original ) {
    if ( false !== strpos( $original, 'Excerpts are optional hand-crafted summaries of your' ) ) {
        return __( 'Textauszüge sind optionale, von Hand erstellte kurze Zusammenfassungen, die auf der Webseite als "Teasertext" angezeigt werden.' );
    } elseif ( "More Fields" == $original ) {
      return 'Weitere Angaben';
    }

    return $translation;
}
add_filter( 'gettext', 'lfm_excerpt_label', 10, 2 );

?>
