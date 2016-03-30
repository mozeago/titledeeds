/**
 * Created by victor on 2/17/2016.
 */

/**
 * Global Variables
 */

WARD_SAVE_TYPE = "save_type";
SAVE_TYPE_INSERT = "save_type_insert";
SAVE_TYPE_UPDATE = "save_type_update";
SAVE_TYPE_TRASH = "save_type_trash";
SAVE_TYPE_DELETE = "save_type_delete";

EXTRA_COUNTY = "extra_county";
EXTRA_WARD = "extra_ward";
SEARCH_KEY = "search_key";

INTENT_QUERY_COUNTIES = "query_counties";
INTENT_UPDATE_WARD_NAMES = "update_ward_names";
INTENT_INSERT_WARD = "insert_ward";
INTENT_QUERY_WARDS = "query_wards";
INTENT_QUERY_DELETED_WARDS = "query_deleted_wards";
INTENT_STAGE_SELECTED_WARD_FOR_EDITING = "stage_selected_ward_for_editing";
INTENT_TRASH_WARD = "trash_ward";
INTENT_ERASE_WARD = "erase_ward";
INTENT_RESTORE_WARD = "restore_ward";

// Event listener for onpage loaded
addEventListener("load", init, false);

function init() {

	checkForAuthenctication();

	sendPOSTHttpRequest(WORKER_SCRIPT_URL, ACTION_TYPE + "=" + ACTION_TYPE,
			INTENT_INJECT_PAGE_NAVIGATION);

	// set default save type
	setDefaultSaveType();

	// add text changed listeners for search
	addSearchTextChangedListener();

	// add button click listeners
	addButtonsClickListeners();

	// add drop down select listeners
	addDropDownSelectListeners();

	// populateCounties
	populateCounties();

	// populateWards
	populateWards();

}

/**
 * Callback called when an http request is successful
 * 
 * @param request_intent
 *            the intent of the http request *
 * @param xhr
 *            an object of XML HTTP Request
 * @param response
 *            the response from the server
 */
function onSuccessfulXHR(request_intent, xhr, response) {

	// $('#id_notification_pane').text(response);

	switch (request_intent) {
	case INTENT_INJECT_PAGE_NAVIGATION:
		document.getElementById("page_navigation").innerHTML = response;
		break;
	case INTENT_INSERT_WARD:
	case INTENT_UPDATE_WARD_NAMES:
		document.getElementById('input_ward_name').value = "";
		document.getElementById('input_ward_headquarters').value = "";
		setDefaultSaveType();
		populateWards();
		window.location="landowners.html";
		break;
	case INTENT_QUERY_COUNTIES:
		setCounties(response);
	case INTENT_TRASH_WARD:
	case INTENT_ERASE_WARD:
	case INTENT_RESTORE_WARD:
		populateWards();
	case INTENT_QUERY_WARDS:
		document.getElementById('id_table_body_wards').innerHTML = response;
		// $('#id_table_body_wards').text(response);
		populateTrashedWards();
		break;
	case INTENT_QUERY_DELETED_WARDS:
		document.getElementById('id_table_body_deleted_wards').innerHTML = response;
		break;
	case INTENT_STAGE_SELECTED_WARD_FOR_EDITING:
		stageSelectedWardForEditing(response);
		break;
	default:
		alert("Undefined callback for intent [" + request_intent + "]");
		break;
	}
}
/**
 * Callback called when an http request failed
 * 
 * @param request_intent
 *            the intent of the http request *
 * @param xhr
 *            an object of XML HTTP Request
 */
function onFailedXHR(request_intent, xhr) {

}

// set default save type
function setDefaultSaveType() {
	setCache(WARD_SAVE_TYPE, SAVE_TYPE_INSERT);
}
// add text changed listeners for search
function addSearchTextChangedListener() {
	document.getElementById("id_input_search_ward").addEventListener("input",
			populateWards, false);
	document.getElementById("id_input_search_deleted_ward").addEventListener(
			"input", populateTrashedWards, false);
}

// add button click listeners
function addButtonsClickListeners() {
	$('#button_save_ward').click(function(e) {
		saveWard();
	});

}
// add drop down select listeners
function addDropDownSelectListeners() {

	$('#select_filter_wards_by_county').change(function(e) {
		populateWards();
	});

	$('#select_filter_deleted_wards_by_county').click(function(e) {
		populateTrashedWards();
	});

}
/**
 * Reads all the counties and shows them on the page
 */
function populateCounties() {
	var searchCounty = "";
	request_url = COUNTIES_URL;

	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&" + SEARCH_KEY + "="
			+ searchCounty + "&" + RESULT_FORMAT + "=" + RESULT_FORMAT_DROPDOWN;

	request_intent = INTENT_QUERY_COUNTIES;

	sendPOSTHttpRequest(request_url, request_params, request_intent);
}

