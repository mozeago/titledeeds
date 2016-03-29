/**
 * Created by victor on 2/17/2016.
 */

/**
 * Global Variables
 */

SYSTEM_USER_SAVE_TYPE = "save_type";
SAVE_TYPE_INSERT = "save_type_insert";
SAVE_TYPE_UPDATE = "save_type_update";
SAVE_TYPE_TRASH = "save_type_trash";
SAVE_TYPE_DELETE = "save_type_delete";

EXTRA_SYSTEM_USER = "extra_system_user";
SEARCH_KEY = "search_key";

INTENT_UPDATE_SYSTEM_USERS = "update_systemUsers";
INTENT_INSERT_SYSTEM_USER = "insert_systemUser";
INTENT_QUERY_SYSTEM_USERS = "query_system_users";
INTENT_QUERY_DELETED_SYSTEM_USERS = "query_deleted_system_users";
INTENT_STAGE_SELECTED_SYSTEM_USER_FOR_EDITING = "stage_selected_systemUser_for_editing";
INTENT_TRASH_SYSTEM_USER = "trash_systemUser";
INTENT_ERASE_SYSTEM_USER = "erase_systemUser";
INTENT_RESTORE_SYSTEM_USER = "restore_systemUser";

// Event listener for onpage loaded
addEventListener("load", init, false);

function init() {

	checkForAuthenctication();

	sendPOSTHttpRequest(WORKER_SCRIPT_URL, ACTION_TYPE + "=" + ACTION_TYPE,
			INTENT_INJECT_PAGE_NAVIGATION);

	/*
	 * document.getElementById('input_system_user_firstname').value = "Victor";
	 * document.getElementById('input_system_user_lastname').value = "Mwenda";
	 * document.getElementById('input_system_user_email').value =
	 * "vmwenda.vm@gmail.com";
	 * document.getElementById('input_system_user_phonenumber').value =
	 * "0718034449";
	 * document.getElementById('input_system_user_id_number').value =
	 * "32361839"; document.getElementById('input_system_user_username').value =
	 * "victor_mwenda";
	 * document.getElementById('input_system_user_password').value =
	 * "trueSecurity";
	 */

	// set default save type
	setDefaultSaveType();

	// add text changed listeners for search
	addSearchTextChangedListener();

	// add button click listeners
	addButtonsClickListeners();

	// populateSystemUsers
	populateSystemUsers();

	setInterval(populateSystemUsers, 3000);
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
	case INTENT_INSERT_SYSTEM_USER:
	case INTENT_UPDATE_SYSTEM_USERS:
		resetFields();
		setDefaultSaveType();
		populateSystemUsers();
		break;
	case INTENT_TRASH_SYSTEM_USER:
	case INTENT_ERASE_SYSTEM_USER:
	case INTENT_RESTORE_SYSTEM_USER:
		populateSystemUsers();
	case INTENT_QUERY_SYSTEM_USERS:
		document.getElementById('id_table_body_system_users').innerHTML = response;
		// $('#id_table_body_system_users').text(response);
		populateTrashedSystemUsers();
		break;
	case INTENT_QUERY_DELETED_SYSTEM_USERS:
		document.getElementById('id_table_body_deleted_system_users').innerHTML = response;
		break;
	case INTENT_STAGE_SELECTED_SYSTEM_USER_FOR_EDITING:
		stageSelectedSystemUserForEditing(response);
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
	setCache(SYSTEM_USER_SAVE_TYPE, SAVE_TYPE_INSERT);
}
// add text changed listeners for search
function addSearchTextChangedListener() {
	document.getElementById("id_input_search_system_user").addEventListener(
			"input", populateSystemUsers, false);
	document.getElementById("id_input_search_deleted_system_user")
			.addEventListener("input", populateTrashedSystemUsers, false);
}

// add button click listeners
function addButtonsClickListeners() {
	$('#button_save_system_user').click(function(e) {
		saveSystemUser();
	});

}

/**
 * Save systemUser
 */
