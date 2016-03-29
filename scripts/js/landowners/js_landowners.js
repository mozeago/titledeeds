/**
 * Created by victor on 2/17/2016.
 */

/**
 * Global Variables
 */

LAND_OWNERS_SAVE_TYPE = "save_type";
SAVE_TYPE_INSERT = "save_type_insert";
SAVE_TYPE_UPDATE = "save_type_update";

SEARCH_KEY = "search_key";

INTENT_UPDATE_LAND_OWNERS_NAMES = "update_land_owner_names";
INTENT_INSERT_LAND_OWNERS = "insert_land_owner";
INTENT_QUERY_LAND_OWNERS = "query_land_owners";
INTENT_STAGE_SELECTED_LAND_OWNERS_FOR_EDITING = "stage_selected_land_owner_for_editing";

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

	// add test data
	// ---NO-LONGER--NEEDED--IN--PRODUCTION BUILD---addTestData();

	// populateLandOwners
	registerLongPollingEngine();

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
	case INTENT_INSERT_LAND_OWNERS:
	case INTENT_UPDATE_LAND_OWNERS_NAMES:
		document.getElementById('input_landowner_firstname').value = "";
		document.getElementById('input_landowner_middlename').value = "";
		document.getElementById('input_landowner_lastname').value = "";
		document.getElementById('input_landowner_idnumber').value = "";
		document.getElementById('input_landowner_passport').value = "";
		document.getElementById('input_landowner_dateofbirth').value = "";
		document.getElementById('input_landowner_address').value = "";
		setDefaultSaveType();
		populateLandOwners();
		break;

	case INTENT_QUERY_LAND_OWNERS:
		document.getElementById('id_table_body_land_owners').innerHTML = response;
		break;

	case INTENT_STAGE_SELECTED_LAND_OWNERS_FOR_EDITING:
		stageSelectedLandOwnerForEditing(response);
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
	setCache(LAND_OWNERS_SAVE_TYPE, SAVE_TYPE_INSERT);
}
// add text changed listeners for search
function addSearchTextChangedListener() {
	document.getElementById("id_input_search_land_owner").addEventListener(
			"input", populateLandOwners, false);
}

// add button click listeners
function addButtonsClickListeners() {
	$('#button_save_land_owner').click(function(e) {
		saveLandOwner();
	});

}

function isValidForm(firstname, lastname, middlename, idnumber, passport,
		dateOfBirth, address) {
	var formValid = true;
	var errorLog = "";
	if (firstname.length < 3 || !isLetters(firstname)) {
		formValid = false;
		errorLog += "Invalid firstname\n";
	}

	if (lastname.length < 3 || !isLetters(lastname)) {
		formValid = false;
		errorLog += "Invalid lastname\n";
	}
	if (middlename.length < 3 || !isLetters(middlename)) {
		formValid = false;
		errorLog += "Invalid middlename\n";
	}
	if (!isKenyanIdNumber (idnumber)) {
		formValid = false;
		errorLog += "Invalid id number\n";
	}
	if (!isKenyanPassport(passport)) {
		formValid = false;
		errorLog += "Invalid passport\n";
	}
	if (dateOfBirth.length == 0) {
		formValid = false;
		errorLog += "Invalid date of birth\n";
	}
	if (!isAlphaNumeric(address)) {
		formValid = false;
		errorLog += "Invalid address\n";
	}
	if (!formValid) {
		alert(errorLog);
	}
	return formValid;
}
/**
 * Save landOwner
 */
