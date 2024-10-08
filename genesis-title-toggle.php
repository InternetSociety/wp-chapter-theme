<?php
/**
 * itle toggle feature as per https://wordpress.org/plugins/genesis-title-toggle/
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Main BE_Title_Toggle class
 *
 * @since 1.0.0
 * @package BE_Title_Toggle
 */
class BE_Title_Toggle {

	/**
	 * Primary constructor.
	 *
	 * @since 1.0.0
	 */
	function __construct() {

		// Run on plugin activation
		register_activation_hook( __FILE__, array( $this, 'activation_hook' ) );

		// Bootstrap and go
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Initialize the plugin.
	 *
	 * @since 1.0.0
	 */
	function init() {

		// Translations
		load_plugin_textdomain( 'genesis-title-toggle', false, basename( dirname( __FILE__ ) ) . '/languages' );

		// Genesis 2.x: Metabox on Theme Settings, for Sitewide Default
		add_filter( 'genesis_theme_settings_defaults',  array( $this, 'settings_defaults'         ) );
		add_action( 'genesis_settings_sanitizer_init',  array( $this, 'settings_sanitization'     ) );
		add_action( 'genesis_theme_settings_metaboxes', array( $this, 'settings_register_metabox' ) );

		// Genesis 3.x: Theme settings in customizer
		add_filter( 'genesis_customizer_theme_settings_config', array( $this, 'customizer_settings' ) );

		// Pages metaboxes
		add_action( 'add_meta_boxes', array( $this, 'metabox_register' )         );
		add_action( 'save_post',      array( $this, 'metabox_save'     ),  1, 2  );

		// Show/hide Page Title
		add_action( 'genesis_meta', array( $this, 'title_toggle' ), 20 );

		// If theme supports post formats, run later
		if( current_theme_supports( 'post-formats' ) ) {
			add_action( 'genesis_before_post', array( $this, 'title_toggle' ), 20 );
			add_action( 'genesis_before_entry', array( $this, 'title_toggle' ), 20 );
		}

		// Site title as h1
		add_filter( 'genesis_site_title_wrap', array( $this, 'site_title_h1' ) );
	}

	/**
	 * Activation Hook - Confirm site is using Genesis
	 *
	 * @since 1.0.0
	 */
	function activation_hook() {

		if ( 'genesis' != basename( TEMPLATEPATH ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			wp_die( sprintf( __( 'Sorry, you can&rsquo;t activate unless you have installed <a href="%s">Genesis</a>', 'genesis-title-toggle' ), 'http://www.billerickson.net/get-genesis' ) );
		}
	}

	/**
	 * Sitewide Setting - Register Defaults
	 *
	 * @since 1.0.0
	 * @link http://www.billerickson.net/genesis-theme-options/
	 * @param array $defaults
	 * @return array modified defaults
	 */
	function settings_defaults( $defaults ) {

		$post_types = apply_filters( 'be_title_toggle_post_types', array( 'page' ) );
		foreach ( $post_types as $post_type ) {
			$defaults[] = array( 'be_title_toggle_' . $post_type => '' );
		}
		return $defaults;
	}

	/**
	 * Sitewide Setting - Sanitization
	 *
	 * @since 1.0.0
	 * @link http://www.billerickson.net/genesis-theme-options/
	 */
	function settings_sanitization() {

		$fields = array();
		$post_types = apply_filters( 'be_title_toggle_post_types', array( 'page' ) );
		foreach ( $post_types as $post_type ) {
			$fields[] = 'be_title_toggle_' . $post_type;
		}

	    genesis_add_option_filter( 'one_zero', GENESIS_SETTINGS_FIELD, $fields );
	}

	/**
	 * Sitewide Setting - Register Metabox
	 *
	 * @since 1.0.0
	 * @link http://www.billerickson.net/genesis-theme-options/
	 * @param string, Genesis theme settings page hook
	 */
	function settings_register_metabox( $_genesis_theme_settings_pagehook ) {

		add_meta_box( 'be-title-toggle', __( 'Title Toggle', 'genesis-title-toggle' ), array( $this, 'settings_render_metabox' ), $_genesis_theme_settings_pagehook, 'main', 'high' );
	}

	/**
	 * Sitewide Setting - Create Metabox
	 *
	 * @since 1.0.0
	 * @link http://www.billerickson.net/genesis-theme-options/
	 */
	function settings_render_metabox() {

		$post_types = apply_filters( 'be_title_toggle_post_types', array( 'page' ) );
		foreach ( $post_types as $post_type ) {
			echo '<p><input type="checkbox" name="' . GENESIS_SETTINGS_FIELD . '[be_title_toggle_' . $post_type . ']" id="' . GENESIS_SETTINGS_FIELD . '[be_title_toggle_' . $post_type . ']" value="1" ' . checked( 1, genesis_get_option( 'be_title_toggle_' . $post_type ), false ) .' /> <label for="' . GENESIS_SETTINGS_FIELD . '[be_title_toggle_' . $post_type . ']"> ' . sprintf( __( 'By default, remove titles in the <strong>%s</strong> post type.', 'genesis-title-toggle' ), $post_type ) .'</label></p>';
		}
	}

	/**
	 * Customizer settings
	 *
	 * @since 1.9.0
	 */
	public function customizer_settings( array $config ) {
		$controls = array();
		$post_types = apply_filters( 'be_title_toggle_post_types', array( 'page' ) );
		foreach( $post_types as $post_type ) {
			$controls['be_title_toggle_' . $post_type ] = array(
				'label'       => ucfirst( $post_type ),
				'description' => sprintf( __( 'By default, remove titles in the <strong>%s</strong> post type.', 'genesis-title-toggle' ), $post_type ),
				'section'     => 'title_toggle',
				'type'        => 'checkbox',
				'settings'    => array(
					'default' => 0,
				),

			);
		}
		$config['genesis']['sections']['title_toggle'] = array(
			'title' => __( 'Title Toggle', 'genesis-title-toggle' ),
			'panel' => 'genesis',
			'controls' => $controls,
		);
		return $config;
	}

	/**
	 * Register the metabox
	 *
	 * @since 1.6.0
	 */
	function metabox_register() {

		// Make sure we're still in Genesis, plugins like WP Touch need this check
		if ( !function_exists( 'genesis_get_option' ) ){
			return $meta_boxes;
		}

		// Allow devs to control what post types this is allowed on
		$post_types = apply_filters( 'be_title_toggle_post_types', array( 'page' ) );

		// Add metabox for each post type found
		foreach ( $post_types as $post_type ) {
			add_meta_box( 'be-title-toggle', 'Title Toggle', array( $this, 'metabox_render' ), $post_type, 'normal', 'high' );
		}
	}

	/**
	 * Output the metabox
	 *
	 * @since 1.6.0
	 */
	function metabox_render() {

		// Grab this post type
		$post_type = get_post_type();

		// Grab default state - True means hidden, empty means displayed
		$default = genesis_get_option( 'be_title_toggle_' . $post_type );

		// Grab current value
		$hide = get_post_meta( get_the_ID(), 'be_title_toggle_hide', true );
		$hide = !empty( $hide ) ? true : false;
		$show = get_post_meta( get_the_ID(), 'be_title_toggle_show', true );
		$show = !empty( $show ) ? true : false;

		// Security nonce
		wp_nonce_field( 'be_title_toggle', 'be_title_toggle_nonce' );

		echo '<p style="padding-top:10px;">';

		if ( $default ) {

			// Hide by default
			printf( '<label for="be_title_toggle_show">%s</label>', __( 'Show Title', 'genesis-title-toggle' ) );

			echo '<input type="checkbox" id="be_title_toggle_show" name="be_title_toggle_show" ' . checked( true , $show, false ) . ' style="margin:0 20px 0 10px;">';

			printf( '<span style="color:#999;">%s</span>', __( 'By default, this post type is set to remove titles. This checkbox lets you show this specific page&rsquo;s title.', 'genesis-title-toggle' ) );

			echo '<input type="hidden" name="be_title_toggle_key" value="show">';

		} else {

		 	// Show by default
		 	printf( '<label for="be_title_toggle_hide">%s</label>', __( 'Hide Title', 'genesis-title-toggle' ) );

			echo '<input type="checkbox" id="be_title_toggle_hide" name="be_title_toggle_hide" ' . checked( true , $hide, false ) . ' style="margin:0 20px 0 10px;">';

		 	printf( '<span style="color:#999;">%s</span>', __( 'By default, this post type is set to display titles. This checkbox lets you hide this specific page&rsquo;s title.', 'genesis-title-toggle' ) );

		 	echo '<input type="hidden" name="be_title_toggle_key" value="hide">';
		}

		echo '</p>';

		// Site title as h1
		if( get_the_ID() == get_option( 'page_on_front' ) ) {

			$h1_site_title = get_post_meta( get_the_ID(), 'be_title_toggle_site_title_h1', true );
			$h1_site_title = !empty( $h1_site_title ) ? true : false;

			echo '<p style="padding-top:10px;">';
		 	printf( '<label for="be_title_toggle_site_title_h1">%s</label>', __( 'h1 Site Title', 'genesis-title-toggle' ) );
			echo '<input type="checkbox" id="be_title_toggle_site_title_h1" name="be_title_toggle_site_title_h1" ' . checked( true , $h1_site_title, false ) . ' style="margin:0 20px 0 10px;">';
		 	printf( '<span style="color:#999;">%s</span>', __( 'Make the site title in header an h1. This is HIGHLY recommended if you are removing the page title.', 'genesis-title-toggle' ) );
			echo '</p>';

		}
	}

	/**
	 * Handle metabox saves
	 *
	 * @since 1.6.0
	 */
	function metabox_save( $post_id, $post ) {

		// Security check
		if ( ! isset( $_POST['be_title_toggle_nonce'] ) || ! wp_verify_nonce( $_POST['be_title_toggle_nonce'], 'be_title_toggle' ) ) {
			return;
		}

		// Bail out if running an autosave, ajax, cron.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}
		if ( defined( 'DOING_CRON' ) && DOING_CRON ) {
			return;
		}

		// Bail out if the user doesn't have the correct permissions to update the slider.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Which key do we use
		$key = 'show' == esc_attr( $_POST['be_title_toggle_key'] ) ? 'be_title_toggle_show' : 'be_title_toggle_hide';

		// Either save or delete they post meta
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, '1' );
		} else {
			delete_post_meta( $post_id, $key );
		}

		// Site title option for front page
		if( $post_id == get_option( 'page_on_front' ) ) {
			if( isset( $_POST['be_title_toggle_site_title_h1'] ) ) {
				update_post_meta( $post_id, 'be_title_toggle_site_title_h1', '1' );
			} else {
				delete_post_meta( $post_id, 'be_title_toggle_site_title_h1' );
			}
		}
	}

