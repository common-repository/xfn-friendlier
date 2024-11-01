<?php
/*
Plugin Name: XFN Friendlier
Plugin URI: http://www.mit.edu/~bens/somepage-or-other
Description: Makes Wordpress fully XFN-friendly.  Normally, XFN relationships are only published for visible links.  This plugin also publishes XFN "rels" for your invisible links.
Version: 0.1
Author: Benjamin Schwartz
Author URI: http://www.mit.edu/~bens/
*/

/*  Copyright 2005  Benjamin Schwartz  (email : benjamin.m.schwartz@gm@!l.com)

    This program is free software; you can redistribute it and/or modify
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

function add_xfn_rels_to_the_header() {
	global $wpdb;
	$sql = "SELECT link_url, link_name, link_rel
		FROM $wpdb->links
		WHERE link_visible = 'N' " ;

	$results = $wpdb->get_results($sql);
	if (!$results) {
		return;
	}
	
	echo "\n";

	foreach ($results as $row) {
			
		$the_link = wp_specialchars($row->link_url) ;
		
		$rel = $row->link_rel;
		
		if (empty($rel) or empty($the_link)) {
			continue;
		} else {
			echo "\t<link rel='$rel' href='$the_link' " ;
		}
		
		$title = wp_specialchars($row->link_name, ENT_QUOTES) ;

		if (!empty($title)) {
			echo "title='$title' ";
		}

		echo "/>\n";

	}
}

add_action('wp_head','add_xfn_rels_to_the_header');
?>
