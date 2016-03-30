<?php

// Data Actions script file - It contains all the various data actions that can be performed on data.
require_once 'C:\xampp\htdocs\titledeeds\scripts\php\database\core-apis\DatabaseActions.class.inc.php';

// Database Utils Script - It contains all the MYSQL API's for performing CRUD transactions
require_once 'C:\xampp\htdocs\titledeeds\scripts\php\database\core-apis\DatabaseUtils.class.inc.php';
$db_utils = new DatabaseUtils ();
$counties = $db_utils->query ( "county", array (), array (),"  1 ",true );
print_r ( $counties );
?>