function setCounties(response) {
	document.getElementById('select_counties').innerHTML = response;

	var noCountyFilters = '<option value="-1">All Counties</option>';
	document.getElementById('select_filter_wards_by_county').innerHTML = noCountyFilters
			+ response;
	document.getElementById('select_filter_deleted_wards_by_county').innerHTML = noCountyFilters
			+ response;
}

function isFormValid(county, wardName, wardHqs) {

	var formValid = true;
	
	if (county == "-1") {
		formValid = false;
		document.getElementById('label_county').style.color = "#FF0000";
	} else {
		document.getElementById('label_county').style.color = "#000000";
	}
	if (wardName.length < 3 || !isLetters(wardName)) {
		formValid = false;
		document.getElementById('label_ward').style.color = "#FF0000";
	} else {
		document.getElementById('label_ward').style.color = "#000000";
	}
	if (wardHqs.length < 3 || !isLetters(wardHqs)) {
		document.getElementById('label_ward_hqs').style.color = "#FF0000";
		formValid = false;
	} else {
		document.getElementById('label_ward_hqs').style.color = "#000000";
	}

	return formValid;
}
/**
 * Save ward
 */
function saveWard() {

	var county = $('#select_counties').val();
	var wardName = $('#input_ward_name').val();
	var wardHqs = $('#input_ward_headquarters').val();

	var saveType = localStorage.getItem(WARD_SAVE_TYPE);

	var params = "ward_name=" + wardName + "&ward_headquarters=" + wardHqs
			+ "&county=" + county;

	if (isFormValid(county, wardName, wardHqs)) {
		switch (saveType) {
		case SAVE_TYPE_UPDATE:
			params += "&" + ACTION_TYPE + "=" + ACTION_UPDATE + "&"
					+ EXTRA_WARD + "=" + getSelectedWard();
			sendPOSTHttpRequest(WARDS_URL, params, INTENT_UPDATE_WARD_NAMES);
			break;
		case SAVE_TYPE_INSERT:
			params += "&" + ACTION_TYPE + "=" + ACTION_INSERT;
			sendPOSTHttpRequest(WARDS_URL, params, INTENT_INSERT_WARD);
			break;

		default:
			break;
		}
	}

}

/**
 * Get the selected ward
 * 
 * @returns ward identifier
 */
function getSelectedWard() {
	return getCache(EXTRA_WARD);
}

/**
 * Sets the selected ward
 * 
 * @param extraWard
 */
function setSelectedWard(extraWard) {
	setCache(EXTRA_WARD, extraWard);
}
/**
 * Reads all the wards and shows them on the page
 */
function populateWards() {

	var countyId = $('#select_filter_wards_by_county').val();
	var searchWard = $("#id_input_search_ward").val();

	request_url = WARDS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&" + SEARCH_KEY + "="
			+ searchWard + "&county=" + countyId + "&" + RESULT_FORMAT + "="
			+ RESULT_FORMAT_TABLE_ROWS;
	request_intent = INTENT_QUERY_WARDS;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}

/**
 * Reads all the trashed wards and shows them on the page
 */
function populateTrashedWards() {

	var countyId = $('#select_filter_deleted_wards_by_county').val();
	var searchWard = $("#id_input_search_deleted_ward").val();

	request_url = WARDS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&" + SEARCH_KEY + "="
			+ searchWard + "&county=" + countyId;
	request_intent = INTENT_QUERY_DELETED_WARDS;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}

function editWard(wardId) {

	setSelectedWard(wardId);

	request_url = WARDS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&" + EXTRA_WARD + "="
			+ wardId;
	request_intent = INTENT_STAGE_SELECTED_WARD_FOR_EDITING;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}
function deleteWard(wardId) {

	setSelectedWard(wardId);

	request_url = WARDS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_UPDATE + "&" + EXTRA_WARD + "="
			+ wardId;
	request_intent = INTENT_TRASH_WARD;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}
function eraseWard(wardId) {

	setSelectedWard(wardId);

	request_url = WARDS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_UPDATE + "&" + EXTRA_WARD + "="
			+ wardId;
	request_intent = INTENT_ERASE_WARD;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}

function restoreWard(wardId) {

	setSelectedWard(wardId);

	request_url = WARDS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_UPDATE + "&" + EXTRA_WARD + "="
			+ wardId;
	request_intent = INTENT_RESTORE_WARD;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}

function stageSelectedWardForEditing(response) {

	setCache(WARD_SAVE_TYPE, SAVE_TYPE_UPDATE);

	var responseJson = eval("(" + response + ")");

	var wardName = responseJson.ward_name;
	var wardHqs = responseJson.ward_headquarters;

	document.getElementById('input_ward_name').value = wardName;
	document.getElementById('input_ward_headquarters').value = wardHqs;
}