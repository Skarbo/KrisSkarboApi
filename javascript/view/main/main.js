/**
 * Main view
 */
MainView.prototype = new View();

function MainView() {
	View.apply(this, arguments);
}

// FUNCTIONS

/**
 * @return {MainController}
 */
MainView.prototype.getController = function() {
	return View.prototype.getController.call(this);
};

/**
 * @returns {EventHandler}
 */
MainView.prototype.getEventHandler = function() {
	return this.getController().getEventHandler();
};

/**
 * Called to bind the event handler, should be called after/at draw, should be
 * overwritten
 */
MainView.prototype.doBindEventHandler = function() {
	// Void
};

/**
 * Binds event handlers, called after draw
 */
MainView.prototype.draw = function(controller) {
	View.prototype.draw.call(this, controller);

	// Call bind event handler
	this.doBindEventHandler();
};

// /FUNCTIONS
