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
EXTRA_TITLE_DEED_EASEMENT = "extra_title_deed_easement";
SEARCH_KEY = "search_key";

INTENT_GET_LAND_OWNER_JSON_OBJECT = "query_get_landowner_json_object";
INTENT_QUERY_TITLE_DEED_OWNER_NAME = "query_titledeed_owner";

INTENT_UPDATE_TITLE_DEED_EASEMENTS = "update_title_deed_easements";
INTENT_INSERT_TITLE_DEED_EASEMENTS = "insert_title_deed_easements";
INTENT_DELETE_TITLE_DEED_EASEMENT = "delete_title_deed_easement";
INTENT_QUERY_TITLE_DEEDS_EASEMENTS = "query_title_deed_easements";
INTENT_STAGE_SELECTED_TITLE_DEEDS_FOR_EDITING = "stage_selected_title_deed_for_editing";
INTENT_QUERY_LAND_OWNER_TITLE_DEEDS = "query_land_owner_title_deeds";

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

	// add text changed listeners for search
	addSearchTextChangedListener();

	// add button click listeners
	addButtonsClickListeners();

	// add drop down select listeners
	addDropDownSelectListeners();

	// add test data
	// ---NO-LONGER--NEEDED--IN--PRODUCTION BUILD---addTestData();

	// register long polling engine
	registerLongPollingEngine();

	if (getCache(EXTRA_LAND_OWNER_ID) == null|| getCache(EXTRA_LAND_OWNER_ID) == 'null') {
		var landowner_id = prompt("Enter land owner id number");
		setCache(EXTRA_LAND_OWNER_ID, landowner_id);
	}
	
	fetchLandOwnerName();
	populateTitleDeeds();

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
	case INTENT_INSERT_TITLE_DEED_EASEMENTS:
	case INTENT_UPDATE_TITLE_DEED_EASEMENTS:
		resetInputFields();
		setDefaultSaveType();
		populateTitleDeedEasements();
		window.location="titledeed_natures.html";
		break;

	case INTENT_QUERY_TITLE_DEEDS_EASEMENTS:
		document.getElementById('id_table_body_titledeeds_easements').innerHTML = response;
		break;
	case INTENT_DELETE_TITLE_DEED_EASEMENT:
		populateTitleDeedEasements();
		break;
	case INTENT_STAGE_SELECTED_TITLE_DEEDS_FOR_EDITING:
		stageSelectedTitleDeedForEditing(response);
		break;
	case INTENT_GET_LAND_OWNER_JSON_OBJECT:
		setLandOwnerProfile(response);
		populateTitleDeeds();
		break;
	case INTENT_QUERY_LAND_OWNER_TITLE_DEEDS:
		document.getElementById('select_landowner_titledeeds').innerHTML = response;
		document.getElementById('select_filter_titledeeds_easements').innerHTML = response;
		
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
// add text changed listeners for search
function addSearchTextChangedListener() {

	document.getElementById("id_input_land_owner_identity_number")
			.addEventListener("input", populateTitleDeedEasements, false);

	document.getElementById("id_input_land_owner_identity_number")
			.addEventListener("input", fetchLandOwnerName, false);

}

// add drop down select listeners
function addDropDownSelectListeners() {

	$('#select_landowner_titledeeds').change(function(e) {

	});

	$('#select_filter_titledeeds_easements').change(function(e) {
		populateTitleDeedEasements();
	});
}

// add button click listeners
function addButtonsClickListeners() {
	$('#button_save_title_deed_easement').click(function(e) {
		saveTitleDeedEasements();
	});
}

/**
 * Save landOwner
 */
function saveTitleDeedEasements() {

	var titleDeedId = $('#select_landowner_titledeeds').val();
	var titledeedEasement = $('#textarea_title_deed_easement').val();

	if (titleDeedId == "-1" || titleDeedId == null) {
		alert("Cannot save title deed easement..Select title deed");
		return;
	}
	if (titledeedEasement.length < 5 || isNumbers(titledeedEasement)) {
		alert("Cannot save title deed easement..Enter title deed easement");
		return;
	}
	var saveType = localStorage.getItem(TITLE_DEEDS_SAVE_TYPE);

	var params = "titledeed_id=" + titleDeedId + "&titledeed_easement="
			+ titledeedEasement;

	switch (saveType) {
	case SAVE_TYPE_UPDATE:
		params += "&" + ACTION_TYPE + "=" + ACTION_UPDATE + "&"
				+ EXTRA_TITLE_DEED_EASEMENT + "="
				+ getSelectedTitleDeedEasement();
		sendPOSTHttpRequest(TITLE_DEEDS_EASEMENTS_URL, params,
				INTENT_UPDATE_TITLE_DEED_EASEMENTS);
		break;
	case SAVE_TYPE_INSERT:
		params += "&" + ACTION_TYPE + "=" + ACTION_INSERT;
		sendPOSTHttpRequest(TITLE_DEEDS_EASEMENTS_URL, params,
				INTENT_INSERT_TITLE_DEED_EASEMENTS);
		break;

	default:
		break;
	}

}

