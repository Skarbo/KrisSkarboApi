MaploadEvent.prototype = new Event();

function MaploadEvent() {
	Event.apply(this, arguments);
}

// VARIABLES

MaploadEvent.TYPE = "MaploadEvent";

// /VARIABLES

// FUNCTIONS

MaploadEvent.prototype.getType = function() {
	return MaploadEvent.TYPE;
};

// /FUNCTIONS
