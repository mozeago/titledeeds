/**
 * Created by victor on 2/17/2016.
 */

/**
 * Global Variables
 */

COUNTY_SAVE_TYPE = "save_type";
SAVE_TYPE_INSERT = "save_type_insert";
SAVE_TYPE_UPDATE = "save_type_update";
SAVE_TYPE_TRASH = "save_type_trash";
SAVE_TYPE_DELETE = "save_type_delete";

EXTRA_COUNTY = "extra_county";
SEARCH_KEY = "search_key";

INTENT_UPDATE_COUNTY_NAMES = "update_county_names";
INTENT_INSERT_COUNTY = "insert_county";
INTENT_QUERY_COUNTIES = "query_counties";
INTENT_QUERY_DELETED_COUNTIES = "query_deleted_counties";
INTENT_STAGE_SELECTED_COUNTY_FOR_EDITING = "stage_selected_county_for_editing";
INTENT_TRASH_COUNTY = "trash_county";
INTENT_ERASE_COUNTY = "erase_county";
INTENT_RESTORE_COUNTY = "restore_county";

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

	// populateCounties
	populateCounties();

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
	case INTENT_INSERT_COUNTY:
	case INTENT_UPDATE_COUNTY_NAMES:
		document.getElementById('input_county_name').value = "";
		document.getElementById('input_county_headquarters').value = "";
		setDefaultSaveType();
		populateCounties();
		break;
	case INTENT_TRASH_COUNTY:
	case INTENT_ERASE_COUNTY:
	case INTENT_RESTORE_COUNTY:
		populateCounties();
	case INTENT_QUERY_COUNTIES:
		document.getElementById('id_table_body_counties').innerHTML = response;
		// $('#id_table_body_counties').text(response);
		populateTrashedCounties();
		break;
	case INTENT_QUERY_DELETED_COUNTIES:
		document.getElementById('id_table_body_deleted_counties').innerHTML = response;
		break;
	case INTENT_STAGE_SELECTED_COUNTY_FOR_EDITING:
		stageSelectedCountyForEditing(response);
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
	setCache(COUNTY_SAVE_TYPE, SAVE_TYPE_INSERT);
}
// add text changed listeners for search
function addSearchTextChangedListener() {
	document.getElementById("id_input_search_county").addEventListener("input",
			populateCounties, false);
	document.getElementById("id_input_search_deleted_county").addEventListener(
			"input", populateTrashedCounties, false);
}

// add button click listeners
function addButtonsClickListeners() {
	$('#button_save_county').click(function(e) {
		saveCounty();
	});

}

function isValid(countyName, countyHqs) {
	var isValid = true;
	if (!isLetters(countyName) || countyName.length == 0) {
		isValid = false;
		document.getElementById('label_county').style.color = "#FF0000";
	} else {
		document.getElementById('label_county').style.color = "#FFFFFF";
	}
	if (!isLetters(countyHqs) || countyHqs.length == 0) {
		isValid = false;
		document.getElementById('label_county_headquaters').style.color = "#FF0000";
	} else {
		document.getElementById('label_county_headquaters').style.color = "#FFFFFF";
	}
	return isValid;
}
/**
 * Save county
 */
function saveCounty() {

	var countyName = $('#input_county_name').val();
	var countyHqs = $('#input_county_headquarters').val();

	if (isValid(countyName, countyHqs)) {
		var saveType = localStorage.getItem(COUNTY_SAVE_TYPE);

		var params = "county_name=" + countyName + "&county_headquarters="
				+ countyHqs;

		switch (saveType) {
		case SAVE_TYPE_UPDATE:
			params += "&" + ACTION_TYPE + "=" + ACTION_UPDATE + "&"
					+ EXTRA_COUNTY + "=" + getSelectedCounty();
			sendPOSTHttpRequest(COUNTIES_URL, params,
					INTENT_UPDATE_COUNTY_NAMES);
			break;
		case SAVE_TYPE_INSERT:
			params += "&" + ACTION_TYPE + "=" + ACTION_INSERT;
			sendPOSTHttpRequest(COUNTIES_URL, params, INTENT_INSERT_COUNTY);
			break;

		default:
			break;
		}
	}

}

/**
 * Get the selected county
 * 
 * @returns county identifier
 */
function getSelectedCounty() {
	return getCache(EXTRA_COUNTY);
}

/**
 * Sets the selected county
 * 
 * @param extraCounty
 */
function setSelectedCounty(extraCounty) {
	setCache(EXTRA_COUNTY, extraCounty);
}
/**
 * Reads all the counties and shows them on the page
 */
function populateCounties() {
	var searchCounty = $("#id_input_search_county").val();
	request_url = COUNTIES_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&" + SEARCH_KEY + "="
			+ searchCounty + "&" + RESULT_FORMAT + "="
			+ RESULT_FORMAT_TABLE_ROWS;
	request_intent = INTENT_QUERY_COUNTIES;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}

/**
 * Reads all the trashed counties and shows them on the page
 */
function populateTrashedCounties() {
	var searchCounty = $("#id_input_search_deleted_county").val();
	request_url = COUNTIES_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&" + SEARCH_KEY + "="
			+ searchCounty;
	request_intent = INTENT_QUERY_DELETED_COUNTIES;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}

function editCounty(countyId) {

	setSelectedCounty(countyId);

	request_url = COUNTIES_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&" + EXTRA_COUNTY
			+ "=" + countyId;
	request_intent = INTENT_STAGE_SELECTED_COUNTY_FOR_EDITING;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}
function deleteCounty(countyId) {

	setSelectedCounty(countyId);

	request_url = COUNTIES_URL;
	request_params = ACTION_TYPE + "=" + ACTION_UPDATE + "&" + EXTRA_COUNTY
			+ "=" + countyId;
	request_intent = INTENT_TRASH_COUNTY;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}
function eraseCounty(countyId) {

	setSelectedCounty(countyId);

	request_url = COUNTIES_URL;
	request_params = ACTION_TYPE + "=" + ACTION_UPDATE + "&" + EXTRA_COUNTY
			+ "=" + countyId;
	request_intent = INTENT_ERASE_COUNTY;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}

function restoreCounty(countyId) {

	setSelectedCounty(countyId);

	request_url = COUNTIES_URL;
	request_params = ACTION_TYPE + "=" + ACTION_UPDATE + "&" + EXTRA_COUNTY
			+ "=" + countyId;
	request_intent = INTENT_RESTORE_COUNTY;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}

function stageSelectedCountyForEditing(response) {

	setCache(COUNTY_SAVE_TYPE, SAVE_TYPE_UPDATE);

	var responseJson = eval("(" + response + ")");

	var countyName = responseJson.county_name;
	var countyHqs = responseJson.county_headquarters;

	document.getElementById('input_county_name').value = countyName;
	document.getElementById('input_county_headquarters').value = countyHqs;
}