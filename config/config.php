<?php
// db options
define('DB_NAME', 'db_url');
define('DB_USER', 'root');
define('DB_PASSWORD', 's0p0rtex1');
define('DB_HOST', 'localhost');
define('DB_TABLE', 'short_urls');

// base location of script (include trailing slash)
define('BASE_HREF', 'http://' . $_SERVER['HTTP_HOST'] . '/url/');

// change to TRUE to start tracking referrals
define('TRACK', TRUE);

// check if URL exists first
define('CHECK_URL', TRUE);

// change the shortened URL allowed characters
define('ALLOWED_CHARS', '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');

// do you want to cache?
define('CACHE', FALSE);

// if so, where will the cache files be stored? (include trailing slash)
define('CACHE_DIR', dirname(__FILE__) . '/cache/');

