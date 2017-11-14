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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'id2094502_wp_9bd2601b024b73faba2cd68b34716e4a' );

/** MySQL database username */
define( 'DB_USER', 'id2094502_wp_9bd2601b024b73faba2cd68b34716e4a' );

/** MySQL database password */
define( 'DB_PASSWORD', '01c0699dadea8f4cc41cf8751c0d83c4b3eaf12c' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'S6Vj)ef&D|v@`<zO.!pPFC #-V7HmVj8qhH+=U6/iY7xt!)OHrnYAg-(QG+k~+<K');
define('SECURE_AUTH_KEY',  'f(-ap.=?VB|xp?vt1:Y^5&f<iGQpl]L.:1gVYrD#}+W<C`?uUpvJ5IDr/>q+F0|D');
define('LOGGED_IN_KEY',    '|5bB/GwSGJ|zqY~u,nh1J(;yL~&H=KmihTw$3k]VS8KFDKg/AEgPAo- 8#KM[xU7');
define('NONCE_KEY',        'RA  z#|]y.1>~{01p0%9Z7r{6-de|@H|]__Ux^>/!YLiVUS1QLHh7%&2P3KS)2=V');
define('AUTH_SALT',        'RfN6_Dn-JSj$Z?$Wk{3-ye=!P276?;!-,Us(_>n=o@fg-<#<Hh5P.ILuu Lkt*-F');
define('SECURE_AUTH_SALT', '<J0D<2h)G4F^]~`zNO@Ma;Mzi~(X2b*Y{85KotUGffuKGjL<0!H^_|VOR=Tg-#bw');
define('LOGGED_IN_SALT',   '[gdl),R=Oc@_2$yY2fd@@k7M!dBr5TC)CCIhw$wVS6d46VQ]O20+g^:;3vG&|B#S');
define('NONCE_SALT',       '6&hL`P4t~jT`WV-C>ta:hpsdtr&+sxtf@8nO_|v^[S90g_D>ERP-Mr{3ee 7hEGC');


/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
