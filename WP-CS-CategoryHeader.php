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
	 
	/**
	 * Initializes the plugin by setting filters, and administration functions.
	 */
	function __construct() {
	
		// Register main function.	
		add_filter( 'the_content', array( &$this, 'add_header' ) );

		// Register admin menu.
		add_action( 'admin_menu', array( &$this, 'add_admin_menu' ) );
		add_action( 'admin_init', array( &$this, 'register_custom_settings' ) );

	}
	
	public function register_custom_settings() {
		//register_setting('grupo', 'nome_do_setting', 'funcao_validacao');
		register_setting( 'wp-cs-categoryheader-group', 'categories' );
		register_setting( 'wp-cs-categoryheader-group', 'template' );
		add_settings_section( 'wp-cs-categoryheader-main', 'Main Settings', array( &$this, 'main_section_text' ), 'wp-cs-categoryheader' );
		add_settings_field( 'wp-cs-categoryheader-template', 'Template', array( &$this, 'setting_template' ), 'wp-cs-categoryheader', 'wp-cs-categoryheader-main' );
	}

	public function main_section_text() {
		echo '<p>Main description of this section here.</p>';
	}

	public function setting_template() {
		$options = get_option('plugin_options');
		echo "<input id='setting_template' name='template[text_string]' size='40' type='text' value='{$options['text_string']}' />";
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
		} ?>
		<div class="wrap">
			<h2>Cine Splendor Category Header</h2>
			<form method="post" action="options.php">
				<?php settings_fields( 'wp-cs-categoryheader-group' ); ?>
				<?php do_settings_sections( 'wp-cs-categoryheader-group' ); ?>
				<?php submit_button(); ?>
			</form>
		</div>
<?php
	}

}

new WP_CS_CategoryHeader();