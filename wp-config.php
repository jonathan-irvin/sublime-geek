<?php
/** 
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information by
 * visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'geekfox_sg');

/** MySQL database username */
define('DB_USER', 'geekfox');

/** MySQL database password */
define('DB_PASSWORD', 'jurby5000');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',        '4ME&ENsZp$B$?AD-r,YOH7({tsoAOn}b4$`m>PBHTU9r28Bw-^i+Q4#O]zQ/+/N3');
define('SECURE_AUTH_KEY', 'QVRw7 COkoo[r!^VZ=hEap}L|UZ:R(+  ,D?~:_`K}x:O?]EuZ9i/UxhE_~H#Z[r');
define('LOGGED_IN_KEY',   '&=!I_,B@`if?KBr_E2=@Cvy8sCNYXsQN6f=ci_1ZO6S=ggvxBGcUSf +,Jk0%!/`');
define('NONCE_KEY',       'mJqD+z-m$V{Ywa+gMdbf6(7Zb=@DPwfQHV^D$WXu=Rpii6-o#{u=CjnA+~ex1Iq8');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'sg_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', '');

/* That's all, stop editing! Happy blogging. */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
