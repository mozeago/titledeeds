<?php
include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/core-apis/DatabaseActions.class.inc.php';
if (! class_exists ( 'TitleDeeds' ))
	include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/TitleDeeds.class.php';
if (! class_exists ( 'County' ))
	include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/County.class.php';
if (! class_exists ( 'Wards' ))
	include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/Wards.class.php';

define ( 'RESULT_FORMAT', 'result_format' );
define ( 'RESULT_FORMAT_DROPDOWN', 'dropdown_format' );
define ( 'RESULT_FORMAT_TABLE_ROWS', 'table_rows_format' );
define ( 'RESULT_FORMAT_ORDERED_LIST', 'ordered_list_format' );
define ( 'RESULT_FORMAT_UNORDERED_LIST', 'unordered_list_format' );

define ( 'INTENT_UPDATE_TITLE_DEEDS_NAMES', 'update_title_deed_names' );
define ( 'INTENT_INSERT_TITLE_DEEDS', 'insert_title_deed' );
define ( 'INTENT_QUERY_TITLE_DEEDS', 'query_title_deeds' );
define ( 'INTENT_QUERY_DELETED_TITLE_DEEDS', 'query_deleted_title_deeds' );
define ( 'INTENT_STAGE_SELECTED_TITLE_DEEDS_FOR_EDITING', 'stage_selected_title_deed_for_editing' );
define ( 'INTENT_QUERY_LAND_OWNER_TITLE_DEEDS', 'query_land_owner_title_deeds' );

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
	if ($intent == INTENT_INSERT_TITLE_DEEDS) {
		insertTitleDeed ( $action, $client );
	}
	if ($intent == INTENT_QUERY_TITLE_DEEDS) {
		queryTitleDeeds ( $action, $client );
	}
	
	if ($intent == INTENT_UPDATE_TITLE_DEEDS_NAMES) {
		updateTitleDeedNames ( $action, $client );
	}
	if ($intent == INTENT_STAGE_SELECTED_TITLE_DEEDS_FOR_EDITING) {
		stageSelectedTitleDeed ( $action, $client );
	}
	if ($intent == INTENT_QUERY_LAND_OWNER_TITLE_DEEDS) {
		prepareLandOwnerTitleDeeds ( $action, $client );
	}
}
function insertTitleDeed($action, $client) {
	$approximate_area = $_POST ['land_approximate_area'];
	$land_owner = getLandOwnerId ( $action, $client, $_POST ['landowner_idnumber'] );
	$edition = $_POST ['title_deed_edition'];
	$opened = $_POST ['title_deed_opened'];
	$registration_section = $_POST ['select_ward'];
	$parcel_number = $_POST ['title_deed_parcel_number'];
	$plot_number = $_POST ['title_deed_plot_number'];
	$registy_map_sheet_number = $_POST ['title_deed_map_sheet_number'];
	
	$titledeeds = new TitleDeeds ( $action, $client );
	$titledeeds->insert_prepared_records ( $approximate_area, $land_owner, $edition, $opened, $registration_section, $parcel_number, $plot_number, $registy_map_sheet_number, true, true );
}
function queryTitleDeeds($action, $client) {
	$title_deed = new TitleDeeds ( $action, $client );
	$identity_number = $_POST ['search_key'];
	$result_format = $_POST [RESULT_FORMAT];
	
	$landownerid = getLandOwnerId ( $action, $client, $identity_number );
	
	$title_deeds = null;
	
	$columns = array (
			"land_owner" 
	);
	$records = array (
			$landownerid 
	);
	
	$title_deeds = $title_deed->query_from_title_deeds ( $columns, $records );
	
	$title_deedHTML = "";
	$count = 1;
	$data_found = false;
	
	if ($result_format == RESULT_FORMAT_TABLE_ROWS) {
		if (count ( $title_deeds ) > 0) {
			foreach ( $title_deeds as $title_deed_info ) {
				
				$id_ward = $title_deed_info ["registration_section"];
				$ward_name = (new Wards ( $action, $client ))->get_ward_name ( $id_ward );
				
				$id_county = (new Wards ( $action, $client ))->get_id_county ( $id_ward );
				$county_name = (new County ( $action, $client ))->get_county_name ( $id_county );
				
				$registration_section = $ward_name . "-" . $county_name;
				
				$title_deedHTML .= "<tr><td>" . $count . "</td><td>" . $title_deed_info ["edition"] . "</td><td>" . $title_deed_info ["opened"] . "</td><td>" . $registration_section . "</td><td>" . $title_deed_info ["approximate_area"] . "</td><td>" . $title_deed_info ["parcel_number"] . "</td><td>" . $title_deed_info ["plot_number"] . "</td><td>" . $title_deed_info ["parcel_number"] . "</td>";
				
				$title_deedHTML .= "<td><button class=\"btn btn-outline btn-info btn-sm\" onclick=editTitleDeed(" . $title_deed_info ['id_title_deed'] . ")>Edit</button></td><!--<td><button onclick=deleteTitleDeed(" . $title_deed_info ['id_title_deed'] . ")>Delete</button></td>--></tr>";
				
				$count ++;
			}
		} else {
			if ($identity_number == "") {
				$title_deedHTML .= '<tr><td colspan="99"><label>There are no title deeds for this land owner</label></td></tr>';
			} else {
				$data_found = true;
				$title_deedHTML .= '<tr><td colspan="99">Oops! No land owner with the id <label style="color:red;">' . $identity_number . '</label></td></tr>';
			}
		}
		
		// Nothing found or did not iterate --
		if ($count == 1) {
			if (! $data_found)
				$title_deedHTML .= '<tr><td colspan="99">Oops! No land owner with the id <label style="color:red;">' . $identity_number . '</label></td></tr>';
		}
	}
	
	$count = 1;
	if ($result_format == RESULT_FORMAT_DROPDOWN) {
		if (count ( $title_deeds ) > 0) {
			foreach ( $title_deeds as $title_deed_info ) {
				if ($title_deed_info ["trashed"] == 1 || $title_deed_info ["deleted"] == 1) {
					continue;
				}
				$title_deedHTML .= '<option value="' . $title_deed_info ['id_land_owner'] . '" >' . $title_deed_info ['land_owner_name'] . '</option>';
				$count ++;
			}
		}
	}
	
	echo $title_deedHTML;
}
function stageSelectedTitleDeed($action, $client) {
	$title_deed = new TitleDeeds ( $action, $client );
	$id_title_deed = $_POST ['extra_title_deed'];
	
	$edition = $title_deed->get_edition ( $id_title_deed );
	$opened = $title_deed->get_opened ( $id_title_deed );
	$registration_section = $title_deed->get_registration_section ( $id_title_deed );
	$approximate_area = $title_deed->get_approximate_area ( $id_title_deed );
	$parcel_number = $title_deed->get_parcel_number ( $id_title_deed );
	$plot_number = $title_deed->get_plot_number ( $id_title_deed );
	$registry_map_sheet_number = $title_deed->get_registy_map_sheet_number ( $id_title_deed );
	
	$title_deed_info = array (
			"edition" => $edition,
			"opened" => $opened,
			"county" => get_county ( $action, $client, $registration_section ),
			"registration_section" => $registration_section,
			"approximate_area" => $approximate_area,
			"parcel_number" => $parcel_number,
			"plot_number" => $plot_number,
			"registry_map_sheet_number" => $registry_map_sheet_number 
	);
	
	echo json_encode ( $title_deed_info );
}
function updateTitleDeedNames($action, $client) {
	$extra_title_deed = $_POST ['extra_title_deed'];
	
	$approximate_area = $_POST ['land_approximate_area'];
	$land_owner = getLandOwnerId ( $action, $client, $_POST ['landowner_idnumber'] );
	$edition = $_POST ['title_deed_edition'];
	$opened = $_POST ['title_deed_opened'];
	$registration_section = $_POST ['select_ward'];
	$parcel_number = $_POST ['title_deed_parcel_number'];
	$plot_number = $_POST ['title_deed_plot_number'];
	$registy_map_sheet_number = $_POST ['title_deed_map_sheet_number'];
	
	$columns = array (
			'approximate_area',
			'land_owner',
			'edition',
			'opened',
			'registration_section',
			'parcel_number',
			'plot_number',
			'registy_map_sheet_number' 
	);
	$records = array (
			$approximate_area,
			$land_owner,
			$edition,
			$opened,
			$registration_section,
			$parcel_number,
			$plot_number,
			$registy_map_sheet_number 
	);
	
	$where_columns = array (
			"id_title_deed" 
	);
	$where_records = array (
			$extra_title_deed 
	);
	
	return (new TitleDeeds ( $action, $client ))->update_record_in_title_deeds ( $columns, $records, $where_columns, $where_records );
}
function updateTitleDeed($action, $client, $columns, $records) {
	$title_deed = new TitleDeeds ( $action, $client );
	$extra_title_deed = $_POST ['extra_title_deed'];
	
	$where_columns = array (
			"id_title_deed" 
	);
	$where_records = array (
			$extra_title_deed 
	);
	return $title_deed->update_record_in_title_deeds ( $columns, $records, $where_columns, $where_records );
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
	return (new Wards ( $action, $client ))->get_id_county ( $id_ward );
}
function queryLandOwnerTitleDeeds($action, $client) {
	$landowner_id = $_POST ['extra_land_owner'];
	
	$columns = array (
			"land_owner" 
	);
	
	$records = array (
			$landowner_id 
	);
	
	return (new TitleDeeds ( $action, $client ))->query_from_title_deeds ( $columns, $records );
}
function prepareLandOwnerTitleDeeds($action, $client) {
	$titledeeds = queryLandOwnerTitleDeeds ( $action, $client );
	
	$title_deeds_html = '<option value="-1">Select Title Deed</option>';
	
	foreach ( $titledeeds as $titledeed ) {
		
		$id_titledeed = $titledeed ["id_title_deed"];
		$registration_section = $titledeed ["registration_section"];
		$parcel_number = $titledeed ["parcel_number"];
		$plot_number = $titledeed ["plot_number"];
		$registy_map_sheet_number = $titledeed ["registy_map_sheet_number"];
		
		$id_ward = $registration_section;
		$ward_name = (new Wards ( $action, $client ))->get_ward_name ( $id_ward );
		$id_county = (new Wards ( $action, $client ))->get_id_county ( $id_ward );
		
		$county_name = (new County ( $action, $client ))->get_county_name ( $id_county );
		
		$title_deeds_html .= '<option value="' . $id_titledeed . '">' . $ward_name . '/' . $county_name . ' Plot no. ' . $plot_number . '</option>';
	}
	
	echo $title_deeds_html;
}
?>