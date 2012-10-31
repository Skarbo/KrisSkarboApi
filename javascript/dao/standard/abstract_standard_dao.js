function AbstractStandardDao(mode, controllerName) {
	this.mode = mode;
	this.foreignField = "id";
	this.list = {};
	this.ajax = new AbstractStandardAjaxDao(controllerName, mode);
	this.listAll = false;
	this.listForeign = [];
}

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

AbstractStandardDao.prototype.getFromList = function(id) {
	return this.list[id] || null;
};

/**
 * @param {Function}
 *            filterFunc Function(single) { return boolean; }
 * @returns {Object}
 */
AbstractStandardDao.prototype.getFilteredList = function(filterFunc) {
	var filteredList = {};
	for (id in this.list) {
		if (filterFunc(this.list[id])) {
			filteredList[id] = this.list[id];
		}
	}
	return filteredList;
};

/**
 * @param foreignId
 * @returns {Object}
 */
AbstractStandardDao.prototype.getForeignList = function(foreignId) {
	var foreignField = this.foreignField;
	return this.getFilteredList(function(single) {
		return single[foreignField] == foreignId;
	});
};

// ... /GET

// ... ADD

AbstractStandardDao.prototype.addSingleToList = function(single) {
	if (jQuery.isPlainObject(single)) {		
		this.list[single.id] = single;
	}
};

AbstractStandardDao.prototype.addListToList = function(list) {
	if (jQuery.isPlainObject(list)) {
		this.list = jQuery.extend({}, list, this.list);
	}
};

// ... /ADD

// ... IS

/**
 * @return {Boolean} True if id is in list
 */
AbstractStandardDao.prototype.isInList = function(id) {
	return this.getFromList(id) != null;
};

// ... /IS

// ... REMOVE

/**
 * @return {Object} Removed item, null if not exist
 */
AbstractStandardDao.prototype.removeFromList = function(id) {
	if (this.isInList(id)) {
		var single = this.list[id];
		delete this.list[id];
		return single;
	}
	return null;
};

// ... /REMOVE

// ... SET

AbstractStandardDao.prototype.setList = function(list) {
	if (jQuery.isPlainObject(list)) {
		this.list = list;
	}
};

// ... /SET

/**
 * @param {integer}
 *            id
 * @param {function}
 *            callback
 * @param {boolean}
 *            forceAjax True if force REST
 * @return {Object}
 */
AbstractStandardDao.prototype.get = function(id, callback, forceAjax) {
	if (!forceAjax && this.isInList(id)) {
		callback(this.getFromList(id));
	} else {
		var context = this;
		this.ajax.get(id, function(single) {
			context.addSingleToList(single);
			callback(single);
		});
	}
};

/**
 * @param {function}
 *            callback
 * @param {boolean}
 *            forceAjax True if force REST
 * @return {Object}
 */
AbstractStandardDao.prototype.getAll = function(callback, forceAjax) {
	if (!forceAjax && this.listAll) {
		callback(this.list);
	} else {
		var context = this;
		this.ajax.getAll(function(list) {
			context.listAll = true;
			context.setList(list);
			callback(list);
		});
	}
};

/**
 * @param {Object}
 *            foreignId
 * @param {function}
 *            callback
 * @param {boolean}
 *            forceAjax True if force REST
 * @return {Object}
 */
AbstractStandardDao.prototype.getForeign = function(foreignId, callback, forceAjax) {
	var context = this;
	if (!forceAjax && jQuery.inArray(foreignId, this.listForeign) > -1) {
		callback(this.getForeignList(foreignId));
	} else {
		this.ajax.getForeign(foreignId, function(list) {
			context.listForeign.push(foreignId);
			context.addListToList(list);
			callback(list);
		});
	}
};

/**
 * @param {Array}
 *            ids
 * @param {function}
 *            callback
 * @param {boolean}
 *            forceAjax True if force REST
 * @return {Object}
 */
AbstractStandardDao.prototype.getList = function(ids, callback, forceAjax) {
	var context = this;

	var getListFunc = function(ids, listKnown) {
		context.ajax.getList(ids, function(list) {
			context.addListToList(list);
			callback(jQuery.extend(list, listKnown));
		});
	};

	if (!forceAjax) {
		var list = {};
		var unknown = [];

		var object = null;
		for (i in ids) {
			object = this.getFromList(ids[i]);
			if (object)
				list[ids[i]] = object;
			else
				unknown.push(ids[i]);
		}

		if (unknown.length == 0)
			callback(list);
		else
			getListFunc(ids, {});
	} else {
		getListFunc(ids, {});
	}
};

/**
 * @param {Object}
 *            object
 * @param {integer}
 *            foreignId
 * @param {function}
 *            callback
 */
AbstractStandardDao.prototype.add = function(object, foreignId, callback) {
	var context = this;
	this.ajax.add(object, foreignId, function(single, list) {
		context.addSingleToList(single);
		callback(single, list);
	});
};

/**
 * @param {Number}
 *            id
 * @param {Object}
 *            object
 * @param {Number}
 *            foreignId
 * @param {function}
 *            callback
 */
AbstractStandardDao.prototype.edit = function(id, object, callback) {
	var context = this;
	this.ajax.edit(id, object, function(single, list) {
		context.addSingleToList(single);
		callback(single, list);
	});
};

// /FUNCTIONS

