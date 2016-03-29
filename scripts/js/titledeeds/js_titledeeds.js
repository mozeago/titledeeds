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
EXTRA_TITLE_DEED = "extra_title_deed";
SEARCH_KEY = "search_key";

INTENT_QUERY_COUNTIES = "query_counties";
INTENT_QUERY_WARDS = "query_wards";
INTENT_QUERY_LAND_OWNER_NAME = "query_landowner_name";
INTENT_QUERY_TITLE_DEED_OWNER_NAME = "query_titledeed_owner";

INTENT_UPDATE_TITLE_DEEDS_NAMES = "update_title_deed_names";
INTENT_INSERT_TITLE_DEEDS = "insert_title_deed";
INTENT_QUERY_TITLE_DEEDS = "query_title_deeds";
INTENT_STAGE_SELECTED_TITLE_DEEDS_FOR_EDITING = "stage_selected_title_deed_for_editing";

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

	// add test data
	// ---NO-LONGER--NEEDED--IN--PRODUCTION BUILD---addTestData();

	// populateTitleDeeds
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
	case INTENT_INSERT_TITLE_DEEDS:
	case INTENT_UPDATE_TITLE_DEEDS_NAMES:
		resetInputFields();
		setDefaultSaveType();
		populateTitleDeeds();
		break;

	case INTENT_QUERY_TITLE_DEEDS:
		document.getElementById('id_table_body_titledeeds').innerHTML = response;
		break;

	case INTENT_STAGE_SELECTED_TITLE_DEEDS_FOR_EDITING:
		stageSelectedTitleDeedForEditing(response);
		break;
	case INTENT_QUERY_COUNTIES:
		document.getElementById('input_select_county').innerHTML = response;
		populateWards();
		break;
	case INTENT_QUERY_WARDS:
		document.getElementById('input_select_ward').innerHTML = response;
		break;
	case INTENT_QUERY_LAND_OWNER_NAME:
		document.getElementById('input_landowner_name').value = response;
		break;
	case INTENT_QUERY_TITLE_DEED_OWNER_NAME:
		document.getElementById('label_title_deed_owner').innerHTML = response;
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

	document.getElementById("id_input_search_titledeed").addEventListener(
			"input", populateTitleDeeds, false);

	document.getElementById("input_landowner_idnumber").addEventListener(
			"input", fetchLandOwnerName, false);

	document.getElementById("id_input_search_titledeed").addEventListener(
			"input", fetchTitleDeedOwnerName, false);
}

// add drop down select listeners
function addDropDownSelectListeners() {

	$('#input_select_county').change(function(e) {
		populateWards();
	});

}

// add button click listeners
function addButtonsClickListeners() {
	$('#button_save_title_deed').click(function(e) {
		saveTitleDeed();
	});

}

function isValid(landowner_idnumber, land_approximate_area, select_ward,
		title_deed_edition, title_deed_opened, title_deed_parcel_number,
		title_deed_plot_number, title_deed_map_sheet_number) {
	var formValid = true;
	var errorLog = "";

	if (!isKenyanIdNumber(landowner_idnumber)) {
		formValid = false;
		errorLog += "Invalid id number\n";
	}

	if (land_approximate_area < 0 || !isNumbers(land_approximate_area)) {
		formValid = false;
		errorLog += "Invalid approximate area\n";
	}
	if (select_ward == "-1" || select_ward == null) {
		formValid = false;
		errorLog += "Invalid registration section, select a ward\n";
	}
	if (!isAlphaNumeric(title_deed_edition)) {
		formValid = false;
		errorLog += "Invalid edition\n";
	}
	if (title_deed_opened.length == 0) {
		formValid = false;
		errorLog += "Invalid date\n";
	}
	if (!isAlphaNumeric(title_deed_parcel_number)) {
		formValid = false;
		errorLog += "Invalid parcel number\n";
	}

	if (!isAlphaNumeric(title_deed_plot_number)) {
		formValid = false;
		errorLog += "Invalid plot number\n";
	}
	if (!isAlphaNumeric(title_deed_map_sheet_number)) {
		formValid = false;
		errorLog += "Invalid map sheet number\n";
	}

	if (!formValid) {
		alert(errorLog);
	}
	return formValid;
}
/**
 * Save landOwner
 */
