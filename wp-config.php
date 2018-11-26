<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', '6079920db3');

/** MySQL database username */
define('DB_USER', 'sql1952095');

/** MySQL database password */
define('DB_PASSWORD', '7sr+z9i');

/** MySQL hostname */
define('DB_HOST', 'mysqlsvr38.world4you.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ',LBUALwL!,}x7_H{^qCXi~*VVQbSn^cxB36gtGV|pV+F*s}3[k3%dz=Cp&Y`N=k6');
define('SECURE_AUTH_KEY',  ']Ay2,_PKm=yZ|xzi`gR0*=4x~]qd=e{TXK!wI+Tn9PzhU1lyh8$)&R52p>NV]7=W');
define('LOGGED_IN_KEY',    '~CaoP@Rt}7y}B[*EbX*<|Qq@zK}MM1cCmA;Oa:oriA:-{HrgRV@W/Ce[~ksoz4mW');
define('NONCE_KEY',        'uCb_eYICB17Mucv:KTIdfL%M$fy;aa=A=$5R{o66Ju!4a2P~JqQ9ct<0y|[DD IC');
define('AUTH_SALT',        'KBe;o?kjf*;xRb.SPY,7;./C$8/1n%=B:?7hJGTX[s~I4X84A;yNGT,a5Qj3uZHh');
define('SECURE_AUTH_SALT', '5Hr~wOMN0R#{LY?*AW&7R}S6C$M]9Uz+tw$JFM1*{k(l0Xmx6{5x&u&NWB;mK4|u');
define('LOGGED_IN_SALT',   ']YO,*Cd*9^ hhFLiee4Bs`b<6:5}`,?@Y?.j!*/wD%5UIZGyAl2W?N#KIcz8][#3');
define('NONCE_SALT',       'MQVBmf f=;t>u_j>6Qo@td8bwgahSqL/{&<x< Ge3eO$$4?5ETKOFk&-NM^3uc k');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
