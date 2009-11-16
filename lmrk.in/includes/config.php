<?php
/*
 ** MySQL settings - You can get this info from your web host
 */

/** MySQL database username */
define('YOURLS_DB_USER', 'geekfox');

/** MySQL database password */
define('YOURLS_DB_PASS', 'jurby5000');

/** The name of the database for YOURLS */
define('YOURLS_DB_NAME', 'geekfox_ms');

/** MySQL hostname */
define('YOURLS_DB_HOST', 'localhost');

/** MySQL URL table name. Don't change this if in doubt. */
define('YOURLS_DB_TABLE_URL', 'livemark_url');

/** MySQL Next ID table name. Don't change this if in doubt. */
define('YOURLS_DB_TABLE_NEXTDEC', 'livemark_next_id');

/*
 ** Site options
 */

/** Turn this on to enable error reporting. Recommended value is false **/
define('YOURLS_DEBUG', false);
 
/** Short domain URL, no trailing slash */
define('YOURLS_SITE', 'http://lmrk.in'); //

/** Timezone GMT offset */
define('YOURLS_HOURS_OFFSET', -6); 

/** Private means protected with login/pass as defined below. Set to false for public usage. */
define('YOURLS_PRIVATE', true);

/** A random secret hash used to encrypt cookies. You don't have to remember it, make it long and complicated. Hint: copy from http://yourls.org/cookiekey.php **/
define('YOURLS_COOKIEKEY', 'Jaa7UM$Mp~%wDmBC3k%Y@1t5m[xOr]@ah}]vC85v');

/**  Username(s) and password(s) allowed to access the site */
$yourls_user_passwords = array(	'admin' => 'Jurb1f!ed'
// You can have one or more 'login'=>'password' lines
	);

/*
 ** URL Shortening settings
 */

/** URL shortening method: 36 or 62 */
define('YOURLS_URL_CONVERT', 62);
/*
 * 36: generates case insentitive lowercase keywords (ie: 13jkm)
 * 62: generate case sensitive keywords (ie: 13jKm or 13JKm)
 * Stick to one setting, don't change after you've created links as it will change all your short URLs!
 * Base 36 should be picked. Use 62 only if you understand what it implies.
 * Using base 62 means you *need* PHP extension BCMath
 */

/** 
* Reserved keywords (so that generated URLs won't match them)
* Define here negative, unwanted or potentially misleading keywords.
*/
$yourls_reserved_URL = array(
	'porn', 'faggot', 'sex', 'nigger', 'fuck', 'cunt', 'dick', 'gay',
);


/******************** DO NOT EDIT ANYTHING ELSE ********************/

// Include everything except auth functions
require_once (dirname(__FILE__).'/version.php');
require_once (dirname(__FILE__).'/functions.php');
require_once (dirname(__FILE__).'/functions-baseconvert.php');
require_once (dirname(__FILE__).'/class-mysql.php');
