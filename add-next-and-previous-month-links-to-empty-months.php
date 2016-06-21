<?php
/**
 * Plugin Name: The Events Calendar — Add Next and Previous Month Links to Empty Months
 * Description: Ensures that you can paginate between months regardless of whether or not adjacent months have events in them.
 * Version: 1.0.0
 * Author: Modern Tribe, Inc.
 * Author URI: http://m.tri.be/1x
 * License: GPLv2 or later
 */
 
defined( 'WPINC' ) or die;

if ( class_exists( 'Tribe__Events__Main' ) ) {

	/**
	 * Ensure the "Next Month" link always exists and shows.
	 *
	 * @return string
	 */
	function tribe_always_show_next_month_link( $link ) {

		$date = Tribe__Events__Main::instance()->nextMonth( tribe_get_month_view_date() );

		if ( empty( $date ) ) {
			return $link;
		}

		$url  = tribe_get_next_month_link();
		$text = tribe_get_next_month_text();

		return sprintf( '<a data-month="%s" href="%s" rel="next">%s <span>&raquo;</span></a>', $date, $url, $text );
	}

	add_filter( 'tribe_events_the_next_month_link', 'tribe_always_show_next_month_link' );

	/**
	 * Ensure the "Previous Month" link always exists and shows.
	 *
	 * @return string
	 */
	function tribe_always_show_prev_month_link( $link ) {

		$date = Tribe__Events__Main::instance()->previousMonth( tribe_get_month_view_date() );

		if ( empty( $date ) ) {
			return $link;
		}

		$url  = tribe_get_previous_month_link();
		$text = tribe_get_previous_month_text();

		return sprintf( '<a data-month="%s" href="%s" rel="prev"><span>&laquo;</span> %s</a>', $date, $url, $text );
	}

	add_filter( 'tribe_events_the_previous_month_link', 'tribe_always_show_prev_month_link' );
}
