<?php

add_action('admin_head', 'lfm_remove_help_tabs');
function lfm_remove_help_tabs() {
    $screen = get_current_screen();
    $screen->remove_help_tabs();
}

?>
