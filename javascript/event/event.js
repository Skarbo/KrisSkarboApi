/**
 * Event interface
 */
function Event() {
}

// FUNCTIONS

/**
 * @return {String} Event type
 */
Event.prototype.getType = function() {
	throw "Event type must be overwritten";
};

// /FUNCTIONS
