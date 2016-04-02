/**
 * Created by victor on 2/17/2016.
 */

/**
 * Global Variables
 */

TITLE_DEEDS_SAVE_TYPE = "save_type";
SAVE_TYPE_INSERT = "save_type_insert";
SAVE_TYPE_UPDATE = "save_type_update";

EXTRA_PROPRIETOR_ID = "extra_registered_proprietor";
EXTRA_IDENTITY_NUMBER = "extra_identity_number";
EXTRA_TITLE_DEED_PROPRIETORSHIP = "extra_title_deed_proprietorship";
SEARCH_KEY = "search_key";

INTENT_GET_LAND_OWNER_JSON_OBJECT = "query_get_landowner_json_object";
INTENT_QUERY_TITLE_DEED_OWNER_NAME = "query_titledeed_owner";

INTENT_UPDATE_TITLE_DEED_PROPRIETORSHIP = "update_title_deed_proprietorship";
INTENT_INSERT_TITLE_DEED_PROPRIETORSHIP = "insert_title_deed_proprietorship";
INTENT_DELETE_TITLE_DEED_PROPRIETORSHIP = "delete_title_deed_proprietorship";
INTENT_QUERY_TITLE_DEEDS_PROPRIETORSHIP = "query_title_deed_proprietorship";
INTENT_STAGE_SELECTED_TITLE_DEEDS_FOR_EDITING = "stage_selected_title_deed_for_editing";
INTENT_QUERY_LAND_OWNER_TITLE_DEEDS = "query_land_owner_title_deeds";
INTENT_GET_REGISTERED_PROPRIETOR_INFO = "get_registered_proprietor_info";
INTENT_QUERY_REGISTERED_PROPRIETOR_NAME = "get_registered_proprietor";

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

	if (getCache(EXTRA_LAND_OWNER_ID) == null
			|| getCache(EXTRA_LAND_OWNER_ID) == 'null') {
		var landowner_id = prompt("Enter land owner id number");
		setCache(EXTRA_LAND_OWNER_ID, landowner_id);
	}
	
	document.getElementById('id_input_registered_proprietor').value = getCache(EXTRA_LAND_OWNER_ID);
	fetchLandOwnerName();
	//populateTitleDeeds();
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
	case INTENT_INSERT_TITLE_DEED_PROPRIETORSHIP:
	case INTENT_UPDATE_TITLE_DEED_PROPRIETORSHIP:
		resetInputFields();
		setDefaultSaveType();
		populateTitleDeedProprietorships();
		window.location = "titledeeds_comments.html";
		break;

	case INTENT_QUERY_TITLE_DEEDS_PROPRIETORSHIP:
		document.getElementById('id_table_body_titledeeds_proprietorship').innerHTML = response;
		break;
	case INTENT_DELETE_TITLE_DEED_PROPRIETORSHIP:
		populateTitleDeedProprietorships();
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
		document.getElementById('select_filter_titledeeds_proprietorship').innerHTML = response;
		break;
	case INTENT_GET_REGISTERED_PROPRIETOR_INFO:
		populateRegisteredProprietorInfo(response);
		break;
	case INTENT_QUERY_REGISTERED_PROPRIETOR_NAME:
		showRegisteredProprietorName(response);
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
			.addEventListener("input", populateTitleDeedProprietorships, false);

	document.getElementById("id_input_land_owner_identity_number")
			.addEventListener("input", fetchLandOwnerName, false);

	document.getElementById("id_input_registered_proprietor").addEventListener(
			"input", fetchRegisteredProprietor, false);

}

// add drop down select listeners
function addDropDownSelectListeners() {

	$('#select_landowner_titledeeds').change(function(e) {

	});

	$('#select_filter_titledeeds_proprietorship').change(function(e) {
		populateTitleDeedProprietorships();
	});
}

// add button click listeners
function addButtonsClickListeners() {
	$('#button_save_title_deed_proprietorship').click(function(e) {
		saveTitleDeedProprietorships();
	});
}

/**
 * Save landOwner
 */
