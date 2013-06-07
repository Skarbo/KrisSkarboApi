/**
 * @param {Object}
 *            list
 */
function ListAdapter(list) {
	this.list = list || {};
	this.notifyOnChange = [];
}

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

/**
 * @returns {Array}
 */
ListAdapter.prototype.getArray = function() {
	var array = [];
	for ( var id in this.list)
		array.push(this.list[id]);
	return array;
};

/**
 * @returns {Object}
 */
ListAdapter.prototype.getAll = function() {
	return this.list;
};

/**
 * @param id
 * @returns {Object}
 */
ListAdapter.prototype.getItem = function(id) {
	return this.list[id] || null;
};

/**
 * @param {Function}
 *            filterFunc Function(single) { return boolean; }
 * @returns {Object}
 */
ListAdapter.prototype.getFilteredList = function(filterFunc) {
	var filteredList = {};
	for (id in this.list) {
		if (filterFunc(this.list[id])) {
			filteredList[id] = this.list[id];
		}
	}
	return filteredList;
};

// ... /GET

// ... ADD

/**
 * @param {Number}
 *            id
 * @param {Object}
 *            object
 */
ListAdapter.prototype.add = function(id, object) {
	if (jQuery.isPlainObject(object)) {
		this.list[id] = object;
		this.notifyDataSetChanged("add", object);
	}
};

/**
 * @param {Object}
 *            list
 */
ListAdapter.prototype.addAll = function(list) {
	if (jQuery.isPlainObject(list)) {
		this.list = jQuery.extend({}, this.list, list);
		this.notifyDataSetChanged("addall", this.list);
	}
};

// ... /ADD

// ... IS

/**
 * @return {Boolean} True if id is in list
 */
ListAdapter.prototype.isInList = function(id) {
	return this.getItem(id) != null;
};

// ... /IS

// ... REMOVE

/**
 * @return {Object} Removed object, null if not exist
 */
ListAdapter.prototype.remove = function(id) {
	if (this.isInList(id)) {
		var object = this.list[id];
		delete this.list[id];
		this.notifyDataSetChanged("remove", object);
		return object;
	}
	return null;
};

// ... /REMOVE

ListAdapter.prototype.clear = function() {
	this.list = {};
	this.notifyDataSetChanged("clear", null);
};

/**
 * @param {Object}
 *            list
 */
ListAdapter.prototype.setList = function(list) {
	if (jQuery.isPlainObject(list)) {
		this.list = list;
		this.notifyDataSetChanged("addall", this.list);
	}
};

// ... /SET

/**
 * @param {Function}
 *            notifyCallback Function(type [add|addall|remove|clear], object)
 */
ListAdapter.prototype.addNotifyOnChange = function(notifyCallback) {
	this.notifyOnChange.push(notifyCallback);
};

/**
 * @param {String}
 *            type add|addall|remove|clear
 * @param {Object}
 *            object added/removed object
 */
ListAdapter.prototype.notifyDataSetChanged = function(type, object) {
	for ( var i in this.notifyOnChange) {
		this.notifyOnChange[i](type, object);
	}
};

/**
 * @returns {Number}
 */
ListAdapter.prototype.size = function() {
	return Core.countObject(this.list);
};

// /FUNCTIONS
