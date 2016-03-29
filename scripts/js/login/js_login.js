INTENT_AUTH_USER = "intent_authenticate_user";

window.onload = function() {

	addEventListeners();
	setInterval(requestAuthentication, 300000);
	document.getElementById("input_login_email_address").value = "vmwenda.vm@gmail.com";
	document.getElementById("input_login_password").value = "trueSecurity";
}

function addEventListeners() {
	$("#button_login").click(function(e) {
		loginUser(e);
	});
}

function loginUser(e) {
	e.preventDefault();
	var username = $("#input_login_email_address").val();
	var password = $("#input_login_password").val();

	if (isValidForm(username, password)) {
		request_params = ACTION_TYPE + "=" + ACTION_QUERY + "&username="
				+ username + "&password=" + password;
		sendPOSTHttpRequest(AUTHENTICATE_URL, request_params, INTENT_AUTH_USER);
	}
}

function isValidForm(username, password) {
	var formValid = true;
	var errorCount = 0;
	var errorLog = "Oops! Found errors:\n";
	if (username.length < 3) {
		errorCount++;
		errorLog += errorCount + " Invalid Username\n";
		formValid = false;
	}
	if (password.length < 3) {
		errorCount++;
		errorLog += errorCount + " Invalid Password\n";
		formValid = false;
	}

	if (!formValid) {
		alert(errorLog);
	}
	return formValid;
}

function onAuthenticateResult(response) {

	var authenticateJSON = eval("(" + response + ")");
	var authenticated = authenticateJSON.authenticated;

	if (authenticated) {

		var userID = authenticateJSON.user_id;
		setCache(AUTHENTICATED_SYSTEM_USER, userID);

		document.getElementById("input_login_information").innerHTML = "Login Successful, Redirecting in 3 seconds to <a href=\""
				+ getCache(PREVIOUS_LOCATION)
				+ "\">"
				+ getCache(PREVIOUS_LOCATION) + "</a> ";
		document.getElementById("input_login_information").style.color = "#00FF00";

		setInterval(
				function() {
					window.location = getCache(PREVIOUS_LOCATION) != null ? window.location = getCache(PREVIOUS_LOCATION)
							: window.location = "index.html";
				}, 3000);

	} else {
		document.getElementById("input_login_password").value = "";
		document.getElementById("input_login_information").innerHTML = "Login Failed";
		document.getElementById("input_login_information").style.color = "#FF0000";
	}

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

	case INTENT_AUTH_USER:
		onAuthenticateResult(response);
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
