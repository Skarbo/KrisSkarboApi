/**
 * SessionsRetrieved event
 */
SessionsRetrievedEvent.prototype = new Event();

/**
 * Search Event
 */
function SessionsRetrievedEvent() {
}

// VARIABLES

SessionsRetrievedEvent.TYPE = "SessionsRetrievedEvent";

// /VARIABLES

// FUNCTIONS

SessionsRetrievedEvent.prototype.getType = function() {
	return SessionsRetrievedEvent.TYPE;
};

// /FUNCTIONS
