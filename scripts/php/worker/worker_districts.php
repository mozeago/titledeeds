<?php
include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/core-apis/DatabaseActions.class.inc.php';
include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/District.class.php';

define ( 'RESULT_FORMAT', 'result_format' );
define ( 'RESULT_FORMAT_DROPDOWN', 'dropdown_format' );
define ( 'RESULT_FORMAT_TABLE_ROWS', 'table_rows_format' );
define ( 'RESULT_FORMAT_ORDERED_LIST', 'ordered_list_format' );
define ( 'RESULT_FORMAT_UNORDERED_LIST', 'unordered_list_format' );

define ( 'INTENT_UPDATE_DISTRICT_NAMES', 'update_district_names' );
define ( 'INTENT_INSERT_DISTRICT', 'insert_district' );
define ( 'INTENT_QUERY_DISTRICTS', 'query_districts' );
define ( 'INTENT_QUERY_DELETED_DISTRICTS', 'query_deleted_districts' );
define ( 'INTENT_STAGE_SELECTED_DISTRICT_FOR_EDITING', 'stage_selected_district_for_editing' );
define ( 'INTENT_TRASH_DISTRICT', 'trash_district' );
define ( 'INTENT_ERASE_DISTRICT', 'erase_district' );
define ( 'INTENT_RESTORE_DISTRICT', 'restore_district' );

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
	if ($intent == INTENT_INSERT_DISTRICT) {
		insertDistrict ( $action, $client );
	}
	if ($intent == INTENT_QUERY_DISTRICTS) {
		queryDistricts ( $action, $client );
	}
	if ($intent == INTENT_QUERY_DELETED_DISTRICTS) {
		queryDeletedDistricts ( $action, $client );
	}
	if ($intent == INTENT_UPDATE_DISTRICT_NAMES) {
		updateDistrictNames ( $action, $client );
	}
	if ($intent == INTENT_STAGE_SELECTED_DISTRICT_FOR_EDITING) {
		stageSelectedDistrict ( $action, $client );
	}
	if ($intent == INTENT_TRASH_DISTRICT) {
		trashDistrict ( $action, $client );
	}
	if ($intent == INTENT_ERASE_DISTRICT) {
		eraseDistrict ( $action, $client );
	}
	if ($intent == INTENT_RESTORE_DISTRICT) {
		restoreDistrict ( $action, $client );
	}
}
function insertDistrict($action, $client) {
	$id_county = $_POST ['county'];
	$district_name = $_POST ['district_name'];
	$district_headquarters = $_POST ['district_headquarters'];
	
	$district = new District ( $action, $client );
	$trashed = 0;
	$deleted = 0;
	$first_created = date ( "Y-m-d h:i:s" );
	$last_modified = date ( "Y-m-d h:i:s" );
	echo $district->insert_prepared_records ( $id_county, $district_name, $district_headquarters, $trashed, $deleted, $first_created, $last_modified, true, false );
}
function queryDistricts($action, $client) {
	$district = new District ( $action, $client );
	
	$search_key = $_POST ['search_key'];
	$county = $_POST ['county'];
	
	$districts = null;
	
	if ($search_key == "") {
		if ($county == "-1") {
			$districts = $district->query_from_district ( array (
					"trashed",
					"deleted" 
			), array (
					0,
					0 
			), "  ORDER BY `last_modified` DESC" );
		} else {
			$districts = $district->query_from_district ( array (
					"id_county",
					"trashed",
					"deleted" 
			), array (
					$county,
					0,
					0 
			), "  ORDER BY `last_modified` DESC" );
		}
	} else {
		if ($county == "-1") {
			$columns = array (
					"district_name",
					"district_headquarters" 
			);
			$records = array (
					$search_key,
					$search_key 
			);
			
			$extraSQL = " AND `trashed`='0' AND `deleted`='0'  ORDER BY `last_modified` DESC ";
			
			$districts = $district->search_in_district ( $columns, $records, $extraSQL );
		} else {
			$columns = array (
					"district_name",
					"district_headquarters" 
			);
			$records = array (
					$search_key,
					$search_key 
			);
			
			$extraSQL = " AND `trashed`='0' AND `deleted`='0'  ORDER BY `last_modified` DESC ";
			
			$districts = $district->search_in_district ( $columns, $records, $extraSQL );
		}
	}
	
	$districtHTML = "";
	$count = 1;
	if (count ( $districts ) > 0) {
		foreach ( $districts as $districtinfo ) {
			if ($districtinfo ["trashed"] == 1 || $districtinfo ["deleted"] == 1) {
				continue;
			}
			if ($county != "-1") {
				if ($districtinfo ["id_county"] != $county) {
					continue;
				}
			}
			$districtHTML .= "<tr><td>" . $count . "</td><td>" . $districtinfo ['district_name'] . "</td><td>" . $districtinfo ['district_headquarters'] . "</td>
					<td>
						<button onclick=editDistrict(" . $districtinfo ['id_district'] . ")>Edit</button>
					</td>
					<td>
						<button onclick=deleteDistrict(" . $districtinfo ['id_district'] . ")>Delete</button>
					</td>
					</tr>";
			$count ++;
		}
	} else {
		if ($search_key == "") {
			$districtHTML .= '<tr><td colspan="99"><label>There are no districts</label></td></tr>';
		} else {
			$districtHTML .= '<tr><td colspan="99">Oops! No district named as <label style="color:red;">' . $search_key . '</label></td></tr>';
		}
	}
	
	// Nothing found or did not iterate --
	if ($count == 1) {
		$districtHTML .= '<tr><td colspan="99">Oops! No district named as <label style="color:red;">' . $search_key . '</label></td></tr>';
	}
	
	echo $districtHTML;
}
function queryDeletedDistricts($action, $client) {
	$district = new District ( $action, $client );
	
	$search_key = $_POST ['search_key'];
	$county = $_POST ['county'];
	
	$districts = null;
	
	if ($search_key == "") {
		
		if ($county == "-1") {
			$districts = $district->query_from_district ( array (
					"trashed",
					"deleted" 
			), array (
					1,
					0 
			) );
		} else {
			$districts = $district->query_from_district ( array (
					"id_county",
					"trashed",
					"deleted" 
			), array (
					$county,
					1,
					0 
			) );
		}
	} else {
		if ($county == "-1") {
			$columns = array (
					"district_name",
					"district_headquarters" 
			);
			$records = array (
					$search_key,
					$search_key 
			);
			
			$extraSQL = " AND `trashed`='1' AND `deleted`='0' ORDER BY `last_modified` DESC";
			
			$districts = $district->search_in_district ( $columns, $records, $extraSQL );
		} else {
			$columns = array (
					"district_name",
					"district_headquarters" 
			);
			$records = array (
					$search_key,
					$search_key 
			);
			
			$extraSQL = " AND `trashed`='1' AND `deleted`='0' ORDER BY `last_modified` DESC";
			
			$districts = $district->search_in_district ( $columns, $records, $extraSQL );
		}
	}
	
	$districtHTML = "";
	$count = 1;
	if (count ( $districts ) > 0) {
		foreach ( $districts as $districtinfo ) {
			
			if ($districtinfo ["trashed"] == 0 || $districtinfo ["deleted"] == 1) {
				continue;
			}
			if ($county != "-1") {
				if ($districtinfo ["id_county"] != $county) {
					continue;
				}
			}
			$districtHTML .= "<tr><td>" . $count . "</td><td>" . $districtinfo ['district_name'] . "</td><td>" . $districtinfo ['district_headquarters'] . "</td>
					<td>
						<button onclick=restoreDistrict(" . $districtinfo ['id_district'] . ")>Restore</button>
					</td>
					<td>
						<button onclick=eraseDistrict(" . $districtinfo ['id_district'] . ")>Erase</button>
					</td>
					</tr>";
			$count ++;
		}
	} else {
		if ($search_key == "") {
			$districtHTML .= '<tr><td colspan="99"><label>There are no deleted districts</label></td></tr>';
		} else {
			$districtHTML .= '<tr><td colspan="99">Oops! No deleted district named as <label style="color:red;">' . $search_key . '</label></td></tr>';
		}
	}
	
	// Nothing found or did not iterate
	if ($count == 1) {
		$districtHTML .= '<tr><td colspan="99">Oops! No deleted district named as <label style="color:red;">' . $search_key . '</label></td></tr>';
	}
	echo $districtHTML;
}
function stageSelectedDistrict($action, $client) {
	$district = new District ( $action, $client );
	$extra_district = $_POST ['extra_district'];
	
	$id_district = $extra_district;
	$district_name = $district->get_district_name ( $id_district );
	$district_headquarters = $district->get_district_headquarters ( $id_district );
	
	$district_info = array (
			"district_name" => $district_name,
			"district_headquarters" => $district_headquarters 
	);
	
	echo json_encode ( $district_info );
}
function updateDistrictNames($action, $client) {
	$id_county = $_POST ['county'];
	$district_name = $_POST ['district_name'];
	$district_headquarters = $_POST ['district_headquarters'];
	
	$columns = array (
			"id_county",
			"district_name",
			"district_headquarters" 
	);
	$records = array (
			$id_county,
			$district_name,
			$district_headquarters 
	);
	
	return updateDistrict ( $action, $client, $columns, $records );
}
function trashDistrict($action, $client) {
	$columns = array (
			"trashed",
			"deleted" 
	);
	$records = array (
			1,
			0 
	);
	
	return updateDistrict ( $action, $client, $columns, $records );
}
function restoreDistrict($action, $client) {
	$columns = array (
			"trashed",
			"deleted" 
	);
	$records = array (
			0,
			0 
	);
	
	return updateDistrict ( $action, $client, $columns, $records );
}
function eraseDistrict($action, $client) {
	$columns = array (
			"trashed",
			"deleted" 
	);
	$records = array (
			1,
			1 
	);
	return updateDistrict ( $action, $client, $columns, $records );
}
function updateDistrict($action, $client, $columns, $records) {
	$district = new District ( $action, $client );
	$extra_district = $_POST ['extra_district'];
	
	$columns [count ( $columns )] = "last_modified";
	$records [count ( $records )] = date ( "Y-m-d h:i:s" );
	
	$where_columns = array (
			"id_district" 
	);
	$where_records = array (
			$extra_district 
	);
	return $district->update_record_in_district ( $columns, $records, $where_columns, $where_records );
}
?>