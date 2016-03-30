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
EXTRA_TITLE_DEED_COMMENT = "extra_title_deed_comment";
SEARCH_KEY = "search_key";

INTENT_GET_LAND_OWNER_JSON_OBJECT = "query_get_landowner_json_object";
INTENT_QUERY_TITLE_DEED_OWNER_NAME = "query_titledeed_owner";

INTENT_UPDATE_TITLE_DEED_COMMENTS = "update_title_deed_comments";
INTENT_INSERT_TITLE_DEED_COMMENTS = "insert_title_deed_comments";
INTENT_DELETE_TITLE_DEED_COMMENT = "delete_title_deed_comment";
INTENT_QUERY_TITLE_DEEDS_COMMENTS = "query_title_deed_comments";
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

	if (getCache(EXTRA_LAND_OWNER_ID) == null) {
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
	case INTENT_INSERT_TITLE_DEED_COMMENTS:
	case INTENT_UPDATE_TITLE_DEED_COMMENTS:
		resetInputFields();
		setDefaultSaveType();
		populateTitleDeedComments();
		break;

	case INTENT_QUERY_TITLE_DEEDS_COMMENTS:
		document.getElementById('id_table_body_titledeeds_comments').innerHTML = response;
		break;
	case INTENT_DELETE_TITLE_DEED_COMMENT:
		populateTitleDeedComments();
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
		document.getElementById('select_filter_titledeeds_comments').innerHTML = response;
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
			.addEventListener("input", populateTitleDeedComments, false);

	document.getElementById("id_input_land_owner_identity_number")
			.addEventListener("input", fetchLandOwnerName, false);

}

// add drop down select listeners
function addDropDownSelectListeners() {

	$('#select_landowner_titledeeds').change(function(e) {

	});

	$('#select_filter_titledeeds_comments').change(function(e) {
		populateTitleDeedComments();
	});
}

// add button click listeners
function addButtonsClickListeners() {
	$('#button_save_title_deed_comment').click(function(e) {
		saveTitleDeedcomments();
	});

}

/**
 * Save landOwner
 */
function saveTitleDeedcomments() {

	var titleDeedId = $('#select_landowner_titledeeds').val();
	var titledeedComment = $('#textarea_title_deed_comment').val();

	if (titleDeedId == "-1" || titleDeedId == null) {
		alertError("Cannot save title deed comment..Select title deed");
		return;
	}
	if (titledeedComment.length < 5 || isNumbers(titledeedComment)) {
		alertError("Cannot save title deed comment..Enter title deed comment");
		return;
	}
	var saveType = localStorage.getItem(TITLE_DEEDS_SAVE_TYPE);

	var params = "titledeed_id=" + titleDeedId + "&titledeed_comment="
			+ titledeedComment;

	switch (saveType) {
	case SAVE_TYPE_UPDATE:
		params += "&" + ACTION_TYPE + "=" + ACTION_UPDATE + "&"
				+ EXTRA_TITLE_DEED_COMMENT + "="
				+ getSelectedTitleDeedEasement();
		sendPOSTHttpRequest(TITLE_DEEDS_COMMENTS_URL, params,
				INTENT_UPDATE_TITLE_DEED_COMMENTS);
		break;
	case SAVE_TYPE_INSERT:
		params += "&" + ACTION_TYPE + "=" + ACTION_INSERT;
		sendPOSTHttpRequest(TITLE_DEEDS_COMMENTS_URL, params,
				INTENT_INSERT_TITLE_DEED_COMMENTS);
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
	return getCache(EXTRA_TITLE_DEED_COMMENT);
}

/**
 * Sets the selected landOwner
 * 
 * @param extraTitleDeed
 */
function setSelectedTitleDeedcomment(extraTitleDeed) {
	setCache(EXTRA_TITLE_DEED_COMMENT, extraTitleDeed);
}
/**
 * Reads all the title_deeds and shows them on the page
 */
function populateTitleDeedComments() {

	var extraIdentityNumber = document
			.getElementById('id_input_land_owner_identity_number').value;

	if (extraIdentityNumber.length == 7 || extraIdentityNumber.length == 8
			|| extraIdentityNumber.length == 10) {
		var extra_title_deed = $("#select_filter_titledeeds_comments").val();

		request_url = TITLE_DEEDS_COMMENTS_URL;
		request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&"
				+ EXTRA_LAND_OWNER + "=" + getCache(LAND_OWNER_ID) + "&"
				+ RESULT_FORMAT + "=" + RESULT_FORMAT_TABLE_ROWS
				+ "&extra_title_deed=" + extra_title_deed;
		request_intent = INTENT_QUERY_TITLE_DEEDS_COMMENTS;
		sendPOSTHttpRequest(request_url, request_params, request_intent);
	} else {
		$('#id_table_body_titledeeds_comments').text("");
	}
}

function editTitleDeedComments(titleDeedId, titleDeedCommentId) {

	setSelectedTitleDeedcomment(titleDeedCommentId);

	request_url = TITLE_DEEDS_COMMENTS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&"
			+ EXTRA_TITLE_DEED_COMMENT + "=" + titleDeedCommentId;
	request_intent = INTENT_STAGE_SELECTED_TITLE_DEEDS_FOR_EDITING;
	sendPOSTHttpRequest(request_url, request_params, request_intent);

	document.getElementById('select_landowner_titledeeds').value = titleDeedId;
}

function deleteTitleDeedComment(titleDeedCommentId) {
	request_url = TITLE_DEEDS_COMMENTS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&"
			+ EXTRA_TITLE_DEED_COMMENT + "=" + titleDeedCommentId;
	request_intent = INTENT_DELETE_TITLE_DEED_COMMENT;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}
function stageSelectedTitleDeedForEditing(response) {

	setCache(TITLE_DEEDS_SAVE_TYPE, SAVE_TYPE_UPDATE);

	document.getElementById('textarea_title_deed_comment').value = response;

}

function registerLongPollingEngine() {
	populateTitleDeedComments();
	setInterval(populateTitleDeedComments, 5000);
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
	document.getElementById('textarea_title_deed_comment').value = "";
	document.getElementById('select_landowner_titledeeds').value = "-1";
}
function addTestData() {
	document.getElementById('textarea_title_deed_comment').value = "Assigned title deed to new land";
}

function alertError(error) {
	notifyError(error);
}
function alertSuccess(success) {
	notifySuccess(success);
}