// CONSTRUCTOR

function AbstractPresenterView(view) {
	this.view = view;
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

/**
 * @returns {AbstractView}
 */
AbstractPresenterView.prototype.getView = function() {
	return this.view;
};

/**
 * @returns {Object}
 */
AbstractPresenterView.prototype.getRoot = function() {
	return this.root;
};

// ... GET

/**
 * @returns {AbstractController} Event handler
 */
AbstractPresenterView.prototype.getController = function() {
	return this.getView().getController();
};

/**
 * @returns {Number} Mode
 */
AbstractPresenterView.prototype.getMode = function() {
	return this.getController().getMode();
};

/**
 * @returns {EventHandler} Event handler
 */
AbstractPresenterView.prototype.getEventHandler = function() {
	return this.getController().getEventHandler();
};

// ... /GET

// ... DO

AbstractPresenterView.prototype.doBindEventHandler = function() {
};

/**
 * Before bind event
 */
AbstractPresenterView.prototype.doBefore = function() {
};

// ... /DO

/**
 * @param {Object}
 *            root
 */
AbstractPresenterView.prototype.draw = function(root) {
	this.root = root;
	this.doBefore();
	this.doBindEventHandler();
};

// FUNCTIONS