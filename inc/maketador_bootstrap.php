<?php
/**
 * Class Name: Maketador_Bootstrap
 * GitHub URI: https://github.com/sigami/maketador/
 * Description: Adds active menu class to categories archive, modifies the caption shortcode, the password form,
 * adds label class to the tag widget, enables shortcodes on text widgets, adds btn classes to the more link,
 * adds thumbnail classes to attachment links, adds comments custom fields and form.
 * Version: 1.0
 * Author: Miguel Sirvent
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
Class Maketador_Bootstrap {
	static function hooks() {
		/*********** Nav Menu ************/
		add_filter( 'nav_menu_css_class', __CLASS__ . '::' . 'nav_menu_css_class', 10, 2 );
		add_filter( 'nav_menu_item_id', '__return_null' );
		/*********** img caption ************/
		add_filter( 'img_caption_shortcode', __CLASS__ . '::' . 'img_caption_shortcode', 10, 3 );
		/*********** password form ************/
		add_filter( 'the_password_form', __CLASS__ . '::' . 'the_password_form' );
		/*********** Tag Widget ************/
		add_filter( 'widget_tag_cloud_args', __CLASS__ . '::' . 'widget_tag_cloud_args' );
		add_action( 'wp_generate_tag_cloud_data', __CLASS__ . '::' . 'wp_generate_tag_cloud_data' );
		/** Enable shortcodes in widgets **/
		add_filter( 'widget_text', 'do_shortcode' );
		/** Disable jump in 'read more' link **/
		add_filter( 'the_content_more_link', __CLASS__ . '::' . 'the_content_more_link' );
		/** Remove height/width attributes on images so they can be responsive **/