function saveTitleDeedProprietorships() {

	if (isValidTitleDeedProprietorsip()) {

		var extraTitleDeed = $('#select_landowner_titledeeds').val();
		var registeredProprietor = $('#id_input_registered_proprietor').val();
		var entryNumber = $('#id_input_entry_number').val();
		var considerationAndRemarks = $('#textarea_consideration_and_remarks')
				.val();

		var saveType = localStorage.getItem(TITLE_DEEDS_SAVE_TYPE);

		var params = "titledeed_id=" + extraTitleDeed
				+ "&registeredProprietor=" + registeredProprietor
				+ "&entryNumber=" + entryNumber + "&consideration_and_remarks="
				+ considerationAndRemarks;

		switch (saveType) {
		case SAVE_TYPE_UPDATE:
			params += "&" + ACTION_TYPE + "=" + ACTION_UPDATE + "&"
					+ EXTRA_TITLE_DEED_PROPRIETORSHIP + "="
					+ getSelectedTitleDeedEasement();
			sendPOSTHttpRequest(TITLE_DEEDS_PROPRIETORSHIP_URL, params,
					INTENT_UPDATE_TITLE_DEED_PROPRIETORSHIP);
			break;
		case SAVE_TYPE_INSERT:
			params += "&" + ACTION_TYPE + "=" + ACTION_INSERT;
			sendPOSTHttpRequest(TITLE_DEEDS_PROPRIETORSHIP_URL, params,
					INTENT_INSERT_TITLE_DEED_PROPRIETORSHIP);
			break;

		default:
			break;
		}

	}

}

/**
 * Validates form data
 * 
 * @returns {Boolean}
 */
function isValidTitleDeedProprietorsip() {

	var isValidTitleDeedProprietorship = true;

	var errorLog = "";
	var extraTitleDeed = $('#select_landowner_titledeeds').val();
	var registeredProprietor = $('#id_input_registered_proprietor').val();
	var entryNumber = $('#id_input_entry_number').val();
	var considerationAndRemarks = $('#textarea_consideration_and_remarks')
			.val();

	var errorCount = 0;

	if (extraTitleDeed == "-1" || extraTitleDeed == null) {
		errorCount++;
		errorLog += "" + errorCount + " Select title deed\n";
		isValidTitleDeedProprietorship = false;
	}
	if (registeredProprietor == "-1" || registeredProprietor.length < 7) {
		errorCount++;
		errorLog += "" + errorCount
				+ " Invalid proprietor, the proprietor may not be registered\n";
		isValidTitleDeedProprietorship = false;
	}
	if (entryNumber.length < 1) {
		errorCount++;
		errorLog += "" + errorCount + " Invalid entry number\n";
		isValidTitleDeedProprietorship = false;
	}
	if (considerationAndRemarks.length < 1) {
		errorCount++;
		errorLog += "" + errorCount + " Enter consideration and remarks\n";
		isValidTitleDeedProprietorship = false;
	}

	if(isValidTitleDeedProprietorship == false)
	alert(errorLog);

	return isValidTitleDeedProprietorship;
}
/**
 * Get the selected landOwner
 * 
 * @returns landOwner identifier
 */
function getSelectedTitleDeedEasement() {
	return getCache(EXTRA_TITLE_DEED_PROPRIETORSHIP);
}

/**
 * Sets the selected landOwner
 * 
 * @param extraTitleDeed
 */
function setSelectedTitleDeedProprietorship(extraTitleDeed) {
	setCache(EXTRA_TITLE_DEED_PROPRIETORSHIP, extraTitleDeed);
}
/**
 * Reads all the title_deeds and shows them on the page
 */
function populateTitleDeedProprietorships() {

	var extraIdentityNumber = extraIdentityNumber = getCache(EXTRA_LAND_OWNER_ID);

	if (extraIdentityNumber.length == 7 || extraIdentityNumber.length == 8
			|| extraIdentityNumber.length == 10) {
		var extra_title_deed = $("#select_filter_titledeeds_proprietorship")
				.val();

		request_url = TITLE_DEEDS_PROPRIETORSHIP_URL;
		request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&"
				+ EXTRA_LAND_OWNER + "=" + getCache(LAND_OWNER_ID) + "&"
				+ RESULT_FORMAT + "=" + RESULT_FORMAT_TABLE_ROWS
				+ "&extra_title_deed=" + extra_title_deed;
		request_intent = INTENT_QUERY_TITLE_DEEDS_PROPRIETORSHIP;
		sendPOSTHttpRequest(request_url, request_params, request_intent);
	} else {
		$('#id_table_body_titledeeds_proprietorship').text("");

		document.getElementById('select_landowner_titledeeds').innerHTML = "<option value=\"-1\">Select title deed</option>";
		document.getElementById('select_filter_titledeeds_proprietorship').innerHTML = "<option value=\"-1\">Select title deed</option>";

		document.getElementById('select_landowner_titledeeds').value = "-1";
		document.getElementById('select_filter_titledeeds_proprietorship').value = "-1";
	}
}

