<?php

class Maketador_Page_Metabox {

	static function checkboxes() {
		return array(
			'_maketador_hide_title'  => __( 'Hide title', 'maketador' ),
			'_maketador_show_date'   => __( 'Show date', 'maketador' ),
			'_maketador_hide_header' => __( 'Hide header', 'maketador' ),
			'_maketador_hide_footer' => __( 'Hide footer', 'maketador' )
		);
	}

	static function hooks() {
		add_action( 'add_meta_boxes_page', __CLASS__ . '::add_meta_boxes_page', 10 );
		add_action( 'save_post', __CLASS__ . '::save_post_page', 10, 2 );
	}

	static function add_meta_boxes_page() {
		add_meta_box(
			'maketador_page_options',
			__( 'Page Options', 'maketador' ),
			__CLASS__ . '::metabox_form',
			'page',
			'side',//context
			'high'//prio
		);
	}

	static function metabox_form() {
		$post_id = get_the_ID();
		wp_nonce_field( __CLASS__, 'maketador_page_options' );
		foreach ( self::checkboxes() as $option => $label ) {
			$checked = ( get_post_meta( $post_id, $option, true ) == 'on' ) ? 'checked="checked"' : '';
			echo "<label><input type='checkbox' name='$option' $checked> $label </label><br>";
		}
		if ( get_page_template_slug( $post_id ) == 'page-templates/no-sidebar.php' ) {
			$label = __( 'Css class of #primary', 'maketador' );
			echo "<label>$label</label><input  type='text' value='" . Maketador_Customizer::get_full_width_class( $post_id ) . "' name='_maketador_full_width_class'  ><br>";
		}
	}

	static function save_post_page( $post_id, $post ) {

		if ( empty( $_POST ) ) {
			return $post_id;
		}

//		wp_die(print_r($_POST,true));

		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || $post->post_status == 'auto-draft' ) {
			return $post_id;
		}

		if ( $post->post_type != 'page' ) {
			return $post_id;
		}

//		if (wp_verify_nonce('maketador_page_options',__CLASS__) !== false) {

		foreach ( self::checkboxes() as $option => $label ) {
			$value = isset( $_POST[ $option ] ) ? 'on' : 'off';
			update_post_meta( $post_id, $option, $value );
		}
		if ( get_page_template_slug( $post_id ) == 'page-templates/no-sidebar.php' ) {
			update_post_meta( $post_id, '_maketador_full_width_class', sanitize_text_field( $_POST['_maketador_full_width_class'] ) );

		}

//		}

		return $post_id;

	}
}