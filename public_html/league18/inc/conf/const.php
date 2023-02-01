<?php
define('DOMAIN', $_SERVER['SERVER_NAME']);
define('DOMAIN_HTTP', 'http://'.$_SERVER['SERVER_NAME']);
define('DOMAIN_SRC', '//src.'.$_SERVER['SERVER_NAME']);
define('DOMAIN_FORUM', '//forum.'.$_SERVER['SERVER_NAME']);
define('DOMAIN_COOKIE', $_SERVER['SERVER_NAME']);
define('DOMAIN_COOKIE_PRIVATE', '');
define('DOMAIN_COOKIE_PATH', '/');
define('PAGE_TITLE', 'League-18 - Браузерная онлайн игра про Покемонов.');
define('PAGE_TITLE_WORLD', 'League-18 -> Игровой мир');
define('PAGE_DESCRIPTION', 'League-18 - Браузерная онлайн игра про Покемонов.');
define('PAGE_KEY', 'League-18, акваворлд, лига18 покелегенда,pokelegenda,существа,покемоны,поки,зверюшки,необычные,пикачу,онлайн,игра,онлайн покемоны,игра покемоны,pokemon,game pokemon,игра про покемонов,russian pokemon');

//Project
define('PROJECT', 'League-18');
define('PROJECT_NAME', 'League-18');
define('PROJECT_ENCODE', 'UTF-8');
define('PROJECT_SALT', 'w4#3*25%3*PL^REBORN*254&s9');

// MySQl:
define('MYSQL_DB', 'league18db');
define('MYSQL_HOST', 'localhost');
define('MYSQL_LOGIN', 'league18db_user');
define('MYSQL_PASSWORD', 'DrFtGyH11');
define('MYSQL_ENCODE', 'utf8');

// Other
define('LIB_DIR', dirname(dirname(__FILE__)));
define('BASE_DIR', $patch_project);
define('PATH_PROJECT', $patch_project);
define('PATH_SRC', '');
define('SHOW_FILE', true);

// Settings:
define('PROJECT_AUTOLOAD', true);
define('PROJECT_MB_STRING', true);
// сообщения с ошибками будут показываться
ini_set('display_errors', 'ON');
error_reporting(E_ALL);
/*define('', '');*/