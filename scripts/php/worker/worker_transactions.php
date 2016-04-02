<?php
include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/core-apis/DatabaseActions.class.inc.php';

if (! class_exists ( 'TitleDeeds' ))
	include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/TitleDeeds.class.php';
if (! class_exists ( 'LandOwners' ))
	include $_SERVER ['DOCUMENT_ROOT'] . '/titledeeds/scripts/php/database/crud/LandOwners.class.php';

define ( "INTENT_EXECUTE_TITLE_DEED_TRANSACTION", "intent_execute_title_deed_transaction" );

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
	if ($intent == INTENT_EXECUTE_TITLE_DEED_TRANSACTION) {
		startLandTransfer ( $action, $client );
	}
}

/**
 * Start land transfer
 *
 * @param unknown $action        	
 * @param unknown $client        	
 */
function startLandTransfer($action, $client) {
	$titledeeds = new TitleDeeds ( $action, $client );
	$land_owners = new LandOwners ( $action, $client );
	
	$newlandowner = $_POST ['new_land_owner'];
	$transferType = $_POST ['transferType'];
	$titleDeedId = $_POST ['titledeed'];
	$oldLandOwner = $_POST ['old_land_owner'];
	$approximateArea = $_POST ['approximate_area'];
	$areaUnits = $_POST ['areaUnits'];
	
	$title_deed_infos = $titledeeds->query_from_title_deeds ( array (
			"id_title_deed" 
	), array (
			$titleDeedId 
	) );
	
	$new_land_owner_infos = $land_owners->query_from_land_owners ( array (
			'idnumber' 
	), array($newlandowner ));
	$new_land_owner_user_id = $new_land_owner_infos [0] ['id_land_owner'];
	
	if ($transferType == "Full land Transfer") {
		$title_deed_transfer_infos = $titledeeds->update_record_in_title_deeds ( array (
				"land_owner" 
		), array (
				$new_land_owner_user_id 
		), array (
				"id_title_deed" 
		), array (
				$titleDeedId 
		) );
		
		if ($title_deed_transfer_infos == 1) {
			echo "Land fully transferred to " . $new_land_owner_infos [0] ['firstname'] . " " . $new_land_owner_infos [0] ['lastname'] . " " . $new_land_owner_infos [0] ['address'];
		}
	}
	if ($transferType == "Land Partition") {
		$land_old_approximate_area = $titledeeds->get_approximate_area ( $titleDeedId );
		$land_old_area_units = $titledeeds->get_area_units ( $titleDeedId );
		
		if ($land_old_area_units != $areaUnits) {
			$land_old_approximate_area = convertLandIntoHectares ( $land_old_approximate_area, $land_old_area_units );
			$approximateArea = convertLandIntoHectares ( $approximateArea, $areaUnits );
		}
		
		if ($approximateArea > $land_old_approximate_area) {
			echo "You cannot transfer " . $approximateArea . " ha of available " . $land_old_approximate_area . " ha. Reduce the value by " . ($approximateArea - $land_old_approximate_area) . " to perform full land transfer";
			return;
		}
		
		if ($approximateArea == $land_old_approximate_area) {
			$title_deed_transfer_infos = $titledeeds->update_record_in_title_deeds ( array (
					"land_owner" 
			), array (
					$new_land_owner_user_id 
			), array (
					"id_title_deed" 
			), array (
					$titleDeedId 
			) );
			
			if ($title_deed_transfer_infos == 1) {
				echo "Land fully transferred to " . $new_land_owner_infos [0] ['firstname'] . " " . $new_land_owner_infos [0] ['lastname'] . " " . $new_land_owner_infos [0] ['address'];
			}
		}
		
		if ($approximateArea < $land_old_approximate_area) {
			
			$title_deed_transfer_infos = $titledeeds->update_record_in_title_deeds ( array (
					'approximate_area',
					'area_units' 
			), array (
					($land_old_approximate_area - $approximateArea),
					'Ha' 
			), array (
					"id_title_deed" 
			), array (
					$titleDeedId 
			) );
			
			$edition = $title_deed_infos [0] ['edition'];
			$opened = $title_deed_infos [0] ['opened'];
			$registration_section = $title_deed_infos [0] ['registration_section'];
			$parcel_number = $title_deed_infos [0] ['parcel_number'];
			$plot_number = $title_deed_infos [0] ['plot_number'];
			$registy_map_sheet_number = $title_deed_infos [0] ['registy_map_sheet_number'];
			
			$columns = array (
					'approximate_area',
					'area_units',
					'land_owner',
					'edition',
					'opened',
					'registration_section',
					'parcel_number',
					'plot_number',
					'registy_map_sheet_number' 
			);
			$records = array (
					$approximateArea,
					'Ha',
					$new_land_owner_user_id,
					$edition,
					$opened,
					$registration_section,
					$parcel_number,
					$plot_number,
					$registy_map_sheet_number 
			);
			
			$titledeeds->insert_records_to_title_deeds ( $columns, $records, true, false );
			
			echo 'Land Partitioned Successfully';
		}
	}
}

/**
 * Converts the land to all use the same units
 *
 * @param unknown $approximateArea        	
 * @param unknown $areaUnits        	
 */
function convertLandIntoHectares($approximateArea, $areaUnits) {
	if ($areaUnits == "Acres") {
		return $approximateArea / 100;
	}
	if ($areaUnits == "Ha") {
		return $approximateArea;
	}
	if ($areaUnits == "flats") {
		return $approximateArea / 10000;
	}
}
?>