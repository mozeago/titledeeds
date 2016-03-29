<?php
include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/core-apis/DatabaseActions.class.inc.php';
include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/County.class.php';

define ( 'RESULT_FORMAT', 'result_format' );
define ( 'RESULT_FORMAT_DROPDOWN', 'dropdown_format' );
define ( 'RESULT_FORMAT_TABLE_ROWS', 'table_rows_format' );
define ( 'RESULT_FORMAT_ORDERED_LIST', 'ordered_list_format' );
define ( 'RESULT_FORMAT_UNORDERED_LIST', 'unordered_list_format' );

define ( 'INTENT_UPDATE_COUNTY_NAMES', 'update_county_names' );
define ( 'INTENT_INSERT_COUNTY', 'insert_county' );
define ( 'INTENT_QUERY_COUNTIES', 'query_counties' );
define ( 'INTENT_QUERY_DELETED_COUNTIES', 'query_deleted_counties' );
define ( 'INTENT_STAGE_SELECTED_COUNTY_FOR_EDITING', 'stage_selected_county_for_editing' );
define ( 'INTENT_TRASH_COUNTY', 'trash_county' );
define ( 'INTENT_ERASE_COUNTY', 'erase_county' );
define ( 'INTENT_RESTORE_COUNTY', 'restore_county' );

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
	if ($intent == INTENT_INSERT_COUNTY) {
		insertCounty ( $action, $client );
	}
	if ($intent == INTENT_QUERY_COUNTIES) {
		queryCounties ( $action, $client );
	}
	if ($intent == INTENT_QUERY_DELETED_COUNTIES) {
		queryDeletedCounties ( $action, $client );
	}
	if ($intent == INTENT_UPDATE_COUNTY_NAMES) {
		updateCountyNames ( $action, $client );
	}
	if ($intent == INTENT_STAGE_SELECTED_COUNTY_FOR_EDITING) {
		stageSelectedCounty ( $action, $client );
	}
	if ($intent == INTENT_TRASH_COUNTY) {
		trashCounty ( $action, $client );
	}
	if ($intent == INTENT_ERASE_COUNTY) {
		eraseCounty ( $action, $client );
	}
	if ($intent == INTENT_RESTORE_COUNTY) {
		restoreCounty ( $action, $client );
	}
}
function insertCounty($action, $client) {
	$county_name = $_POST ['county_name'];
	$county_headquarters = $_POST ['county_headquarters'];
	
	$county = new County ( $action, $client );
	$trashed = 0;
	$deleted = 0;
	$first_created = date ( "Y-m-d h:i:s" );
	$last_modified = date ( "Y-m-d h:i:s" );
	echo $county->insert_prepared_records ( $county_name, $county_headquarters, $trashed, $deleted, $first_created, $last_modified, true, false );
}
function queryCounties($action, $client) {
	$county = new County ( $action, $client );
	$search_key = $_POST ['search_key'];
	$result_format = $_POST [RESULT_FORMAT];
	
	$counties = null;
	
	if ($search_key == "") {
		$counties = $county->query_from_county ( array (
				"trashed",
				"deleted" 
		), array (
				0,
				0 
		), " ORDER BY `last_modified` DESC " );
	} else {
		$columns = array (
				"county_name",
				"county_headquarters" 
		);
		$records = array (
				$search_key,
				$search_key 
		);
		
		$extraSQL = " AND `trashed`='0' AND `deleted`='0'  ORDER BY `last_modified` DESC ";
		
		$counties = $county->search_in_county ( $columns, $records, $extraSQL );
	}
	
	$countyHTML = "";
	$count = 1;
	$iterated = false;
	if ($result_format == RESULT_FORMAT_TABLE_ROWS) {
		if (count ( $counties ) > 0) {
			foreach ( $counties as $countyinfo ) {
				if ($countyinfo ["trashed"] == 1 || $countyinfo ["deleted"] == 1) {
					continue;
				}
				if ($search_key == "") {
					$countyHTML .= "<tr><td>" . $count . "</td><td>" . $countyinfo ['county_name'] . "</td><td>" . $countyinfo ['county_headquarters'] . "</td>
					<td>
						<button class=\"btn btn-outline btn-info btn-sm  \" onclick=editCounty(" . $countyinfo ['id_county'] . ")>Edit</button>
					</td>
					<td>
						<button class=\"btn btn-outline btn-warning btn-sm  \" onclick=deleteCounty(" . $countyinfo ['id_county'] . ")>Delete</button>
					</td>
					</tr>";
				} else {
					$countyHTML .= "<tr><td>" . $count . "</td><td>" . highligh_search_text ( $search_key, $countyinfo ['county_name'] ) . "</td><td>" . highligh_search_text ( $search_key, $countyinfo ['county_headquarters'] ) . "</td>
					<td>
						<button class=\"btn btn-outline btn-info btn-sm  \" onclick=editCounty(" . $countyinfo ['id_county'] . ")>Edit</button>
					</td>
					<td>
						<button class=\"btn btn-outline btn-warning btn-sm  \" onclick=deleteCounty(" . $countyinfo ['id_county'] . ")>Delete</button>
					</td>
					</tr>";
				}
				$count ++;
				$iterated = true;
			}
		} else {
			if ($search_key == "") {
				$countyHTML .= '<tr><td colspan="99"><label>There are no counties</label></td></tr>';
			} else {
				$countyHTML .= '<tr><td colspan="99">Oops! No county named as <label style="color:red;">' . $search_key . '</label></td></tr>';
			}
		}
		
		// Nothing found or did not iterate --
		if ($count == 1 && $iterated) {
			$countyHTML .= '<tr><td colspan="99">Oops! No county named as <label style="color:red;">' . $search_key . '</label></td></tr>';
		}
	}
	
	$count = 1;
	if ($result_format == RESULT_FORMAT_DROPDOWN) {
		if (count ( $counties ) > 0) {
			foreach ( $counties as $countyinfo ) {
				if ($countyinfo ["trashed"] == 1 || $countyinfo ["deleted"] == 1) {
					continue;
				}
				$countyHTML .= '<option value="' . $countyinfo ['id_county'] . '" >' . $countyinfo ['county_name'] . '</option>';
				$count ++;
			}
		}
	}
	
	echo $countyHTML;
}
function queryDeletedCounties($action, $client) {
	$county = new County ( $action, $client );
	$search_key = $_POST ['search_key'];
	
	$counties = null;
	
	if ($search_key == "") {
		$counties = $county->query_from_county ( array (
				"trashed",
				"deleted" 
		), array (
				1,
				0 
		), " ORDER BY `last_modified` DESC " );
	} else {
		$columns = array (
				"county_name",
				"county_headquarters" 
		);
		$records = array (
				$search_key,
				$search_key 
		);
		
		$extraSQL = " AND `trashed`='1' AND `deleted`='0' ORDER BY `last_modified` DESC";
		
		$counties = $county->search_in_county ( $columns, $records, $extraSQL );
	}
	
	$countyHTML = "";
	$count = 1;
	$iterated = false;
	if (count ( $counties ) > 0) {
		foreach ( $counties as $countyinfo ) {
			
			if ($countyinfo ["trashed"] == 0 || $countyinfo ["deleted"] == 1) {
				continue;
			}
			
			if ($search_key == "") {
				$countyHTML .= "<tr><td>" . $count . "</td><td>" . $countyinfo ['county_name'] . "</td><td>" . $countyinfo ['county_headquarters'] . "</td>
					<td>
						<button class=\"btn btn-outline btn-success btn-sm \" onclick=restoreCounty(" . $countyinfo ['id_county'] . ")>Restore</button>
					</td>
					<td>
						<button class=\"btn btn-outline btn-danger btn-sm  \" onclick=eraseCounty(" . $countyinfo ['id_county'] . ")>Erase</button>
					</td>
					</tr>";
			} else {
				$countyHTML .= "<tr><td>" . $count . "</td><td>" . highligh_search_text ( $search_key, $countyinfo ['county_name'] ) . "</td><td>" . highligh_search_text ( $search_key, $countyinfo ['county_headquarters'] ) . "</td>
					<td>
						<button class=\"btn btn-outline btn-success btn-sm \" onclick=restoreCounty(" . $countyinfo ['id_county'] . ")>Restore</button>
					</td>
					<td>
						<button class=\"btn btn-outline btn-danger btn-sm  \" onclick=eraseCounty(" . $countyinfo ['id_county'] . ")>Erase</button>
					</td>
					</tr>";
			}
			$count ++;
			$iterated = true;
		}
	} else {
		if ($search_key == "") {
			$countyHTML .= '<tr><td colspan="99"><label>There are no deleted counties</label></td></tr>';
		} else {
			$countyHTML .= '<tr><td colspan="99">Oops! No deleted county named as <label style="color:red;">' . $search_key . '</label></td></tr>';
		}
	}
	
	// Nothing found or did not iterate
	if ($count == 1 && $iterated) {
		$countyHTML .= '<tr><td colspan="99">Oops! No deleted county named as <label style="color:red;">' . $search_key . '</label></td></tr>';
	}
	echo $countyHTML;
}
function stageSelectedCounty($action, $client) {
	$county = new County ( $action, $client );
	$extra_county = $_POST ['extra_county'];
	
	$id_county = $extra_county;
	$county_name = $county->get_county_name ( $id_county );
	$county_headquarters = $county->get_county_headquarters ( $id_county );
	
	$county_info = array (
			"county_name" => $county_name,
			"county_headquarters" => $county_headquarters 
	);
	
	echo json_encode ( $county_info );
}
function updateCountyNames($action, $client) {
	$county_name = $_POST ['county_name'];
	$county_headquarters = $_POST ['county_headquarters'];
	
	$columns = array (
			"county_name",
			"county_headquarters" 
	);
	$records = array (
			$county_name,
			$county_headquarters 
	);
	
	return updateCounty ( $action, $client, $columns, $records );
}
function trashCounty($action, $client) {
	$columns = array (
			"trashed",
			"deleted" 
	);
	$records = array (
			1,
			0 
	);
	
	return updateCounty ( $action, $client, $columns, $records );
}
function restoreCounty($action, $client) {
	$columns = array (
			"trashed",
			"deleted" 
	);
	$records = array (
			0,
			0 
	);
	
	return updateCounty ( $action, $client, $columns, $records );
}
function eraseCounty($action, $client) {
	$columns = array (
			"trashed",
			"deleted" 
	);
	$records = array (
			1,
			1 
	);
	return updateCounty ( $action, $client, $columns, $records );
}
function updateCounty($action, $client, $columns, $records) {
	$county = new County ( $action, $client );
	$extra_county = $_POST ['extra_county'];
	
	$columns [count ( $columns )] = "last_modified";
	$records [count ( $records )] = date ( "Y-m-d h:i:s" );
	
	$where_columns = array (
			"id_county" 
	);
	$where_records = array (
			$extra_county 
	);
	return $county->update_record_in_county ( $columns, $records, $where_columns, $where_records );
}
function highligh_search_text($search_key, $search_results) {
	if ($search_key == "") {
		return $search_results;
	}
	return str_replace ( $search_key, '<b style="color:blue;">' . $search_key . '</b>', $search_results );
}
?>