MaploadedEvent.prototype = new Event();

function MaploadedEvent() {
}

// VARIABLES

MaploadedEvent.TYPE = "MaploadedEvent";

// /VARIABLES

// FUNCTIONS

MaploadedEvent.prototype.getType = function() {
	return MaploadedEvent.TYPE;
};

// /FUNCTIONS
