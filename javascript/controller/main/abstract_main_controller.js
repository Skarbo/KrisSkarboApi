AbstractMainController.prototype = new AbstractController();

// CONSTRUCTOR

function AbstractMainController(eventHandler, mode, query) {
	AbstractController.apply(this, arguments);
	this.eventHandler = eventHandler;
	this.mode = mode;
	this.query = query || {};
}

// /CONSTRUCTOR

// FUNCTIONS

/**
 * @param {EventHandler}
 *            eventHandler
 */
AbstractMainController.prototype.setEventHandler = function(eventHandler) {
	this.eventHandler = eventHandler;
};

/**
 * @returns {EventHandler}
 */
AbstractMainController.prototype.getEventHandler = function() {
	return this.eventHandler;
};

AbstractMainController.prototype.getMode = function() {
	return this.mode;
};

/**
 * @return {Object}
 */
AbstractMainController.prototype.getQuery = function() {
	return this.query;
};

/**
 * Called to bind event handler listeners, should be called after/at render,
 * should be overwritten
 */
AbstractMainController.prototype.doBindEventHandler = function() {
	// Void
};

AbstractMainController.prototype.render = function(view) {
	AbstractController.prototype.render.call(this, view);

	// Call bind event handler
	this.doBindEventHandler();
};

// /FUNCTIONS
