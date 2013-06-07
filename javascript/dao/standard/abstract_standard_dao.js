function AbstractStandardDao(mode, controllerName) {
	this.mode = mode;
	this.foreignField = "id";
	this.list = new ListAdapter();
	this.ajax = new AbstractStandardAjaxDao(controllerName, mode);
	this.listAll = false;
	this.listForeign = [];
}

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @returns {ListAdapter}
 */
AbstractStandardDao.prototype.getListAdapter = function() {
	return this.list;
};

/**
 * @param foreignId
 * @returns {Object}
 */
AbstractStandardDao.prototype.getForeignList = function(foreignId) {
	var foreignField = this.foreignField;
	return this.getListAdapter().getFilteredList(function(object) {
		return object[foreignField] == foreignId;
	});
};

// ... /GET

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
	if (!forceAjax && this.getListAdapter().isInList(id)) {
		callback(this.getListAdapter().getItem(id));
	} else {
		var context = this;
		this.ajax.get(id, function(single) {
			context.getListAdapter().add(single.id, single);
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
		callback(this.getListAdapter().getAll());
	} else {
		var context = this;
		this.ajax.getAll(function(list) {
			context.listAll = true;
			context.getListAdapter().addAll(list);
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
			context.getListAdapter().addAll(list);
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
			context.getListAdapter().addAll(list);
			callback(jQuery.extend(list, listKnown));
		});
	};

	if (!forceAjax) {
		var list = {};
		var unknown = [];

		var object = null;
		for (i in ids) {
			object = this.getListAdapter().getItem(ids[i]);
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
		context.getListAdapter().add(single.id, single);
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
		context.getListAdapter().add(single.id, single);
		if (callback)
			callback(single, list);
	});
};

/**
 * @param {Number}
 *            id
 * @param {function}
 *            callback
 */
AbstractStandardDao.prototype.remove = function(id, callback) {
	var context = this;
	this.ajax.remove(id, function(single, list) {
		context.getListAdapter().remove(id);
		callback(single, list);
	});
};

// /FUNCTIONS

