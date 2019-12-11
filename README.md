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
  * Modify certain admin forms for own content types via css ::before
  * Restrict media usage of users to own media
    - Code from https://plugins.trac.wordpress.org/browser/restrict-author-posting/trunk/readme.txt
    - licensed under GPLv2 or later, Copyright Jam Việt 2015 (https://plugins.trac.wordpress.org/browser/restrict-author-posting/trunk/restrict-author-posting.php)
    - GPLv3 is included in this repository

## Gotchas

  * Use of German terms, because form UI for creating POD items is not easily translateable.

## Development

### Release

  * modify [lernorte-fuer-morgen.php](lernorte-fuer-morgen.php); bump the version number
  * add change and commit with version number as commit message
    * make sure it is the same (and use '0.1.2' instead of 'v0.1.2')
  * tag with version number as commit message
  * git push
  * git push --tags

## License

Except for parts mentioned below released under the AGPL-3.0+ (see file `LICENSE`)
Copyright 2019 Felix Wolfsteller

### Parts with other licenses

#### [restrict-media/restrict-media.php]

  * Source: http://www.jamviet.com/2015/05/restrict-author-posting.html , https://plugins.trac.wordpress.org/browser/restrict-author-posting/trunk
  * Originally licensed under GPLv2+, Copyright 2015 Jam Việt, relicensed in the lernorte-fuer-morgen-plugin under the GPLv3.
  * For transparency reasons the initial commit in the lernorte-fuer-morgen git-repository for the file contains the original source code and was stripped and modified by Felix Wolfsteller afterwards.
  
