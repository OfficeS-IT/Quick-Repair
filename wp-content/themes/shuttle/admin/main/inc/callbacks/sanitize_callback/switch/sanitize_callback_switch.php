<?php
/**
 * Custom sanitisation callback - Switch.
 *
 * @package ShuttleThemes
 */

function shuttle_customizer_callback_sanitize_switch( $value ) {
	
	// Switch values must be equal to 1 of off. Off is indicator and should not be translated.
	return ( ( isset( $value ) && $value == 1 ) ? 1 : 'off' );

}