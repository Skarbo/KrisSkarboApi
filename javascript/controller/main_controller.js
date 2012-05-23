MainController.prototype = new Controller();

// CONSTRUCTOR

/** 
 * @param {EventHandler}
 *            eventHandler
 * @returns {MainController}
 */
function MainController(eventHandler, mode, query) {
	Controller.apply(this, arguments);
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
MainController.prototype.setEventHandler = function(eventHandler) {
	this.eventHandler = eventHandler;
};

/**
 * @returns {EventHandler}
 */
MainController.prototype.getEventHandler = function() {
	return this.eventHandler;
};

MainController.prototype.getMode = function() {
	return this.mode;
};

/**
 * @return {Object}
 */
MainController.prototype.getQuery = function() {
	return this.query;
};

/**
 * Called to bind event handler listeners, should be called after/at render,
 * should be overwritten
 */
MainController.prototype.doBindEventHandler = function() {
	// Void
};

MainController.prototype.render = function(view) {
	Controller.prototype.render.call(this, view);

	// Call bind event handler
	this.doBindEventHandler();
};

// /FUNCTIONS
