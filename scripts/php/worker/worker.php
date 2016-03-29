<?php

//Data Actions script file - It contains all the various data actions that can be performed on data.
require_once 'C:\xampp\htdocs\titledeeds\scripts\php\database\core-apis\DatabaseActions.class.inc.php';

define('INTENT_INJECT_PAGE_NAVIGATION','intent_inject_page_navigation');
define('ACTION_TYPE','action');


if(isset($_POST[ACTION_TYPE])){

	if($_POST[ACTION_TYPE] == ACTION_TYPE){
		handleActionType();
	}
}

function handleActionType(){
	$intent = $_POST[CLIENT_INTENT];
	
	if($intent == INTENT_INJECT_PAGE_NAVIGATION){
		if(!class_exists('Utils')){
			include '../utils/Utils.inc.class.php';
		}
		echo Utils::readFile($_SERVER['DOCUMENT_ROOT']."/titledeeds/navigation.html");
	}
}
?>