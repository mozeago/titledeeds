/**
 * This script contains all the various API's used in the whole project Created
 * by victor on 2/17/2016.
 */

/**
 * Function to perform XML HTTP Request
 * 
 * @param request_type
 *            this can be either GET or POST
 * @param request_url
 *            the url to the script that perform the xhr
 * @params request_params the form params sent to the script that handles the
 *         xhr request
 * @param data_type
 *            the datatype of the form params
 * @param request_intent
 *            a form of request code that can be used to get the sent xhr
 * 
 * This methods has two callbacks :
 * 
 * onSuccessHttpRequest(request_intent, response) This callback is sent whenever
 * a xhr request is successful
 * 
 * onFailedHttpRequest(request_intent) This callback is sent whenever a xhr
 * request failed
 */
function perfomHttpRequest(request_type, request_url, request_params,
		data_type, request_intent) {

	$.ajax({
		type : request_type,
		url : request_url,
		data : request_params,
		dataType : data_type,
		success : function(response, xhr) {
			onSuccessHttpRequest(request_intent, xhr, response);
		},
		error : function(xhr) {
			onFailedHttpRequest(request_intent, xhr);
		}
	});

}

/**
 * Callback called when an http request is successful
 * 
 * @param request_intent
 *            the intent of the http request
 * @param xhr
 *            an object of XML HTTP Request
 * @param response
 *            the response from the server
 */
function onSuccessHttpRequest(request_intent, xhr, response) {
	onSuccessfulXHR(request_intent, xhr, response);
}

/**
 * Callback called when an http request failed
 * 
 * @param request_intent
 *            the intent of the http request *
 * @param xhr
 *            an object of XML HTTP Request
 */
function onFailedHttpRequest(request_intent, xhr) {
	onFailedXHR(request_intent, xhr);
}

/**
 * Sends a POST XML HTTP REQUEST
 * 
 * 
 * @param request_url ->
 *            the url to the script that perform the xhr
 * @params request_params -> the form params sent to the script that handles the
 *         xhr request
 * @param request_intent ->
 *            a form of request code that can be used to get the sent xhr
 */
function sendPOSTHttpRequest(request_url, request_params, request_intent) {
	request_type = "POST";
	data_type = "text";
	request_params += "&" + HTTP_CLIENT + "=" + CLIENT_DESKTOP + "&"
			+ CLIENT_INTENT + "=" + request_intent;
	perfomHttpRequest(request_type, request_url, request_params, data_type,
			request_intent);
}

/**
 * Sends a GET XML HTTP REQUEST
 * 
 * @param request_url ->
 *            the url to the script that perform the xhr
 * @params request_params -> the form params sent to the script that handles the
 *         xhr request
 * @param request_intent ->
 *            a form of request code that can be used to get the sent xhr
 */
function sendGETHttpRequest(request_url, request_params, request_intent) {
	request_type = "GET";
	data_type = "text";
	request_params += "&" + HTTP_CLIENT + "=" + CLIENT_DESKTOP;
	perfomHttpRequest(request_type, request_url, request_params, data_type,
			request_intent);
}

/**
 * Caches data to the local storage of the browser
 * 
 * @param key
 * @param value
 */
function setCache(key, value) {
	localStorage.setItem(key, value);
}

/**
 * Gets cached data from the local storage of the browser
 * 
 * @param key
 */
function getCache(key) {
	return localStorage.getItem(key);
}

/**
 * Remove an item from the local storage
 * 
 * @param key
 * @returns
 */
function removeCache(key) {
	return localStorage.removeItem(key);
}
/**
 * Hides an HTML Element
 * 
 * @param id
 */
function hideElement(id) {

	if (document.getElementById(id) != null) {
		document.getElementById(id).style.display = "none";
	} else {
		prompt("Cannot find element with an id of ", id);
	}

}

/**
 * Shows a hidden HTML Element
 * 
 * @param id
 */
function showElement(id) {
	if (document.getElementById(id) != null) {
		document.getElementById(id).style.display = "block";
	} else {
		prompt("Cannot find element with an id of ", id);
	}
}

/**
 * Shows a hidden HTML Element inline
 * 
 * @param id
 */
function showElementInline(id) {
	if (document.getElementById(id) != null) {
		document.getElementById(id).style.display = "inline-block";
	} else {
		prompt("Cannot find element with an id of ", id);
	}
}

