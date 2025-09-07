<?php
/**
 * Register additional theme directories class.
 *
 * @package           WritePoetry
 * @subpackage        WritePoetry/Base
 * @author            Giacomo Secchi <info@giacomosecchi.com>
 * @copyright         2024 Giacomo Secchi
 * @license           GPL-2.0-or-later
 */

namespace WritePoetry\Base;

use WritePoetry\Base\Base_Controller;
/**
 * Register additional theme directories.
 * @access public
 */
class Register_Theme_Directories extends Base_Controller {
	/**
	 * Invoke hooks.
	 *
	 * @return void
	 */
	public function register() {
		add_filter( 'after_setup_theme', array( $this, 'register_theme_directories' ), 10, 2 ); 
	}


	/**
	 * Register additional theme directories.
	 *
	 * @return void
	 */
	public function register_theme_directories() {
		foreach ( apply_filters( 'writepoetry_register_theme_directories', array() ) as $dir ) {

			register_theme_directory( trailingslashit( ABSPATH ) . trailingslashit( $dir ) );
		}
	}
}
