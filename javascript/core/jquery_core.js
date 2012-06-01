(function($) {
<<<<<<< HEAD

	// SERIALIZE FORM TO JSON

=======
>>>>>>> ca9894a39c3802f40ea1cd2a22a42091edaffc6a
	$.fn.serializeJSON = function() {
		var json = {};
		jQuery.map($(this).serializeArray(), function(n, i) {
			json[n['name']] = n['value'];
		});
		return json;
	};

<<<<<<< HEAD
	// /SERIALIZE FORM TO JSON

=======
>>>>>>> ca9894a39c3802f40ea1cd2a22a42091edaffc6a
	// INPUT HINT

	var INPUTHINT_CLASS = "hint";
	var INPUTHINT_DATA = "inputHint";

	var inputhintMethods = {
		init : function(options) {
<<<<<<< HEAD
			var data = $(this).data(INPUTHINT_DATA);

			// Data init
			if (!data) {
				options = $.extend({
					"class" : INPUTHINT_CLASS
				}, options);
				$(this).data(INPUTHINT_DATA, {
					options : options
				});
				data = $(this).data(INPUTHINT_DATA);
			}

			return this
					.each(function() {
						var $input = jQuery(this), title = $input.attr("title"), $form = jQuery(this.form), $win = jQuery(window), hintClass = data.options.class;

						function remove() {
							if ($input.val() === title && $input.hasClass(hintClass)) {
								$input.val("").removeClass(hintClass);
							}
						}

						if (title) {
							$input.blur(function() {
								if (this.value === "") {
									$input.val(title).addClass(hintClass);
								}
							}).focus(remove).blur();

							$form.submit(remove);
							$win.unload(remove);
						}
					});
=======

			var $this = $(this), data = $this.data(INPUTHINT_DATA);

			if (!data) {

				// Data
				var settings = $.extend({
					'class' : INPUTHINT_CLASS,
					'hint' : $this.attr("title"),
					'value' : $this.val()
				}, options);

				$(this).data(INPUTHINT_DATA, {
					target : $this,
					settings : settings
				});

				data = $this.data(INPUTHINT_DATA);

			}

			// Hint
			$this.inputHint('hint', data.settings.hint);

			// Value
			$this.inputHint('value', data.settings.value);

			// Handle form submit
			$this.parents('form:first').each(function(i) {
				var namespace = "submit.inputhint." + data.settings.class;
				$(this).bind(namespace, function(event) {
					$this.inputHint("reset");
				});
			});

			// Hook up
			return $this.focus(function() {
				var data = $(this).data(INPUTHINT_DATA);
				if ($(this).val() == $(this).attr("title")) {
					$(this).val("").removeClass(data.settings.class);
				}
			}).blur(function() {
				var data = $(this).data(INPUTHINT_DATA);
				if ($(this).val() == "") {
					$(this).val($(this).attr("title")).addClass(data.settings.class);
				}
			});
		},
		destroy : function() {

			var $this = $(this), data = $this.data(INPUTHINT_DATA);

			data.inputHint.remove();
			$this.removeData(INPUTHINT_DATA);

			return $this;
>>>>>>> ca9894a39c3802f40ea1cd2a22a42091edaffc6a

		},
		value : function(value) {
			var $this = $(this), data = $this.data(INPUTHINT_DATA);
<<<<<<< HEAD

			if (value != undefined && value != "") {
				$this.each(function(i) {
					$(this).val(value);
					if (value != "") {
						$(this).val(value).removeClass(data.options.class);
					}
				});
			} else if (value == undefined) {
				var values = [];
				$this.each(function(i) {
					values.push($(this).hasClass(data.options.class) ? "" : $(this).val());
				});
				return values.length == 0 ? "" : (values.length == 1 ? values[0] : values);
			} else if (value == "") {
				$this.each(function(i) {
					$(this).val("").blur();
				});
			}
=======
			value = value || "";

			$this.each(function(i) {
				$(this).val(value);
				if (value != "") {
					$(this).val(value).removeClass(data.settings.class);
				}
			});
		},
		hint : function(hint) {
			var $this = $(this), data = $this.data(INPUTHINT_DATA);
			hint = hint || "";

			$this.each(function(i) {
				$(this).attr("title", hint);
				if ($(this).val() == "" || $(this).val() == hint) {
					$(this).val(hint).addClass(data.settings.class);
				}
			});
		},
		reset : function() {
			var $this = $(this), data = $this.data(INPUTHINT_DATA);

			$this.each(function(i) {
				if ($(this).attr("title") == $(this).val()) {
					$(this).val("");
				}
			});
>>>>>>> ca9894a39c3802f40ea1cd2a22a42091edaffc6a
		}
	};

	$.fn.inputHint = function(method) {

		if (inputhintMethods[method]) {
			return inputhintMethods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return inputhintMethods.init.apply(this, arguments);
		} else {
			$.error('Method ' + method + ' does not exist on jQuery.inputHint');
		}

	};

	// /INPUT HINT

})(jQuery);