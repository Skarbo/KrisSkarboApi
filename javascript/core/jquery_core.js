(function($) {

	// SERIALIZE FORM TO JSON

	$.fn.serializeJSON = function() {
		var json = {};
		jQuery.map($(this).serializeArray(), function(n, i) {
			json[n['name']] = n['value'];
		});
		return json;
	};

	// /SERIALIZE FORM TO JSON

	// INPUT HINT

	var INPUTHINT_CLASS = "hint";
	var INPUTHINT_DATA = "inputHint";

	var inputhintMethods = {
		init : function(options) {
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

		},
		value : function(value) {
			var $this = $(this), data = $this.data(INPUTHINT_DATA);

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