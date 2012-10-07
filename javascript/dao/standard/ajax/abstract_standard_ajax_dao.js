function AbstractStandardAjaxDao(uriControllerName, mode) {
	this.uriControllerName = uriControllerName;
	this.mode = mode;
}

// VARIABLES

AbstractStandardAjaxDao.URI_API = "api_rest.php?/%s/%s&mode=%s";
AbstractStandardAjaxDao.URI_SPLITTER_ID = "_";
AbstractStandardAjaxDao.URI_GET_LIST_GET = "get";
AbstractStandardAjaxDao.URI_GET_SINGLE_GET = "get/%s";
AbstractStandardAjaxDao.URI_GET_LIST_FOREIGN_GET = "foreign/%s";
AbstractStandardAjaxDao.URI_POST_SINGLE_ADD = "add/%s";
AbstractStandardAjaxDao.URI_POST_SINGLE_EDIT = "edit/%s";
AbstractStandardAjaxDao.URI_GET_SINGLE_REMOVE = "remove/%s";

// /VARIABLES

// FUNCTIONS

// ... GET

AbstractStandardAjaxDao.prototype.getUriControllerName = function() {
	return this.uriControllerName;
};

AbstractStandardAjaxDao.prototype.getUriIds = function(id) {
	return jQuery.isArray(id) ? id.join(AbstractStandardAjaxDao.URI_SPLITTER_ID) : id;
};

AbstractStandardAjaxDao.prototype.getMode = function() {
	return this.mode;
};

AbstractStandardAjaxDao.prototype.getUri = function(uri) {
	return Core.sprintf(AbstractStandardAjaxDao.URI_API, this.getUriControllerName(), uri, this.getMode());
};

// ... /GET

/**
 * @param {integer}
 *            id
 * @param {function}
 *            callback
 * @return {Object}
 */
AbstractStandardAjaxDao.prototype.get = function(id, callback) {
	// Generate url
	var url = Core.sprintf(this.getUri(AbstractStandardAjaxDao.URI_GET_SINGLE_GET), id);

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
AbstractStandardAjaxDao.prototype.getAll = function(callback) {
	// Generate url
	var url = this.getUri(AbstractStandardAjaxDao.URI_GET_LIST_GET);

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
AbstractStandardAjaxDao.prototype.getForeign = function(id, callback) {
	// Generate url
	var url = Core.sprintf(this.getUri(AbstractStandardAjaxDao.URI_GET_LIST_FOREIGN_GET), this.getUriIds(id));

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
 *            ids
 * @param {function}
 *            callback
 * @return {Object}
 */
AbstractStandardAjaxDao.prototype.getList = function(ids, callback) {
	// Generate url
	var url = Core.sprintf(this.getUri(AbstractStandardAjaxDao.URI_GET_SINGLE_GET), this.getUriIds(ids));

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
AbstractStandardAjaxDao.prototype.add = function(object, foreignId, callback) {
	// Generate url
	var url = Core.sprintf(this.getUri(AbstractStandardAjaxDao.URI_POST_SINGLE_ADD), foreignId ? foreignId : "");

	// Do ajax
	$.ajax({
		url : url,
		dataType : "json",
		type : "POST",
		data : {
			'object' : object
		},
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
AbstractStandardAjaxDao.prototype.edit = function(id, object, callback) {
	// Generate url
	var url = Core.sprintf(this.getUri(AbstractStandardAjaxDao.URI_POST_SINGLE_EDIT), id);

	// Do ajax
	$.ajax({
		url : url,
		dataType : "json",
		type : "POST",
		data : {
			'object' : object
		},
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
AbstractStandardAjaxDao.prototype.remove = function(id, callback) {
	// Generate url
	var url = Core.sprintf(this.getUri(AbstractStandardAjaxDao.URI_GET_SINGLE_REMOVE), id);

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

AbstractStandardAjaxDao.prototype.query = function(uri, callback) {
	// Generate url
	var url = this.getUri(uri);

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
