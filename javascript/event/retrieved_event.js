/**
 * Scale event
 */
RetrievedEvent.prototype = new Event();

function RetrievedEvent(type, retrieved) {
	this.retrievedType = type;
	this.retrieved = retrieved;
}

// VARIABLES

RetrievedEvent.TYPE = "RetrievedEvent";

// /VARIABLES

// FUNCTIONS

RetrievedEvent.prototype.getRetrievedType = function() {
	return this.retrievedType;
};

RetrievedEvent.prototype.getRetrieved = function() {
	return this.retrieved;
};

RetrievedEvent.prototype.getType = function() {
	return RetrievedEvent.TYPE;
};

// /FUNCTIONS
