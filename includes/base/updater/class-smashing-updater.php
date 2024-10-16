<?php
/**
 * Check plugin version and update it
 *
 * @package WritePoetry\Base\Updater
 *
 * @link https://www.smashingmagazine.com/2015/08/deploy-wordpress-plugins-with-github-using-transients/
 */

namespace WritePoetry\Base\Updater;

/**
 * Class Smashing_Updater
 */
class Smashing_Updater {

	/**
	 * The plugin file
	 *
	 * @var string
	 */
	private $file;

	/**
	 * The plugin data
	 *
	 * @var array
	 */
	private $plugin;

	/**
	 * The plugin basename
	 *
	 * @var string
	 */
	private $basename;

	/**
	 * The plugin active status
	 *
	 * @var boolean
	 */
	private $active;

	/**
	 * The username of the repository owner
	 *
	 * @var string
	 */
	private $username;

	/**
	 * The repository name
	 *
	 * @var string
	 */
	private $repository;

	/**
	 * The authorize token
	 *
	 * @var string
	 */
	private $authorize_token;

	/**
	 * The github response
	 *
	 * @var array
	 */
	private $github_response;

	/**
	 * Smashing_Updater constructor.
	 *
	 * @param string $file The plugin file.
	 */
	public function __construct( $file ) {

		$this->file = $file;

		add_action( 'admin_init', array( $this, 'set_plugin_properties' ) );
	}

	/**
	 * Set the plugin properties
	 */
	public function set_plugin_properties() {
		$this->plugin   = get_plugin_data( $this->file );
		$this->basename = plugin_basename( $this->file );
		$this->active   = is_plugin_active( $this->basename );
	}

	/**
	 * Set the username
	 *
	 * @param string $username The username of the repository owner.
	 */
	public function set_username( $username ) {
		$this->username = $username;
	}

	/**
	 * Set the repository
	 *
	 * @param string $repository The repository name.
	 */
	public function set_repository( $repository ) {
		$this->repository = $repository;
	}

	/**
	 * Set the authorize token
	 *
	 * @param string $token The authorize token.
	 */
	public function authorize( $token ) {
		$this->authorize_token = $token;
	}

	/**
	 * Get the repository info
	 */
	private function get_repository_info() {
		if ( is_null( $this->github_response ) ) { // Do we have a response?
			$args        = array();
			$request_uri = sprintf( 'https://api.github.com/repos/%s/%s/releases', $this->username, $this->repository ); // Build URI.

			if ( $this->authorize_token ) { // Is there an access token?
					$args['headers']['Authorization'] = "bearer {$this->authorize_token}"; // Set the headers.
			}

			$response = json_decode( wp_remote_retrieve_body( wp_remote_get( $request_uri, $args ) ), true ); // Get JSON and parse it.

			if ( is_array( $response ) ) { // If it is an array.
				$response = current( $response ); // Get the first item.
			}

			$this->github_response = $response; // Set it to our property.
		}
	}

	/**
	 * Initialize the plugin updater
	 */
	public function initialize() {
		add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'modify_transient' ), 10, 1 );
		add_filter( 'plugins_api', array( $this, 'plugin_popup' ), 10, 3 );
		add_filter( 'upgrader_post_install', array( $this, 'after_install' ), 10, 3 );

		// Add Authorization Token to download_package.
		add_filter(
			'upgrader_pre_download',
			function () {
				add_filter( 'http_request_args', array( $this, 'download_package' ), 15, 2 );
				return false; // upgrader_pre_download filter default return value.
			}
		);
	}

	/**
	 * Modify the transient
	 *
	 * @param object $transient The plugin data.
	 *
	 * @return object
	 */
	public function modify_transient( $transient ) {

		if ( property_exists( $transient, 'checked' ) ) { // Check if transient has a checked property.

			if ( $checked = $transient->checked ) { // Did WordPress check for updates?

				$this->get_repository_info(); // Get the repo info.

				$out_of_date = version_compare( $this->github_response['tag_name'], $checked[ $this->basename ], 'gt' ); // Check if we're out of date.

				if ( $out_of_date ) {

					$new_files = null;

					array_walk_recursive(
						$this->github_response,
						function ( $value, $key ) use ( &$new_files ) {
							if ( 'browser_download_url' === $key ) {
								$new_files = $value;
								return false; // Stop the walk.
							}
						}
					);

					$slug = current( explode( '/', $this->basename ) ); // Create valid slug.

					$plugin = array( // setup our plugin info.
						'url'         => $this->plugin['PluginURI'],
						'slug'        => $slug,
						'package'     => $new_files,
						'new_version' => $this->github_response['tag_name'],
					);

					$transient->response[ $this->basename ] = (object) $plugin; // Return it in response.
				}
			}
		}

		return $transient; // Return filtered transient.
	}

	/**
	 * Get the plugin data
	 *
	 * @param boolean $result The result of the update operation.
	 * @param string  $action The action.
	 * @param object  $args The plugin data.
	 *
	 * @return object
	 */
	public function plugin_popup( $result, $action, $args ) {

		if ( ! empty( $args->slug ) ) { // If there is a slug.

			if ( current( explode( '/', $this->basename ) ) === $args->slug ) { // And it's our slug.

				$this->get_repository_info(); // Get our repo info.

				// Set it to an array.
				$plugin = array(
					'name'              => $this->plugin['Name'],
					'slug'              => $this->basename,
					'requires'          => '3.3',
					'tested'            => '4.4.1',
					'rating'            => '100.0',
					'num_ratings'       => '10823',
					'downloaded'        => '14249',
					'added'             => '2016-01-05',
					'version'           => $this->github_response['tag_name'],
					'author'            => $this->plugin['AuthorName'],
					'author_profile'    => $this->plugin['AuthorURI'],
					'last_updated'      => $this->github_response['published_at'],
					'homepage'          => $this->plugin['PluginURI'],
					'short_description' => $this->plugin['Description'],
					'sections'          => array(
						'Description' => $this->plugin['Description'],
						'Updates'     => $this->github_response['body'],
					),
					'download_link'     => $this->github_response['zipball_url'],
				);

				return (object) $plugin; // Return the data.
			}
		}
		return $result; // Otherwise return default.
	}

	/**
	 * Add Authorization Token to download_package
	 *
	 * @param array  $args The plugin data.
	 * @param string $url The plugin data.
	 *
	 * @return array
	 */
	public function download_package( $args, $url ) {
		$url;
		if ( null !== $args['filename'] ) {
			if ( $this->authorize_token ) {
				$args = array_merge( $args, array( 'headers' => array( 'Authorization' => "token {$this->authorize_token}" ) ) );
			}
		}

		remove_filter( 'http_request_args', array( $this, 'download_package' ) );

		return $args;
	}

	/**
	 * After install
	 *
	 * @param array  $response The plugin data.
	 * @param array  $hook_extra The plugin data.
	 * @param string $result The plugin data.
	 *
	 * @return array
	 */
	public function after_install( $response, $hook_extra, $result ) {
		global $wp_filesystem; // Get global FS object.

		$install_directory = plugin_dir_path( $this->file ); // Our plugin directory.
		$wp_filesystem->move( $result['destination'], $install_directory ); // Move files to the plugin dir.
		$result['destination'] = $install_directory; // Set the destination for the rest of the stack.

		if ( $this->active ) { // If it was active.
			activate_plugin( $this->basename ); // Reactivate.
		}

		return $result;
	}
}
