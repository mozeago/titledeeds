<?php
include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/core-apis/DatabaseActions.class.inc.php';
include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/LandOwners.class.php';

define ( 'RESULT_FORMAT', 'result_format' );
define ( 'RESULT_FORMAT_DROPDOWN', 'dropdown_format' );
define ( 'RESULT_FORMAT_TABLE_ROWS', 'table_rows_format' );
define ( 'RESULT_FORMAT_ORDERED_LIST', 'ordered_list_format' );
define ( 'RESULT_FORMAT_UNORDERED_LIST', 'unordered_list_format' );

define ( 'INTENT_UPDATE_LAND_OWNERS_NAMES', 'update_land_owner_names' );
define ( 'INTENT_INSERT_LAND_OWNERS', 'insert_land_owner' );
define ( 'INTENT_QUERY_LAND_OWNERS', 'query_land_owners' );
define ( 'INTENT_QUERY_DELETED_LAND_OWNERS', 'query_deleted_land_owners' );
define ( 'INTENT_STAGE_SELECTED_LAND_OWNERS_FOR_EDITING', 'stage_selected_land_owner_for_editing' );
define ( 'INTENT_TRASH_LAND_OWNERS', 'trash_land_owner' );
define ( 'INTENT_ERASE_LAND_OWNERS', 'erase_land_owner' );
define ( 'INTENT_RESTORE_LAND_OWNERS', 'restore_land_owner' );
define ( 'INTENT_QUERY_LAND_OWNER_NAME', 'query_landowner_name' );
define ( 'INTENT_QUERY_TITLE_DEED_OWNER_NAME', 'query_titledeed_owner' );
define ( 'INTENT_GET_LAND_OWNER_JSON_OBJECT', 'query_get_landowner_json_object' );
define ( 'INTENT_GET_REGISTERED_PROPRIETOR_INFO', 'get_registered_proprietor_info' );
define ( 'INTENT_QUERY_REGISTERED_PROPRIETOR_NAME', 'get_registered_proprietor' );

