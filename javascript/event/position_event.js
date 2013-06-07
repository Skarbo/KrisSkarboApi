PositionEvent.prototype = new Event();

function PositionEvent(lanLon, isGeolocation) {
	this.lanLon = lanLon;
	this.isGeolocation = isGeolocation;
}

// VARIABLES

PositionEvent.TYPE = "PositionEvent";

// /VARIABLES

// FUNCTIONS

/**
 * @return {Object} Google LanLon object
 */
PositionEvent.prototype.getLanLon = function() {
	return this.lanLon;
};

PositionEvent.prototype.isGeolocation = function() {
	return this.isGeolocation;
};

PositionEvent.prototype.getType = function() {
	return PositionEvent.TYPE;
};

// /FUNCTIONS