function notifyError(error) {
	document.getElementById('id_notification_pane').innerHTML = ("<label style=\"color:red;\">"
			+ error + "</label>");
	setCache(NOTIFICATION_ID, setInterval(clearNotification, 3000));
}
function notifySuccess(success) {
	document.getElementById('id_notification_pane').innerHTML = ("<label style=\"color:red;\">"
			+ success + "</label>");
	setCache(NOTIFICATION_ID, setInterval(clearNotification, 3000));
}

function clearNotification() {
	document.getElementById('id_notification_pane').innerHTML = ("");
	return clearInterval(getCache(NOTIFICATION_ID));
}
/*
 * function notifyError(notification_section, error) {
 * document.getElementById(notification_section).innerHTML = ("<label
 * style=\"color:red;\">" + error + "</label>"); setCache(NOTIFICATION_ID,
 * setInterval(clearErrorNotification(notification_section), 3000)); }
 * 
 * function notifyCustomError(notification_section, errorHTML) {
 * document.getElementById(notification_section).innerHTML = errorHTML;
 * setCache(NOTIFICATION_ID,
 * setInterval(clearErrorNotification(notification_section), 3000)); }
 * 
 * function notifyCustomError(notification_section, errorHTML, delay) {
 * document.getElementById(notification_section).innerHTML = errorHTML;
 * setCache(NOTIFICATION_ID,
 * setInterval(clearErrorNotification(notification_section), delay)); }
 * 
 * function notifySuccess(notification_section, success) {
 * document.getElementById(notification_section).innerHTML = ("<label
 * style=\"color:red;\">" + success + "</label>"); setCache(NOTIFICATION_ID,
 * setInterval(clearSuccessNotification(notification_section), 3000)); }
 * 
 * function notifyCustomSuccess(notification_section, successHMTL) {
 * document.getElementById(notification_section).innerHTML = successHMTL;
 * setCache(NOTIFICATION_ID, setInterval(clearSuccessNotification, 3000)); }
 * function notifyCustomSuccess(notification_section, successHMTL, delay) {
 * document.getElementById(notification_section).innerHTML = successHMTL;
 * setCache(NOTIFICATION_ID,
 * setInterval(clearSuccessNotification(notification_section), delay)); }
 * 
 * function clearErrorNotification(notification_section){
 * document.getElementById(notification_section).innerHTML = "";
 * clearInterval(getCache(NOTIFICATION_ID)); } function
 * clearSuccessNotification(notification_section){
 * document.getElementById(notification_section).innerHTML = "";
 * clearInterval(getCache(NOTIFICATION_ID)); }
 */

AUTHENTICATED_SYSTEM_USER = "authenticated_system_user";
PREVIOUS_LOCATION = "previous_location";

function requestAuthentication() {
	setCache(
			PREVIOUS_LOCATION,
			window.location == "http://localhost/titledeeds/login.html" ? "http://localhost/titledeeds/index.html"
					: window.location);

	setCache(AUTHENTICATED_SYSTEM_USER, -1);

	window.location = "login.html";
}

function checkForAuthenctication() {
	if (getCache(AUTHENTICATED_SYSTEM_USER) == -1) {
		window.location = "login.html";
	} else {
		setInterval(requestAuthentication, 300000);
	}
}

/**
 * Checks where the input meets the specified pattern
 * 
 * @param pattern
 * @param input
 * @returns true if input matches pattern
 */

function validate(pattern, input) {
	return input.match(pattern);
}

/**
 * Checks whether the input contains only letters
 * 
 * @param input
 * @returns
 */
function isLetters(input) {
	return validate(/^[A-Za-z]+$/, input);
}

/**
 * Checks whether the input contains only numbers
 * 
 * @param input
 * @returns
 */
function isNumbers(input) {
	return validate(/^[0-9]+$/, input);
}

/**
 * Checks whether the input is a valid email address
 * 
 * @param input
 * @returns
 */
function isEmail(input) {
	return validate(/^[w-.+]+@[a-zA-Z0-9.-]+.[a-zA-z0-9]{2,4}$/, input);
}

/**
 * Checks whether the input contains only letters and numbers
 * 
 * @param input
 * @returns
 */
function isAlphaNumeric(input) {
	return validate(/^[0-9a-zA-Z]+$/, input);
}

/**
 * Checks whether the input is a valid kenyan id number
 * 
 * @param input
 * @returns
 */
function isKenyanIdNumber(input) {
	return validate(/^[0-9]{7,8}$/, input);
}

/**
 * Checks whether the input is a valid kenyan passport number
 * 
 * @param input
 * @returns
 */
function isKenyanPassport(input) {
	return validate(/^[0-9]{10}$/, input);
}