/**
 * Get the selected landOwner
 * 
 * @returns landOwner identifier
 */
function getSelectedTitleDeedEasement() {
	return getCache(EXTRA_TITLE_DEED_EASEMENT);
}

/**
 * Sets the selected landOwner
 * 
 * @param extraTitleDeed
 */
function setSelectedTitleDeedEASEMENT(extraTitleDeed) {
	setCache(EXTRA_TITLE_DEED_EASEMENT, extraTitleDeed);
}
/**
 * Reads all the title_deeds and shows them on the page
 */
function populateTitleDeedEasements() {

	var extraIdentityNumber = document
			.getElementById('id_input_land_owner_identity_number').value;

	if (extraIdentityNumber.length == 7 || extraIdentityNumber.length == 8
			|| extraIdentityNumber.length == 10) {
		var extra_title_deed = $("#select_filter_titledeeds_easements").val();

		request_url = TITLE_DEEDS_EASEMENTS_URL;
		request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&"
				+ EXTRA_LAND_OWNER + "=" + getCache(LAND_OWNER_ID) + "&"
				+ RESULT_FORMAT + "=" + RESULT_FORMAT_TABLE_ROWS
				+ "&extra_title_deed=" + extra_title_deed;
		request_intent = INTENT_QUERY_TITLE_DEEDS_EASEMENTS;
		sendPOSTHttpRequest(request_url, request_params, request_intent);
	} else {
		$('#id_table_body_titledeeds_easements').text("");
	}
}

function editTitleDeedEasement(titleDeedId, titleDeedEasementId) {

	setSelectedTitleDeedEASEMENT(titleDeedEasementId);

	request_url = TITLE_DEEDS_EASEMENTS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&"
			+ EXTRA_TITLE_DEED_EASEMENT + "=" + titleDeedEasementId;
	request_intent = INTENT_STAGE_SELECTED_TITLE_DEEDS_FOR_EDITING;
	sendPOSTHttpRequest(request_url, request_params, request_intent);

	document.getElementById('select_landowner_titledeeds').value = titleDeedId;
}
function deleteTitleDeedEasement(titleDeedEasementId) {
	request_url = TITLE_DEEDS_EASEMENTS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&"
			+ EXTRA_TITLE_DEED_EASEMENT + "=" + titleDeedEasementId;
	request_intent = INTENT_DELETE_TITLE_DEED_EASEMENT;
	sendPOSTHttpRequest(request_url, request_params, request_intent);

}
function stageSelectedTitleDeedForEditing(response) {

	setCache(TITLE_DEEDS_SAVE_TYPE, SAVE_TYPE_UPDATE);

	document.getElementById('textarea_title_deed_easement').value = response;

}

function registerLongPollingEngine() {
	populateTitleDeedEasements();
	setInterval(populateTitleDeedEasements, 5000);
}

function populateTitleDeeds() {
	
	extraIdentityNumber = getCache(EXTRA_LAND_OWNER_ID);
	
	
	if (extraIdentityNumber.length == 7 || extraIdentityNumber.length == 8
			|| extraIdentityNumber.length == 10) {
		request_url = TITLE_DEEDS_URL;
		request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&"
				+ EXTRA_LAND_OWNER + "=" + getCache(LAND_OWNER_ID);
		request_intent = INTENT_QUERY_LAND_OWNER_TITLE_DEEDS;
		sendPOSTHttpRequest(request_url, request_params, request_intent);
	}
}
function fetchLandOwnerName() {

	var extraIdentityNumber = getCache(EXTRA_LAND_OWNER_ID);

	if (extraIdentityNumber.length == 7 || extraIdentityNumber.length == 8
			|| extraIdentityNumber.length == 10) {
		request_url = LAND_OWNERS_URL;
		request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&"
				+ EXTRA_IDENTITY_NUMBER + "=" + extraIdentityNumber;
		request_intent = INTENT_GET_LAND_OWNER_JSON_OBJECT;
		sendPOSTHttpRequest(request_url, request_params, request_intent);

	}

}

function fetchTitleDeedOwnerName() {
	var extraIdentityNumber = getCache(EXTRA_LAND_OWNER_ID);

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
	document.getElementById('textarea_title_deed_easement').value = "";
	document.getElementById('select_landowner_titledeeds').value = "-1";
}
function addTestData() {
	document.getElementById('textarea_title_deed_easement').value = "Assigned title deed to new land";
}

function alertError(error) {
	notifyError(error);
}
function alertSuccess(success) {
	notifySuccess(success);
}