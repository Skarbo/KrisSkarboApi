/**
 * Error event
 */
ErrorEvent.prototype = new Event();

/**
 * Search Event
 */
function ErrorEvent(error) {
	this.error = error;
}

// VARIABLES

ErrorEvent.TYPE = "ErrorEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @returns {String}
 */
ErrorEvent.prototype.getError = function() {
	return this.error;
};

ErrorEvent.prototype.getType = function() {
	return ErrorEvent.TYPE;
};

// /FUNCTIONS
