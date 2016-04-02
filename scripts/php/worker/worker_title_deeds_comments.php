<?php
include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/core-apis/DatabaseActions.class.inc.php';
include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/TitleDeedComments.class.php';

define ( 'RESULT_FORMAT', 'result_format' );
define ( 'RESULT_FORMAT_DROPDOWN', 'dropdown_format' );
define ( 'RESULT_FORMAT_TABLE_ROWS', 'table_rows_format' );
define ( 'RESULT_FORMAT_ORDERED_LIST', 'ordered_list_format' );
define ( 'RESULT_FORMAT_UNORDERED_LIST', 'unordered_list_format' );

define ( 'INTENT_DELETE_TITLE_DEED_COMMENT', 'delete_title_deed_comment' );
define ( 'INTENT_UPDATE_TITLE_DEED_COMMENTS', 'update_title_deed_comments' );
define ( 'INTENT_INSERT_TITLE_DEED_COMMENTS', 'insert_title_deed_comments' );
define ( 'INTENT_QUERY_TITLE_DEEDS_COMMENTS', 'query_title_deed_comments' );
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
	if ($intent == INTENT_INSERT_TITLE_DEED_COMMENTS) {
		insertTitleDeedComments ( $action, $client );
	}
	if ($intent == INTENT_QUERY_TITLE_DEEDS_COMMENTS) {
		queryTitleDeedComments ( $action, $client );
	}
	
	if ($intent == INTENT_UPDATE_TITLE_DEED_COMMENTS) {
		updateTitleDeedComments ( $action, $client );
	}
	if ($intent == INTENT_DELETE_TITLE_DEED_COMMENT) {
		deleteTitleDeedComment ( $action, $client );
	}
	if ($intent == INTENT_STAGE_SELECTED_TITLE_DEEDS_FOR_EDITING) {
		stageSelectedTitleDeed ( $action, $client );
	}
}
function insertTitleDeedComments($action, $client) {
	$id_title_deed = $_POST ['titledeed_id'];
	$title_deed_comments = $_POST ['titledeed_comment'];
	$charged = $_POST['charged'];
	$posted_date = date ( "Y-m-d h:i:s" );
	return (new TitleDeedComments ( $action, $client ))->insert_prepared_records ( $id_title_deed, $title_deed_comments, $charged,$posted_date, true, true );
}
function queryTitleDeedComments($action, $client) {
	include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/County.class.php';
	include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/Wards.class.php';
	include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/TitleDeeds.class.php';
	
	$titledeed_comments = new TitleDeedComments ( $action, $client );
	$title_deed = new TitleDeeds ( $action, $client );
	
	$land_owner_id = $_POST ['extra_land_owner'];
	
	$columns = array (
			"land_owner" 
	);
	$records = array (
			$land_owner_id 
	);
	
	$extra_title_deed = $_POST ['extra_title_deed'];
	
	if ($extra_title_deed != "-1") {
		$columns [count ( $columns )] = "id_title_deed";
		$records [count ( $records )] = $extra_title_deed;
	}
	
	$landowner_titledeeds = $title_deed->query_from_title_deeds ( $columns, $records );
	
	$titledeeds = array (
			count ( $landowner_titledeeds ) 
	);
	
	foreach ( $landowner_titledeeds as $landowner_titledeed ) {
		$titledeeds [count ( $titledeeds )] = $landowner_titledeed;
	}
	
	$title_deedHTML = "";
	$i = 1;
	foreach ( $titledeeds as $titledeed ) {
		$id_title_deed = $titledeed ["id_title_deed"];
		$registration_section = $titledeed ["registration_section"];
		
		$columns = array (
				"id_title_deed" 
		);
		$records = array (
				$id_title_deed 
		);
		
		$titledeed_registration_section_info = get_title_deed_registration_section ( $client, $action, $registration_section );
		
		$comments = $titledeed_comments->query_from_title_deed_comments ( $columns, $records );
		
		foreach ( $comments as $comment ) {
			$id_title_deed_comment = $comment ["id_title_deed_comment"];
			$titledeed_comment = $comment ["title_deed_comments"];
			$title_deedHTML .= "<tr><td>" . $i . "</td><td>" . $titledeed_registration_section_info . "</td><td>" . $titledeed_comment . "</td><td>" . (elapsed_time ( $comment ["posted_date"] ) > 300 ? "<button class=\"btn btn-outline btn-info btn-block btn-sm\" disabled=\"disabled\" >Edit</button></td><td><button class=\"btn btn-outline btn-warning btn-block btn-sm\" disabled=\"disabled\" >Delete</button>" : "<button class=\"btn btn-outline btn-info btn-block btn-sm \" onclick=\"editTitleDeedComments(" . $id_title_deed . "," . $id_title_deed_comment . ");\">Edit</button></td><td><button class=\"btn btn-outline btn-warning btn-block btn-sm\" onclick=\"deleteTitleDeedComment(" . $id_title_deed_comment . ");\">Delete</button>") . "</td></tr>";
			
			$i ++;
		}
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
	echo (new TitleDeedComments ( $action, $client ))->get_title_deed_comments ( $_POST ['extra_title_deed_comment'] );
}
function updateTitleDeedComments($action, $client) {
	$title_deed_comment_id = $_POST ["extra_title_deed_comment"];
	$title_deed_comments = $_POST ['titledeed_comment'];
	$posted_date = date ( "Y-m-d h:i:s" );
	$columns = array (
			"title_deed_comments",
			"posted_date" 
	);
	$records = array (
			$title_deed_comments,
			$posted_date 
	);
	$where_columns = array (
			"id_title_deed_comment" 
	);
	$where_records = array (
			$title_deed_comment_id 
	);
	return (new TitleDeedComments ( $action, $client ))->update_record_in_title_deed_comments ( $columns, $records, $where_columns, $where_records );
}
function deleteTitleDeedComment($action, $client) {
	return (new TitleDeedComments ( $action, $client ))->delete_record_from_title_deed_comments ( array (
			"id_title_deed_comment" 
	), array (
			$_POST ["extra_title_deed_comment"] 
	) );
}
function highligh_search_text($search_key, $search_results) {
	if ($search_key == "") {
		return $search_results;
	}
	return str_replace ( $search_key, '<b style="color:green;">' . $search_key . '</b>', $search_results );
}
function getLandOwnerId($action, $client, $identity_number) {
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
	include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/Wards.class.php';
	return (new Wards ( $action, $client ))->get_id_county ( $id_ward );
}
function elapsed_time($timestamp) {
	return strtotime ( date ( "Y-m-d h:i:s", time () ) ) - strtotime ( $timestamp );
}
?>