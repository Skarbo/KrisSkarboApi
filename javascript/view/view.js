/**
 * View
 */
function View() {
	this.controller = null;
}

/**
 * @param {Controller}
 *            controller
 */
View.prototype.setController = function(controller) {
	this.controller = controller;
};

/**
 * @returns {Controller}
 */
View.prototype.getController = function() {
	return this.controller;
};


/**
 * Draws view, called at render
 * 
 * @param {Controller}
 *            controller
 */
View.prototype.draw = function(controller) {
	this.setController(controller);
};

/**
 * Called before draw
 */
View.prototype.before = function() {
	// Void
};

/**
 * Called after draw
 */
View.prototype.after = function() {
	// Void
};