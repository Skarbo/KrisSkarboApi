function MapUtil() {
}

/**
 * @param lat1
 * @param lon1
 * @param lat2
 * @param lon2
 * @returns {Number} Distance in km
 */
MapUtil.distance = function(lat1, lon1, lat2, lon2) {
	// Radius of the earth in: 1.609344 miles, 6371 km |
	var R = 6371;
	// var R = 3958.7558657440545; // Radius of earth in Miles
	var dLat = MapUtil.toRad(lat2 - lat1);
	var dLon = MapUtil.toRad(lon2 - lon1);
	var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(MapUtil.toRad(lat1)) * Math.cos(MapUtil.toRad(lat2))
			* Math.sin(dLon / 2) * Math.sin(dLon / 2);
	var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
	var d = R * c;
	return d;
};

MapUtil.toRad = function(value) {
	return value * Math.PI / 180;
};

/**
 * @param {google.maps.Geocoder}
 *            geocoder
 * @param {String}
 *            address
 * @param {Function}
 *            callback Result callback
 */
MapUtil.setLocationAtAddress = function(geocoder, address, callback) {
	geocoder.geocode({
		'address' : address
	}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			if (results[0]) {
				if (callback) {
					callback(results[0]);
				}
			}
		} else {
			console.error("Geocode was not successful for the following reason:", status);
		}
	});
};

/**
 * @param {google.maps.Geocoder}
 *            geocoder
 * @param {google.maps.Marker}
 *            latLng
 * @param {Function}
 *            callback
 */
MapUtil.getAddressAtLocation = function(geocoder, latLng, callback) {
	geocoder.geocode({
		'latLng' : latLng
	}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			if (results[0]) {
				if (callback) {
					callback(results[0]);
				}
			}
		} else {
			console.error("Geocoder failed due to:", status);
		}
	});
};