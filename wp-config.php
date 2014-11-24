<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
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
define('DB_NAME', 'xooma');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'zBt|XroY%n1[jV#RIDWoKA//Gt+JG$4Jrm@zfGq-u2WNwd`-_ao;o:+b(!cr$Qa.');
define('SECURE_AUTH_KEY',  'A;^#o9f|Q&;vPKR6w(7x|AY#&S:}gx#9`{]MCcEOsetl|O5P:}z4I[]&_U:-Pc[k');
define('LOGGED_IN_KEY',    '/VkLX|rDAuu^r21].iL-{<h5,KT+=+g<~}46|r:0]0fyJa*Z=-ZK_o;2 8q zOtd');
define('NONCE_KEY',        'ai44$?aENwtv}E|!0R`;LAG#&PiNC-yv>6Sgq|IVBbYO*<^%^91|{PVM284%3ASH');
define('AUTH_SALT',        '+[Z(J(Vt!`7zdCnsa6VS| IZV`DAgtxgaj-[9Z4i9j_!g_1fSL$+V&<P.o(dp(iZ');
define('SECURE_AUTH_SALT', 'c`;l*!gcO*Sv=zuv&-p{`V3f#]v0F7+[/ZBuZ.VUVoOe9%b7NQKLFl0u]n(;-J1a');
define('LOGGED_IN_SALT',   '.eQ`@Nt%bNf-eX.ZD9+t`PCW.e1v&<}:KI|qP:2}%6f;-U~{1l`/fmc1I(:UK~*Z');
define('NONCE_SALT',       ',Pzz|Rq94.Cg7gPSp:S/g-r_uE#aR]xmrd%kTvpwJ)xE/U^H4%+k&FS+c>:EzCc5');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);
define('ENV', 'production');
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
