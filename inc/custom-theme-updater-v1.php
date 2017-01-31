<?php
/**
 * Project: maketador
 * Author: Miguel Sirvent
 * Date: 1/25/17 1:43 PM CST
 */

class Custom_Theme_Updater_v1 {

	private $server = '';
	private $slug = '';
	private static $instance = null;

	static function instance($server, $slug) {
		if ( self::$instance === null ) {
			self::$instance = new self($server, $slug);
		}

		return self::$instance;
	}
	function __construct( $server, $slug ) {
		$this->server = $server;
		$this->slug   = $slug;
		add_filter( 'pre_set_site_transient_update_themes', array( $this, 'pre_set_site_transient_update_themes' ) );
	}

	function pre_set_site_transient_update_themes( $checked_data ) {
		if ( empty( $checked_data->checked ) ) {
			return $checked_data;
		}

		$data = $this->get_data( $this->slug );
		if ( ! is_object( $data ) ) {
			return $checked_data;
		}

		if ( version_compare( $data->version, $checked_data->checked[$this->slug] ) == 1 ) {
			$checked_data->response[$this->slug] = [
				'theme'=>$this->slug,
				'new_version'=>$data->version,
				'url'=>$data->url,
			];
			if ( isset( $data->package ) && ! empty( $data->package ) ) {
				$checked_data->response[$this->slug]['package'] = $data->package;
			}
		}

		return $checked_data;
	}

	protected function get_data( $slug ) {

		$remote_args = array( 'user-agent' => 'Custom-PT-Updater/v1 ' . home_url(), 'timeout'=>6 );

		$remote_args = apply_filters( 'custom_p_updater_remote_args', $remote_args, $slug );

		$response = wp_remote_post( trailingslashit( $this->server ) . "theme/$slug/", $remote_args );

		if ( wp_remote_retrieve_response_code( $response ) == '200' ) {
			$content = wp_remote_retrieve_body( $response );
			if ( ! empty( $content ) ) {
				return json_decode( $content );
			}
		}

		return false;
	}

}
