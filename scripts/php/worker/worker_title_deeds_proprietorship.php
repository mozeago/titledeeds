<?php
include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/core-apis/DatabaseActions.class.inc.php';
include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/TitleDeedProprietorship.class.php';

define ( 'RESULT_FORMAT', 'result_format' );
define ( 'RESULT_FORMAT_DROPDOWN', 'dropdown_format' );
define ( 'RESULT_FORMAT_TABLE_ROWS', 'table_rows_format' );
define ( 'RESULT_FORMAT_ORDERED_LIST', 'ordered_list_format' );
define ( 'RESULT_FORMAT_UNORDERED_LIST', 'unordered_list_format' );

define ( 'INTENT_UPDATE_TITLE_DEED_PROPRIETORSHIP', 'update_title_deed_proprietorship' );
define ( 'INTENT_INSERT_TITLE_DEED_PROPRIETORSHIP', 'insert_title_deed_proprietorship' );
define ( 'INTENT_QUERY_TITLE_DEEDS_PROPRIETORSHIP', 'query_title_deed_proprietorship' );
define ( 'INTENT_DELETE_TITLE_DEED_PROPRIETORSHIP', 'delete_title_deed_proprietorship' );
define ( 'INTENT_STAGE_SELECTED_TITLE_DEEDS_FOR_EDITING', 'stage_selected_title_deed_for_editing' );

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
	if ($intent == INTENT_INSERT_TITLE_DEED_PROPRIETORSHIP) {
		insertTitleDeedProprietorship ( $action, $client );
	}
	if ($intent == INTENT_QUERY_TITLE_DEEDS_PROPRIETORSHIP) {
		queryTitleDeedProprietorship ( $action, $client );
	}
	
	if ($intent == INTENT_UPDATE_TITLE_DEED_PROPRIETORSHIP) {
		updateTitleDeedProprietorship ( $action, $client );
	}
	if ($intent == INTENT_DELETE_TITLE_DEED_PROPRIETORSHIP) {
		deleteTitleDeedProprietorship ( $action, $client );
	}
	if ($intent == INTENT_STAGE_SELECTED_TITLE_DEEDS_FOR_EDITING) {
		stageSelectedTitleDeed ( $action, $client );
	}
}
function insertTitleDeedProprietorship($action, $client) {
	$id_title_deed = $_POST ['titledeed_id'];
	$entry_number = $_POST ['entryNumber'];
	$registered_proprietor = getLandOwnerId ( $action, $client, $_POST ['registeredProprietor'] );
	$consideration_and_remarks = $_POST ['consideration_and_remarks'];
	$signature_of_register = $_POST ['registeredProprietor'];
	$posted_date = date ( "Y-m-d h:i:s" );
	
	return (new TitleDeedProprietorship ( $action, $client ))->insert_prepared_records ( $id_title_deed, $entry_number, $posted_date, $registered_proprietor, $consideration_and_remarks, $signature_of_register, true, true );
}
function queryTitleDeedProprietorship($action, $client) {
	if (! class_exists ( 'LandOwners' )) {
		include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/LandOwners.class.php';
	}
	
	$land_owner = new LandOwners ( $action, $client );
	$titledeedProprietorship = new TitleDeedProprietorship ( $action, $client );
	
	$extra_land_owner = $_POST ['extra_land_owner'];
	$extra_title_deed = $_POST ['extra_title_deed'];
	
	$columns = array (
			"registered_proprietor" 
	);
	$records = array (
			$extra_land_owner 
	);
	
	if ($extra_title_deed != "-1") {
		$columns [count ( $columns )] = "id_title_deed";
		$records [count ( $records )] = $extra_title_deed;
	}
	
	$proprietorships = $titledeedProprietorship->query_from_title_deed_proprietorship ( $columns, $records );
	
	$title_deedHTML = "";
	$count = 1;
	foreach ( $proprietorships as $proprietorship ) {
		$entry_number = $proprietorship ["entry_number"];
		$id_land_owner = $proprietorship ["registered_proprietor"];
		$land_owner_name = $land_owner->get_firstname ( $id_land_owner ) . " " . $land_owner->get_middlename ( $id_land_owner ) . " " . $land_owner->get_lastname ( $id_land_owner );
		$land_owner_address = $land_owner->get_address ( $id_land_owner );
		$comments_and_remarks = $proprietorship ["consideration_and_remarks"];
		
		$signature_of_registered_proprietor = $proprietorship ["signature_of_register"];
		$id_title_deed = $proprietorship ['id_title_deed'];
		$id_title_deed_proprietorship = $proprietorship ['id_title_deed_proprietorship'];
		$date = $proprietorship ['posted_date'];
		$title_deedHTML .= "<tr><td>" . $count . "</td>
				<td>" . $entry_number . "</td>
				<td>" . $date . "</td>
				<td>" . $land_owner_name . "</td>
				<td>" . $land_owner_address . "</td>
						<td>" . $comments_and_remarks . "</td>
								<td>" . $signature_of_registered_proprietor . "</td>
				<td>" . (elapsed_time ( $proprietorship ["posted_date"] ) > 300 ? "<button class=\"btn btn-outline btn-info btn-block btn-sm \" disabled=\"disabled\" >Edit</button> </td> <td> <button class=\"btn btn-outline btn-warning btn-block btn-sm \"disabled=\"disabled\" >Delete</button>" : "<button class=\"btn btn-outline btn-info btn-block btn-sm \" onclick=\"editTitleDeedProprietorship(" . $id_title_deed_proprietorship . ");\">Edit</button> </td><td><button class=\"btn btn-outline btn-warning btn-block btn-sm \" onclick=\"deleteTitleDeedProprietorship(" . $id_title_deed_proprietorship . ");\">Delete</button>") . "</td></tr>";
		$count ++;
	}
	
	echo $title_deedHTML;
}
function get_title_deed_registration_section($client, $action, $registration_section) {
	$id_ward = $registration_section;
	$ward_name = (new Wards ( $action, $client ))->get_ward_name ( $id_ward );
	$id_county = (new Wards ( $action, $client ))->get_id_county ( $id_ward );
	
	$county_name = (new County ( $action, $client ))->get_county_name ( $id_county );
	
	return $ward_name . "/" . $county_name;
}
function stageSelectedTitleDeed($action, $client) {
	$columns = array (
			"id_title_deed_proprietorship" 
	);
	$records = array (
			$_POST ['extra_title_deed_proprietorship'] 
	);
	$title_deed_proprietorship = new TitleDeedProprietorship ( $action, $client );
	$proprietorships = $title_deed_proprietorship->query_from_title_deed_proprietorship ( $columns, $records );
	
	// Echo the last proprietor for this piece of land
	echo json_encode ( $proprietorships [count ( $proprietorships ) - 1] );
}
function updateTitleDeedProprietorship($action, $client) {
	$title_deed_proprietorship_id = $_POST ["extra_title_deed_proprietorship"];
	
	$id_title_deed = $_POST ['titledeed_id'];
	$entry_number = $_POST ['entryNumber'];
	$registered_proprietor = getLandOwnerId ( $action, $client, $_POST ['registeredProprietor'] );
	$consideration_and_remarks = $_POST ['consideration_and_remarks'];
	$signature_of_register = $_POST ['registeredProprietor'];
	$posted_date = date ( "Y-m-d h:i:s" );
	
	$columns = array (
			"id_title_deed",
			"entry_number",
			"posted_date",
			"registered_proprietor",
			"consideration_and_remarks" 
	);
	$records = array (
			$id_title_deed,
			$entry_number,
			$posted_date,
			$registered_proprietor,
			$consideration_and_remarks 
	);
	$where_columns = array (
			"id_title_deed_proprietorship" 
	);
	$where_records = array (
			$title_deed_proprietorship_id 
	);
	return (new TitleDeedProprietorship ( $action, $client ))->update_record_in_title_deed_proprietorship ( $columns, $records, $where_columns, $where_records, true );
}
function deleteTitleDeedProprietorship($action, $client) {
	return (new TitleDeedProprietorship ( $action, $client ))->delete_record_from_title_deed_proprietorship ( array (
			"id_title_deed_proprietorship" 
	), array (
			$_POST ["extra_title_deed_proprietorship"] 
	) );
}
function highligh_search_text($search_key, $search_results) {
	if ($search_key == "") {
		return $search_results;
	}
	return str_replace ( $search_key, '<b style="color:green;">' . $search_key . '</b>', $search_results );
}
function getLandOwnerId($action, $client, $identity_number) {
	if (! class_exists ( 'LandOwners' ))
		include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/LandOwners.class.php';
	$land_owner = new LandOwners ( $action, $client );
	
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
			return $landownerinfo [0] ["id_land_owner"];
		}
		// Multiple land owners found -- a problem in the database
		if (count ( $landownerinfo ) > 1) {
			return - 1;
		}
		// No land owner found, most probably a wrong id number
		if (count ( $landownerinfo ) == 0) {
			return - 1;
		}
	}
}
function get_county($action, $client, $id_ward) {
	if (! class_exists ( 'Wards' ))
		include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/Wards.class.php';
	return (new Wards ( $action, $client ))->get_id_county ( $id_ward );
}
function elapsed_time($timestamp) {
	return strtotime ( date ( "Y-m-d h:i:s", time () ) ) - strtotime ( $timestamp );
}
function getTitleDeedInfo($action, $client, $id_title_deed) {
	if (! class_exists ( 'County' ))
		include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/County.class.php';
	if (! class_exists ( 'Wards' ))
		include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/Wards.class.php';
	if (! class_exists ( 'TitleDeeds' ))
		include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/TitleDeeds.class.php';
	
	$id_ward = (new TitleDeeds ( $action, $client ))->get_registration_section ( $id_title_deed );
	$id_county = (new Wards ( $action, $client ))->get_id_county ( $id_ward );
	
	$ward_name = (new Wards ( $action, $client ))->get_ward_name ( $id_ward );
	$county_name = (new County ( $action, $client ))->get_county_name ( $id_county );
	
	return $ward_name . "(" . $county_name . ")";
}

?>