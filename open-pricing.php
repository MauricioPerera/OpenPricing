<?php
/*
Plugin Name: Open Pricing
Plugin URI: https://rckflr.com/products/open-pricing/
Description: Open price (i.e. Name your price) products for WooCommerce.
Version: 1.0
Author: RCKFLR
Author URI: https://rckflr.com/
Text Domain: open-pricing
Domain Path: /langs
Copyright: © 2019-2020 RCKFLR
WC tested up to: 4.8
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

require __DIR__ . '/vendor/autoload.php';

function appsero_init_tracker_open_pricing() {

    if ( ! class_exists( 'Appsero\Client' ) ) {
      require_once __DIR__ . '/appsero/src/Client.php';
    }

    $client = new Appsero\Client( '613d5d26-f3b2-4664-bde2-761fa81286c2', 'Open Pricing', __FILE__ );

    // Active insights
    $client->insights()->init();

    // Active automatic updater
    $client->updater();

}

appsero_init_tracker_open_pricing();
// Check if WooCommerce is active
$plugin = 'woocommerce/woocommerce.php';
if (
	! in_array( $plugin, apply_filters( 'active_plugins', get_option( 'active_plugins', array() ) ) ) &&
	! ( is_multisite() && array_key_exists( $plugin, get_site_option( 'active_sitewide_plugins', array() ) ) )
) {
	return;
}

if ( 'open-pricing.php' === basename( __FILE__ ) ) {
	$plugin = 'open-pricing-pro/open-pricing-pro.php';
	if (
		in_array( $plugin, apply_filters( 'active_plugins', get_option( 'active_plugins', array() ) ) ) ||
		( is_multisite() && array_key_exists( $plugin, get_site_option( 'active_sitewide_plugins', array() ) ) )
	) {
		return;
	}
}

if ( ! class_exists( 'Alg_WC_Product_Open_Pricing' ) ) :

/**
 * Main Alg_WC_Product_Open_Pricing Class
 *
 * @class   Alg_WC_Product_Open_Pricing
 * @version 1.4.6
 * @since   1.0.0
 */
final class Alg_WC_Product_Open_Pricing {

	/**
	 * Plugin version.
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	public $version = '1.5.0';

	/**
	 * @var   Alg_WC_Product_Open_Pricing The single instance of the class
	 * @since 1.0.0
	 */
	protected static $_instance = null;

	/**
	 * Main Alg_WC_Product_Open_Pricing Instance
	 *
	 * Ensures only one instance of Alg_WC_Product_Open_Pricing is loaded or can be loaded.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @static
	 * @return  Alg_WC_Product_Open_Pricing - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Alg_WC_Product_Open_Pricing Constructor.
	 *
	 * @version 1.3.0
	 * @since   1.0.0
	 * @access  public
	 */
	function __construct() {

		// Set up localisation
		load_plugin_textdomain( 'open-pricing', false, dirname( plugin_basename( __FILE__ ) ) . '/langs/' );

		// Include required files
		$this->includes();

		// Admin
		if ( is_admin() ) {
			$this->admin();
		}
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 *
	 * @version 1.3.0
	 * @since   1.0.0
	 */
	function includes() {
		// Core
		require_once( 'includes/class-rckflr-wc-product-open-pricing-core.php' );
	}

	/**
	 * add settings to WC status report
	 *
	 * @version 1.5.0
	 * @since   1.4.6
	 * @author  RCKFLR
	 */
	public static function add_settings_to_status_report() {
		#region add_settings_to_status_report
		$protected_settings = array( 'rckflr_product_open_pricing_license' );
		$settings           = Alg_WC_Product_Open_Pricing_Settings_General::get_settings();
		?>
		<table class="wc_status_table widefat" cellspacing="0">
			<thead>
				<tr>
					<th colspan="3" data-export-label="Product Open Pricing Settings"><h2><?php esc_html_e( 'Product Open Pricing Settings', 'open-pricing' ); ?></h2></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $settings as $setting ): ?>
				<?php 
				if ( in_array( $setting['type'], array( 'title', 'sectionend' ) ) ) { 
					continue;
				}
				if ( isset( $setting['title'] ) ) {
					$title = $setting['title'];
				} elseif ( isset( $setting['desc'] ) ) {
					$title = $setting['desc'];
				} else {
					$title = $setting['id'];
				}
				$value = get_option( $setting['id'] ); 
				if ( in_array( $setting['id'], $protected_settings ) ) {
					$value = $value > '' ? '(set)' : 'not set';
				}
				?>
				<tr>
					<td data-export-label="<?php echo esc_attr( $title ); ?>"><?php esc_html_e( $title, 'open-pricing' ); ?>:</td>
					<td class="help">&nbsp;</td>
					<td><?php echo is_array( $value ) ? print_r( $value, true ) : $value; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php
		#endregion add_settings_to_status_report
	}

	/**
	 * admin.
	 *
	 * @version 1.3.0
	 * @since   1.3.0
	 */
	function admin() {
		// Action links
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'action_links' ) );
		// Settings
		require_once( 'includes/settings/class-rckflr-wc-product-open-pricing-settings-section.php' );
		$this->settings = array();
		$this->settings['general'] = require_once( 'includes/settings/class-rckflr-wc-product-open-pricing-settings-general.php' );
		add_filter( 'woocommerce_get_settings_pages', array( $this, 'add_woocommerce_settings_tab' ) );
		add_action( 'woocommerce_system_status_report', array( $this, 'add_settings_to_status_report' ) );
		// Metaboxes (per Product Settings)
		require_once( 'includes/settings/class-rckflr-wc-product-open-pricing-settings-per-product.php' );
		// Version updated
		if ( get_option( 'alg_wc_product_open_pricing_version', '' ) !== $this->version ) {
			add_action( 'admin_init', array( $this, 'version_updated' ) );
		}
	}

	/**
	 * Show action links on the plugin screen.
	 *
	 * @version 1.2.5
	 * @since   1.0.0
	 * @param   mixed $links
	 * @return  array
	 */
	function action_links( $links ) {
		$custom_links = array();
		$custom_links[] = '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=alg_wc_product_open_pricing' ) . '">' . __( 'Settings', 'woocommerce' ) . '</a>';
		$custom_links[] = '<a href="https://rckflr.com/#contacto">' . __( 'Contact', 'woocommerce' ) . '</a>';
		
		return array_merge( $custom_links, $links );
	}

	/**
	 * Add Product Open Pricing settings tab to WooCommerce settings.
	 *
	 * @version 1.3.0
	 * @since   1.0.0
	 */
	function add_woocommerce_settings_tab( $settings ) {
		$settings[] = require_once( 'includes/settings/class-rckflr-wc-settings-product-open-pricing.php' );
		return $settings;
	}

	/**
	 * version_updated.
	 *
	 * @version 1.3.0
	 * @since   1.3.0
	 */
	function version_updated() {
		update_option( 'alg_wc_product_open_pricing_version', $this->version );
	}

	/**
	 * Get the plugin url.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return  string
	 */
	function plugin_url() {
		return untrailingslashit( plugin_dir_url( __FILE__ ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return  string
	 */
	function plugin_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

}

endif;

if ( ! function_exists( 'alg_wc_product_open_pricing' ) ) {
	/**
	 * Returns the main instance of Alg_WC_Product_Open_Pricing to prevent the need to use globals.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return  Alg_WC_Product_Open_Pricing
	 */
	function alg_wc_product_open_pricing() {
		return Alg_WC_Product_Open_Pricing::instance();
	}
}

alg_wc_product_open_pricing();
