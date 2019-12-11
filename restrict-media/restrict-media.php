/*
 * Originally licensed under GPLv2+, Copyright 2015 Jam Việt, relicensed in the lernorte-fuer-morgen-plugin under the GPLv3.
 * Source: http://www.jamviet.com/2015/05/restrict-author-posting.html , https://plugins.trac.wordpress.org/browser/restrict-author-posting/trunk
 * For transparency reasons the initial commit in the lernorte-fuer-morgen git-repository for the file contains the relevant original source code and was stripped and modified by Felix Wolfsteller afterwards.

Header of file readme.txt

=== Restrict Author Posting ===
Contributors: mcjambi
Tags: restrict user, banned user, user role, posting to category, specific posting category,author role
Requires at least: 3.0
Tested up to: 4.8
Stable tag: 2.1.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate link: http://www.jamviet.com/2015/05/restrict-author-posting.html
*/

<?php
/*
Plugin Name: Restrict Author Posting
Plugin URI: http://www.jamviet.com/2015/05/restrict-author-posting.html
Description: This plugin help you to add restriction posting to editor/author in your blog.
Author: Jam Việt
Version: 2.1.5
Tags:   restrict user, banned user, user role, posting to category, specific posting category, author role, restrict using media, user file media
Author URI: http://www.jamviet.com
Donate link: http://www.jamviet.com/2015/05/restrict-author-posting.html
Text Domain: restrict-author-posting
*/

/*
Thanks to my friend: Pete Stoves  (email : stovesy@gmail.com)
        Changed to allow the selection of more than one category restriction.
        We use jQuery and...
                the jquery.multiple.select plugin (http://wenzhixin.net.cn/p/multiple-select)
                Copyright (c) 2012-2014 Zhixin Wen <wenzhixin2010@gmail.com>

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
Add translate function to plugin !
*/

add_action( 'plugins_loaded', 'restrictauthorposting_load_textdomain' );
function restrictauthorposting_load_textdomain() {
  load_plugin_textdomain( 'restrict-author-posting', false, plugin_basename( dirname( __FILE__ ) ) . '/lang' );
}

add_action( 'admin_enqueue_scripts', 'restrict_user_form_enqueue_scripts' );
function restrict_user_form_enqueue_scripts($hook) {
        if ( ! in_array($hook, array('profile.php', 'user-edit.php' )))
                return;
        wp_enqueue_script('jquery');
        wp_enqueue_script( 'jquery.multiple.select', plugin_dir_url( __FILE__ ) . 'inc/jquery.multiple.select.js' );
        wp_register_style( 'jquery.multiple.select_css', plugin_dir_url( __FILE__ ) . 'inc/multiple-select.css', false, '1.0.0' );
        wp_enqueue_style( 'jquery.multiple.select_css' );
}

/*
        restrict User using own Media
*/

function jamviet_restrict_author_file_in_media( $wp_query = array() ) {
                $user_id = get_current_user_id();
                if ( get_user_meta( $user_id , '_restrict_media', true) ) {
                        $wp_query['author'] =  $user_id;
                }
                return $wp_query;
}
add_filter('ajax_query_attachments_args', 'jamviet_restrict_author_file_in_media' );


/*
Change default category to his/her category !
*/

add_filter('pre_option_default_category', 'jam_change_default_category');

function jam_change_default_category($ID) {
        // Avoid error or heavy load !
        if ( ! is_user_logged_in() )
                return $ID;
        $user_id = get_current_user_id();
        $restrict_cat = get_user_meta( $user_id, '_access', true);
        if ( is_array($restrict_cat) ) {
                return reset($restrict_cat);
        } else {
                return $ID;
        }
}


/**
* Exclude categories which arent selected for this user.
*/
add_filter( 'get_terms_args', 'restrict_user_get_terms_args', 10, 2 );

