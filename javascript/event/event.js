/**
 * Event interface
 */
function Event(options) {
	this.options = options || {};
}

// FUNCTIONS

/**
 * @return {String} Event type
 */
Event.prototype.getType = function() {
	throw "Event type must be overwritten";
};

/**
 * @returns {Object}
 */
Event.prototype.getOptions = function() {
	return this.options;
};

// /FUNCTIONS
