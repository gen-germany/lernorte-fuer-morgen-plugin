# Lernorte für MorGEN Wordpress plugin

This is a WordPress plugin for the Lernorte für MorGEN website.

Pretty specific stuff, but if you want to get some inspiration or get in contact or feedback, feel free!

Other parts are covered by the [Child-Theme](https://github.com/gen-germany/lernorte-fuer-morgen-childtheme).

## Installation

There is not much sense in installing this for a page different then "[lernorte für morgen](https://lernorte.gen-deutschland.de)" - if you are inclined to do that its a very good idea to get in contact with us first.

  * Install [github-updater](https://github.com/afragen/github-updater)
  * Use [github-updater](https://github.com/afragen/github-updater) and provide `https://github.com/gen-germany/lernorte-fuer-morgen-plugin` as the URL.

### Prerequisites

The plugin assumes certain [pod](pods.io) (CPT) classes to be installed and configured which is not (yet?) done from within this plugin!
Eventually, the pods/CPTs could be create by this plugin, but I am not yet sure how and whether this is always a good idea. Happy about comments.

Specifically, following pods are expected to exist
<table>
  <tr>
    <td>pod name</td>
    <td>props</td>
    <td>needed templates</td>
  </tr>
  <tr>
    <td>Veranstaltung</td>
    <td>...</td>
    <td>...</td>
  </tr>
  <tr>
    <td>Referentn</td>
    <td>...</td>
    <td>Referent*n: Single</td>
  </tr>
  <tr>
    <td>Lernort</td>
    <td>...</td>
    <td>...</td>
  </tr>
</table>

## Implemented Features

**Technical**
  * Make nested shortcodes work (although this might be removed once features implemented within this plugin TODO) - done in `lernorte-fuer-morgen.php` .

**Styling**
  * Modify style of require featured image plugin, so that the warning shows up bigger.

**Dashboard**
  * Modify Dashboard:
    * remove default widgets
    * add custom welcome box
    * add custom help box
    * add custom widgets for events and referees

**"POD"ish**
([pods/](pods/))

  * Modify certain admin forms for own content types via css `::before`
  * Force default setting of `lernort` when creating a `veranstaltung` (`function autoselect_lernort()`).

**Admin/UI**
([admin/](admin/))
  * Hide irrelevant options from profile editing page for users.
  * Remove Wordpress "Help" links

**Editing**
([editor_ui/editor_ui.php](editor_ui/editor_ui.php))
  * Restrict media usage of users to own media (exception: users with 'administrator' role)
    - Code from https://plugins.trac.wordpress.org/browser/restrict-author-posting/trunk/readme.txt
    - licensed under GPLv2 or later, Copyright Jam Việt 2015 (https://plugins.trac.wordpress.org/browser/restrict-author-posting/trunk/restrict-author-posting.php)
    - GPLv3 is included in this repository
  * Remove divis default project thing
  * add custom search form
  * In (classic) editor for non-admins, hide:
    - pods shortcode generator
    - media buttons
    - visual/text tab
  * Change excerpt help text ('labels').
  * Change 'More Fields' label.
  * Remove Caldera Form Button for non-admins
  * Display a warning in tinyMCEs word count field if referentn description is
    above 60 words long.

**Calender/Filtering**
  * Add query vars for year and month in order to use them in rewrite and
    calendar display (to a hardcoded page).
  * Rewrite "veranstaltungen/2022/10" to include the query vars.
  * Automatically populate the menu with links to years and months
    (`[nav/auto_menu.php](nav/auto_menu.php)`).
    * -> **GOTCHA**: You have to visit the Permalink settings page in WP Admin in order to flush the rewrite cache!
  * shortcode

**Shortcodes**
([shortcodes/shortcodes.php](shortcodes/shortcodes.php))
  * [lfm_veranstaltungen_count] returns number of `veranstaltung` entities
  * [lfm_referentn_count] returns number of `referentn` entities
  * [lfm_lernorte_count] returns number of `lernorte` entities
  * [lfm_month_links] shows links per (upcoming) month

## Gotchas

  * Use of German terms, because form UI for creating POD items is not easily translateable.

## Development

### Release

  * modify [lernorte-fuer-morgen.php](lernorte-fuer-morgen.php); bump the version number
  * add change and commit with version number as commit message
    * make sure it is the same (and use '0.1.2' instead of 'v0.1.2')
  * tag with version number as commit message (`git tag -a '0.1.2' -m '0.1.2'`)
  * `git push && git push --tags`

### Debugging

*Because I always forget how to*

In `wp-config.php`
```
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
```

- Then use `error_log` to write to the default debug file (`wp-content/debug.log`).
- Use `json_encode()` to get a JSON representation of a complicated object.
- Or use `print_r` to print datastructures
- Also `var_dump` comes helpful for variables / datastructures sometimes

### Lessons learned / take home messages

#### Dynamic menus

In Wordpress you have a number of ways to dynamically (via php) modify menus:
  * with `add_filter( 'wp_nav_menu_items', cb, 10, 2)` you can inject HTML.
  * with `add_filter( 'wp_nav_menu_objects', cb, 10, 2 )` you can inject objects
    in the menu tree.
  * with `wp_update_nav_menu_item` you can manipulate the menu structure.
  * ...

#### Shortcodes and output buffering

Shortcodes should `return` the output and not `echo` it directly. If this is
ignored, the output might end up at the wrong place in the rendered result.

To make the code behave, start a output buffer `ob_start();` and `return
ob_get_clean()` at the end of the function.

## License

Except for parts mentioned below released under the AGPL-3.0+ (see file `LICENSE`)
Copyright 2019,2020 Felix Wolfsteller

### Parts with other licenses

#### [restrict-media/restrict-media.php]

  * Source: http://www.jamviet.com/2015/05/restrict-author-posting.html , https://plugins.trac.wordpress.org/browser/restrict-author-posting/trunk
  * Originally licensed under GPLv2+, Copyright 2015 Jam Việt, relicensed in the lernorte-fuer-morgen-plugin under the GPLv3.
  * For transparency reasons the initial commit in the lernorte-fuer-morgen git-repository for the file contains the original source code and was stripped and modified by Felix Wolfsteller afterwards.
  
