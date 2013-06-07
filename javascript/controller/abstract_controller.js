// CONSTRUCTOR
function AbstractController() {
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
AbstractController.prototype.setView = function(view) {
	this.view = view;
};

/**
 * @returns {View}
 */
AbstractController.prototype.getView = function() {
	return this.view;
};

// ... /GETTERS/SETTERS

// ... GET

/**
 * @returns {Object}
 */
AbstractController.prototype.getHash = function() {
	var hash = window.location.hash.substring(1);
	var hashRegex = /(\w+)\[(\w+)\]/;

	var hashesArray = hash.split("/");
	var hashesObject = {};
	var hashArray;

	for (i in hashesArray) {
		hashArray = hashesArray[i].split(":");

		var match = hashRegex.exec(hashArray[0]);
		if (match != null) {
			if (!hashesObject[match[1]])
				hashesObject[match[1]] = {};
			hashesObject[match[1]][match[2]] = hashArray[1];
		} else {
			hashesObject[hashArray[0]] = hashArray[1];
		}
	}

	return hashesObject;
};

/**
 * @return {String} Local storage value
 */
AbstractController.prototype.getLocalStorageVariable = function(variable) {
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
AbstractController.prototype.setLocalStorageVariable = function(variable, value) {
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
AbstractController.prototype.removeLocalStorageVariable = function(variable) {
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
AbstractController.prototype.isSupportLocalStorage = function() {
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
AbstractController.prototype.updateHash = function(hashObject) {
	var hash = this.getHash();

	// Create new hash object
	var hashNew = $.extend(hash, hashObject);

	// Hash string
	var hashArray = [];
	for (key in hashNew) {
		if (key && hashNew[key]) {
			if (typeof hashNew[key] == "object") {
				for ( var i in hashNew[key]) {
					if (i && hashNew[key][i])
						hashArray.push(key + "[" + i + "]:" + hashNew[key][i]);
				}
			} else
				hashArray.push(key + ":" + hashNew[key]);
		}
	}

	// Set window hash
	window.location.hash = "#" + hashArray.join("/");
};

// ... /UPDATE

AbstractController.prototype.before = function() {
};

AbstractController.prototype.after = function() {
};

/**
 * @param {View}
 *            view
 */
AbstractController.prototype.render = function(view) {
	this.setView(view);
	this.before();
	this.getView().before();
	this.getView().draw(this);
	this.getView().after();
	this.after();
};

// /FUNCTIONS
