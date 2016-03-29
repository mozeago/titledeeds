<?php
include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/core-apis/DatabaseActions.class.inc.php';
include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/Wards.class.php';

define ( 'RESULT_FORMAT', 'result_format' );
define ( 'RESULT_FORMAT_DROPDOWN', 'dropdown_format' );
define ( 'RESULT_FORMAT_TABLE_ROWS', 'table_rows_format' );
define ( 'RESULT_FORMAT_ORDERED_LIST', 'ordered_list_format' );
define ( 'RESULT_FORMAT_UNORDERED_LIST', 'unordered_list_format' );

define ( 'INTENT_UPDATE_WARD_NAMES', 'update_ward_names' );
define ( 'INTENT_INSERT_WARD', 'insert_ward' );
define ( 'INTENT_QUERY_WARDS', 'query_wards' );
define ( 'INTENT_QUERY_DELETED_WARDS', 'query_deleted_wards' );
define ( 'INTENT_STAGE_SELECTED_WARD_FOR_EDITING', 'stage_selected_ward_for_editing' );
define ( 'INTENT_TRASH_WARD', 'trash_ward' );
define ( 'INTENT_ERASE_WARD', 'erase_ward' );
define ( 'INTENT_RESTORE_WARD', 'restore_ward' );

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
	if ($intent == INTENT_INSERT_WARD) {
		insertWard ( $action, $client );
	}
	if ($intent == INTENT_QUERY_WARDS) {
		queryWards ( $action, $client );
	}
	if ($intent == INTENT_QUERY_DELETED_WARDS) {
		queryDeletedWards ( $action, $client );
	}
	if ($intent == INTENT_UPDATE_WARD_NAMES) {
		updateWardNames ( $action, $client );
	}
	if ($intent == INTENT_STAGE_SELECTED_WARD_FOR_EDITING) {
		stageSelectedWard ( $action, $client );
	}
	if ($intent == INTENT_TRASH_WARD) {
		trashWard ( $action, $client );
	}
	if ($intent == INTENT_ERASE_WARD) {
		eraseWard ( $action, $client );
	}
	if ($intent == INTENT_RESTORE_WARD) {
		restoreWard ( $action, $client );
	}
}
function insertWard($action, $client) {
	$id_county = $_POST ['county'];
	$ward_name = $_POST ['ward_name'];
	$ward_headquarters = $_POST ['ward_headquarters'];
	
	$ward = new Wards ( $action, $client );
	$trashed = 0;
	$deleted = 0;
	$first_created = date ( "Y-m-d h:i:s" );
	$last_modified = date ( "Y-m-d h:i:s" );
	echo $ward->insert_prepared_records ( $id_county, $ward_name, $ward_headquarters, $trashed, $deleted, $first_created, $last_modified, true, false );
}
function queryWards($action, $client) {
	$ward = new Wards ( $action, $client );
	
	$search_key = $_POST ['search_key'];
	$county = $_POST ['county'];
	$wards = null;
	
	if ($search_key == "") {
		if ($county == "-1") {
			$wards = $ward->query_from_wards ( array (
					"trashed",
					"deleted" 
			), array (
					0,
					0 
			), "  ORDER BY `last_modified` DESC" );
		} else {
			$wards = $ward->query_from_wards ( array (
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
					"ward_name",
					"ward_headquarters" 
			);
			$records = array (
					$search_key,
					$search_key 
			);
			
			$extraSQL = " AND `trashed`='0' AND `deleted`='0'  ORDER BY `last_modified` DESC ";
			
			$wards = $ward->search_in_wards ( $columns, $records, $extraSQL );
		} else {
			$columns = array (
					"ward_name",
					"ward_headquarters" 
			);
			$records = array (
					$search_key,
					$search_key 
			);
			
			$extraSQL = " AND `trashed`='0' AND `deleted`='0'  ORDER BY `last_modified` DESC ";
			
			$wards = $ward->search_in_wards ( $columns, $records, $extraSQL );
		}
	}
	
	$wardHTML = "";
	$count = 1;
	$iterated = false;
	if ($_POST [RESULT_FORMAT] == RESULT_FORMAT_TABLE_ROWS) {
		if (count ( $wards ) > 0) {
			foreach ( $wards as $wardinfo ) {
				if ($wardinfo ["trashed"] == 1 || $wardinfo ["deleted"] == 1) {
					continue;
				}
				if ($county != "-1") {
					if ($wardinfo ["id_county"] != $county) {
						continue;
					}
				}
				if ($search_key == "") {
					$wardHTML .= "<tr><td>" . $count . "</td><td>" . $wardinfo ['ward_name'] . "</td><td>" . $wardinfo ['ward_headquarters'] . "</td>
					<td>
						<button class=\"btn btn-outline btn-info btn-sm  \" onclick=editWard(" . $wardinfo ['id_ward'] . ")>Edit</button>
					</td>
					<td>
						<button class=\"btn btn-outline btn-warning btn-sm  \" onclick=deleteWard(" . $wardinfo ['id_ward'] . ")>Delete</button>
					</td>
					</tr>";
				} else {
					$wardHTML .= "<tr><td>" . $count . "</td><td>" . highligh_search_text ( $search_key, $wardinfo ['ward_name'] ) . "</td><td>" . highligh_search_text ( $search_key, $wardinfo ['ward_headquarters'] ) . "</td>
					<td>
						<button class=\"btn btn-outline btn-info btn-sm  \" onclick=editWard(" . $wardinfo ['id_ward'] . ")>Edit</button>
					</td>
					<td>
						<button class=\"btn btn-outline btn-warning btn-sm  \" onclick=deleteWard(" . $wardinfo ['id_ward'] . ")>Delete</button>
					</td>
					</tr>";
				}
				$count ++;
				$iterated = true;
			}
		} else {
			if ($search_key == "") {
				$wardHTML .= '<tr><td colspan="99"><label>There are no wards</label></td></tr>';
			} else {
				$wardHTML .= '<tr><td colspan="99">Oops! No ward named as <label style="color:red;">' . $search_key . '</label></td></tr>';
			}
		}
		
		// Nothing found or did not iterate --
		if ($count == 1 && $iterated) {
			$wardHTML .= '<tr><td colspan="99">Oops! No ward named as <label style="color:red;">' . $search_key . '</label></td></tr>';
		}
	}
	
	if ($_POST [RESULT_FORMAT] == RESULT_FORMAT_DROPDOWN) {
		
		if (count ( $wards ) > 0) {
			foreach ( $wards as $wardinfo ) {
				if ($wardinfo ["trashed"] == 1 || $wardinfo ["deleted"] == 1) {
					continue;
				}
				if ($county != "-1") {
					if ($wardinfo ["id_county"] != $county) {
						continue;
					}
				}
				
				$wardHTML .= '<option value="' . $wardinfo ['id_ward'] . '">' . $wardinfo ['ward_name'] . '</option>';
				
				$count ++;
			}
		}
	}
	echo $wardHTML;
}
function queryDeletedWards($action, $client) {
	$ward = new Wards ( $action, $client );
	
	$search_key = $_POST ['search_key'];
	$county = $_POST ['county'];
	
	$wards = null;
	
	if ($search_key == "") {
		
		if ($county == "-1") {
			$wards = $ward->query_from_wards ( array (
					"trashed",
					"deleted" 
			), array (
					1,
					0 
			) );
		} else {
			$wards = $ward->query_from_wards ( array (
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
					"ward_name",
					"ward_headquarters" 
			);
			$records = array (
					$search_key,
					$search_key 
			);
			
			$extraSQL = " AND `trashed`='1' AND `deleted`='0' ORDER BY `last_modified` DESC";
			
			$wards = $ward->search_in_wards ( $columns, $records, $extraSQL );
		} else {
			$columns = array (
					"ward_name",
					"ward_headquarters" 
			);
			$records = array (
					$search_key,
					$search_key 
			);
			
			$extraSQL = " AND `trashed`='1' AND `deleted`='0' ORDER BY `last_modified` DESC";
			
			$wards = $ward->search_in_wards ( $columns, $records, $extraSQL );
		}
	}
	
	$wardHTML = "";
	$count = 1;
	$iterated = false;
	if (count ( $wards ) > 0) {
		foreach ( $wards as $wardinfo ) {
			
			if ($wardinfo ["trashed"] == 0 || $wardinfo ["deleted"] == 1) {
				continue;
			}
			if ($county != "-1") {
				if ($wardinfo ["id_county"] != $county) {
					continue;
				}
			}
			
			if ($search_key == "") {
				$wardHTML .= "<tr><td>" . $count . "</td><td>" . $wardinfo ['ward_name'] . "</td><td>" . $wardinfo ['ward_headquarters'] . "</td>
					<td>
						<button class=\"btn btn-outline btn-success btn-sm \" onclick=restoreWard(" . $wardinfo ['id_ward'] . ")>Restore</button>
					</td>
					<td>
						<button class=\"btn btn-outline btn-danger btn-sm  \" onclick=eraseWard(" . $wardinfo ['id_ward'] . ")>Erase</button>
					</td>
					</tr>";
			} else {
				$wardHTML .= "<tr><td>" . $count . "</td><td>" . highligh_search_text ( $search_key, $wardinfo ['ward_name'] ) . "</td><td>" . highligh_search_text ( $search_key, $wardinfo ['ward_headquarters'] ) . "</td>
					<td>
						<button class=\"btn btn-outline btn-success btn-sm \" onclick=restoreWard(" . $wardinfo ['id_ward'] . ")>Restore</button>
					</td>
					<td>
						<button class=\"btn btn-outline btn-danger btn-sm  \" onclick=eraseWard(" . $wardinfo ['id_ward'] . ")>Erase</button>
					</td>
					</tr>";
			}
			
			$count ++;
			$iterated = true;
		}
	} else {
		if ($search_key == "") {
			$wardHTML .= '<tr><td colspan="99"><label>There are no deleted wards</label></td></tr>';
		} else {
			$wardHTML .= '<tr><td colspan="99">Oops! No deleted ward named as <label style="color:red;">' . $search_key . '</label></td></tr>';
		}
	}
	
	// Nothing found or did not iterate
	if ($count == 1 && $iterated) {
		$wardHTML .= '<tr><td colspan="99">Oops! No deleted ward named as <label style="color:red;">' . $search_key . '</label></td></tr>';
	}
	echo $wardHTML;
}
function stageSelectedWard($action, $client) {
	$ward = new Wards ( $action, $client );
	$extra_ward = $_POST ['extra_ward'];
	
	$id_ward = $extra_ward;
	$ward_name = $ward->get_ward_name ( $id_ward );
	$ward_headquarters = $ward->get_ward_headquarters ( $id_ward );
	
	$ward_info = array (
			"ward_name" => $ward_name,
			"ward_headquarters" => $ward_headquarters 
	);
	
	echo json_encode ( $ward_info );
}
function updateWardNames($action, $client) {
	$id_county = $_POST ['county'];
	$ward_name = $_POST ['ward_name'];
	$ward_headquarters = $_POST ['ward_headquarters'];
	
	$columns = array (
			"id_county",
			"ward_name",
			"ward_headquarters" 
	);
	$records = array (
			$id_county,
			$ward_name,
			$ward_headquarters 
	);
	
	return updateWard ( $action, $client, $columns, $records );
}
function trashWard($action, $client) {
	$columns = array (
			"trashed",
			"deleted" 
	);
	$records = array (
			1,
			0 
	);
	
	return updateWard ( $action, $client, $columns, $records );
}
function restoreWard($action, $client) {
	$columns = array (
			"trashed",
			"deleted" 
	);
	$records = array (
			0,
			0 
	);
	
	return updateWard ( $action, $client, $columns, $records );
}
function eraseWard($action, $client) {
	$columns = array (
			"trashed",
			"deleted" 
	);
	$records = array (
			1,
			1 
	);
	return updateWard ( $action, $client, $columns, $records );
}
function updateWard($action, $client, $columns, $records) {
	$ward = new Wards ( $action, $client );
	$extra_ward = $_POST ['extra_ward'];
	
	$columns [count ( $columns )] = "last_modified";
	$records [count ( $records )] = date ( "Y-m-d h:i:s" );
	
	$where_columns = array (
			"id_ward" 
	);
	$where_records = array (
			$extra_ward 
	);
	return $ward->update_record_in_wards ( $columns, $records, $where_columns, $where_records );
}
function highligh_search_text($search_key, $search_results) {
	if ($search_key == "") {
		return $search_results;
	}
	return str_replace ( $search_key, '<b style="color:blue;">' . $search_key . '</b>', $search_results );
}
?>