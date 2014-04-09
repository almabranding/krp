<?php

// Always provide a TRAILING SLASH (/) AFTER A PATH
define('LIBS', 'libs/');
define('TEMPDIR', '/');
define('URL', 'http://' . $_SERVER['HTTP_HOST'] . TEMPDIR);
define('ROOT', $_SERVER['DOCUMENT_ROOT'] . TEMPDIR);
define('CACHE', ROOT . 'cache/');
define('UPLOAD', URL . 'uploads/');
 
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'krp'); 
define('DB_USER', '');
define('DB_PASS', '');
define('DB_PREFIX', ''); 

// The sitewide hashkey, do not change this because its used for passwords!
// This is for other hash keys... Not sure yet
define('HASH_GENERAL_KEY', 'MixitUp200');

// This is for database passwords only
define('HASH_PASSWORD_KEY', 'catsFLYhigh2000miles');
define('NUMPP', 35);
if(!strstr($_SERVER['HTTP_HOST'],'temp.') && $_SERVER['REQUEST_URI']=='/')  header('location: '.URL.'temp');
