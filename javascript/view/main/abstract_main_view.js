AbstractMainView.prototype = new AbstractView();

function AbstractMainView(wrapperId) {
	AbstractView.apply(this, arguments);
	this.wrapperId = wrapperId;
}

// FUNCTIONS

/**
 * @return {string} wrapper id
 */
AbstractMainView.prototype.getWrapperId = function() {
	return this.wrapperId;
};

/**
 * @return {Object}
 */
AbstractMainView.prototype.getWrapperElement = function() {
	return $(Core.sprintf("#%s", this.getWrapperId()));
};

/**
 * @return {AbstractMainController}
 */
AbstractMainView.prototype.getController = function() {
	return AbstractView.prototype.getController.call(this);
};

/**
 * @returns {EventHandler}
 */
AbstractMainView.prototype.getEventHandler = function() {
	return this.getController().getEventHandler();
};

/**
 * Called to bind the event handler, should be called after/at draw, should be
 * overwritten
 */
AbstractMainView.prototype.doBindEventHandler = function() {
	// Void
};

/**
 * Binds event handlers, called after draw
 */
AbstractMainView.prototype.draw = function(controller) {
	AbstractView.prototype.draw.call(this, controller);

	// Call bind event handler
	this.doBindEventHandler();
};

// /FUNCTIONS
