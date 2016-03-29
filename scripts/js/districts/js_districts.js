/**
 * Created by victor on 2/17/2016.
 */

/**
 * Global Variables
 */

DISTRICT_SAVE_TYPE = "save_type";
SAVE_TYPE_INSERT = "save_type_insert";
SAVE_TYPE_UPDATE = "save_type_update";
SAVE_TYPE_TRASH = "save_type_trash";
SAVE_TYPE_DELETE = "save_type_delete";

EXTRA_COUNTY = "extra_county";
EXTRA_DISTRICT = "extra_district";
SEARCH_KEY = "search_key";

INTENT_QUERY_COUNTIES = "query_counties";
INTENT_UPDATE_DISTRICT_NAMES = "update_district_names";
INTENT_INSERT_DISTRICT = "insert_district";
INTENT_QUERY_DISTRICTS = "query_districts";
INTENT_QUERY_DELETED_DISTRICTS = "query_deleted_districts";
INTENT_STAGE_SELECTED_DISTRICT_FOR_EDITING = "stage_selected_district_for_editing";
INTENT_TRASH_DISTRICT = "trash_district";
INTENT_ERASE_DISTRICT = "erase_district";
INTENT_RESTORE_DISTRICT = "restore_district";

// Event listener for onpage loaded
addEventListener("load", init, false);

function init() {

	checkForAuthenctication();

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

	// populateDistricts
	populateDistricts();

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
	case INTENT_INSERT_DISTRICT:
	case INTENT_UPDATE_DISTRICT_NAMES:
		document.getElementById('input_district_name').value = "";
		document.getElementById('input_district_headquarters').value = "";
		setDefaultSaveType();
		populateDistricts();
		break;
	case INTENT_QUERY_COUNTIES:
		setCounties(response);
	case INTENT_TRASH_DISTRICT:
	case INTENT_ERASE_DISTRICT:
	case INTENT_RESTORE_DISTRICT:
		populateDistricts();
	case INTENT_QUERY_DISTRICTS:
		document.getElementById('id_table_body_districts').innerHTML = response;
		// $('#id_table_body_districts').text(response);
		populateTrashedDistricts();
		break;
	case INTENT_QUERY_DELETED_DISTRICTS:
		document.getElementById('id_table_body_deleted_districts').innerHTML = response;
		break;
	case INTENT_STAGE_SELECTED_DISTRICT_FOR_EDITING:
		stageSelectedDistrictForEditing(response);
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
	setCache(DISTRICT_SAVE_TYPE, SAVE_TYPE_INSERT);
}
// add text changed listeners for search
function addSearchTextChangedListener() {
	document.getElementById("id_input_search_district").addEventListener(
			"input", populateDistricts, false);
	document.getElementById("id_input_search_deleted_district")
			.addEventListener("input", populateTrashedDistricts, false);
}

// add button click listeners
function addButtonsClickListeners() {
	$('#button_save_district').click(function(e) {
		saveDistrict();
	});

}
// add drop down select listeners
function addDropDownSelectListeners() {

	$('#select_filter_districts_by_county').change(function(e) {
		populateDistricts();
	});

	$('#select_filter_deleted_districts_by_county').click(function(e) {
		populateTrashedDistricts();
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
	document.getElementById('select_filter_districts_by_county').innerHTML = noCountyFilters
			+ response;
	document.getElementById('select_filter_deleted_districts_by_county').innerHTML = noCountyFilters
			+ response;
}
/**
 * Save district
 */
function saveDistrict() {

	var county = $('#select_counties').val();
	var districtName = $('#input_district_name').val();
	var districtHqs = $('#input_district_headquarters').val();

	var saveType = localStorage.getItem(DISTRICT_SAVE_TYPE);

	var params = "district_name=" + districtName + "&district_headquarters="
			+ districtHqs + "&county=" + county;

	switch (saveType) {
	case SAVE_TYPE_UPDATE:
		params += "&" + ACTION_TYPE + "=" + ACTION_UPDATE + "&"
				+ EXTRA_DISTRICT + "=" + getSelectedDistrict();
		sendPOSTHttpRequest(DISTRICTS_URL, params, INTENT_UPDATE_DISTRICT_NAMES);
		break;
	case SAVE_TYPE_INSERT:
		params += "&" + ACTION_TYPE + "=" + ACTION_INSERT;
		sendPOSTHttpRequest(DISTRICTS_URL, params, INTENT_INSERT_DISTRICT);
		break;

	default:
		break;
	}
}

/**
 * Get the selected district
 * 
 * @returns district identifier
 */
function getSelectedDistrict() {
	return getCache(EXTRA_DISTRICT);
}

/**
 * Sets the selected district
 * 
 * @param extraDistrict
 */
function setSelectedDistrict(extraDistrict) {
	setCache(EXTRA_DISTRICT, extraDistrict);
}
/**
 * Reads all the districts and shows them on the page
 */
function populateDistricts() {

	var countyId = $('#select_filter_districts_by_county').val();
	var searchDistrict = $("#id_input_search_district").val();

	request_url = DISTRICTS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&" + SEARCH_KEY + "="
			+ searchDistrict + "&county=" + countyId;
	request_intent = INTENT_QUERY_DISTRICTS;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}

/**
 * Reads all the trashed districts and shows them on the page
 */
function populateTrashedDistricts() {

	var countyId = $('#select_filter_deleted_districts_by_county').val();
	var searchDistrict = $("#id_input_search_deleted_district").val();

	request_url = DISTRICTS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&" + SEARCH_KEY + "="
			+ searchDistrict + "&county=" + countyId;
	request_intent = INTENT_QUERY_DELETED_DISTRICTS;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}

function editDistrict(districtId) {

	setSelectedDistrict(districtId);

	request_url = DISTRICTS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&" + EXTRA_DISTRICT
			+ "=" + districtId;
	request_intent = INTENT_STAGE_SELECTED_DISTRICT_FOR_EDITING;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}
function deleteDistrict(districtId) {

	setSelectedDistrict(districtId);

	request_url = DISTRICTS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_UPDATE + "&" + EXTRA_DISTRICT
			+ "=" + districtId;
	request_intent = INTENT_TRASH_DISTRICT;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}
function eraseDistrict(districtId) {

	setSelectedDistrict(districtId);

	request_url = DISTRICTS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_UPDATE + "&" + EXTRA_DISTRICT
			+ "=" + districtId;
	request_intent = INTENT_ERASE_DISTRICT;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}

function restoreDistrict(districtId) {

	setSelectedDistrict(districtId);

	request_url = DISTRICTS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_UPDATE + "&" + EXTRA_DISTRICT
			+ "=" + districtId;
	request_intent = INTENT_RESTORE_DISTRICT;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}

function stageSelectedDistrictForEditing(response) {

	setCache(DISTRICT_SAVE_TYPE, SAVE_TYPE_UPDATE);

	var responseJson = eval("(" + response + ")");

	var districtName = responseJson.district_name;
	var districtHqs = responseJson.district_headquarters;

	document.getElementById('input_district_name').value = districtName;
	document.getElementById('input_district_headquarters').value = districtHqs;
}