define ( 'EXTRA_IDENTITY_NUMBER', 'extra_identity_number' );

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
	if ($intent == INTENT_INSERT_LAND_OWNERS) {
		insertLandOwner ( $action, $client );
	}
	if ($intent == INTENT_QUERY_LAND_OWNERS) {
		queryLandOwners ( $action, $client );
	}
	
	if ($intent == INTENT_UPDATE_LAND_OWNERS_NAMES) {
		updateLandOwnerNames ( $action, $client );
	}
	if ($intent == INTENT_STAGE_SELECTED_LAND_OWNERS_FOR_EDITING) {
		stageSelectedLandOwner ( $action, $client );
	}
	if ($intent == INTENT_QUERY_LAND_OWNER_NAME || $intent == INTENT_QUERY_TITLE_DEED_OWNER_NAME || $intent == INTENT_QUERY_REGISTERED_PROPRIETOR_NAME) {
		queryLandOwnerName ( $action, $client );
	}
	if ($intent == INTENT_GET_LAND_OWNER_JSON_OBJECT) {
		getLandOwnerJsonObject ( $action, $client );
	}
	if ($intent == INTENT_GET_REGISTERED_PROPRIETOR_INFO) {
		getRegisteredProprietorInfo ( $action, $client );
	}
}
function insertLandOwner($action, $client) {
	$firstname = $_POST ['firstname'];
	$middlename = $_POST ['middlename'];
	$lastname = $_POST ['lastname'];
	$idnumber = $_POST ['idnumber'];
	$passport = $_POST ['passport'];
	$date_of_birth = $_POST ['dateOfBirth'];
	$address = $_POST ['address'];
	
	$land_owner = new LandOwners ( $action, $client );
	$trashed = 0;
	$deleted = 0;
	$first_created = date ( "Y-m-d h:i:s" );
	$last_modified = date ( "Y-m-d h:i:s" );
	echo $land_owner->insert_prepared_records ( $firstname, $middlename, $lastname, $idnumber, $passport, $date_of_birth, $address );
}
function queryLandOwners($action, $client) {
	$land_owner = new LandOwners ( $action, $client );
	$search_key = $_POST ['search_key'];
	$result_format = $_POST [RESULT_FORMAT];
	
	$land_owners = null;
	
	if ($search_key == "") {
		
		$land_owners = $land_owner->query_from_land_owners ( array (), array () );
	} else {
		$columns = array (
				"firstname",
				"middlename",
				"lastname",
				"idnumber",
				"passport",
				"date_of_birth",
				"address" 
		);
		$records = array (
				$search_key,
				$search_key,
				$search_key,
				$search_key,
				$search_key,
				$search_key,
				$search_key 
		);
		
		$land_owners = $land_owner->search_in_land_owners ( $columns, $records );
	}
	
	$land_ownerHTML = "";
	$count = 1;
	$data_found = false;
	
	if ($result_format == RESULT_FORMAT_TABLE_ROWS) {
		if (count ( $land_owners ) > 0) {
			foreach ( $land_owners as $land_ownerinfo ) {
				
				$land_ownerHTML .= "<tr><td>" . $count . "</td><td>" . highligh_search_text ( $search_key, $land_ownerinfo ['firstname'] ) . "</td><td>" . highligh_search_text ( $search_key, $land_ownerinfo ['middlename'] ) . "</td><td>" . highligh_search_text ( $search_key, $land_ownerinfo ['lastname'] ) . "</td><td>" . highligh_search_text ( $search_key, $land_ownerinfo ['idnumber'] ) . "</td><td>" . highligh_search_text ( $search_key, $land_ownerinfo ['passport'] ) . "</td><td>" . highligh_search_text ( $search_key, $land_ownerinfo ['date_of_birth'] ) . "</td><td>" . highligh_search_text ( $search_key, $land_ownerinfo ['address'] ) . "</td><td>";
				$land_ownerHTML .= "<button class=\"btn btn-info btn-outline\" onclick=editLandOwner(" . $land_ownerinfo ['id_land_owner'] . ")>Edit</button></td><!--<td><button onclick=deleteLandOwner(" . $land_ownerinfo ['id_land_owner'] . ")>Delete</button></td>--></tr>";
				
				$count ++;
			}
		} else {
			if ($search_key == "") {
				$land_ownerHTML .= '<tr><td colspan="99"><label>There are no land_owners</label></td></tr>';
			} else {
				$data_found = true;
				$land_ownerHTML .= '<tr><td colspan="99">Oops! No land_owner named as <label style="color:red;">' . $search_key . '</label></td></tr>';
			}
		}
		
		// Nothing found or did not iterate --
		if ($count == 1) {
			if (! $data_found)
				$land_ownerHTML .= '<tr><td colspan="99">Oops! No land_owner named as <label style="color:red;">' . $search_key . '</label></td></tr>';
		}
	}
	
	$count = 1;
	if ($result_format == RESULT_FORMAT_DROPDOWN) {
		if (count ( $land_owners ) > 0) {
			foreach ( $land_owners as $land_ownerinfo ) {
				if ($land_ownerinfo ["trashed"] == 1 || $land_ownerinfo ["deleted"] == 1) {
					continue;
				}
				$land_ownerHTML .= '<option value="' . $land_ownerinfo ['id_land_owner'] . '" >' . $land_ownerinfo ['land_owner_name'] . '</option>';
				$count ++;
			}
		}
	}
	
	echo $land_ownerHTML;
}
function stageSelectedLandOwner($action, $client) {
	$land_owner = new LandOwners ( $action, $client );
	$extra_land_owner = $_POST ['extra_land_owner'];
	
	$id_land_owner = $extra_land_owner;
	
	$firstname = $land_owner->get_firstname ( $id_land_owner );
	$middlename = $land_owner->get_middlename ( $id_land_owner );
	$lastname = $land_owner->get_lastname ( $id_land_owner );
	$idnumber = $land_owner->get_idnumber ( $id_land_owner );
	$passport = $land_owner->get_passport ( $id_land_owner );
	$date_of_birth = $land_owner->get_date_of_birth ( $id_land_owner );
	$address = $land_owner->get_address ( $id_land_owner );
	
	$land_owner_info = array (
			"firstname" => $firstname,
			"middlename" => $middlename,
			"lastname" => $lastname,
			"idnumber" => $idnumber,
			"passport" => $passport,
			"date_of_birth" => $date_of_birth,
			"address" => $address 
	);
	
	echo json_encode ( $land_owner_info );
}
function updateLandOwnerNames($action, $client) {
	$firstname = $_POST ['firstname'];
	$middlename = $_POST ['middlename'];
	$lastname = $_POST ['lastname'];
	$idnumber = $_POST ['idnumber'];
	$passport = $_POST ['passport'];
	$date_of_birth = $_POST ['dateOfBirth'];
	$address = $_POST ['address'];
	
	$columns = array (
			"firstname",
			"middlename",
			"lastname",
			"idnumber",
			"passport",
			"date_of_birth",
			"address" 
	);
	$records = array (
			$firstname,
			$middlename,
			$lastname,
			$idnumber,
			$passport,
			$date_of_birth,
			$address 
	);
	
	return updateLandOwner ( $action, $client, $columns, $records, true );
}
function updateLandOwner($action, $client, $columns, $records) {
	$land_owner = new LandOwners ( $action, $client );
	$extra_land_owner = $_POST ['extra_land_owner'];
	
	$where_columns = array (
			"id_land_owner" 
	);
	$where_records = array (
			$extra_land_owner 
	);
	return $land_owner->update_record_in_land_owners ( $columns, $records, $where_columns, $where_records );
}
function highligh_search_text($search_key, $search_results) {
	if ($search_key == "") {
		return $search_results;
	}
	return str_replace ( $search_key, '<b style="color:blue;">' . $search_key . '</b>', $search_results );
}
function queryLandOwnerName($action, $client) {
	$land_owner = new LandOwners ( $action, $client );
	$identity_number = $_POST [EXTRA_IDENTITY_NUMBER];
	
	$records = array (
			$identity_number 
	);
	
	$landownerfound = false;
	$landownerinfo = array ();
	
	if (! $landownerfound) {
		$columns = array (
				"idnumber" 
		);
		$landownerinfo = $land_owner->query_distinct_from_land_owners ( $columns, $records );
		if (count ( $landownerinfo ) == 1) {
			$landownerfound = true;
		}
	}
	
	if (! $landownerfound) {
		$columns = array (
				"passport" 
		);
		
		$landownerinfo = $land_owner->query_distinct_from_land_owners ( $columns, $records );
		if (count ( $landownerinfo ) == 1) {
			$landownerfound = true;
		}
	}
	
	if ($landownerfound) {
		// Only a single land owner was found
		if (count ( $landownerinfo ) == 1) {
			echo $landownerinfo [0] ["firstname"] . " " . $landownerinfo [0] ["middlename"] . " " . $landownerinfo [0] ["lastname"];
		}
		// Multiple land owners found -- a problem in the database
		if (count ( $landownerinfo ) > 1) {
		}
		// No land owner found, most probably a wrong id number
		if (count ( $landownerinfo ) == 0) {
		}
	}
}
function getLandOwnerJsonObject($action, $client) {
	$land_owner = new LandOwners ( $action, $client );
	$identity_number = $_POST [EXTRA_IDENTITY_NUMBER];
	
	$records = array (
			$identity_number 
	);
	
	$landownerfound = false;
	$landownerinfo = array ();
	
	if (! $landownerfound) {
		$columns = array (
				"idnumber" 
		);
		$landownerinfo = $land_owner->query_distinct_from_land_owners ( $columns, $records );
		if (count ( $landownerinfo ) == 1) {
			$landownerfound = true;
		}
	}
	
	if (! $landownerfound) {
		$columns = array (
				"passport" 
		);
		
		$landownerinfo = $land_owner->query_distinct_from_land_owners ( $columns, $records );
		if (count ( $landownerinfo ) == 1) {
			$landownerfound = true;
		}
	}
	
	if ($landownerfound) {
		// Only a single land owner was found
		if (count ( $landownerinfo ) == 1) {
			
			foreach ( $landownerinfo as $landowner ) {
				echo json_encode ( $landowner );
				break;
			}
		}
		// Multiple land owners found -- a problem in the database
		if (count ( $landownerinfo ) > 1) {
		}
		// No land owner found, most probably a wrong id number
		if (count ( $landownerinfo ) == 0) {
		}
	}
}
function getRegisteredProprietorInfo($action, $client) {
	echo json_encode ( (new LandOwners ( $action, $client ))->query_from_land_owners ( array (
			"id_land_owner" 
	), array (
			$_POST ['extra_registered_proprietor'] 
	) )[0] );
}
?>