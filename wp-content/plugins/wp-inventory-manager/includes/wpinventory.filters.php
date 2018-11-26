<?php

/**
 * This file contains "default" filters that are run as part of the core WP Inventory installation.
 */

/**
 * These filters ensure that inventory displays, even when no display is configured.
 * To override: add_filter( 'wpim_ignore_default_display', function() { return TRUE; } );
 */
if ( ! apply_filters( 'wpim_ignore_default_display', FALSE ) ) {
	add_filter( 'wpim_display_settings', 'wpinventory_default_display_settings', 10, 2 );
	add_filter( 'wpim_display_listing_settings', 'wpinventory_default_listing_display_settings', 20 );
	add_filter( 'wpim_display_detail_settings', 'wpinventory_default_detail_display_settings', 20 );
}


if ( ! apply_filters( 'wpim_ignore_default_display', FALSE ) ) {
	add_action( 'wpim_single_before_the_field', array( 'WPIMDefaultLayout', 'open_column' ), 10, 2 );
	add_action( 'wpim_the_field_close', array( 'WPIMDefaultLayout', 'close_column' ), 10, 2 );
}


class WPIMDefaultLayout {
	private static $column_opened = FALSE;

	/**
	 * Function to determine if "two column" display should be used.
	 * If so, "open" the column tag.
	 *
	 * @param string $field
	 * @param $display
	 */
	public static function open_column( $field, $display ) {
		if ( self::$column_opened ) {
			return;
		}

		if ( ! self::image_is_first( $display ) ) {
			return;
		}

		if ( ! self::is_image_field( $field ) ) {
			return;
		}

		self::$column_opened = TRUE;

		echo '<div class="wpinventory-column wpinventory-default-left-column">';
	}

	public static function close_column( $field, $display ) {
		if ( ! self::$column_opened ) {
			return;
		}

		$position = array_search( $field, $display );

		if ( ( $position - 1 ) >= count( $display ) ) {
			echo '</div>';
		} else if ( $position <= 1 ) {
			$second_field = ( ! empty( $display[1] ) ) ? $display[1] : NULL;

			if ( ( 1 === $position ) && self::is_image_field( $second_field ) ||
			     ( 0 === $position ) && ! self::is_image_field( $second_field ) ) {
				echo '</div>';
				echo '<div class="wpinventory-column wpinventory-default-right-column">';
			}
		}
	}

	private static function image_is_first( $display ) {
		$first_field = reset( $display );

		return self::is_image_field( $first_field );
	}

	private static function is_image_field( $field ) {
		return ( in_array( $field, array( 'inventory_image', 'inventory_images' ) ) );
	}
}