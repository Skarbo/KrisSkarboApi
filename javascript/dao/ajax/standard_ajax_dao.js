/**
 * Abstract class
 * 
 * @param {string}
 *            uriControllerName
 * @param {integer}
 *            mode
 */
function StandardAjaxDao(uriControllerName, mode) {
	this.uriControllerName = uriControllerName;
	this.mode = mode;
}

// VARIABLES

StandardAjaxDao.URI_API = "api_rest.php?/%s/%s&mode=%s";
StandardAjaxDao.URI_SPLITTER_ID = "_";
StandardAjaxDao.URI_GET_LIST_GET = "get";
StandardAjaxDao.URI_GET_SINGLE_GET = "get/%s";
StandardAjaxDao.URI_GET_LIST_FOREIGN_GET = "foreign/%s";
StandardAjaxDao.URI_POST_SINGLE_ADD = "add/%s";
StandardAjaxDao.URI_POST_SINGLE_EDIT = "edit/%s";
StandardAjaxDao.URI_GET_SINGLE_REMOVE = "remove/%s";

// /VARIABLES

// FUNCTIONS

// ... GET

StandardAjaxDao.prototype.getUriControllerName = function() {
	return this.uriControllerName;
};

StandardAjaxDao.prototype.getUriIds = function(id) {
	return jQuery.isArray(id) ? id.join(StandardAjaxDao.URI_SPLITTER_ID) : id;
};

StandardAjaxDao.prototype.getMode = function() {
	return this.mode;
};

StandardAjaxDao.prototype.getUri = function(uri) {
	return Core.sprintf(StandardAjaxDao.URI_API, this
			.getUriControllerName(), uri, this.getMode());
};

// ... /GET

/**
 * @param {integer}
 *            id
 * @param {function}
 *            callback
 * @return {Object}
 */
StandardAjaxDao.prototype.get = function(id, callback) {
	// Generate url
	var url = Core.sprintf(this
			.getUri(StandardAjaxDao.URI_GET_SINGLE_GET), id);

	// Do ajax
	$.ajax({
		url : url,
		dataType : "json",
		success : function(data) {
			callback(data["single"]);
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	});
};

/**
 * @param {function}
 *            callback
 * @return {Object}
 */
StandardAjaxDao.prototype.getAll = function(callback) {
	// Generate url
	var url = this.getUri(StandardAjaxDao.URI_GET_LIST_GET);

	// Do ajax
	$.ajax({
		url : url,
		dataType : "json",
		success : function(data) {
			callback(data["list"]);
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	});
};

/**
 * @param {integer}
 *            id
 * @param {function}
 *            callback
 * @return {Object}
 */
StandardAjaxDao.prototype.getForeign = function(id, callback) {
	// Generate url
	var url = Core.sprintf(this
			.getUri(StandardAjaxDao.URI_GET_LIST_FOREIGN_GET), this
			.getUriIds(id));

	// Do ajax
	$.ajax({
		url : url,
		dataType : "json",
		success : function(data) {
			callback(data["list"]);
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	});
};

/**
 * @param {integer}
 *            id
 * @param {function}
 *            callback
 * @return {Object}
 */
StandardAjaxDao.prototype.getList = function(id, callback) {
	// Generate url
	var url = Core.sprintf(this
			.getUri(StandardAjaxDao.URI_GET_SINGLE_GET), this
			.getUriIds(id));

	// Do ajax
	$.ajax({
		url : url,
		dataType : "json",
		success : function(data) {
			callback(data["list"]);
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	});
};

/**
 * @param {integer}
 *            foreignId
 * @param {Objecet}
 *            object
 * @param {function}
 *            callback
 * @return {Object}
 */
StandardAjaxDao.prototype.add = function(foreignId, object, callback) {
	// Generate url
	var url = Core.sprintf(this
			.getUri(StandardAjaxDao.URI_POST_SINGLE_ADD), foreignId ? foreignId : "");

	// Do ajax
	$.ajax({
		url : url,
		dataType : "json",
		type: "POST",
		data : { 'object' : object },
		success : function(data) {
			callback(data["single"], data["list"]);
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	});
};

/**
 * @param {integer}
 *            id
 * @param {function}
 *            callback
 * @return {Object}
 */
StandardAjaxDao.prototype.edit = function(id, object, callback) {
	// Generate url
	var url = Core.sprintf(this
			.getUri(StandardAjaxDao.URI_POST_SINGLE_EDIT), id);

	// Do ajax
	$.ajax({
		url : url,
		dataType : "json",
		type: "POST",
		data : { 'object' : object },
		success : function(data) {
			callback(data["single"], data["list"]);
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	});
};

/**
 * @param {integer}
 *            id
 * @return {Object}
 */
StandardAjaxDao.prototype.remove = function(id, callback) {
	// Generate url
	var url = Core.sprintf(this
			.getUri(StandardAjaxDao.URI_GET_SINGLE_REMOVE), id);

	// Do ajax
	$.ajax({
		url : url,
		dataType : "json",
		success : function(data) {
			callback(data["single"], data["list"]);
		},
		error : function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	});
};

// /FUNCTIONS
