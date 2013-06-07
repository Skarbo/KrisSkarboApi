ResizeEvent.prototype = new Event();

function ResizeEvent() {
}

// VARIABLES

ResizeEvent.TYPE = "ResizeEvent";

// /VARIABLES

// FUNCTIONS

ResizeEvent.prototype.getType = function() {
	return ResizeEvent.TYPE;
};

// /FUNCTIONS
