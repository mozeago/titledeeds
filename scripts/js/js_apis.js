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
	perfomHttpRequest(request_type, request_url, request_params, data_type,
			request_intent);
}