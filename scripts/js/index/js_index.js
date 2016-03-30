/**
 * Created by victor on 2/17/2016.
 */
addEventListener("load", welcome, false);

function welcome() {

	checkForAuthenctication();

	params = ACTION_TYPE + "=" + ACTION_TYPE;
	sendPOSTHttpRequest(WORKER_SCRIPT_URL, params,
			INTENT_INJECT_PAGE_NAVIGATION);
	
	removeCache(EXTRA_LAND_OWNER_ID);
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
	switch (request_intent) {

	case INTENT_INJECT_PAGE_NAVIGATION:
		document.getElementById("page_navigation").innerHTML = response;
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

function showNavigation() {

}