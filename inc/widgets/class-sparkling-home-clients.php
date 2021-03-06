<?php

/**
 * Homepage parralax section Widget
 * Sparkling Theme
 */
class Sparkling_Home_Clients extends WP_Widget {
	function __construct() {

		$widget_ops = array(
			'classname'                   => 'sparkling_home_clients',
			'description'                 => esc_html__( 'Sparkling Client Section That Displays Logos In A Slider', 'sparkling' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'sparkling_home_clients', esc_html__( '[Sparkling] Client Section For FrontPage', 'sparkling' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		$title = isset( $instance['title'] ) && ! empty( $instance['title'] ) ? $instance['title'] : __( 'Our Main Clients', 'sparkling' );
		$logos = isset( $instance['client_logo'] ) ? $instance['client_logo'] : '';

		echo $instance['before_widget'];
		if ( 'object' == gettype( $logos ) ) {
			$logos = get_object_vars( $logos );
		}

		/**
		 * Widget Content
		 */
		?>
		<?php if ( isset( $logos['img'] ) && 0 != count( $logos['img'] ) ) { ?>
			<section>
				<div class="container">
					<div class="row">
						<div class="col-sm-12 text-center">
							<h3 class="mb64 mb-xs-40"><?php echo wp_kses_post( $title ); ?></h3>
						</div>
					</div>
					<!--end of row-->
					<div class="row">
						<div class="logo-carousel">
							<ul class="slides"><?php
							for ( $i = 0; $i < count( $logos['img'] ); $i ++ ) {
								if ( '' != $logos['img'] && '' != $logos['link'] ) { ?>
										<li>
										<a href="<?php echo esc_url_raw( $logos['link'][ $i ] ); ?>">
											<img alt="<?php _e( 'Logos', 'sparkling' ); ?>"
												 src="<?php echo esc_url_raw( $logos['img'][ $i ] ); ?>"/>
										</a>
										</li><?php
								}
							} ?>
							</ul>
						</div>
						<!--end of logo slider-->
					</div>
					<!--end of row-->
				</div>
				<!--end of container-->
			</section>
		<?php } ?>

		<?php

		echo $instance['after_widget'];
	}


	function form( $instance ) {
		if ( ! isset( $instance['title'] ) ) {
			$instance['title'] = '';
		}

		$logos = array();
		if ( ! empty( $instance['client_logo'] ) ) {
			$logos = $instance['client_logo'];
			if ( 'object' == gettype( $logos ) ) {
				$logos = get_object_vars( $logos );
			}
		}

		if ( ! isset( $logos['img'] ) ) {
			$logos['img'] = array( '' );
		}
		if ( ! isset( $logos['link'] ) ) {
			$logos['link'] = array( '' );
		}
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title ', 'sparkling' ) ?></label>
			<input type="text" value="<?php echo esc_attr( $instance['title'] ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
				   id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				   class="widefat"/>
		</p>

		<ul class="client-sortable clone-wrapper"><?php
		$image_src    = $logos['img'];
		$logo_link    = $logos['link'];
		$slider_count = ( isset( $image_src ) && count( $image_src ) > 0 ) ? count( $image_src ) : 3;

		for ( $i = 0; $i < $slider_count; $i ++ ) : ?>
			<li class="toclone">
				<br>
				<p class="sparkling-media-control"
				   data-delegate-container="<?php echo esc_attr( $this->get_field_id( 'client_logo' ) . '-' . absint( $i ) ) ?>">
					<label class="logo_heading" for="<?php echo esc_attr( $this->get_field_id( 'client_logo' ) . '-' . absint( $i ) ); ?>"><?php _e( 'Logo #', 'sparkling' ); ?>
						<span class="count"><?php echo absint( $i ) + 1; ?></span>:
					</label>

					<img src="<?php echo ( isset( $image_src[ $i ] ) ) ? esc_url( $image_src[ $i ] ) : ''; ?>"/>

					<input type="hidden"
						   name="<?php echo esc_attr( $this->get_field_name( 'client_logo' ) . '[img][' . $i . ']' ); ?>"
						   id="<?php echo esc_attr( $this->get_field_id( 'client_logo' ) . '-' . (int) $i ); ?>"
						   value="<?php echo ( isset( $image_src[ $i ] ) ) ? esc_url( $image_src[ $i ] ) : ''; ?>"
						   class="image-id blazersix-media-control-target">

					<button type="button" class="button upload-button"><?php _e( 'Choose Image', 'sparkling' ); ?></button>
				</p>

				<label><?php _e( 'Link:', 'sparkling' ); ?></label>
				<input name="<?php echo esc_attr( $this->get_field_name( 'client_logo' ) . '[link][' . $i . ']' ); ?>"
					   id="link<?php echo esc_attr( '-' . absint( $i ) ); ?>" class="widefat client-link" type="text"
					   size="36"
					   value="<?php echo ( isset( $logo_link[ $i ] ) ) ? esc_url( $logo_link[ $i ] ) : ''; ?>"/><br><br>

				<a href="#" class="clone button-primary"><?php _e( 'Add', 'sparkling' ); ?></a>
				<a href="#" class="delete button"><?php _e( 'Delete', 'sparkling' ); ?></a>
			</li>
		<?php endfor; ?>
		</ul><?php

	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? wp_kses_post( $new_instance['title'] ) : '';

		if ( isset( $new_instance['client_logo']['img'] ) && count( $new_instance['client_logo']['img'] ) != 0 ) {
			for ( $i = 0; $i < count( $new_instance['client_logo']['img'] ); $i ++ ) {
				$instance['client_logo']['img'][ $i ] = ( ! empty( $new_instance['client_logo']['img'][ $i ] ) ) ? esc_url_raw( $new_instance['client_logo']['img'][ $i ] ) : '';
			}
		}
		if ( isset( $new_instance['client_logo']['link'] ) && count( $new_instance['client_logo']['link'] ) != 0 ) {
			for ( $i = 0; $i < count( $new_instance['client_logo']['link'] ); $i ++ ) {
				$instance['client_logo']['link'][ $i ] = ( ! empty( $new_instance['client_logo']['link'][ $i ] ) ) ? esc_url_raw( $new_instance['client_logo']['link'][ $i ] ) : '';
			}
		}

		return $instance;
	}

}

?>
