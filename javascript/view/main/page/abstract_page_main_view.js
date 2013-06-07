// CONSTRUCTOR

function AbstractPageMainView(view) {
	this.view = view;
}

// /CONSTRUCTOR

// VARIABLES

// /VARIABLES

// FUNCTIONS

/**
 * @param {AbstractMainView}
 *            view
 */
AbstractPageMainView.prototype.setView = function(view) {
	this.view = view;
};

/**
 * @returns {AbstractMainView}
 */
AbstractPageMainView.prototype.getView = function() {
	return this.view;
};

/**
 * @param {Object}
 *            root
 */
AbstractPageMainView.prototype.setRoot = function(root) {
	this.root = root;
};

/**
 * @returns {Object}
 */
AbstractPageMainView.prototype.getRoot = function() {
	return this.root;
};

// ... GET

/**
 * @returns {Number} Mode
 */
AbstractPageMainView.prototype.getMode = function() {
	return this.getView().getController().getMode();
};

/**
 * @returns {AbstractMainController} Event handler
 */
AbstractPageMainView.prototype.getController = function() {
	return this.getView().getController();
};

/**
 * @returns {EventHandler} Event handler
 */
AbstractPageMainView.prototype.getEventHandler = function() {
	return this.getController().getEventHandler();
};

// ... /GET

// ... DO

AbstractPageMainView.prototype.doBindEventHandler = function() {
};

/**
 * Before bind event
 */
AbstractPageMainView.prototype.doBefore = function() {
};

// ... /DO

/**
 * @param {Element}
 *            root
 */
AbstractPageMainView.prototype.draw = function(root) {
	this.setRoot(root);
	this.doBefore();
	this.doBindEventHandler();
};

// FUNCTIONS