function saveLandOwner() {

	var firstname = $('#input_landowner_firstname').val();
	var lastname = $('#input_landowner_lastname').val();
	var middlename = $('#input_landowner_middlename').val();
	var idnumber = $('#input_landowner_idnumber').val();
	var passport = $('#input_landowner_passport').val();
	var dateOfBirth = $('#input_landowner_dateofbirth').val();
	var address = $('#input_landowner_address').val();

	var landOwnerName = $('#input_land_owner_name').val();
	var landOwnerHqs = $('#input_land_owner_headquarters').val();

	var saveType = localStorage.getItem(LAND_OWNERS_SAVE_TYPE);

	var params = "firstname=" + firstname + "&lastname=" + lastname
			+ "&middlename=" + middlename + "&idnumber=" + idnumber
			+ "&passport=" + passport + "&dateOfBirth=" + dateOfBirth
			+ "&address=" + address;

	if (isValidForm(firstname, lastname, middlename, idnumber, passport,
			dateOfBirth, address)) {
		switch (saveType) {
		case SAVE_TYPE_UPDATE:
			params += "&" + ACTION_TYPE + "=" + ACTION_UPDATE + "&"
					+ EXTRA_LAND_OWNER + "=" + getSelectedLandOwner();
			sendPOSTHttpRequest(LAND_OWNERS_URL, params,
					INTENT_UPDATE_LAND_OWNERS_NAMES);
			break;
		case SAVE_TYPE_INSERT:
			params += "&" + ACTION_TYPE + "=" + ACTION_INSERT;
			sendPOSTHttpRequest(LAND_OWNERS_URL, params,
					INTENT_INSERT_LAND_OWNERS);
			break;

		default:
			break;
		}
	}

}

/**
 * Get the selected landOwner
 * 
 * @returns landOwner identifier
 */
function getSelectedLandOwner() {
	return getCache(EXTRA_LAND_OWNER);
}

/**
 * Sets the selected landOwner
 * 
 * @param extraLandOwner
 */
function setSelectedLandOwner(extraLandOwner) {
	setCache(EXTRA_LAND_OWNER, extraLandOwner);
}
/**
 * Reads all the land_owners and shows them on the page
 */
function populateLandOwners() {
	var searchLandOwner = $("#id_input_search_land_owner").val();
	request_url = LAND_OWNERS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&" + SEARCH_KEY + "="
			+ searchLandOwner + "&" + RESULT_FORMAT + "="
			+ RESULT_FORMAT_TABLE_ROWS;
	request_intent = INTENT_QUERY_LAND_OWNERS;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}

function editLandOwner(landOwnerId) {

	setSelectedLandOwner(landOwnerId);

	request_url = LAND_OWNERS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&" + EXTRA_LAND_OWNER
			+ "=" + landOwnerId;
	request_intent = INTENT_STAGE_SELECTED_LAND_OWNERS_FOR_EDITING;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}

function stageSelectedLandOwnerForEditing(response) {

	setCache(LAND_OWNERS_SAVE_TYPE, SAVE_TYPE_UPDATE);

	var responseJson = eval("(" + response + ")");

	var firstname = responseJson.firstname;
	var middlename = responseJson.middlename;
	var lastname = responseJson.lastname;
	var idnumber = responseJson.idnumber;
	var passport = responseJson.passport;
	var date_of_birth = responseJson.date_of_birth;
	var address = responseJson.address;

	document.getElementById('input_landowner_firstname').value = firstname
	document.getElementById('input_landowner_middlename').value = middlename;
	document.getElementById('input_landowner_lastname').value = lastname;
	document.getElementById('input_landowner_idnumber').value = idnumber;
	document.getElementById('input_landowner_passport').value = passport;
	document.getElementById('input_landowner_dateofbirth').value = date_of_birth;
	document.getElementById('input_landowner_address').value = address;
}

function registerLongPollingEngine() {
	populateLandOwners();
	setInterval(populateLandOwners, 5000);
}
function addTestData() {

	document.getElementById('input_landowner_firstname').value = "Victor";
	document.getElementById('input_landowner_middlename').value = "Mwenda";
	document.getElementById('input_landowner_lastname').value = "Rwanda";
	document.getElementById('input_landowner_idnumber').value = "32361839";
	document.getElementById('input_landowner_passport').value = "";
	document.getElementById('input_landowner_dateofbirth').value = "1995-11-14";
	document.getElementById('input_landowner_address').value = "340 Maua";
}