<?php
/*
Plugin Name: SudoSearch
Description: Spotlight for WordPress admin
Author: David Laing & Ryan Holder
Version: 0.1

License: GPLv2 ->

  Copyright 2012 Forsite Themes (team@forsitethemes.com)

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


class SudoSearch {

    function __construct() {
        add_action( 'admin_print_styles',    array( &$this, 'register_admin_styles' ) );
        add_action( 'admin_enqueue_scripts', array( &$this, 'register_admin_scripts' ) );

        add_action( 'admin_bar_menu', array(&$this, 'customize_admin_bar'), -1); //want to add to the secondary menu
    }
    
    
    /**
    * Registers and enqueues admin-specific styles.
    */
    public function register_admin_styles() {
        wp_enqueue_style( 'wp-jquery-ui-dialog');
    } 
        
    /**
    * Registers and enqueues admin-specific JavaScript.
    */	
    public function register_admin_scripts() {
        wp_enqueue_script( 'jquery-ui-autocomplete' );
        wp_enqueue_script( 'jquery-ui-dialog' );
        wp_enqueue_script( 'mousetrap', plugins_url( 'sudosearch/vendor/mousetrap.min.js' ) );
        wp_enqueue_script( 'sudosearch-spotlight', plugins_url( 'sudosearch/assets/javascripts/sudosearch.js' ), 
                array('mousetrap', 'jquery-ui-dialog', 'jquery-ui-autocomplete') );
    } 
    
    function customize_admin_bar(){
        global $wp_admin_bar;
        global $menu;  
        global $submenu;
        
        // Create JS array of available menu items to search
        echo "<script>var sudosearch_terms = [";
        foreach ($menu as $menu_item) {
            foreach ($submenu[$menu_item[2]] as $sub_menu_item) {
                $term = strip_tags($sub_menu_item[0]);
                $parent = $menu_item[0];
                $url = $sub_menu_item[2];
                echo "{label:'$term', category:'$parent', url:'$url'},";
            }
        }
	echo "{}]; </script>";
        
        //Inject a search menu into the admin bar
        $wp_admin_bar->add_node(array(
            "id" => "sudosearch",
            "title" => "ss",
            "parent" => "top-secondary"
            ));
        $wp_admin_bar->add_node(array(
            "id" => "sudosearch-sub",
            "title" => '<form id="sudosearch-form" action="#" method="GET"><input id="sudosearch"></form>',
            "parent" => "sudosearch"
            ));
    }
}

//and we're off
new SudoSearch();


