<?php

class Maketador_Page_Metabox {

	static function checkboxes(){
		return array(
			'_maketador_hide_title' =>__('Hide Title','maketador'),
			'_maketador_show_date' =>__('Show Date','maketador'),
			'_maketador_hide_header' =>__('Hide Header','maketador'),
			'_maketador_hide_footer' =>__('Hide Footer','maketador')
		);
	}
	static function hooks(){
		add_action('add_meta_boxes_page', __CLASS__ . '::add_meta_boxes_page', 10);
		add_action('save_post', __CLASS__ . '::save_post_page', 10, 3);
	}
	static function add_meta_boxes_page() {
		add_meta_box(
			'maketador_page_options',
			__('Page Options','maketador'),
			__CLASS__ . '::metabox_form',
			'page',
			'side',//context
			'high'//prio
		);
	}

	static function metabox_form() {
		$post_id = get_the_ID();
		wp_nonce_field(__CLASS__, 'maketador_page_options');
		foreach (self::checkboxes() as $option=>$label){
			$checked = ( get_post_meta( $post_id, $option, true ) == 'on' ) ? 'checked="checked"' : '';
			echo "<label>$label<input type='checkbox' name='$option' $checked></label><br>";
		}
	}

	static function save_post_page($id, $post, $update) {

		if (empty($_POST)) return $id;

//		wp_die(print_r($_POST,true));

		if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || $post->post_status == 'auto-draft') return $id;

		if ($post->post_type != 'page') return $id;

//		if (wp_verify_nonce('maketador_page_options',__CLASS__) !== false) {

			foreach (self::checkboxes() as $option=>$label){
				$value = isset($_POST[$option]) ? 'on' : 'off';
				update_post_meta($id, $option, $value);
			}

//		}

		return $id;

	}
}