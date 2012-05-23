// CONSTRUCTOR
function Controller() {
	this.view = null;
	this.local = {};
}

// /CONSTRUCTOR

// FUNCTIONS

// ... GETTERS/SETTERS

/**
 * @param {View}
 *            view
 */
Controller.prototype.setView = function(view) {
	this.view = view;
};

/**
 * @returns {View}
 */
Controller.prototype.getView = function() {
	return this.view;
};

// ... /GETTERS/SETTERS

// ... GET

/**
 * @returns {Object}
 */
Controller.prototype.getHash = function() {
	var hash = window.location.hash.substring(1);

	var hashesArray = hash.split("/");
	var hashesObject = {};
	var hashArray;

	for (i in hashesArray) {
		hashArray = hashesArray[i].split(":");
		hashesObject[hashArray[0]] = hashArray[1];
	}

	return hashesObject;
};

/**
 * @return {String} Local storage value
 */
Controller.prototype.getLocalStorageVariable = function(variable) {
	if (this.isSupportLocalStorage()) {
		return localStorage.getItem(variable);
	} else {
		console.error("Local storage unsupported");
		return this.local[variable] || null;
	}
};

// ... /GET

// ... SET

/**
 * @param {String}
 *            variable
 * @param {String}
 *            value
 */
Controller.prototype.setLocalStorageVariable = function(variable, value) {
	if (this.isSupportLocalStorage()) {
		localStorage.setItem(variable, value);
	} else {
		this.local[variable] = value;
		console.error("Local storage unsupported");
	}
};

// ... /SET

// ... REMOVE

/**
 * @param {String}
 *            variable
 */
Controller.prototype.removeLocalStorageVariable = function(variable) {
	if (this.isSupportLocalStorage()) {
		localStorage.removeItem(variable);
	} else {
		delete this.local[variable];
		console.error("Local storage unsupported");
	}
};

// ... /REMOVE

// ... IS

/**
 * @return {boolean} True if support local storage
 */
Controller.prototype.isSupportLocalStorage = function() {
	try {
		return 'localStorage' in window && window['localStorage'] !== null;
	} catch (e) {
		return false;
	}
};

// ... /IS

// ... UPDATE

/**
 * @param {Object}
 *            hashObject
 */
Controller.prototype.updateHash = function(hashObject) {
	var hash = this.getHash();

	// Create new hash object
	var hashNew = $.extend(hash, hashObject);

	// Hash string
	var hashArray = [];
	for (key in hashNew) {
		if (key && hashNew[key]) {
			hashArray.push(key + ":" + hashNew[key]);
		}
	}

	// Set window hash
	window.location.hash = "#" + hashArray.join("/");
};

// ... /UPDATE

Controller.prototype.before = function() {
};

Controller.prototype.after = function() {
};

/**
 * @param {View}
 *            view
 */
Controller.prototype.render = function(view) {
	this.setView(view);
	this.before();
	this.getView().before();
	this.getView().draw(this);
	this.getView().after();
	this.after();
};

// /FUNCTIONS
