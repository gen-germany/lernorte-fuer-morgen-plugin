# Lernorte für MorGEN Wordpress plugin

This is a WordPress plugin for the Lernorte für MorGEN website.

Pretty specific stuff, but if you want to get some inspiration or get in contact or feedback, feel free!

Other parts are covered by the [Child-Theme](https://github.com/gen-germany/lernorte-fuer-morgen-childtheme).

## Installation

There is not much sense in installing this for a page different then "lernorte für morgen" - if you are inclined to do that its a good idea to get in contact with us first.

  * Install [github-updater](https://github.com/afragen/github-updater)
  * Use [github-updater](https://github.com/afragen/github-updater) and provide `https://github.com/gen-germany/lernorte-fuer-morgen-plugin` as the URL.

### Prerequisites

The plugin assumes certain pod (CPT) classes to be installed and configured which is not (yet?) done from within this plugin!
Eventually, the pods/CPTs could be create by this plugin, but I am not yet sure how and whether this is always a good idea. Happy about comments.

## Implemented Features

  * Make nested shortcodes work (although this might be removed once features implemented within this plugin TODO) - done in `lernorte-fuer-morgen.php` .
  * Modify style of require featured image plugin, so that the warning shows up bigger.
  * Modify Dashboard:
    * remove default widgets
    * add custom welcome box
    * add custom help box
    * add custom widgets for events and referees

## Gotchas

  * Use of German terms, because form UI for creating POD items is not easily translateable.

## Development

### Release

  * modify [lernorte-fuer-morgen.php](lernorte-fuer-morgen.php); bump the version number
  * add change and commit with version number as commit message
  * tag with version number as commit message
  * git push
  * git push --tags

## License

Released under the AGPL-3.0+ (see file `LICENSE`)
Copyright 2019 Felix Wolfsteller
