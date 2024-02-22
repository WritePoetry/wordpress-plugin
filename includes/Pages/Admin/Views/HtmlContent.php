<?php

namespace WritePoetry\Pages\Admin\Views;

use WritePoetry\Api\PluginConfig;
use WritePoetry\Pages\Admin\SettingsPage;

/**
 * Class HtmlContent
 * @package WritePoetry\Pages\Admin\Views
 */
class HtmlContent {
	public static function getForm() {

		$settings_page = new SettingsPage();
		$page         = $settings_page->getPageSlug();
		$option_group = $settings_page->getOptionGroup();

		?>
		<div class="wrap">
			<h1><?php echo esc_html( sprintf( __( '%s Settings' ), get_admin_page_title() ) ); ?></h1>

			<?php settings_errors(); ?>

			<form action="<?php echo esc_url( admin_url( 'options.php' ) ); ?>" method="post">
				<?php
					// output security fields for the registered setting "{$config->prefix}-settings-group".
					settings_fields( $option_group );
					// output setting sections and their fields
					// (sections are registered for "{$config->prefix}-settings", each field is registered to a specific section).
					do_settings_sections( $page );
					// output save settings button.
					submit_button( __( 'Save Settings', 'write-poetry' ) );
				?>
			</form>
		</div>
		<?php
	}
}
