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
define('DB_NAME', 'continentalpools_dev');

/** MySQL database username */
define('DB_USER', 'continentalpools_devu');

/** MySQL database password */
define('DB_PASSWORD', 'Qi6MeNc*WJbL');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'h8U*YXd|4kHpA|fc+uqxQU%#c<EQJ{G4*xOxmv`]_?Wff`Vq*qN+LF7vz3C!#+7O');
define('SECURE_AUTH_KEY',  '-76%U2ORBjf%!A}z8jSDCUS5%qi}#{+vul]HZT%x$y;EbMx)LFtk-<[HCX/-#8Mp');
define('LOGGED_IN_KEY',    '3-soNVmiGB1)]BFtYveSWyg>|bh8Zvq<CKmys@~sP6 KCR=3aL9!:Dc{v7uMJ@X[');
define('NONCE_KEY',        ':;N4w/vMYXOQ$I)3I+kvb@9U6~BWAq:&Plu*JJ(M,^:(JNn9rD(C;3zIh2]LKQiE');
define('AUTH_SALT',        '44d/W3 ?Pm3^z<CroX^Kk[0dn]u!n~_%NA,z&Q5cTglWQUNfQ3yk4V[VeUT9qPCf');
define('SECURE_AUTH_SALT', 'SF)#vnQ=)?5szx9leZdm;v|+xFOSGKtsAWsP%i!4*anDsPo>`l@[=MaUJKYsQ.8}');
define('LOGGED_IN_SALT',   '8I;@!@^+1BZ1{Jk`L {.aC$@lbt1AE!kl7;6,h6jSP|X2%Gw `[HIoY<*cP+={8?');
define('NONCE_SALT',       '/gs}=#G@i*x)BH>wDsMEOm}`GsKf&W^WVwx4v~gk&6`f_>D}R2R_pNJpvVh=?Uq;');

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
define( 'AUTOMATIC_UPDATER_DISABLED', true );

define( 'WP_MEMORY_LIMIT', '64M' );
define( 'WP_MAX_MEMORY_LIMIT', '256M' );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