//        add_filter('post_thumbnail_html', __CLASS__.'::'.'remove_thumbnail_dimensions'), 10);
//        add_filter('image_send_to_editor', __CLASS__.'::'.'remove_thumbnail_dimensions'), 10);
		/** Add thumbnail class to thumbnail links **/
		add_filter( 'wp_get_attachment_link', __CLASS__ . '::' . 'wp_get_attachment_link', 10, 1 );

		add_filter( 'comment_form_default_fields', __CLASS__ . '::' . 'comment_form_default_fields' );
	}

	static function img_caption_shortcode( $output, $attr, $content ) {
		if ( is_feed() ) {
			return $output;
		}
		$defaults = array(
			'id'      => '',
			'align'   => 'alignnone',
			'width'   => '',
			'caption' => ''
		);
		$attr     = shortcode_atts( $defaults, $attr );
		// If the width is less than 1 or there is no caption, return the content wrapped between the [caption] tags
		if ( $attr['width'] < 1 || empty( $attr['caption'] ) ) {
			return $content;
		}
		// Set up the attributes for the caption <figure>
		$attributes = ( ! empty( $attr['id'] ) ? ' id="' . esc_attr( $attr['id'] ) . '"' : '' );
		$attributes .= ' class="thumbnail wp-caption ' . esc_attr( $attr['align'] ) . '"';
		$attributes .= ' style="width: ' . esc_attr( $attr['width'] ) . 'px"';
		$output = '<figure' . $attributes . '>';
		$output .= do_shortcode( $content );
		$output .= '<figcaption class="caption wp-caption-text">' . $attr['caption'] . '</figcaption>';
		$output .= '</figure>';

		return $output;
	}

	static function is_element_empty( $element ) {
		$element = trim( $element );

		return empty( $element ) ? false : true;
	}

	static function nav_menu_css_class( $classes, $item ) {
		$slug      = sanitize_title( $item->title );
		$classes   = preg_replace( '/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', 'active', $classes );
		$classes   = preg_replace( '/^((menu|page)[-_\w+]+)+/', '', $classes );
		$classes[] = 'menu-' . $slug;
		$classes   = array_unique( $classes );

		return array_filter( $classes, __CLASS__ . '::' . 'is_element_empty' );
	}

	static function the_password_form() {
		ob_start();
		?>
		<form action="<?php echo site_url('/wp-login.php?action=postpass'); ?>" method="post" class="form-inline text-center">
			<fieldset>
				<p class="post-pass-alert alert alert-info"><?php _e( 'This post is password protected. To view it please enter your password below:', 'maketador' ) ?></p>

				<div class="input-group">
					<input class="form-control" type="password" name="post_password" id="search"
					       placeholder="<?php _e( 'Password', 'maketador' ); ?>"/>
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><?php _e( 'Submit', 'maketador' ); ?></button>
                    </span>
				</div>
			</fieldset>
		</form>
		<br>
		<?php
		return ob_get_clean();
	}

	static function widget_tag_cloud_args( $args ) {
//		$args['number']   = 20; // show less tags
		$args['largest']  = 12; // make largest and smallest the same - i don't like the varying font-size look
		$args['smallest'] = 9.7;
		$args['unit']     = 'px';

		return $args;
	}

	static function wp_generate_tag_cloud_data($tags_data){
		foreach($tags_data as $key => $tag){
			$tag['class'] .= ' label';
			if($tag['real_count']==1){
				$tag['class'] .= ' label-default';
			} elseif($tag['real_count']==2){
				$tag['class'] .= ' label-info';
			} elseif($tag['real_count']>=3 && $tag['real_count']<=4){
				$tag['class'] .= ' label-success';
			} elseif($tag['real_count']>=5 && $tag['real_count']<10){
				$tag['class'] .= ' label-warning';
			}else {
				$tag['class'] .= ' label-danger';
			}
			$tags_data[$key] = $tag;
		}
		return $tags_data;
	}

	static function the_content_more_link( $link ) {
		if ( $offset = strpos( $link, '#more-' ) ) {
			if ( $end = strpos( $link, '"', $offset ) ) {
				$link = substr_replace( $link, '', $offset, $end - $offset );
			}
		}

		return str_replace( 'more-link', 'more-link btn btn-sm btn-primary', '<br>' . $link );
	}

	static function remove_thumbnail_dimensions( $html ) {
		$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );

		return $html;
	}

	static function wp_get_attachment_link( $html ) {
		$html = str_replace( '<a', '<a class="thumbnail"', $html );

		return $html;
	}

	/**
	 * Example usage on comments.php
	 *
	 * <ol class="comment-list">
	 *  <?php wp_list_comments( array('callback'=>'Maketador_Bootstrap::comments') ); ?>
	 * </ol>
	 *
	 * @param $comment
	 * @param $args
	 * @param $depth
	 */
	static function comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment; ?>
		<?php if ( $comment->comment_type == 'pingback' ) : ?>
			<li id="comment-<?php comment_ID(); ?>">&nbsp;&nbsp;<i
				class="glyphicon glyphicon-share"></i>&nbsp;<?php comment_author_link(); ?>
		<?php else : ?>
			<li <?php comment_class(); ?>>
			<article id="comment-<?php comment_ID(); ?>" class="clearfix <?php echo 'single-comment' ?>">
				<div class="comment-author vcard clearfix">
					<div class="avatar col-sm-3 text-center">
						<?php echo get_avatar( $comment, $size = '75' ); ?>
					</div>
					<div class="col-sm-9 comment-text">
						<?php printf( '<h3>%s</h3>', get_comment_author_link() ) ?>
						<?php edit_comment_link( __( 'Edit', 'maketador' ), '<span class="edit-comment btn btn-sm btn-info"><i class="glyphicon-pencil"></i>', '</span>' ) ?>

						<?php if ( $comment->comment_approved == '0' ) : ?>
							<div class="alert-message success">
								<p><?php _e( 'Your comment is awaiting moderation.', 'maketador' ) ?></p>
							</div>
						<?php endif; ?>

						<?php comment_text() ?>

						<time datetime="<?php comment_time( 'Y-m-j' ); ?>"><a
								href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time( 'F jS, Y' ); ?> </a>
						</time>

						<?php comment_reply_link( array_merge( $args, array( 'depth'     => $depth,
						                                                     'max_depth' => $args['max_depth']
						) ) ) ?>
					</div>
				</div>
			</article>
		<?php endif; ?>
		<?php
	}

	static function comment_form_default_fields() {

		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );


		return array(

			'author' =>
				'<div class="form-group">
			  <label for="author">' . __( "Name", 'maketador' )
				. ( $req ? " (" . __( "required", 'maketador' ) . ")" : '' )
				. ' </label>
			  <div class="input-group">
			  	<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
			  	<input class="form-control" type="text" name="author" id="author" value="'
				. esc_attr( $commenter['comment_author'] ) . '" placeholder="'
				. __( "Your Name", 'maketador' ) . '"'
				. ( $req ? ' required aria-required="true"' : '' ) . '/>'
				. '</div>'
				. '</div>',
			'email'  =>
				'<div class="form-group">
			  <label for="email">' . __( "Email", 'maketador' )
				. ( $req ? " (" . __( "required", 'maketador' ) . ")" : '' )
				. ' </label>
			  <div class="input-group">
			  	<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
			  	<input class="form-control" type="email" name="email" id="email" value="'
				. esc_attr( $commenter['comment_author_email'] ) . '" placeholder="'
				. __( "Your Email", 'maketador' ) . '"'
				. ( $req ? ' required aria-required="true"' : '' ) . '/>'
				. '</div>'
				. '<span class="help-block">' . __( "will not be published", 'maketador' ) . '</span>'
				. '</div>',
			'url'    => '<div class="form-group">
			  <label for="author">' . __( "Website", 'maketador' )
			            . ' </label>
			  <div class="input-group">
			  	<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
			  	<input class="form-control" type="url" name="url" id="url" value="'
			            . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="'
			            . __( "Your Website", 'maketador' ) . '"'
			            . '/>'
			            . '</div>'
			            . '</div>'
		);
	}
}
