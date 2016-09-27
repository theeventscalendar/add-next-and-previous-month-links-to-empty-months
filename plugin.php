<?php
/**
 * Plugin Name: The Events Calendar Extension: Add Next and Previous Month Links to Empty Months
 * Description: Ensures that you can paginate between months regardless of whether or not adjacent months have events in them.
 * Version: 1.0.0
 * Author: Modern Tribe, Inc.
 * Author URI: http://m.tri.be/1971
 * License: GPLv2 or later
 */

defined( 'WPINC' ) or die;

class Tribe__Extension__Add_Nav_Links_Atop_Empty_Months {

	/**
	 * The semantic version number of this extension; should always match the plugin header.
	 */
	const VERSION = '1.0.0';

	/**
	 * Each plugin required by this extension
	 *
	 * @var array Plugins are listed in 'main class' => 'minimum version #' format
	 */
	public $plugins_required = array(
		'Tribe__Events__Main' => '4.2'
	);

	/**
	 * The constructor; delays initializing the extension until all other plugins are loaded.
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init' ), 100 );
	}

	/**
	 * Extension hooks and initialization; exits if the extension is not authorized by Tribe Common to run.
	 */
	public function init() {

		// Exit early if our framework is saying this extension should not run.
		if ( ! function_exists( 'tribe_register_plugin' ) || ! tribe_register_plugin( __FILE__, __CLASS__, self::VERSION, $this->plugins_required ) ) {
			return;
		}

		add_filter( 'tribe_events_the_next_month_link', array( $this, 'tribe_always_show_next_month_link' ) );
		add_filter( 'tribe_events_the_previous_month_link', array( $this, 'tribe_always_show_prev_month_link' ) );
	}

	/**
	 * Ensure the "Next Month" link always exists and shows.
	 *
	 * @return string
	 */
	public function tribe_always_show_next_month_link( $link ) {

		$date = Tribe__Events__Main::instance()->nextMonth( tribe_get_month_view_date() );

		if ( empty( $date ) ) {
			return $link;
		}

		$url  = tribe_get_next_month_link();
		$text = tribe_get_next_month_text();

		return sprintf( '<a data-month="%s" href="%s" rel="next">%s <span>&raquo;</span></a>', $date, $url, $text );
	}

	/**
	 * Ensure the "Previous Month" link always exists and shows.
	 *
	 * @return string
	 */
	public function tribe_always_show_prev_month_link( $link ) {

		$date = Tribe__Events__Main::instance()->previousMonth( tribe_get_month_view_date() );

		if ( empty( $date ) ) {
			return $link;
		}

		$url  = tribe_get_previous_month_link();
		$text = tribe_get_previous_month_text();

		return sprintf( '<a data-month="%s" href="%s" rel="prev"><span>&laquo;</span> %s</a>', $date, $url, $text );
	}
}

new Tribe__Extension__Add_Nav_Links_Atop_Empty_Months();