function saveSystemUser() {

	var firstname = $('#input_system_user_firstname').val();
	var lastname = $('#input_system_user_lastname').val();
	var email = $('#input_system_user_email').val();
	var phonenumber = $('#input_system_user_phonenumber').val();
	var idnumber = $('#input_system_user_id_number').val();
	var username = $('#input_system_user_username').val();
	var password = $('#input_system_user_password').val();

	if (isFormValid(firstname, lastname, email, phonenumber, idnumber,
			username, password)) {
		var saveType = localStorage.getItem(SYSTEM_USER_SAVE_TYPE);

		var params = "firstname=" + firstname + "&lastname=" + lastname
				+ "&email=" + email + "&phonenumber=" + phonenumber
				+ "&idnumber=" + idnumber + "&username=" + username
				+ "&password=" + password;

		switch (saveType) {
		case SAVE_TYPE_UPDATE:
			params += "&" + ACTION_TYPE + "=" + ACTION_UPDATE + "&"
					+ EXTRA_SYSTEM_USER + "=" + getSelectedSystemUser();
			sendPOSTHttpRequest(SYSTEM_USERS_URL, params,
					INTENT_UPDATE_SYSTEM_USERS);
			break;
		case SAVE_TYPE_INSERT:
			params += "&" + ACTION_TYPE + "=" + ACTION_INSERT;
			sendPOSTHttpRequest(SYSTEM_USERS_URL, params,
					INTENT_INSERT_SYSTEM_USER);
			break;

		default:
			break;
		}
	}

}

function isFormValid(firstname, lastname, email, phonenumber, idnumber,
		username, password) {
	var formValid = true;

	if (firstname.length < 3 || lastname.length < 3) {
		formValid = false;
		var errorLog = "";
		var errorCount = 0;
		if (firstname.length < 3) {
			errorCount++;
			errorLog += errorCount + ". Invalid first name<br />";
		}
		if (lastname.length < 3) {
			errorCount++;
			errorLog += errorCount + ". Invalid last name<br />";
		}

		document.getElementById("panel_person_name_extras").innerHTML = "<span style=\"color:black;\">Errors</span><br />"
				+ errorLog;
	} else {
		document.getElementById("panel_person_name_extras").innerHTML = "";
	}
	if (email.length < 3 || phonenumber.length < 9 || phonenumber.length > 10) {
		formValid = false;
		var errorLog = "";
		var errorCount = 0;
		if (email.length < 3) {
			errorCount++;
			errorLog += errorCount + ". Invalid email<br />";
		}
		if (phonenumber.length < 9 || phonenumber.length > 10) {
			errorCount++;
			errorLog += errorCount + ". Invalid phonenumber hint(length:"
					+ phonenumber.length + ")<br />";
		}
		document.getElementById("panel_person_contacts_extras").innerHTML = "<span style=\"color:black;\">Errors</span><br />"
				+ errorLog;
	} else {
		document.getElementById("panel_person_contacts_extras").innerHTML = "";
	}
	if (idnumber.length < 7 || idnumber.length > 8 || username.length < 3
			|| username.length < 3 || username === password) {
		formValid = false;
		var errorLog = "";
		var errorCount = 0;

		if (idnumber.length < 7) {
			errorCount++;
			errorLog += errorCount
					+ ". Invalid id number -> error hint(length:"
					+ idnumber.length + ")<br />";
		}
		if (idnumber.length > 8) {
			errorCount++;
			errorLog += errorCount
					+ ". Invalid id number -> error hint(length:"
					+ idnumber.length + ")<br />";
		}
		if (username.length < 3) {
			errorCount++;
			errorLog += errorCount + ". Invalid username<br />";
		}
		if (password.length < 3) {
			errorCount++;
			errorLog += errorCount + ". Weak Password<br />";
		}
		if (username === password) {
			errorCount++;
			errorLog += errorCount
					+ ". Weak Password, should not be your username<br />";
		}
		document.getElementById("panel_person_authentication_extras").innerHTML = "<span style=\"color:black;\">Errors</span><br />"
				+ errorLog;
	} else {
		document.getElementById("panel_person_authentication_extras").innerHTML = "";
	}

	return formValid;

}
/**
 * Get the selected systemUser
 * 
 * @returns systemUser identifier
 */
