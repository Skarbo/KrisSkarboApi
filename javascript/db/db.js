/**
 * @param {string}
 *            dbDatabase
 * @param {string}
 *            dbVersion
 * @param {string}
 *            dbDesc
 * @param {string}
 *            dbSize
 * @param {function}
 *            errorHandler
 */
function Db(dbDatabase, dbVersion, dbDesc, dbSize, errorHandler) {
	this.db = null;
	this.dbDatabase = dbDatabase;
	this.dbVersion = dbVersion;
	this.dbDesc = dbDesc;
	this.dbSize = dbSize;
	this.errorHandler = errorHandler;
}

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... IS

/**
 * @returns {boolean} True if database is supported
 */
Db.prototype.isSupport = function() {
	return window.openDatabase;
};

/**
 * @returns {boolean} True if database is connected
 */
Db.prototype.isConnected = function() {
	return this.db != null;
};

// ... /IS

// ... DO

Db.prototype.doConnect = function() {
	if (this.isSupport()) {
		this.db = openDatabase(this.dbDatabase, this.dbVersion, this.dbDesc,
				this.dbSize);
	} else {
		throw "Open Database is not supported";
	}
};

// ... /DO

/**
 * @param {string}
 *            table
 */
Db.prototype.dropTable = function(table) {
	this.db.transaction(function(tx) {
		var query = Core.sprintf("DROP TABLE IF EXISTS %s", table);
		console.log("DAO drop table", table, quey);
		tx.executeSql(query);
	}, this.handleError);
};

/**
 * @param {string}
 *            table
 * @param {array}
 *            fields
 */
Db.prototype.createTable = function(table, fields) {
	this.db.transaction(function(tx) {
		var query = Core.sprintf("CREATE TABLE IF NOT EXISTS %s (%s)", table,
				fields.join(", "));
		console.debug("DB create table", table, fields, query);
		tx.executeSql(query);
	});
};

/**
 * @param {string}
 *            table
 * @param {object}
 *            where { where : [ value, ... ], ... }
 * @param {function}
 *            generateObject Function( { row } ) : { id : object }
 * @param {function}
 *            callback Function( { id : object, ... } )
 * @param whereOperator
 *            OR
 */
Db.prototype.getRows = function(table, where, generateObject, callback,
		whereOperator) {
	this.db.transaction(function(tx) {

		// Initiate list
		var list = {};

		// Generate fields array
		var whereArray = [], valuesArray = [];
		for (whereKey in where) {
			whereArray.push(Cores.sprintf("%s IN (%s)", field, where[whereKey]
					.join(", ")));
			valuesArray = valuesArray.concat(where[whereKey]);
		}

		// Generate query
		var query = Core.sprintf("SELECT * FROM %s WHERE %s", table,
				fieldsArray.join(Core.sprintf(" %s ", whereOperator)));
		console.debug("DB get rows", table, where, whereOperator, query);
		// Execute SQL
		tx.executeSql(query, valuesArray, function(tx, results) {
			var length = results.rows.length;
			for ( var index = 0; index < length; index++) {

				// Get generated Object
				var object = generateObject(results.rows.item(index));

				// Add Object
				if (object) {
					list.push(object);
				}

			}

			// Callback
			callback(list);

		});

	}, this.errorHandler);
};

/**
 * @param {string}
 *            table
 * @param {object}
 *            fields Object[ field : value, ... ]
 * @param {function}
 *            callback
 */
Db.prototype.insertRow = function(table, fields, callback) {
	this.db.transaction(function(tx) {

		// Generate fields array
		var fieldsArray = [], valuesArray = [], bindsArray = [];
		for (field in fields) {
			fieldsArray.push(field);
			valuesArray.push(fields[field]);
			bindsArray.push("?");
		}

		// Generate query
		var query = Core.sprintf("INSERT INTO %s (%s) VALUES (%s)", table,
				fieldsArray.join(", "), bindsArray.join(", "));
		console.debug("DB insert row", table, fields, query);
		// Execute SQL
		tx.executeSql(query, valuesArray);

		// Callback
		if (callback) {
			callback();
		}

	}, function(err) {
		console.error("DB insert row error", table, fields, err);

		// // Constrain error
		// if (err.code == 1) {
		// // Update Movie
		// // context.updateMovie(movie);
		// }
		// // Handle error
		// else {
		// this.errorHandler(err);
		// }
		this.errorHandler(err);

	});
};

/**
 * @param {string}
 *            table
 * @param {object}
 *            fields { field : value, ... }
 * @param {object}
 *            where { where : [ value, ... ], ... }
 * @param {function}
 *            callback Function()
 * @param {string}
 *            whereOperator OR
 */
Db.prototype.updateRow = function(table, fields, where, callback, whereOperator) {
	this.db.transaction(function(tx) {

		if (whereOperator == undefined) {
			whereOperator = "OR";
		}

		// Generate fields array
		var fieldsArray = [], bindsArray = [], whereArray = [];
		for (field in fields) {
			fieldsArray.push(Core.sprintf("%s = ?", field));
			bindsArray.push(fields[field]);
		}
		for (whereKey in where) {
			whereArray.push(Core.sprintf("%s IN (%s)", whereKey,
					where[whereKey].join(", ")));
			bindsArray = bindsArray.concat(where[whereKey]);
		}

		// Generate query
		var query = Core.sprintf("UPDATE %s SET %s WHERE %s = ?", table,
				fieldsArray.join(", "), whereArray.join(Core.sprintf(" %s ",
						whereOperator)));
		console.debug("DB update row", table, fields, where, whereOperator,
				query);
		// Execute SQL
		tx.executeSql(query, bindsArray);

		// Callback
		if (callback) {
			callback();
		}

	}, this.errorHandler);
};

/**
 * @param {string}
 *            table
 * @param {object}
 *            where { where : [ value, ... ], ... }
 * @param {function}
 *            callback Function()
 * @param {string}
 *            whereOperator OR
 */
Db.prototype.deleteRow = function(table, where, callback, whereOperator) {
	this.db.transaction(function(tx) {

		if (whereOperator == undefined) {
			whereOperator = "OR";
		}

		// Generate where array
		var whereArray = [], bindsArray = [];
		for (whereKey in where) {
			whereArray.push(Core.sprintf("%s IN (%s)", whereKey,
					where[whereKey].join(", ")));
			bindsArray = bindsArray.concat(where[whereKey]);
		}

		// Generate query
		var query = Core.sprintf("DELETE FROM %s WHERE %s", table, whereArray
				.join(Core.sprintf(" %s ", whereOperator)));
		console.debug("DB delete row", table, where, whereOperator, query);
		// Execute SQL
		tx.executeSql(query, bindsArray);

		// Callback
		if (callback) {
			callback();
		}

	}, this.errorHandler);
};

/**
 * @param {string}
 *            table
 * @param {function}
 *            callback Function()
 */
Db.prototype.deleteAllRows = function(table, callback) {
	this.db.transaction(function(tx) {

		// Generate query
		var query = Core.sprintf("DELETE FROM %s", table);
		console.debug("DB delete all rows", table, query);
		// Execute SQL
		tx.executeSql(query, bindsArray);

		// Callback
		if (callback) {
			callback();
		}

	}, this.errorHandler);
};

// /FUNCTIONS
