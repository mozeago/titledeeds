<?php
include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/core-apis/DatabaseActions.class.inc.php';
include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/SystemUsers.class.php';

define ( 'RESULT_FORMAT', 'result_format' );
define ( 'RESULT_FORMAT_DROPDOWN', 'dropdown_format' );
define ( 'RESULT_FORMAT_TABLE_ROWS', 'table_rows_format' );
define ( 'RESULT_FORMAT_ORDERED_LIST', 'ordered_list_format' );
define ( 'RESULT_FORMAT_UNORDERED_LIST', 'unordered_list_format' );

define ( 'INTENT_UPDATE_SYSTEM_USERS', 'update_systemUsers' );
define ( 'INTENT_INSERT_SYSTEM_USER', 'insert_systemUser' );
define ( 'INTENT_QUERY_SYSTEM_USERS', 'query_system_users' );
define ( 'INTENT_QUERY_DELETED_SYSTEM_USERS', 'query_deleted_system_users' );
define ( 'INTENT_STAGE_SELECTED_SYSTEM_USER_FOR_EDITING', 'stage_selected_systemUser_for_editing' );
define ( 'INTENT_TRASH_SYSTEM_USER', 'trash_systemUser' );
define ( 'INTENT_ERASE_SYSTEM_USER', 'erase_systemUser' );
define ( 'INTENT_RESTORE_SYSTEM_USER', 'restore_systemUser' );

