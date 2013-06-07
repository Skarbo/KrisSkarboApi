MapinitEvent.prototype = new Event();

function MapinitEvent() {
}

// VARIABLES

MapinitEvent.TYPE = "MapinitEvent";

// /VARIABLES

// FUNCTIONS

MapinitEvent.prototype.getType = function() {
	return MapinitEvent.TYPE;
};

// /FUNCTIONS
