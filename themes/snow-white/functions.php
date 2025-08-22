<?php
/**
 * Functions and definitions
 *
 * @package WritePoetry
 * @subpackage WritePoetry/Themes/SnowWhite
 */

// Use this filter to change the default path for additional blocks styles.
add_filter(
	'blank_theme_assets_path',
	function () {
		return 'public/blocks';
	}
);
