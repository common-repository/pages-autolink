<?php
function pages_autolink($text) 
{

/*
Plugin Name: Pages Autolink 
Version: 1.0
Version description: Automatically turns pages names in posts and pages in links to the URLs. Keeps the original words case in text.
Plugin URI: http://www.centrostudilaruna.it/huginnemuninn/plugin-wordpress
Description: Wraps pages names in links
Author: Alberto Lombardo
Author URI: http://www.centrostudilaruna.it/huginnemuninn
Based on: Categories Autolink by Alberto Lombardo
Copyright (c) 2009
Released under the GPL license
http://www.gnu.org/licenses/gpl.txt

    This file is part of WordPress.
    WordPress is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/* Define the $wpdb to perform queries on the WP database */
global $wpdb;
/* Wrap spaces around the text - helps with regexp? */
$text = " $text ";
/* Set exceptions; will be developed in following releases */
// $exceptions = 'WHERE page_name <> "Names"';
/* Load pages */
$pages = $wpdb->get_results("SELECT post_title, ID identificativo FROM $wpdb->posts WHERE post_type = 'page'");
/* Loop through links */
foreach ($pages as $page) 
{
/* createpage_urls */
$page_urls = get_page_link($page->identificativo);
/* Replace any instance of the cat_name with the cat_name wrapped in a HREF to link_url */
$text = preg_replace("|(?!<[^<>]*?)(?<![?./&])\b($page->post_title)\b(?!:)(?![^<>]*?>)|imsU","<a href=\"$page_urls\">$1</a>" , $text);
}
/* Trim extraneous spaces off and return */
return trim( $text );
}
add_filter('the_content', 'pages_autolink', 16);
?>