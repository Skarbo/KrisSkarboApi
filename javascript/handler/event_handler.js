/**
 * Event handler
 */
function EventHandler() {
	this.listeners = new Object();
	this.wait = {};
	this.history = [];
};

// FUNCTIONS

/**
 * @param {String}
 *            Event type to listen to
 * @param {any}
 *            Event listener function, recieves a {Event} as parameter
 */
EventHandler.prototype.registerListener = function(eventType, eventListener) {
	// Event listener must be given
	if (typeof eventListener != "function") {
		console.error("Cannot register listener, event listener must be a function");
		return;
	}

	// Check if listeners for event type is created
	if (this.listeners[eventType] == null) {
		this.listeners[eventType] = new Array();
	}

	// Register listener
	this.listeners[eventType].push(eventListener);
};

/**
 * @param {Event}
 *            Event to handle
 * @param {String}
 *            Event type
 */
EventHandler.prototype.handle = function(event, waitFor, waitForFunc) {
	// Must be an Event
	if (Core.objectClass(event) != "Event") {
		console.error("Cannot handle Event. Argument is of object class \"" + Core.objectClass(event) + "\".");
		return;
	}

	// Add to wait for queue
	if (waitFor && jQuery.inArray(waitFor, this.history) == -1) {
		if (!this.wait[waitFor]) {
			this.wait[waitFor] = [];
		}
		event.waitForFunc = waitForFunc;
		this.wait[waitFor].push(event);
		return;
	}

	// Call event
	this.callEvent(event);

	// Call wait for queue
	if (this.wait[event.getType()] != null && this.wait[event.getType()].length > 0) {
		for (i in this.wait[event.getType()]) {
			if (this.wait[event.getType()][i].waitForFunc) {
				if (this.wait[event.getType()][i].waitForFunc(event)) {
					this.callEvent(this.wait[event.getType()][i]);
					delete this.wait[event.getType()][i];
				}
			} else {
				this.callEvent(this.wait[event.getType()][i]);
				delete this.wait[event.getType()][i];
			}
		}

	}

	// Add to history
	if (jQuery.inArray(event.getType(), this.history) == -1) {
		this.history.push(event.getType());
	}

};

EventHandler.prototype.callEvent = function(event) {

	// Event type must have been registered
	if (this.listeners[event.getType()] == null) {
		return;
	}
	// For each event listeneres
	for ( var i = 0; i < this.listeners[event.getType()].length; i++) {

		// Function as variable
		var func = this.listeners[event.getType()][i];

		// Function must be function
		if (typeof func != "function") {
			console.error("Cannot handle event \"" + event.getType() + "\", listener registered for index \"" + i + "\" is not a function");
			return;
		}

		// Call event listener function
		func(event);

	}

};

// /FUNCTIONS