define ( 'EXTRA_SYSTEM_USER', 'extra_system_user' );
define ( 'SEARCH_KEY', 'search_key' );

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
	if ($intent == INTENT_INSERT_SYSTEM_USER) {
		insertSystemUsers ( $action, $client );
	}
	if ($intent == INTENT_QUERY_SYSTEM_USERS) {
		querySystemUsers ( $action, $client );
	}
	if ($intent == INTENT_QUERY_DELETED_SYSTEM_USERS) {
		queryDeletedSystemUsers ( $action, $client );
	}
	if ($intent == INTENT_UPDATE_SYSTEM_USERS) {
		updateSystemUsersNames ( $action, $client );
	}
	if ($intent == INTENT_STAGE_SELECTED_SYSTEM_USER_FOR_EDITING) {
		stageSelectedSystemUsers ( $action, $client );
	}
	if ($intent == INTENT_TRASH_SYSTEM_USER) {
		trashSystemUsers ( $action, $client );
	}
	if ($intent == INTENT_ERASE_SYSTEM_USER) {
		eraseSystemUsers ( $action, $client );
	}
	if ($intent == INTENT_RESTORE_SYSTEM_USER) {
		restoreSystemUsers ( $action, $client );
	}
}
function insertSystemUsers($action, $client) {
	$firstname = $_POST ['firstname'];
	$lastname = $_POST ['lastname'];
	$email = $_POST ['email'];
	$phonenumber = $_POST ['phonenumber'];
	$username = $_POST ['username'];
	$password = $_POST ['password'];
	$account_status = 1;
	return (new SystemUsers ( $action, $client ))->insert_prepared_records ( $firstname, $lastname, $email, $phonenumber, $username, $password, $account_status );
}
function querySystemUsers($action, $client) {
	$system_users = new SystemUsers ( $action, $client );
	$search_key = $_POST ['search_key'];
	$result_format = $_POST [RESULT_FORMAT];
	
	$system_users_info = null;
	
	if ($search_key == "") {
		$system_users_info = $system_users->query_from_system_users ( array (
				"account_status" 
		), array (
				1 
		) );
	} else {
		$columns = array (
				"firstname",
				"lastname",
				"email",
				"phonenumber",
				"username" 
		);
		$records = array (
				$search_key,
				$search_key,
				$search_key,
				$search_key,
				$search_key 
		);
		
		$extraSQL = " AND `account_status`='1';";
		
		$system_users_info = $system_users->search_in_system_users ( $columns, $records, $extraSQL );
	}
	
	$system_usersHTML = "";
	$count = 1;
	$iterated = false;
	if ($result_format == RESULT_FORMAT_TABLE_ROWS) {
		if (count ( $system_users_info ) > 0) {
			foreach ( $system_users_info as $system_usersinfo ) {
				if ($system_usersinfo ["account_status"] == 2 || $system_usersinfo ["account_status"] == 0) {
					continue;
				}
				if ($search_key == "") {
					$system_usersHTML .= "<tr><td>" . $count . "</td>
							<td>" . $system_usersinfo ['firstname'] . "</td><td>" . $system_usersinfo ['lastname'] . "</td><td>" . $system_usersinfo ['phonenumber'] . "</td>
					<td>
						<button class=\"btn btn-outline btn-info btn-sm  \" onclick=editSystemUsers(" . $system_usersinfo ['id_system_user'] . ")>Edit</button>
					</td>
					<td>
						<button class=\"btn btn-outline btn-warning btn-sm  \" onclick=deleteSystemUsers(" . $system_usersinfo ['id_system_user'] . ")>Delete</button>
					</td>
					</tr>";
				} else {
					$system_usersHTML .= "<tr><td>" . $count . "</td><td>" . highligh_search_text ( $search_key, $system_usersinfo ['firstname'] ) . "</td><td>" . highligh_search_text ( $search_key, $system_usersinfo ['lastname'] ) . "</td><td>" . highligh_search_text ( $search_key, $system_usersinfo ['phonenumber'] ) . "</td>
					<td>
						<button class=\"btn btn-outline btn-info btn-sm  \" onclick=editSystemUsers(" . $system_usersinfo ['id_system_user'] . ")>Edit</button>
					</td>
					<td>
						<button class=\"btn btn-outline btn-warning btn-sm  \" onclick=deleteSystemUsers(" . $system_usersinfo ['id_system_user'] . ")>Delete</button>
					</td>
					</tr>";
				}
				$count ++;
				$iterated = true;
			}
		} else {
			if ($search_key == "") {
				$system_usersHTML .= '<tr><td></td><td colspan="99"><label>There are no system users found</label></td></tr>';
			} else {
				$system_usersHTML .= '<tr><td></td><td colspan="99">Oops! No System user named as <label style="color:red;">' . $search_key . '</label></td></tr>';
			}
		}
		
		// Nothing found or did not iterate --
		if ($count == 1 && $iterated) {
			$system_usersHTML .= '<tr><td colspan="99">Oops! No System user named as <label style="color:red;">' . $search_key . '</label></td></tr>';
		}
	}
	
	echo $system_usersHTML;
}
function queryDeletedSystemUsers($action, $client) {
	$system_users = new SystemUsers ( $action, $client );
	$search_key = $_POST ['search_key'];
	
	$system_users_info = null;
	
	if ($search_key == "") {
		$system_users_info = $system_users->query_from_system_users ( array (
				"account_status" 
		), array (
				2 
		) );
	} else {
		$columns = array (
				"firstname",
				"lastname",
				"email",
				"phonenumber",
				"username" 
		);
		$records = array (
				$search_key,
				$search_key,
				$search_key,
				$search_key,
				$search_key 
		);
		
		$extraSQL = " AND `account_status`='2';";
		
		$system_users_info = $system_users->search_in_system_users ( $columns, $records, $extraSQL );
	}
	
	$system_usersHTML = "";
	$count = 1;
	$iterated = false;
	
	if (count ( $system_users_info ) > 0) {
		foreach ( $system_users_info as $system_usersinfo ) {
			if ($system_usersinfo ["account_status"] == 1 || $system_usersinfo ["account_status"] == 0) {
				continue;
			}
			if ($search_key == "") {
				$system_usersHTML .= "<tr><td>" . $count . "</td>
							<td>" . $system_usersinfo ['firstname'] . "</td><td>" . $system_usersinfo ['lastname'] . "</td><td>" . $system_usersinfo ['phonenumber'] . "</td>
					<td>
						<button class=\"btn btn-outline btn-info btn-sm  \" onclick=restoreSystemUsers(" . $system_usersinfo ['id_system_user'] . ")>Restore</button>
					</td>
					<td>
						<button class=\"btn btn-outline btn-warning btn-sm  \" onclick=eraseSystemUsers(" . $system_usersinfo ['id_system_user'] . ")>Erase</button>
					</td>
					</tr>";
			} else {
				$system_usersHTML .= "<tr><td>" . $count . "</td><td>" . highligh_search_text ( $search_key, $system_usersinfo ['firstname'] ) . "</td><td>" . highligh_search_text ( $search_key, $system_usersinfo ['lastname'] ) . "</td><td>" . highligh_search_text ( $search_key, $system_usersinfo ['phonenumber'] ) . "</td>
					<td>
						<button class=\"btn btn-outline btn-info btn-sm  \" onclick=restoreSystemUsers(" . $system_usersinfo ['id_system_user'] . ")>Restore</button>
					</td>
					<td>
						<button class=\"btn btn-outline btn-warning btn-sm  \" onclick=eraseSystemUsers(" . $system_usersinfo ['id_system_user'] . ")>Erase</button>
					</td>
					</tr>";
			}
			$count ++;
			$iterated = true;
		}
	} else {
		if ($search_key == "") {
			$system_usersHTML .= '<tr><td></td><td colspan="99"><label>There are no system users found</label></td></tr>';
		} else {
			$system_usersHTML .= '<tr><td></td><td colspan="99">Oops! No System user named as <label style="color:red;">' . $search_key . '</label></td></tr>';
		}
	}
	
	// Nothing found or did not iterate --
	if ($count == 1 && $iterated) {
		$system_usersHTML .= '<tr><td colspan="99">Oops! No System user named as <label style="color:red;">' . $search_key . '</label></td></tr>';
	}
	
	echo $system_usersHTML;
}
function stageSelectedSystemUsers($action, $client) {
	$system_users = new SystemUsers ( $action, $client );
	$extra_system_user = $_POST ['extra_system_user'];
	
	$columns = array (
			'id_system_user' 
	);
	$records = array (
			$extra_system_user 
	);
	
	$system_user = $system_users->query_from_system_users ( $columns, $records );
	
	$system_users_info = array (
			'firstname' => $system_user [0] ['firstname'],
			'lastname' => $system_user [0] ['lastname'],
			'email' => $system_user [0] ['email'],
			'phonenumber' => $system_user [0] ['phonenumber'],
			'username' => $system_user [0] ['username'],
			'password' => $system_user [0] ['password'],
			'account_status' => $system_user [0] ['account_status'] 
	);
	
	echo json_encode ( $system_users_info );
}
function updateSystemUsersNames($action, $client) {
	$system_users_name = $_POST ['county_name'];
	$system_users_headquarters = $_POST ['county_headquarters'];
	
	$columns = array (
			"county_name",
			"county_headquarters" 
	);
	$records = array (
			$system_users_name,
			$system_users_headquarters 
	);
	
	return updateSystemUsers ( $action, $client, $columns, $records );
}
function trashSystemUsers($action, $client) {
	$columns = array (
			"account_status" 
	);
	$records = array (
			2 
	);
	
	return updateSystemUsers ( $action, $client, $columns, $records );
}
function restoreSystemUsers($action, $client) {
	$columns = array (
			"account_status" 
	);
	$records = array (
			1 
	);
	
	return updateSystemUsers ( $action, $client, $columns, $records );
}
function eraseSystemUsers($action, $client) {
	$columns = array (
			"account_status" 
	);
	$records = array (
			0 
	);
	return updateSystemUsers ( $action, $client, $columns, $records );
}
function updateSystemUsers($action, $client, $columns, $records) {
	$system_users = new SystemUsers ( $action, $client );
	$extra_system_user = $_POST ['extra_system_user'];
		
	$where_columns = array (
			"id_system_user" 
	);
	$where_records = array (
			$extra_system_user 
	);
	return $system_users->update_record_in_system_users ( $columns, $records, $where_columns, $where_records );
}
function highligh_search_text($search_key, $search_results) {
	if ($search_key == "") {
		return $search_results;
	}
	return str_replace ( $search_key, '<b style="color:blue;">' . $search_key . '</b>', $search_results );
}
?>