	/**
	 * Logic that determines if we should show/hide the title.
	 *
	 * @since 1.0.0
	 */
	function title_toggle() {

		// Make sure we're on the single page
		if ( !is_singular() )
			return;

		global $post;
		$post_type = get_post_type( $post );

		// See if post type has pages turned off by default
		$default = genesis_get_option( 'be_title_toggle_' . $post_type );

		// If titles are turned off by default, let's check for an override before removing
		if ( !empty( $default ) ) {
			$override = get_post_meta( $post->ID, 'be_title_toggle_show', true );

			// If override is empty, get rid of that title
			if ( empty( $override ) ) {
				$this->remove_title();
			}

		// If titles are turned on by default, let's see if this specific one is turned off
		} else {
			$override = get_post_meta( $post->ID, 'be_title_toggle_hide', true );

			// If override has a value, the title's gotta go
			if ( !empty( $override ) ) {
				$this->remove_title();
			}
		}
	}

	/**
	 * Remove Title
	 *
	 * @since 1.8.0
	 */
	function remove_title() {

		// Theme specific code
		$this->theme_specific();

		// Remove post title
		remove_action( 'genesis_post_title', 'genesis_do_post_title' );
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

		// Remove header markup
		if( apply_filters( 'be_title_toggle_remove_markup', true ) ) {
			remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
			remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
		}

	}

