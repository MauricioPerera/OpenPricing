<?php
/**
 * Product Open Pricing for WooCommerce - General Section Settings
 *
 * @version 1.5.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 * @author  RCKFLR
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_Product_Open_Pricing_Settings_General' ) ) :

class Alg_WC_Product_Open_Pricing_Settings_General extends Alg_WC_Product_Open_Pricing_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function __construct() {
		$this->id   = '';
		$this->desc = __( 'General', 'open-pricing' );
		parent::__construct();
	}

	/**
	 * get_settings.
	 *
	 * @version 1.5.0
	 * @since   1.0.0
	 */
	public static function get_settings() {
		$default_price_step = 1 / pow( 10, absint( get_option( 'woocommerce_price_num_decimals', 2 ) ) );
		$settings = array(

			array(
				'title'    => __( 'Product Open Pricing Options', 'open-pricing' ),
				'type'     => 'title',
				'id'       => 'alg_wc_product_open_pricing_options',
			),
			array(
				'title'    => __( 'Product Open Pricing (Name Your Price)', 'open-pricing' ),
				'desc'     => '<strong>' . __( 'Enable plugin', 'open-pricing' ) . '</strong>',
				'desc_tip' => __( 'Let your WooCommerce store customers enter price for the product manually.', 'open-pricing' ),
				'id'       => 'alg_wc_product_open_pricing_enabled',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_product_open_pricing_options',
			),

			// Single Product Page
			array(
				'title'    => __( 'Single Product Page Options', 'open-pricing' ),
				'type'     => 'title',
				'id'       => 'alg_wc_product_open_pricing_single_product_page_options',
			),
			array(
				'title'    => __( 'Frontend template', 'open-pricing' ),
				'desc'     => sprintf( __( 'Replaced placeholders: %s.' ),
					'<code>' . implode( '</code>, <code>', array( '%input_id%', '%open_price_input%', '%currency_symbol%', '%minimum_price%', '%max_price%' ) ) . '</code>' ),
				'id'       => 'alg_wc_product_open_pricing_frontend_template',
				'default'  => '<label for="%input_id%">'.__( 'Name Your Price', 'open-pricing' ).'</label> %open_price_input% %currency_symbol%',
				'type'     => 'textarea',
				'css'      => 'width:100%;',
				'alg_wc_pop_raw' => true,
			),
			array(
				'title'    => __( 'Input field position', 'open-pricing' ),
				'id'       => 'alg_wc_product_open_pricing_field_position',
				'default'  => 'woocommerce_before_add_to_cart_button',
				'type'     => 'select',
				'class'    => 'wc-enhanced-select',
				'options'  => array(
					'woocommerce_before_add_to_cart_button'     => __( 'Before add to cart button', 'open-pricing' ),
					'woocommerce_before_add_to_cart_quantity'   => __( 'Before add to cart quantity', 'open-pricing' ),
					'woocommerce_after_add_to_cart_quantity'    => __( 'After add to cart quantity', 'open-pricing' ),
					'woocommerce_after_add_to_cart_button'      => __( 'After add to cart button', 'open-pricing' ),
				),
			),
			array(
				'desc'     => __( 'Position priority.', 'open-pricing' ),
				'desc_tip' => __( 'Change this if you want to move the field inside the Position.', 'open-pricing' ),
				'id'       => 'alg_wc_product_open_pricing_field_position_priority',
				'default'  => 9999,
				'type'     => 'number',
			),
			array(
				'title'    => __( 'Hide price', 'open-pricing' ),
				'desc'     => __( 'Hide', 'open-pricing' ),
				'desc_tip' => __( 'Hides original price on single product page.', 'open-pricing' ),
				'id'       => 'alg_wc_product_open_pricing_hide_price',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'title'    => __( 'Disable quantity selector', 'open-pricing' ),
				'desc'     => __( 'Disable', 'open-pricing' ),
				'id'       => 'alg_wc_product_open_pricing_disable_qty',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_product_open_pricing_single_product_page_options',
			),

			// Loop
			array(
				'title'    => __( 'Shop/Category Page Options', 'open-pricing' ),
				'desc'     => __( 'Options regarding WooCommerce loop, like shop or category pages.', 'open-pricing' ),
				'type'     => 'title',
				'id'       => 'alg_wc_product_open_pricing_loop_options',
			),
			array(
				'title'    => __( 'Display on loop', 'open-pricing' ),
				'desc'     => __( 'Enable', 'open-pricing' ),
				'desc_tip' => __( 'Displays the open pricing input field on loop.', 'open-pricing' ),
				'id'       => 'alg_wc_product_open_pricing_field_on_loop',
				'default'  => 'no',
				'type'     => 'checkbox',
			),
			array(
				'title'    => __( 'Frontend loop template', 'open-pricing' ),
				'desc_tip' => __( 'Overwrites the "Frontend template" option if input field displayed on loop.', 'open-pricing' ),
				'desc'     => sprintf( __( 'Replaced placeholders: %s.' ),
					'<code>' . implode( '</code>, <code>', array( '%input_id%', '%open_price_input%', '%currency_symbol%', '%minimum_price%', '%max_price%' ) ) . '</code>' ),
				'id'       => 'alg_wc_product_open_pricing_frontend_loop_template',
				'default'  => '<label for="%input_id%">' . __( 'Name Your Price', 'open-pricing' ) . '</label> %open_price_input% %currency_symbol%',
				'type'     => 'textarea',
				'css'      => 'width:100%;',
				'alg_wc_pop_raw' => true,
			),
			array(
				'title'    => __( 'Input field loop position', 'open-pricing' ),
				'id'       => 'alg_wc_product_open_pricing_field_loop_position',
				'default'  => 'woocommerce_after_shop_loop_item',
				'type'     => 'select',
				'class'    => 'wc-enhanced-select',
				'options'  => array(
					'woocommerce_before_shop_loop_item'   => __( 'Before item', 'open-pricing' ),
					'woocommerce_after_shop_loop_item'    => __( 'After item', 'open-pricing' ),
				),
			),
			array(
				'desc'     => __( 'Position priority.', 'open-pricing' ),
				'desc_tip' => __( 'Change this if you want to move the field inside the Position.', 'open-pricing' ),
				'id'       => 'alg_wc_product_open_pricing_field_loop_position_priority',
				'default'  => 9,
				'type'     => 'number',
			),
			array(
				'title'    => __( 'Hide price', 'open-pricing' ),
				'desc'     => __( 'Hide', 'open-pricing' ),
				'desc_tip' => __( 'Hides original price on loop.', 'open-pricing' ),
				'id'       => 'alg_wc_product_open_pricing_loop_hide_price',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_product_open_pricing_loop_options',
			),

			// Frontend
			array(
				'title'    => __( 'Frontend Options', 'open-pricing' ),
				'type'     => 'title',
				'id'       => 'alg_wc_product_open_pricing_general_options',
			),
			array(
				'title'    => __( 'Input style', 'open-pricing' ),
				'id'       => 'alg_wc_product_open_pricing_input_style',
				'default'  => 'width:75px;text-align:center;',
				'type'     => 'text',
				'css'      => 'width:100%;',
				'alg_wc_pop_raw' => true,
			),
			array(
				'title'    => __( 'Input pattern', 'open-pricing' ),
				'desc'     => sprintf( __( 'For backslash use %s, e.g.: %s.', 'open-pricing' ),
					'<code>%backslash%</code>', '<code>%backslash%d*</code>' ),
				'id'       => 'alg_wc_product_open_pricing_input_pattern',
				'default'  => '',
				'type'     => 'text',
				'alg_wc_pop_raw' => true,
			),
			array(
				'title'    => __( 'Enable step ticker', 'open-pricing' ),
				'desc'     => __( 'Enable', 'open-pricing' ),
				'desc_tip' => __( 'Enables up/down ticker buttons for the input field.', 'open-pricing' ),
				'id'       => 'alg_wc_product_open_pricing_enable_step',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'title'    => __( 'Price step', 'open-pricing' ),
				'id'       => 'alg_wc_product_open_pricing_price_step',
				'default'  => $default_price_step,
				'type'     => 'number',
				'custom_attributes' => array( 'step' => '0.000000001', 'min' => '0.000000001' ),
			),
			array(
				'title'    => __( 'Force number of decimals', 'open-pricing' ),
				'desc'     => __( 'Enable', 'open-pricing' ),
				'id'       => 'alg_wc_product_open_pricing_force_decimal_width_enabled',
				'default'  => 'no',
				'type'     => 'checkbox',
			),
			array(
				'desc'     => __( 'Number of decimals.', 'open-pricing' ),
				'id'       => 'alg_wc_product_open_pricing_force_decimal_width',
				'default'  => get_option( 'woocommerce_price_num_decimals', 2 ),
				'type'     => 'number',
				'custom_attributes' => array( 'min' => '0' ),
			),
			array(
				'title'    => __( 'Add To Cart button text', 'open-pricing' ),
				'desc'     => __( 'Applies to Open Pricing products only. Leave blank for WooCommerce default text.', 'open-pricing' ),
				'id'       => 'wpw_pop_add_to_cart_text',
				'default'  => '',
				'type'     => 'text',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_product_open_pricing_general_options',
			),

			// Messages
			array(
				'title'    => __( 'Message Options', 'open-pricing' ),
				'desc'     => __( 'Confirmation/Error messages, displayed after customer try to purchase.', 'open-pricing' ),
				'type'     => 'title',
				'id'       => 'alg_wc_product_open_pricing_message_options',
			),
			array(
				'title'    => __( 'Message on empty price', 'open-pricing' ),
				'id'       => 'alg_wc_product_open_pricing_messages_required',
				'default'  => __( 'Price is required!', 'open-pricing' ),
				'type'     => 'text',
				'css'      => 'width:100%;',
				'alg_wc_pop_raw' => true,
			),
			array(
				'title'    => __( 'Message on price too low', 'open-pricing' ),
				'id'       => 'alg_wc_product_open_pricing_messages_too_small',
				'default'  => __( 'Price is too low!', 'open-pricing' ),
				'type'     => 'text',
				'css'      => 'width:100%;',
				'alg_wc_pop_raw' => true,
			),
			array(
				'title'    => __( 'Message on price too high', 'open-pricing' ),
				'id'       => 'alg_wc_product_open_pricing_messages_too_big',
				'default'  => __( 'Price is too high!', 'open-pricing' ),
				'type'     => 'text',
				'css'      => 'width:100%;',
				'alg_wc_pop_raw' => true,
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_product_open_pricing_message_options',
			),

			// Admin
			array(
				'title'    => __( 'Admin Options', 'open-pricing' ),
				'type'     => 'title',
				'id'       => 'alg_wc_product_open_pricing_admin_options',
			),
			array(
				'title'    => __( 'Add "Open Pricing" column', 'open-pricing' ),
				'desc'     => __( 'Add', 'open-pricing' ),
				'desc_tip' => sprintf( __( 'Adds "Open Pricing" column to the admin <a href="%s">products list</a>.', 'open-pricing' ),
					admin_url( 'edit.php?post_type=product' ) ),
				'id'       => 'alg_wc_product_open_pricing_add_admin_column',
				'default'  => 'no',
				'type'     => 'checkbox',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_product_open_pricing_admin_options',
			),

			// Advanced
			array(
				'title'    => __( 'Advanced Options', 'open-pricing' ),
				'type'     => 'title',
				'id'       => 'alg_wc_product_open_pricing_advanced_options',
			),
			array(
				'title'    => __( 'Fix mini cart', 'open-pricing' ),
				'desc'     => __( 'Enable', 'open-pricing' ),
				'desc_tip' => __( 'Fixes open pricing item price in mini cart.', 'open-pricing' ),
				'id'       => 'alg_wc_product_open_pricing_fix_mini_cart',
				'default'  => 'no',
				'type'     => 'checkbox',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_product_open_pricing_advanced_options',
			),

		);
		return $settings;
	}

}

endif;

return new Alg_WC_Product_Open_Pricing_Settings_General();
