/**
 * List Model
 */
List.prototype = new Array();

function List() {
	Array.apply(this, arguments);
}

List.prototype.get = function(index) {
	return this[index];
};

List.prototype.toString = function() {
	var string = "";

	for ( var i = 0; i < this.length; i++) {
		string += this.get(i) + " ";
	}

	return jQuery.trim(string);
};