
<?php
// -----------------------------------------------------------------------
// DEFINE SEPERATOR ALIASES
// -----------------------------------------------------------------------
define("URL_SEPARATOR", '/');

define("DS", DIRECTORY_SEPARATOR);

// -----------------------------------------------------------------------
// DEFINE ROOT PATHS
// -----------------------------------------------------------------------
defined('SITE_ROOT')? null: define('SITE_ROOT', realpath(dirname(__FILE__)));
define("LIB_PATH_INC", SITE_ROOT.DS);


require_once(LIB_PATH_INC.'../Connection/config.php');
require_once(LIB_PATH_INC.'../DataAccessLayer/functions.php');
require_once(LIB_PATH_INC.'../DataAccessLayer/session.php');
require_once(LIB_PATH_INC.'../DataAccessLayer/upload.php');
require_once(LIB_PATH_INC.'../Connection/database.php');
require_once(LIB_PATH_INC.'../DataAccessLayer/sql.php');

?>
