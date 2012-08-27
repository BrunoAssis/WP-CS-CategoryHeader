<?php
/*
Plugin Name: WP CineSplendor Category Header
Plugin URI: http://github.com/BrunoAssis/WP-CS-CategoryHeader
Description: Inserts some categories' descriptions in content header.
Version: 0.1
Author: Bruno Assis
Author URI: http://brunoassis.org
Author Email: brunoassis@gmail.com
License:

  Copyright 2012 Bruno Assis (brunoassis@gmail.com)

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

class WP_CS_CategoryHeader {
	 
	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/
	
	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {
	
		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( &$this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'register_admin_scripts' ) );
	
		// Register site styles
		add_action( 'wp_enqueue_scripts', array( &$this, 'register_plugin_styles' ) );

		// Register main function.	
		add_filter( 'the_content', array( &$this, 'add_header' ) );

		// Register admin menu.
		add_action( 'admin_menu', array( &$this, 'add_admin_menu' ) );

	}
	
	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {
	
		wp_register_style( 'WP-CS-CategoryHeader-admin-styles', plugins_url( 'WP-CS-CategoryHeader/css/admin.css' ) );
		wp_enqueue_style( 'WP-CS-CategoryHeader-admin-styles' );
	
	}

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */	
	public function register_admin_scripts() {
	
		wp_register_script( 'WP-CS-CategoryHeader-admin-script', plugins_url( 'WP-CS-CategoryHeader/js/admin.js' ) );
		wp_enqueue_script( 'WP-CS-CategoryHeader-admin-script' );
	
	}
	
	/**
	 * Registers and enqueues plugin-specific styles.
	 */
	public function register_plugin_styles() {
	
		wp_register_style( 'WP-CS-CategoryHeader-plugin-styles', plugins_url( 'WP-CS-CategoryHeader/css/display.css' ) );
		wp_enqueue_style( 'WP-CS-CategoryHeader-plugin-styles' );
	
	}

	/**
	 * Adds the main functionality of the plugin.
	 */
	public function add_header($content) {
		$allowed_categories = array(1, 2, 3, 4, 5);
		if ( in_category($allowed_categories) )
			$content = sprintf(
				'FUNFOU MANOLO %s',
				$content
			);
		return $content;
	}

	public function add_admin_menu() {
		add_plugins_page( 'CS Category Header Options', 'CS Category Header', 'manage_options', 'WP-CS-CategoryHeader', array(&$this, 'add_plugin_options') );
	}

	public function add_plugin_options() {
		if ( !current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		echo '<div class="wrap">';
		echo '<p>Here is where the form would go if I actually had options.</p>';
		echo '</div>';
	}

}

new WP_CS_CategoryHeader();
define( 'WP_DEBUG', true);
