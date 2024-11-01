<?php
/*
Plugin Name:  SX No Homepage Pagination
Version:      1.3
Plugin URI:   https://www.seomix.fr
Description:  SX No Homepage Pagination removes properly any homepage pagination (whatever plugin or function you are using) and redirect useless paginated content. This plugin works on any default homepage, not on a blog page.
Availables languages : en_EN
Text Domain: sx-no-homepage-pagination
Tags: homepage, frontpage, pagination, seo, paged, crawl
Author: Daniel Roch - SeoMix
Author URI: https://www.seomix.fr
Requires at least: 3.3
Tested up to: 6.6
License: GPL v3

SX No Homepage Pagination - SeoMix
Copyright (C) 2014, Daniel Roch - contact@seomix.fr

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/**
  Security
*/
if ( ! defined( 'ABSPATH' ) ) exit;

/**
  Don't paginate homepage
  * © Daniel Roch
  */
function seomix_remove_homepage_pagination( $query ) { 
  // Are we on a blog page ? It still might be the real homepage or another page defined in WordPress admin
  if ( is_home() && $query->is_main_query() ) {
    // the is_front_page() conditional tag does not work with pre_get_post action, we need to check if we really are on the website homepage
    if ( !$query->get( 'page_id' ) != get_option( 'page_on_front' ) ) {
        $query->set('no_found_rows', true);
    }
  }
}
add_action( 'pre_get_posts', 'seomix_remove_homepage_pagination' );

/**
 Redirect homepage pagination
 * Redirect homepage pagination (if is_front_page is true)
 * © Daniel Roch 
 */ 
function seomix_redirect_homepage_pagination () {
  global $paged, $page;
  // Are we on an homepage pagination ?
  if ( is_front_page() && is_home() && ( $paged >= 2 || $page >= 2 ) ) {
     wp_redirect( home_url() , '301' );
     die;
  }
}
add_action( 'template_redirect', 'seomix_redirect_homepage_pagination' );