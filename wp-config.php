<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'fichcard' );

/** MySQL database username */
define( 'DB_USER', 'fichcard' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Fichcard_2122!' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Y#c#XQ:km@XMj(F`%GpizkV()ICKcJD7i=Bc+3+0(RL#+PA>[.RS(*3Ais(Iid7-' );
define( 'SECURE_AUTH_KEY',  '{X:Nkym@{R<XZc4;t!h]4gNp0)mKReR|[:sRfvloVkle1I#wRYpDA>y;0}RNu7>i' );
define( 'LOGGED_IN_KEY',    ';}C?+v1-KnXi.VB(`<Aa]yjUOnr){Z3lzlh,SX&P;2?v|nmH%Qy.=Noaf)Tp&KfA' );
define( 'NONCE_KEY',        'S[)!WBy3NA.xPv&E.b4m2p H/msvW^ #4a{yF;m@L&|ROZD$[nyC%ONQk9&yk$B8' );
define( 'AUTH_SALT',        '@SSI!$Q&BiDzvG?OOpLsr.pLWm2qjo*j7@NB]<w-jiZeXjwo/8D]Bpr51s;ySEiu' );
define( 'SECURE_AUTH_SALT', '+}}k]A]T1?k[(^p&E~LMLABL)vdf5v%FEZB|::Q&SptbI$V:<&`8![z|iS$ .<?s' );
define( 'LOGGED_IN_SALT',   '6/|# [sDE[!LlEz9Wy: .; g=NGaF:ef1>2Y/&&ot^2w-*y*<rTA|**MBMN$@ZrL' );
define( 'NONCE_SALT',       'IVqTB{+!!>(dY:kwYT*QDN@2~#VxxSkLF<+S)LujI2`3e`1H,vTK*Pg+T[yG$W<p' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'fichc_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';


@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);