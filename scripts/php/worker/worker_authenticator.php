<?php
include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/core-apis/DatabaseActions.class.inc.php';
include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/SystemUsers.class.php';

define ( 'INTENT_AUTH_USER', 'intent_authenticate_user' );

if (isset ( $_POST [POST_ACTION] )) {
	if (isset ( $_POST [POST_CLIENT] )) {
		if (isset ( $_POST [CLIENT_INTENT] )) {
			
			$action = $_POST [POST_ACTION];
			$client = $_POST [POST_CLIENT];
			$intent = $_POST [CLIENT_INTENT];
			
			processHTTPRequest ( $action, $client, $intent );
		} else {
			echo "Unknown client intent";
		}
	} else {
		echo "Unknown post client";
	}
} else {
	echo "Unknown post action";
}
function processHTTPRequest($action, $client, $intent) {
	if ($intent == INTENT_AUTH_USER) {
		authenticateSystemUser ( $action, $client );
	}
}
function authenticateSystemUser($action, $client) {
	$columns = array (
			'email',
			'password' 
	);
	$records = array (
			$_POST ['username'],
			$_POST ['password'] 
	);
	
	$authenticate = (new SystemUsers ( $action, $client ))->is_exists ( $columns, $records );
	
	if (! $authenticate) {
		$columns = array (
				'username',
				'password' 
		);
		
		$authenticate = (new SystemUsers ( $action, $client ))->is_exists ( $columns, $records );
	}
	
	if ($authenticate) {
		echo json_encode ( array (
				"authenticated" => true,
				"user_id" => get_user_id ( $action, $client, $columns, $records ) 
		) );
	} else {
		echo json_encode ( array (
				"authenticated" => false 
		) );
	}
}
function get_user_id($action, $client, $columns, $records) {
	$system_users = (new SystemUsers ( $action, $client, $action, $client ))->query_from_system_users ( $columns, $records );
	return $system_users [0] ['id_system_user'];
}
?>