function getSelectedSystemUser() {
	return getCache(EXTRA_SYSTEM_USER);
}

/**
 * Sets the selected systemUser
 * 
 * @param extraSystemUser
 */
function setSelectedSystemUser(extraSystemUser) {
	setCache(EXTRA_SYSTEM_USER, extraSystemUser);
}
/**
 * Reads all the system_users and shows them on the page
 */
function populateSystemUsers() {
	var searchSystemUser = $("#id_input_search_system_user").val();
	request_url = SYSTEM_USERS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&" + SEARCH_KEY + "="
			+ searchSystemUser + "&" + RESULT_FORMAT + "="
			+ RESULT_FORMAT_TABLE_ROWS;
	request_intent = INTENT_QUERY_SYSTEM_USERS;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}

/**
 * Reads all the trashed system_users and shows them on the page
 */
function populateTrashedSystemUsers() {
	var searchSystemUser = $("#id_input_search_deleted_system_user").val();
	request_url = SYSTEM_USERS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&" + SEARCH_KEY + "="
			+ searchSystemUser;
	request_intent = INTENT_QUERY_DELETED_SYSTEM_USERS;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}

function resetFields() {
	document.getElementById('input_system_user_firstname').value = "";
	document.getElementById('input_system_user_lastname').value = "";
	document.getElementById('input_system_user_email').value = "";
	document.getElementById('input_system_user_phonenumber').value = "";
	document.getElementById('input_system_user_id_number').value = "";
	document.getElementById('input_system_user_username').value = "";
	document.getElementById('input_system_user_password').value = "";
}

function editSystemUsers(systemUserId) {

	setSelectedSystemUser(systemUserId);

	request_url = SYSTEM_USERS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&" + EXTRA_SYSTEM_USER
			+ "=" + systemUserId;
	request_intent = INTENT_STAGE_SELECTED_SYSTEM_USER_FOR_EDITING;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}
function deleteSystemUsers(systemUserId) {

	setSelectedSystemUser(systemUserId);

	request_url = SYSTEM_USERS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_UPDATE + "&"
			+ EXTRA_SYSTEM_USER + "=" + systemUserId;
	request_intent = INTENT_TRASH_SYSTEM_USER;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}
function eraseSystemUsers(systemUserId) {

	setSelectedSystemUser(systemUserId);

	request_url = SYSTEM_USERS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_UPDATE + "&"
			+ EXTRA_SYSTEM_USER + "=" + systemUserId;
	request_intent = INTENT_ERASE_SYSTEM_USER;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}

function restoreSystemUsers(systemUserId) {

	setSelectedSystemUser(systemUserId);

	request_url = SYSTEM_USERS_URL;
	request_params = ACTION_TYPE + "=" + ACTION_UPDATE + "&"
			+ EXTRA_SYSTEM_USER + "=" + systemUserId;
	request_intent = INTENT_RESTORE_SYSTEM_USER;
	sendPOSTHttpRequest(request_url, request_params, request_intent);
}

function stageSelectedSystemUserForEditing(response) {

	setCache(SYSTEM_USER_SAVE_TYPE, SAVE_TYPE_UPDATE);

	var responseJson = eval("(" + response + ")");

	document.getElementById('input_system_user_firstname').value = responseJson.firstname;
	document.getElementById('input_system_user_lastname').value = responseJson.lastname;
	document.getElementById('input_system_user_email').value = responseJson.email;
	document.getElementById('input_system_user_phonenumber').value = responseJson.phonenumber;
	document.getElementById('input_system_user_username').value = responseJson.username;
	document.getElementById('input_system_user_password').value = responseJson.password;
}