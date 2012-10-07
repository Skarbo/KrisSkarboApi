AbstractMainView.prototype = new AbstractView();

function AbstractMainView() {
	AbstractView.apply(this, arguments);
}

// FUNCTIONS

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
