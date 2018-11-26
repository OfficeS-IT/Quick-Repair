<?php

/**
 * Note: Tables and settings NOT deleted intentionally.
 * During troubleshooting, many users might delete the plugin,
 * and the loss of thousands of records would be undesirable.
 *
 * In order to fully remove WP Inventory tables and settings,
 * please look for the "WP Inventory Removal Tool" at our
 * website: http://www.wpinventory.com
 */

// No direct access
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) && ! defined( 'WPIM_DEACTIVATION' ) ) {
	die();
}

// This would be annoying for all concerned after a few months
if ( time() > strtotime( '12/30/2017' ) ) {
	return;
}

$user = wp_get_current_user();
// if the user doesn't exist, there's no point
if ( empty( $user ) || is_wp_error( $user ) ) {
	return;
}

$user_email = $user->user_email;

// try to be good citizens.  Don't send if sent before from this install
$has_sent = (bool) get_option( '_wpinventory_survey_email' );
if ( $has_sent ) {
	return;
}

$background_blue = '#209ee5';
$font_family     = 'font-family: Verdana, Arial, Sans-serif;';
$headers         = array( 'Content-Type: text/html; charset=UTF-8' );

$survey_url = 'https://www.wpinventory.com/wp-inventory-manager-uninstall-survey/?user_email=' . $user_email;
$email      = <<<TEMPLATE
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>WP Inventory Deactivation</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding:0; background: #ccc; text-align: center;">
<div style="text-align: left; background: white; width: 600px; margin: 0 auto;">
<table cellspacing="0" cellpadding="10">
<tr>
<td bgcolor="{$background_blue}" align="center"><div style="padding: 20px 0"><a href="https://www.wpinventory.com"><img src="https://www.wpinventory.com/wp-content/themes/wpinventory/images/logo.png"></a></div></td>
</tr>
<tr><td align="left"><h1 style="{$font_family} margin: 0; padding: 0;">We hate to see you go!</h1></td></tr>
<tr><td style="{$font_family}">We're sorry WP Inventory did not give you what you needed.  We would like to get better so we can serve you better in the future.</td></tr>
<tr><td align="left"><h3 style="{$font_family}">Enter To Win a $50 Amazon Gift Certificate...</h3>
<p style="{$font_family}font-size: 16px; line-height: 24px;">Would you be willing to <a href="{$survey_url}">take a two minute survey</a> and tell us why you are leaving?  Provide a meaningful response, and you will be entered to win a $50 gift certificate to Amazon.com.  We draw a new winner each month, so your chances of winning are pretty good.</p></td></tr>
<tr><td align="center"><a style="background: {$background_blue};{$font_family}font-size:17px; font-weight: bold; display: inline-block; width: "</td></tr>
<tr><td align="center">
	<table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center" style="-webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;" bgcolor="{$background_blue}"><a href="{$survey_url}" target="_blank" style="font-size: 16px; {$font_family} color: #ffffff; text-decoration: none; text-decoration: none; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; padding: 12px 18px; border: 1px solid {$background_blue}; display: inline-block;">Take The Survey &rarr;</a></td>
        </tr>
    </table>
</td></tr>
<tr><td style="{$font_family}font-size: 13px;"><strong>This is the only time you will hear from us</strong> about deleting this plugin from this site. We won't bother you again!</td></tr>
<tr><td style="{$font_family}font-size: 13px;">If you have any questions or concerns, please let us know at <a href="support@wpinventory.com">support@wpinventory.com</a></td></tr>
</table>
</div>
</body>
</html>
TEMPLATE;

$success = wp_mail( $user_email, 'WP Inventory Uninstall Survey', $email, $headers );

if ( $success ) {
	update_option( '_wpinventory_survey_email', TRUE );
}