	/**
	 * Theme Specific Code
	 *
	 * @since 1.8.0
	 */
	function theme_specific() {

		// Custom themes can use this to disable the title if they've moved it
		// @see https://github.com/billerickson/genesis-title-toggle/wiki#integrating-with-a-custom-theme
		do_action( 'be_title_toggle_remove' );

		if( ! defined( 'CHILD_THEME_NAME' ) )
			return false;

		switch( CHILD_THEME_NAME ) {

			case 'Academy Pro':
				remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_post_title' );
				break;

			case 'Business Pro':
				remove_action( 'genesis_after_header', 'business_page_header_title', 24 );
				break;

			case 'Business Pro Theme':
				remove_action( 'business_page_header', 'business_page_title', 10 );
				break;

			case 'Centric Theme':
				if( is_page() ) {
					add_action(
					'genesis_before',
						function() {
							remove_action( 'genesis_after_header', 'centric_open_post_title', 1 );
							remove_action( 'genesis_after_header', 'genesis_do_post_title', 2 );
							remove_action( 'genesis_after_header', 'centric_close_post_title', 3 );
						},
						20
					);
				}
				break;

			case 'Interior Pro Theme':
				remove_action( 'genesis_after_header', 'genesis_do_post_title' );
				break;

			case 'Showcase Pro':
				if( has_post_thumbnail() ) {
					add_action( 'genesis_after_header', function() {
						add_filter( 'the_title', '__return_false' );
					}, 7 );
					add_action( 'genesis_after_header', function() {
						remove_filter( 'the_title', '__return_false' );
					}, 9 );
				}
				break;

			case 'Studio Pro':
				remove_action( 'studio_page_header', 'studio_page_title', 10 );
				break;
		}
	}

	/**
	 * Make Site Title an h1 on homepage
	 *
	 * @since 1.7.0
	 * @link http://www.billerickson.net/genesis-h1-front-page/
	 * @param string $wrap, html element wrapping the site title
	 * @return string $wrap
	 */
	function site_title_h1( $wrap ) {

		if( is_front_page() && ! is_home() ) {
			$show_as_h1 = get_post_meta( get_the_ID(), 'be_title_toggle_site_title_h1', true );
			if( $show_as_h1 )
				$wrap = 'h1';
		}

		return $wrap;

	}
}

new BE_Title_Toggle;
