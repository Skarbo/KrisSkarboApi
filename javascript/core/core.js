/**
 * Core
 */
function Core() {
}

/**
 * @param {float}
 *            Number
 * @param {integer}
 *            Decimal places
 * @return {float} Rounded number
 */
Core.roundNumber = function(num, dec) {
	var result = Math.round(num * Math.pow(10, dec)) / Math.pow(10, dec);
	return result.toFixed(dec);
};

/**
 * Copyright (c) Alexandru Marasteanu <alexaholic [at) gmail (dot] com> All
 * rights reserved.
 * 
 * @returns {string}
 */
Core.sprintf = function() {
	var str_repeat = function(i, m) {
		for ( var o = []; m > 0; o[--m] = i)
			;
		return o.join('');
	};

	try {
		var i = 0, a, f = arguments[i++], o = [], m, p, c, x, s = '';
		while (f) {
			if (m = /^[^\x25]+/.exec(f)) {
				o.push(m[0]);
			} else if (m = /^\x25{2}/.exec(f)) {
				o.push('%');
			} else if (m = /^\x25(?:(\d+)\$)?(\+)?(0|'[^$])?(-)?(\d+)?(?:\.(\d+))?([b-fosuxX])/.exec(f)) {
				if (((a = arguments[m[1] || i++]) == null) || (a == undefined)) {
					throw ('Too few arguments for string \"' + arguments[0] + '\"');
				}
				if (/[^s]/.test(m[7]) && (typeof (a) != 'number')) {
					throw ('Expecting number but found ' + typeof (a));
				}
				switch (m[7]) {
				case 'b':
					a = a.toString(2);
					break;
				case 'c':
					a = String.fromCharCode(a);
					break;
				case 'd':
					a = parseInt(a);
					break;
				case 'e':
					a = m[6] ? a.toExponential(m[6]) : a.toExponential();
					break;
				case 'f':
					a = m[6] ? parseFloat(a).toFixed(m[6]) : parseFloat(a);
					break;
				case 'o':
					a = a.toString(8);
					break;
				case 's':
					a = ((a = String(a)) && m[6] ? a.substring(0, m[6]) : a);
					break;
				case 'u':
					a = Math.abs(a);
					break;
				case 'x':
					a = a.toString(16);
					break;
				case 'X':
					a = a.toString(16).toUpperCase();
					break;
				}
				a = (/[def]/.test(m[7]) && m[2] && a >= 0 ? '+' + a : a);
				c = m[3] ? m[3] == '0' ? '0' : m[3].charAt(1) : ' ';
				x = m[5] - String(a).length - s.length;
				p = m[5] ? str_repeat(c, x) : '';
				o.push(s + (m[4] ? a + p : p + a));
			} else {
				throw ('Huh ?!');
			}
			f = f.substring(m[0].length);
		}

	} catch (e) {
		console.error("Core.sprintf error:", e, arguments);
		return;
	}
	return o.join('');
};

/**
 * @return {String} Object class name
 */
Core.objectClass = function(obj) {
	if (obj && obj.constructor && obj.constructor.toString) {
		var arr = obj.constructor.toString().match(/function\s*(\w+)/);

		if (arr && arr.length == 2) {
			return arr[1];
		}
	}

	return undefined;
};

Core.prettyDate = function(time) {
	var time_formats = [ [ 60, 'just now', 1 ], // 60
	[ 120, '1 minute ago', '1 minute from now' ], // 60*2
	[ 3600, 'minutes', 60 ], // 60*60, 60
	[ 7200, '1 hour ago', '1 hour from now' ], // 60*60*2
	[ 86400, 'hours', 3600 ], // 60*60*24, 60*60
	[ 172800, 'yesterday', 'tomorrow' ], // 60*60*24*2
	[ 604800, 'days', 86400 ], // 60*60*24*7, 60*60*24
	[ 1209600, 'last week', 'next week' ], // 60*60*24*7*4*2
	[ 2419200, 'weeks', 604800 ], // 60*60*24*7*4, 60*60*24*7
	[ 4838400, 'last month', 'next month' ], // 60*60*24*7*4*2
	[ 29030400, 'months', 2419200 ], // 60*60*24*7*4*12, 60*60*24*7*4
	[ 58060800, 'last year', 'next year' ], // 60*60*24*7*4*12*2
	[ 2903040000, 'years', 29030400 ], // 60*60*24*7*4*12*100, 60*60*24*7*4*12
	[ 5806080000, 'last century', 'next century' ], // 60*60*24*7*4*12*100*2
	[ 58060800000, 'centuries', 2903040000 ] // 60*60*24*7*4*12*100*20,
	// 60*60*24*7*4*12*100
	];
	// var time = ('' + date_str).replace(/-/g, "/").replace(/[TZ]/g, " ")
	// .replace(/^\s\s*/, '').replace(/\s\s*$/, '');
	// if (time.substr(time.length - 4, 1) == ".")
	// time = time.substr(0, time.length - 4);
	var time = isNaN(time) ? parseInt(time) : time;
	var time = ("" + time).length == 14 ? time : time * 1000;
	var seconds = (new Date - new Date(time)) / 1000;
	var token = 'ago', list_choice = 1;
	if (seconds < 0) {
		seconds = Math.abs(seconds);
		token = 'from now';
		list_choice = 2;
	}
	var i = 0, format;
	while (format = time_formats[i++])
		if (seconds < format[0]) {
			if (typeof format[2] == 'string')
				return format[list_choice];
			else
				return Math.floor(seconds / format[2]) + ' ' + format[1] + ' ' + token;
		}
	return time;
};

/**
 * Copy JSON
 * 
 * @return {object}
 */
Core.copyJson = function(json) {
	var copy = {};

	for (key in json) {
		copy[key] = json[key];
	}

	return copy;
};

/**
 * @param {string}
 *            path
 * @param {Object}
 *            params
 */
Core.postToUrl = function(path, params) {
	var params = params || {};

	var form = document.createElement("form");
	form.setAttribute("method", "post");
	form.setAttribute("action", path);

	for ( var key in params) {
		if (params.hasOwnProperty(key)) {
			var hiddenField = document.createElement("input");
			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", key);
			hiddenField.setAttribute("value", params[key]);

			form.appendChild(hiddenField);
		}
	}

	document.body.appendChild(form);
	form.submit();
};

Core.removeDefaultText = function(formElement) {
	var input;
	formElement.find("input.default_text").each(function(i, element) {
		input = $(element);
		if (input.attr("title") == input.val()) {
			input.val("");
		}
	});
	return formElement;
};

/**
 * @param obj
 * @returns {Number}
 */
Core.countObject = function(obj) {
	var count = 0;

	for ( var prop in obj) {
		if (obj.hasOwnProperty(prop))
			++count;
	}

	return count;
};