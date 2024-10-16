<?php
/**
 * Plugin Name: Project engine room
 * Author: Giacomo Secchi
 * Author URI: https://giacomosecchi.com
 * Version: 1.0.0
 *
 * @package WritePoetry
 * @subpackage project-engine-room
 */

/* Place custom code below this line. */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


// custom code for the current project.


/**
 * Hard code Google Tag Manager parameters in wp-config.php.
 *
 * @link https://gtm4wp.com/gtm4wp-for-developers/hard-code-google-tag-manager-parameters-in-wp-config-php
 */
define( 'GTM4WP_HARDCODED_GTM_ID', 'GTM-XXXXXX' );
define( 'GTM4WP_HARDCODED_GTM_ENV_AUTH', '' );
define( 'GTM4WP_HARDCODED_GTM_ENV_PREVIEW', '' );


// Remove version query string from static CSS files.
add_filter( 'writepoetry_remove_query_strings', '__return_true' );

// Enable maintenance mode.
add_filter(
	'pre_option_writepoetry_maintenance_mode',
	function () {
		return '1';
	}
);


// Exclude specific pages from being in maintenance mode.
add_filter(
	'writepoetry_maintenance_excluded_pages',
	function ( $condition ) {
		$condition[] = 'cart';
		$condition[] = 'sample-page';
		return $condition;
	}
);


// Choose to enable or disable product image zoom on product page (to disable change 'yes' to 'no').
add_filter(
	'pre_option_writepoetry_product_zoom',
	function () {
		return 'yes';
	}
);


add_filter(
	'pre_option_writepoetry_product_quantity_layout',
	function () {
		// possible values are: 'hidden', 'input', 'buttons', 'select'.
		return 'buttons';
	}
);


// Choose to what page redirect after add to cart.
add_filter(
	'pre_option_writepoetry_redirect_after_add',
	function () {
		// possible values are: 'product-checkout', 'product-cart', 'checkout', 'cart'.
		return 'checkout';
	}
);


add_filter(
	'pre_option_writepoetry_product_min_quantity',
	function () {
		return 2;
	}
);


add_filter(
	'pre_option_writepoetry_product_max_quantity',
	function () {
		return 20;
	}
);


// What kind of design do you want for single product page additional info (possible vaules are accordion, tabs or list).
add_filter(
	'pre_option_writepoetry_product_infos_layout',
	function () {
		// possible values are 'tabs', 'accordion' or 'list'.
		return 'list';
	}
);



add_filter(
	'pre_option_writepoetry_quantity_input_step',
	function () {
		return 5;
	}
);

// Disable elements.
add_filter(
	'writepoetry_disable_features',
	function ( $args ) {
		$args[] = 'woocommerce_sale_flash';
		// $args[] = 'woocommerce_twenty_twenty_two_styles';

		return $args;
	},
	10,
	1
);


// Add parameters to url.
add_filter(
	'writepoetry_query_vars',
	function () {
		// Test here http://localhost:8888/sample-page/?test-param=ciao&test-param2=caro.
		return array( 'test-param', 'test-param2' );
	}
);



add_filter(
	'writepoetry_add_custom_taxonomies',
	function () {
		$string = array(
			'product-type'   => array(
				'post_type'         => 'product',
				'labels'            => array(
					'name' => esc_html( 'Product Type' ),
				),
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'show_tagcloud'     => true,
			),
			'product-format' => array(
				'post_type'     => 'product',
				'labels'        => array(
					'name' => esc_html( 'Product Format' ),
				),
				'show_ui'       => true,
				'show_tagcloud' => true,
			),
		);

		return $string;
	},
	10,
	3
);





add_filter(
	'writepoetry_add_custom_post_types',
	function () {
		$string = array(
			'books'              =>
				array(
					'labels'             => array(
						'name'          => esc_html( 'Books' ),
						'singular_name' => esc_html( 'Books' ),
					),
					'publicly_queryable' => true,
				),
			'points_of_interest' =>
				array(
					'labels' => array(
						'name'          => esc_html( 'Points of interest' ),
						'singular_name' => esc_html( 'Point of interest' ),
					),
				),

			'excursions'         =>
				array(
					'labels'             => array(
						'name'          => 'Transfer & Excursions',
						'singular_name' => 'Excursion',
					),
					'publicly_queryable' => true,
				),
		);

		return $string;
	},
	10,
	3
);


add_filter(
	'writepoetry_add_custom_fields_to_post',
	function () {
		$meta_keys = array(
			'test_meta_key' => array(
				'type'         => 'boolean',
				'default'      => false,
			),
			'test_meta_key2' => array(
				'show_in_rest' => false,
			),
			'test_meta_key3' => array(),
			'test_meta_key4',
		);

		return $meta_keys;
	},
	10,
	3
);
