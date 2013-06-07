/**
 * Scale event
 */
RetrieveEvent.prototype = new Event();

function RetrieveEvent(type, retrieve) {
	this.retrieveType = type;
	this.retrieve = retrieve;
}

// VARIABLES

RetrieveEvent.TYPE = "RetrieveEvent";

// /VARIABLES

// FUNCTIONS

RetrieveEvent.prototype.getRetrieveType = function() {
	return this.retrieveType;
};

RetrieveEvent.prototype.getRetrieve = function() {
	return this.retrieve;
};

RetrieveEvent.prototype.getType = function() {
	return RetrieveEvent.TYPE;
};

// /FUNCTIONS