function restrict_user_get_terms_args( $args, $taxonomies ) {
        // Dont worry if we're not in the admin screen
        if (! is_admin() || $taxonomies[0] !== 'category')
                return $args;
        // Admin users are exempt.
        $currentUser = wp_get_current_user();
        if (in_array('administrator', $currentUser->roles))
                return $args;

        $include = get_user_meta( $currentUser->ID, '_access', true);

        $args['include'] = $include;
        return $args;
}
/*
        Display and save data in admin setting !
*/
add_action( 'show_user_profile', 'restrict_user_form' );
add_action( 'edit_user_profile', 'restrict_user_form' );
function restrict_user_form( $user ) {
        // A little security
        if ( ! current_user_can('add_users'))
                return false;
        $args = array(
                'show_option_all'    => '',
                'orderby'            => 'ID',
                'order'              => 'ASC',
                'show_count'         => 0,
                'hide_empty'         => 0,
                'child_of'           => 0,
                'exclude'            => '',
                'echo'               => 0,
                'hierarchical'       => 1,
                'name'               => 'allow',
                'id'                 => '',
                'class'              => 'postform',
                'depth'              => 0,
                'tab_index'          => 0,
                'taxonomy'           => 'category',
                'hide_if_empty'      => false,
                'walker'             => ''
        );

        $dropdown = wp_dropdown_categories($args);
        // We are going to modify the dropdown a little bit.
        $dom = new DOMDocument();
        /*
                @http://ordinarygentlemen.co.uk
                There's an error here, while using PHP 5.4 not support LIBXML_HTML_NOIMPLIED or LIBXML_HTML_NODEFDTD
                Vietnamese error, So fixed it by adding mb_convert_encoding() !
        */
        //$dom->loadHTML($dropdown, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $dom->loadHTML( mb_convert_encoding($dropdown, 'HTML-ENTITIES', 'UTF-8') );
        $xpath = new DOMXpath($dom);
        $selectPath = $xpath->query("//select[@id='allow']");

        if ($selectPath != false) {
                // Change the name to an array.
                $selectPath->item(0)->setAttribute('name', 'allow[]');
                // Allow multi select.
                $selectPath->item(0)->setAttribute('multiple', 'yes');

                $selected = get_user_meta( $user->ID, '_access', true);
                // Flag as selected the categories we've previously chosen
                // Do not throught error in user's screen ! // @JamViet
                if ( $selected )
                foreach ($selected as $term_id) {
                        // fixed delete category make error !
                        if (!empty($term_id) && get_the_category_by_ID($term_id) ){
                                $option = $xpath->query("//select[@id='allow']//option[@value='$term_id']");
                                $option->item(0)->setAttribute('selected', 'selected');
                        }
                }
        }
?>
        <h3><?php _e('Restrict the categories in which this user can post to', 'restrict-author-posting'); ?></h3>
        <table class="form-table">
                <tr>
                        <th><label for="access"><?php _e('Select categories', 'restrict-author-posting') ?>:</label></th>
                        <td>
                                <?php echo $dom->saveXML($dom);?>
                                <span class="description"><?php _e('Author restriced to post selected categories only.', 'restrict-author-posting') ?></span>
                        </td>
                </tr>

        </table>
        <table class="form-table">
                <tr>
                        <th><label for="access"><?php _e('Restrict using his/her own file in Media', 'restrict-author-posting') ?></label></th>
                        <td>
                                        <fieldset>
                                        <legend class="screen-reader-text"><span><?php _e('Restrict using his/her own file in Media', 'restrict-author-posting') ?></span></legend>
                                        <label for="_restrict_media">
                                        <input type="checkbox" <?php checked (get_user_meta($user->ID, '_restrict_media', true), 1, 1 ) ?> value="1" id="_restrict_media" name="_restrict_media">
                                <?php _e('Whenever it checked, Author can only use his/her own file (image/video) in Media', 'restrict-author-posting') ?></label>
                                        </fieldset>
                        </td>
                </tr>
        </table>
        <script>
        <!--
                jQuery('select#allow').multipleSelect();
        -->
        </script>
<?php
}

/* save the category selections from admin */
add_action( 'personal_options_update', 'restrict_save_data' );
add_action( 'edit_user_profile_update', 'restrict_save_data' );
function restrict_save_data( $user_id ) {
        // check security
        if ( ! current_user_can( 'add_users' ) )
                return false;
        // admin can not restrict himself
        if ( get_current_user_id() == $user_id )
                return false;
        // and last, save it
        if ( ! empty ($_POST['_restrict_media']) ) {
                update_user_meta( $user_id, '_restrict_media', $_POST['_restrict_media'] );
        } else {
                delete_user_meta( $user_id, '_restrict_media' );
        }
        if ( ! empty ($_POST['allow']) ) {
                update_user_meta( $user_id, '_access', $_POST['allow'] );
        } else  {
                delete_user_meta( $user_id, '_access' );
        }
}
