<?php

// Database configurations
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_DATABASE', 'ekd');

//Session cookie path
define('SESSION_COOKIE_PATH', '/ekdadmin');

// reCAPTCHA configurations
// https://www.google.com/recaptcha/admin
define('RECAPTCHA_CLIENT_KEY', '');
define('RECAPTCHA_SERVER_KEY', '');

// Fields pattern check
define('PATTERN_DENYXSS', '/[^-a-zA-Z0-9_]/');
define('PATTERN_PASSWORD', '/^[a-zA-Z0-9!@#$%^&*()]{8,20}$/'); // alphanumeric values with symbols between 8 to 20 characers
define('PATTERN_NAME', '/^[a-zA-Z\s]{2,35}$/'); // alphabets with spaces between 2 to 35 characters
define('PATTERN_MOBILENUMBER', '/^[0-9]{8}$/'); // numeric values, strictly 8 digits
define('PATTERN_DOB', '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/');
define('PATTERN_ADDRESS', '/^[a-zA-Z0-9\s#]{2,100}$/'); // alphanumeric values with spaces between 2 to 100 characters
define('PATTERN_CCNUMBER', '/^[0-9]{16}$/'); // strictly 16 digits
define('PATTERN_CCV', '/^[0-9]{3}$/'); // numeric values, strictly 3 digits
define('PATTERN_ADDORDERITEM_CBO_MAXVALUE', '/^[0-9]{1}$/'); // strict 1 digit value from combobox inputs
define('PATTERN_FEEDBACKMESSAGE', '/^[a-zA-Z]{10,}$/'); // at least 10 alphabets