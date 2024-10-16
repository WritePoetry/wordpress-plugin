<?php
/**
 *  Customize Admin Login Screen Page.
 *
 * @package           WritePoetry
 * @subpackage        WritePoetry/Admin
 * @author            Giacomo Secchi <giacomo.secchi@gmail.com>
 * @copyright         2023 Giacomo Secchi
 * @license           GPL-2.0-or-later
 * @since             0.2.4
 */

namespace WritePoetry\Pages\Admin;

use WritePoetry\Pages\Admin_Controller;

/**
 * Class Login_Screen
 */
class Login_Screen extends Admin_Controller {
	/**
	 * Invoke hooks.
	 *
	 * @return void
	 */
	public function register() {

		add_action( 'login_head', array( $this, 'custom_loginlogo' ) );
		add_filter( 'login_headerurl', array( $this, 'custom_loginlogo_url' ) );
		add_filter( 'login_headertext', array( $this, 'custom_login_title' ) );
		add_filter( 'login_title', array( $this, 'custom_login_title' ) );
	}

	/**
	 * Custom login logo.
	 *
	 * @return void
	 */
	public function custom_loginlogo() {
		$site_icon        = get_site_icon_url();
		$background_image = '';

		if ( ! empty( $site_icon ) ) {
			$background_image = $site_icon;
		} elseif ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
			$custom_logo_id   = get_theme_mod( 'custom_logo' );
			$image            = wp_get_attachment_image_src( $custom_logo_id, 'full' );
			$background_image = $image[0];
		}

		if ( ! empty( $background_image ) ) {
			echo '<style>
			#login h1 a,
			.login h1 a {
				background-image:url( ' . esc_url( $background_image ) . ');
				background-position: center;
				background-size: contain;
				background-repeat: no-repeat;
			}
			</style>';
		}
	}

	/**
	 * Custom login logo url.
	 *
	 * @param string $url The URL.
	 *
	 * @return string
	 */
	public function custom_loginlogo_url( $url ) {
		return esc_url( home_url( '/' ) );
	}

	/**
	 * Custom login title.
	 *
	 * @return string
	 */
	public function custom_login_title() {
		return get_bloginfo( 'name' );
	}
}
