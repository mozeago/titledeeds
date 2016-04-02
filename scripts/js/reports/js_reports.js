/**
 * Created by victor on 2/17/2016.
 */

/**
 * Global Variables
 */

TITLE_DEEDS_SAVE_TYPE = "save_type";
SAVE_TYPE_INSERT = "save_type_insert";
SAVE_TYPE_UPDATE = "save_type_update";

EXTRA_IDENTITY_NUMBER = "extra_identity_number";
EXTRA_TITLE_DEED_NATURE = "extra_title_deed_nature";

INTENT_GET_LAND_OWNER_JSON_OBJECT = "query_get_landowner_json_object";
INTENT_QUERY_TITLE_DEED_OWNER_NAME = "query_titledeed_owner";

INTENT_QUERY_LAND_OWNER_TITLE_DEEDS = "query_land_owner_title_deeds";

INTENT_PRINT_TITLE_DEED = "intent_print_title_deed";

// Event listener for onpage loaded
addEventListener("load", init, false);

function init() {

	checkForAuthenctication();

	sendPOSTHttpRequest(WORKER_SCRIPT_URL, ACTION_TYPE + "=" + ACTION_TYPE,
			INTENT_INJECT_PAGE_NAVIGATION);

	// Reset last known land owner id
	setCache(LAND_OWNER_ID, "-1");

	// set default save type
	setDefaultSaveType();

	// add text change watche
	addTextChangeWatcher();

	// add button click listeners
	addButtonsClickListeners();

	// add test data addTestData();

	if (getCache(EXTRA_LAND_OWNER_ID) == null
			| getCache(EXTRA_LAND_OWNER_ID) == "null") {
		var landowner_id = prompt("Enter land owner id number");
		setCache(EXTRA_LAND_OWNER_ID, landowner_id);
	}

	fetchfetchLandOwnerJsonObject();

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
	case INTENT_PRINT_TITLE_DEED:
		resetInputFields();
		setDefaultSaveType();
		window.location = "print_titledeed.php";
		break;
	case INTENT_GET_LAND_OWNER_JSON_OBJECT:
		setLandOwnerProfile(response);
		populateTitleDeeds();
		break;
	case INTENT_QUERY_LAND_OWNER_TITLE_DEEDS:
		document.getElementById('input_select_title_deed').innerHTML = response;
		break;
	case INTENT_QUERY_TITLE_DEED_OWNER_NAME:
		document.getElementById('input_new_land_owner_name').value = response;
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
	setCache(TITLE_DEEDS_SAVE_TYPE, SAVE_TYPE_INSERT);
}

// add button click listeners
function addButtonsClickListeners() {
	$('#button_create_title_deed').click(function(e) {
		createTitleDeedReport();
	});
}

function addTextChangeWatcher() {
	$('#input_new_land_owner_id').click(function(e) {
		fetchNewLandOwnerName();
	});
}

function createTitleDeedReport() {
	var selected_title_deed = $("#input_select_title_deed").val();
	if (selected_title_deed == "-1") {
		alert("Invalid Title Deed");
		return;
	}

	request_url = PRINT_REPORTS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&title_deed="
			+ selected_title_deed;
	request_intent = INTENT_PRINT_TITLE_DEED;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}
function populateTitleDeeds() {
	var extraIdentityNumber = getCache(EXTRA_LAND_OWNER_ID);

	if (extraIdentityNumber.length == 7 || extraIdentityNumber.length == 8
			|| extraIdentityNumber.length == 10) {
		request_url = TITLE_DEEDS_URL;
		request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&"
				+ EXTRA_LAND_OWNER + "=" + getCache(LAND_OWNER_ID);
		request_intent = INTENT_QUERY_LAND_OWNER_TITLE_DEEDS;
		sendPOSTHttpRequest(request_url, request_params, request_intent);
	}
}
function fetchfetchLandOwnerJsonObject() {

	extraIdentityNumber = getCache(EXTRA_LAND_OWNER_ID);

	if (extraIdentityNumber.length == 7 || extraIdentityNumber.length == 8
			|| extraIdentityNumber.length == 10) {
		request_url = LAND_OWNERS_URL;
		request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&"
				+ EXTRA_IDENTITY_NUMBER + "=" + extraIdentityNumber;
		request_intent = INTENT_GET_LAND_OWNER_JSON_OBJECT;
		sendPOSTHttpRequest(request_url, request_params, request_intent);

	}

}

function fetchNewLandOwnerName() {

	extraIdentityNumber = document.getElementById('input_new_land_owner_id').value;

	if (extraIdentityNumber.length == 7 || extraIdentityNumber.length == 8
			|| extraIdentityNumber.length == 10) {
		request_url = LAND_OWNERS_URL;
		request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&"
				+ EXTRA_IDENTITY_NUMBER + "=" + extraIdentityNumber;
		request_intent = INTENT_QUERY_TITLE_DEED_OWNER_NAME;
		sendPOSTHttpRequest(request_url, request_params, request_intent);

	}
}

function setLandOwnerProfile(response) {
	if (response.length == 0) {
		return;
	}
	var landOwnerJson = eval("(" + response + ")");

	var id_land_owner = landOwnerJson["id_land_owner"];
	var firstname = landOwnerJson["firstname"];
	var middlename = landOwnerJson["middlename"];
	var lastname = landOwnerJson["lastname"];
	var idnumber = landOwnerJson["idnumber"];
	var passport = landOwnerJson["passport"];
	var date_of_birth = landOwnerJson["date_of_birth"];

	$("#label_title_deed_owner").text(
			firstname + " " + middlename + " " + lastname);

	setCache(LAND_OWNER_ID, id_land_owner);

}

function resetInputFields() {
	
}

function alertError(error) {
	notifyError(error);
}
function alertSuccess(success) {
	notifySuccess(success);
}