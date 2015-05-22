<?php
/**
 * Plugin Name: GiveWP Toolbar
 * Description: A simple toolbar plugin for the Give Plugin for WordPress
 * Author: Nikhil Vimal
 * Author URI: http://nik.techvoltz.com
 * Version: 1.0
 * Plugin URI:
 * License: GNU GPLv2+
 */

class GiveWP_Admin_Bar {
	//The GiveWP Toolbar Instance
	public static function init() {
		static $instance = false;
		if ( ! $instance ) {
			$instance = new GiveWP_Admin_Bar();
		}
		return $instance;
	}

	public function __construct() {
		add_action('admin_bar_menu', array( $this, 'admin_bar_nodes'), 999);
	}

	/**
	 * The function that creates the menus (nodes) for the admin bar
	 *
	 * @param $wp_admin_bar The WordPress admin bar
	 */
	public function admin_bar_nodes( $wp_admin_bar ) {
		if ( ! is_admin() ) {
			$count_posts = wp_count_posts('give_payment');

			$wp_admin_bar->add_node( array(
					'id'    => 'givewp_toolbar',
					'title' => 'Give',
				)
			);

			if( is_singular('give_forms')) {
				//Code coming here soon!


			}

			$wp_admin_bar->add_node( array(
					'id'     => 'givewp_all_products',
					'title'  => 'All Products',
					'parent' => 'givewp_toolbar',
					'href'   => admin_url( 'edit.php?post_type=give_forms' ),
				)
			);

			$wp_admin_bar->add_node( array(
					'id'     => 'givewp_new_product',
					'title'  => 'New Give Form',
					'parent' => 'givewp_toolbar',
					'href'   => admin_url( 'post-new.php?post_type=give_forms' ),
				)
			);

			$wp_admin_bar->add_node( array(
					'id'     => 'givewp_transactions',
					'title'  => 'Transactions (' . $count_posts->publish . ')',
					'parent' => 'givewp_toolbar',
					'href'   => admin_url( 'edit.php?post_type=give_forms&page=give-payment-history' ),
				)
			);

			$wp_admin_bar->add_node( array(
					'id'     => 'givewp_reports',
					'title'  => 'Reports',
					'parent' => 'givewp_toolbar',
					'href'   => admin_url( 'edit.php?post_type=give_forms&page=give-reports' ),
				)
			);

			$wp_admin_bar->add_node( array(
					'id'     => 'givewp_settings',
					'title'  => 'Settings',
					'parent' => 'givewp_toolbar',
					'href'   => admin_url( 'edit.php?post_type=give_forms&page=give-settings' ),
				)
			);

		}
	}
}
/**
 * Load the class, and check if the main plugin file exists
 *
 * @since 1.0
 */
function load_GiveWP_Admin_Bar() {
	if( !function_exists( 'is_plugin_active' ) ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}
	//Check if the plugin's main file exists
	if( is_plugin_active( 'Give/give.php' ) ) {
		return GiveWP_Admin_Bar::init();
	}
}
add_action('plugins_loaded', 'load_GiveWP_Admin_Bar');