function editTitleDeedProprietorship(id_title_deed_proprietorship) {

	setSelectedTitleDeedProprietorship(id_title_deed_proprietorship);

	request_url = TITLE_DEEDS_PROPRIETORSHIP_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&"
			+ EXTRA_TITLE_DEED_PROPRIETORSHIP + "="
			+ id_title_deed_proprietorship;
	request_intent = INTENT_STAGE_SELECTED_TITLE_DEEDS_FOR_EDITING;
	sendPOSTHttpRequest(request_url, request_params, request_intent);

}
function deleteTitleDeedProprietorship(id_title_deed_proprietorship) {
	request_url = TITLE_DEEDS_PROPRIETORSHIP_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&"
			+ EXTRA_TITLE_DEED_PROPRIETORSHIP + "="
			+ id_title_deed_proprietorship;
	request_intent = INTENT_DELETE_TITLE_DEED_PROPRIETORSHIP;
	sendPOSTHttpRequest(request_url, request_params, request_intent);

}
function stageSelectedTitleDeedForEditing(response) {

	setCache(TITLE_DEEDS_SAVE_TYPE, SAVE_TYPE_UPDATE);
	var responseJSON = eval("(" + response + ")");

	var id_title_deed_proprietorship = responseJSON.id_title_deed_proprietorship;
	var entry_number = responseJSON.entry_number;
	var id_title_deed = responseJSON.id_title_deed;

	var consideration_and_remarks = responseJSON.consideration_and_remarks;
	var signature_of_register = responseJSON.signature_of_register;

	document.getElementById('id_input_entry_number').value = entry_number;
	document.getElementById('textarea_consideration_and_remarks').value = consideration_and_remarks;
	document.getElementById('select_landowner_titledeeds').value = id_title_deed;

	var registered_proprietor = responseJSON.registered_proprietor;
	getProprietorIdNumber(registered_proprietor);
}

function getProprietorIdNumber(registered_proprietor_id) {
	request_url = LAND_OWNERS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&"
			+ EXTRA_PROPRIETOR_ID + "=" + registered_proprietor_id;
	request_intent = INTENT_GET_REGISTERED_PROPRIETOR_INFO;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}

function populateRegisteredProprietorInfo(response) {
	var registeredProprietorJSON = eval("(" + response + ")");
	document.getElementById('id_input_registered_proprietor').value = registeredProprietorJSON.idnumber;

}

function showRegisteredProprietorName(response) {
	document.getElementById('label_registered_proprietor').innerHTML = response;
}

function registerLongPollingEngine() {
	populateTitleDeedProprietorships();
	setInterval(populateTitleDeedProprietorships, 5000);
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
function fetchLandOwnerName() {

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

function fetchTitleDeedOwnerName() {

	extraIdentityNumber = getCache(EXTRA_LAND_OWNER_ID);

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

function fetchRegisteredProprietor() {
	var extraIdentityNumber = document
			.getElementById('id_input_registered_proprietor').value;

	if (extraIdentityNumber.length == 7 || extraIdentityNumber.length == 8
			|| extraIdentityNumber.length == 10) {
		request_url = LAND_OWNERS_URL;
		request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&"
				+ EXTRA_IDENTITY_NUMBER + "=" + extraIdentityNumber;
		request_intent = INTENT_QUERY_REGISTERED_PROPRIETOR_NAME;
		sendPOSTHttpRequest(request_url, request_params, request_intent);

	}
}
function resetInputFields() {

	document.getElementById('id_input_registered_proprietor').value = "";
	document.getElementById('id_input_entry_number').value = "";
	document.getElementById('textarea_consideration_and_remarks').value = "";

	// document.getElementById('select_landowner_titledeeds').innerHTML =
	// "<option value=\"-1\">Select title deed</option>";
	document.getElementById('select_filter_titledeeds_proprietorship').innerHTML = "<option value=\"-1\">Select title deed</option>";

	// document.getElementById('select_landowner_titledeeds').value = "-1";
	document.getElementById('select_filter_titledeeds_proprietorship').value = "-1";
}
function addTestData() {
	document.getElementById('id_input_land_owner_identity_number').value = getCache(EXTRA_LAND_OWNER_ID);
	document.getElementById('id_input_registered_proprietor').value = "32361839";
	document.getElementById('id_input_entry_number').value = "001";
	document.getElementById('textarea_consideration_and_remarks').value = "Considered and remarked";

}

function alertError(error) {
	notifyError(error);
}
function alertSuccess(success) {
	notifySuccess(success);
}