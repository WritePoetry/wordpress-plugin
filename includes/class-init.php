<?php
/**
 * Main Init Class
 *
 * @package           WritePoetry
 * @subpackage        WritePoetry/init
 * @author            Giacomo Secchi <giacomo.secchi@gmail.com>
 * @copyright         2023 Giacomo Secchi
 * @license           GPL-2.0-or-later
 * @since             0.2.1
 */

namespace WritePoetry;

use WritePoetry\Api\Plugin_Config;
use WritePoetry\Base\Base_Controller;

include_once ABSPATH . 'wp-admin/includes/plugin.php';


/**
 * Main Init class
 */
final class Init {

	/**
	 * Store all the classes inside an array
	 *
	 * @return array Full list of classes
	 */
	public static function get_services() {
		$config = Plugin_Config::get_instance();

		$services = array(
			Api\Register_Post_Types::class,
			Api\Register_Post_Taxonomies::class,
			Api\Register_Custom_Fields::class,
			Base\Development\Maintenance_Mode::class,
			Base\Development\Utils::class,
			Base\Utils::class,
			FSE\Blocks::class,
			FSE\Shortcode::class,
			FSE\Theme\Assets::class,
			Pages\Admin\Login_Screen::class,

			// @phpcs:disable Squiz.PHP.CommentedOutCode.Found, Squiz.Commenting.InlineComment.InvalidEndChar
			// Base\Development\Example::class,
			// Plugins\Gtm4wp::class,
			// @phpcs:enable
		);

		if ( is_admin() ) {
			array_push(
				$services,
				// Base\Updater\Updater::class,
				Pages\Admin\Settings_Page::class,
				Pages\Admin\Custom_Media_Type::class,
				Pages\Admin\Settings_Link::class,
				Pages\Admin\WooCommerce_Page::class,
			);
		}

		self::add_plugin_service( $services,
			'woocommerce/woocommerce.php',
			array(
				Plugins\WooCommerce\Cart_Redirect::class,
				Plugins\WooCommerce\Product_Zoom::class,
				Plugins\WooCommerce\Product_Additional_Infos::class,
				Plugins\WooCommerce\Quantity_Layout::class,
				Plugins\WooCommerce\WooCommerce_Controller::class
			)
		);

		self::add_plugin_service( $services,
			'jetpack/jetpack.php',
			array(
				Plugins\Jetpack\Portfolio::class,
				Plugins\Jetpack\Testimonial::class
			)
		);

		self::add_plugin_service( $services,
			'wordpress-seo/wp-seo.php',
			array(
				Plugins\Yoast\Sitemap::class
			)
		);

		self::add_plugin_service( $services,
			'translatepress-multilingual/index.php',
			array(
				Plugins\Translatepress\Translatepress::class
			)
		);

		return $services;
	}

	/**
	 * Loop through the classes, initialize them,
	 * and call the register() method if it exists
	 *
	 * @return void
	 */
	public static function register_services() {
		foreach ( self::get_services() as $class ) {
			$service = self::instantiate( $class );
			if ( method_exists( $service, 'register' ) ) {
				$service->register();
			}
		}
	}

	/**
	 * Initialize the class
	 *
	 * @param string $class_name The name of the class to instantiate.
	 * @return object The instantiated object.
	 */
	private static function instantiate( $class_name ) {
		$service = new $class_name();

		return $service;
	}

	/**
	 * Add a service if the plugin is active
	 *
	 * @param array  &$services     The array of services to modify.
	 * @param string $plugin        The plugin to check.
	 * @param string $service_class The service class to add.
	 */
	public static function add_plugin_service( &$services, $plugin, $service_classes ) {
		if ( \is_plugin_active( $plugin ) ) {
			foreach ( $service_classes as $service_class ) {
				array_push( $services, $service_class );
			}
		}
	}
}