function saveTitleDeed() {

	var landowner_idnumber = $('#input_landowner_idnumber').val();
	var landowner_name = $('#input_landowner_name').val(); // MEMORY LEAK
	var land_approximate_area = $('#input_land_approximate_area').val();
	var select_county = $('#input_select_county').val(); // MEMORY LEAK
	var select_ward = $('#input_select_ward').val();
	var title_deed_edition = $('#input_title_deed_edition').val();
	var title_deed_opened = $('#input_title_deed_opened').val();
	var title_deed_parcel_number = $('#input_title_deed_parcel_number').val();
	var title_deed_plot_number = $('#input_title_deed_plot_number').val();
	var title_deed_map_sheet_number = $('#input_title_deed_map_sheet_number')
			.val();

	if (isValid(landowner_idnumber, land_approximate_area, select_ward,
			title_deed_edition, title_deed_opened, title_deed_parcel_number,
			title_deed_plot_number, title_deed_map_sheet_number)) {
		var saveType = localStorage.getItem(TITLE_DEEDS_SAVE_TYPE);

		var params = "landowner_idnumber=" + landowner_idnumber

		+ "&land_approximate_area=" + land_approximate_area + "&select_ward="
				+ select_ward + "&title_deed_edition=" + title_deed_edition
				+ "&title_deed_opened=" + title_deed_opened
				+ "&title_deed_parcel_number=" + title_deed_parcel_number
				+ "&title_deed_plot_number=" + title_deed_plot_number
				+ "&title_deed_map_sheet_number=" + title_deed_map_sheet_number;

		switch (saveType) {
		case SAVE_TYPE_UPDATE:
			params += "&" + ACTION_TYPE + "=" + ACTION_UPDATE + "&"
					+ EXTRA_TITLE_DEED + "=" + getSelectedTitleDeed();
			sendPOSTHttpRequest(TITLE_DEEDS_URL, params,
					INTENT_UPDATE_TITLE_DEEDS_NAMES);
			break;
		case SAVE_TYPE_INSERT:
			params += "&" + ACTION_TYPE + "=" + ACTION_INSERT;
			sendPOSTHttpRequest(TITLE_DEEDS_URL, params,
					INTENT_INSERT_TITLE_DEEDS);
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
function getSelectedTitleDeed() {
	return getCache(EXTRA_TITLE_DEED);
}

/**
 * Sets the selected landOwner
 * 
 * @param extraTitleDeed
 */
function setSelectedTitleDeed(extraTitleDeed) {
	setCache(EXTRA_TITLE_DEED, extraTitleDeed);
}
/**
 * Reads all the title_deeds and shows them on the page
 */
function populateTitleDeeds() {

	var extraIdentityNumber = $("#id_input_search_titledeed").val();

	if (extraIdentityNumber.length == 7 || extraIdentityNumber.length == 8
			|| extraIdentityNumber.length == 10) {
		request_url = TITLE_DEEDS_URL;
		request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&" + SEARCH_KEY
				+ "=" + extraIdentityNumber + "&" + RESULT_FORMAT + "="
				+ RESULT_FORMAT_TABLE_ROWS;
		request_intent = INTENT_QUERY_TITLE_DEEDS;
		sendPOSTHttpRequest(request_url, request_params, request_intent);
	} else {

		if (extraIdentityNumber.length < 7 || extraIdentityNumber.length > 10) {
			document.getElementById('id_table_body_titledeeds').innerHTML = "<tr><td colspan=\"99\">Invalid ID Number or Passport Number</td></tr>";

		}

		if (extraIdentityNumber.length == 0) {
			document.getElementById('id_table_body_titledeeds').innerHTML = "<tr><td colspan=\"99\"><b>Enter ID Number or Passport Number to view land owner title deed(s)</b></td></tr>";
		}
	}

}

function editTitleDeed(titleDeedId) {

	setSelectedTitleDeed(titleDeedId);

	request_url = TITLE_DEEDS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&" + EXTRA_TITLE_DEED
			+ "=" + titleDeedId;
	request_intent = INTENT_STAGE_SELECTED_TITLE_DEEDS_FOR_EDITING;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}

function stageSelectedTitleDeedForEditing(response) {

	setCache(TITLE_DEEDS_SAVE_TYPE, SAVE_TYPE_UPDATE);

	var responseJson = eval("(" + response + ")");

	var extraIdentityNumber = document
			.getElementById('id_input_search_titledeed').value;

	var land_approximate_area = responseJson.approximate_area;
	var select_county = responseJson.county;
	var select_ward = responseJson.registration_section;
	var title_deed_edition = responseJson.edition;
	var title_deed_opened = responseJson.opened;
	var title_deed_parcel_number = responseJson.parcel_number;
	var title_deed_plot_number = responseJson.plot_number;
	var title_deed_map_sheet_number = responseJson.registry_map_sheet_number;

	document.getElementById('input_landowner_idnumber').value = extraIdentityNumber;
	document.getElementById('input_land_approximate_area').value = land_approximate_area;
	document.getElementById('input_select_county').value = select_county;
	document.getElementById('input_select_ward').value = select_ward;
	document.getElementById('input_title_deed_edition').value = title_deed_edition;
	document.getElementById('input_title_deed_opened').value = title_deed_opened;
	document.getElementById('input_title_deed_parcel_number').value = title_deed_parcel_number;
	document.getElementById('input_title_deed_plot_number').value = title_deed_plot_number;
	document.getElementById('input_title_deed_map_sheet_number').value = title_deed_map_sheet_number;

}

function registerLongPollingEngine() {
	populateTitleDeeds();
	populateCounties();
	setInterval(populateTitleDeeds, 5000);
}

function populateCounties() {
	var searchCounty = "";
	request_url = COUNTIES_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&" + SEARCH_KEY + "="
			+ searchCounty + "&" + RESULT_FORMAT + "=" + RESULT_FORMAT_DROPDOWN;
	request_intent = INTENT_QUERY_COUNTIES;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}

function populateWards() {
	var countyId = $('#input_select_county').val();
	var searchWard = "";

	request_url = WARDS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&" + SEARCH_KEY + "="
			+ searchWard + "&county=" + countyId + "&" + RESULT_FORMAT + "="
			+ RESULT_FORMAT_DROPDOWN;

	request_intent = INTENT_QUERY_WARDS;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}

function fetchLandOwnerName() {

	var extraIdentityNumber = document
			.getElementById('input_landowner_idnumber').value;

	if (extraIdentityNumber.length == 7 || extraIdentityNumber.length == 8
			|| extraIdentityNumber.length == 10) {
		request_url = LAND_OWNERS_URL;
		request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&"
				+ EXTRA_IDENTITY_NUMBER + "=" + extraIdentityNumber;
		request_intent = INTENT_QUERY_LAND_OWNER_NAME;
		sendPOSTHttpRequest(request_url, request_params, request_intent);

	}

}

function fetchTitleDeedOwnerName() {
	var extraIdentityNumber = document
			.getElementById('id_input_search_titledeed').value;

	if (extraIdentityNumber.length == 7 || extraIdentityNumber.length == 8
			|| extraIdentityNumber.length == 10) {
		request_url = LAND_OWNERS_URL;
		request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&"
				+ EXTRA_IDENTITY_NUMBER + "=" + extraIdentityNumber;
		request_intent = INTENT_QUERY_TITLE_DEED_OWNER_NAME;
		sendPOSTHttpRequest(request_url, request_params, request_intent);

	}
}
function resetInputFields() {
	document.getElementById('input_landowner_idnumber').value = "";
	document.getElementById('input_landowner_name').value = "";
	document.getElementById('input_land_approximate_area').value = "";
	document.getElementById('input_select_county').value = "";
	document.getElementById('input_select_ward').value = "";
	document.getElementById('input_title_deed_edition').value = "";
	document.getElementById('input_title_deed_opened').value = "";
	document.getElementById('input_title_deed_parcel_number').value = "";
	document.getElementById('input_title_deed_plot_number').value = "";
	document.getElementById('input_title_deed_map_sheet_number').value = "";
}
function addTestData() {

	document.getElementById('input_landowner_idnumber').value = "32361839";
	document.getElementById('input_land_approximate_area').value = "100";
	document.getElementById('input_select_county').value = "1";
	document.getElementById('input_select_ward').value = "2";
	document.getElementById('input_title_deed_edition').value = "1";
	document.getElementById('input_title_deed_opened').value = "1995-11-14";
	document.getElementById('input_title_deed_parcel_number').value = "1995";
	document.getElementById('input_title_deed_plot_number').value = "11";
	document.getElementById('input_title_deed_map_sheet_number').value = "14";

}