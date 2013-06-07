$(function() {

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

			return this.each(function() {
				var input = $(this), title = input.attr("title") || input.attr("data-hint"), form = $(this.form), win = $(window), hintClass = data.options.clas;

				function remove() {
					if (input.val() === title && input.hasClass(hintClass)) {
						input.val("").removeClass(hintClass);
					}
				}

				if (title) {
					input.attr("title", title);
					input.blur(function() {
						if (this.value === "") {
							input.val(title).addClass(hintClass);
						}
					}).focus(remove).blur();

					form.submit(remove);
					win.unload(remove);
				}
			});

		},
		value : function(value) {
			var $this = $(this), data = $this.data(INPUTHINT_DATA);

			if (value != undefined && value != "") {
				$this.each(function(i) {
					$(this).val(value);
					if (value != "") {
						$(this).val(value).removeClass(data.options.clas);
					}
				});
			} else if (value == undefined) {
				var values = [];
				$this.each(function(i) {
					values.push($(this).hasClass(data.options.clas) ? "" : $(this).val());
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

	// TOUCH ACTIVE

	var TOUCHACTIVE_CLASS = "touching";

	var touchActiveMethods = {
		init : function(options) {
			var class_ = options && options["class"] ? options["class"] : TOUCHACTIVE_CLASS;
			return $(this).unbind(".touching").bind("touchstart.touching touchend.touching touchcancel.touching mousedown.touching mouseup.touching", {
				"clas" : class_
			}, function(event) {
				if (event.type == "touchstart" || event.type == "mousedown") {
					$(this).addClass(event.data.clas);
				} else {
					$(this).removeClass(event.data.clas);
				}
			});
		}
	};

	$.fn.touchActive = function(method) {
		if (inputhintMethods[method]) {
			return touchActiveMethods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return touchActiveMethods.init.apply(this, arguments);
		} else {
			$.error('Method ' + method + ' does not exist on jQuery.touchActive');
		}
	};

	// /TOUCH ACTIVE

	// FILL HEIGHT

	$.fn.fillHeight = function() {
		var windowHeight = $(window).height();
		var documentHeight = $(document).height();
		$(this).height((windowHeight > documentHeight ? windowHeight : documentHeight) - $(this).offset().top - ($(this).outerHeight(true) - $(this).height()));
	};

	// /FILL HEIGHT

	// FIT TO PARENT

	$.fn.fitToParent = function() {
		var parent = null, target = null, parentSelector = null, fitparentType = null;
		$(this).filter("[data-fitparent],[data-fitparent-width]").each(function(i, element) {
			target = $(element);
			fitparentType = target.attr("data-fitparent-width") ? "width" : "all";
			parentSelector = target.attr(fitparentType == "width" ? "data-fitparent-width" : "data-fitparent");
			parent = parentSelector == "true" ? null : target.parentsUntil(parentSelector).parent();
			parent = parent && parent.length > 0 ? parent : target.parent();
			if (fitparentType == "width") {
				target.width(parent.width());
			} else {
				target.width(parent.width()).height(parent.height());
			}
		});
	};

	// /FIT TO PARENT

	// JQUERY UI ACTIVE

	$.fn.jqueryUiActive = function(inactive) {
		$(this).each(function() {
			var $this = $(this), next = $this.next();
			var button = $(this).find("ui-button");
			if (button.length == 0 && next.hasClass("ui-button"))
				button = next;

			next.addClass("ui-state-active").attr("aria-pressed", "true");

			$this.prop("checked", true);
		});
	};

	// /JQUERY UI ACTIVE

});

/**
 * jQuery.fn.sortElements
 * --------------
 * @param Function comparator:
 *   Exactly the same behaviour as [1,2,3].sort(comparator)
 *   
 * @param Function getSortable
 *   A function that should return the element that is
 *   to be sorted. The comparator will run on the
 *   current collection, but you may want the actual
 *   resulting sort to occur on a parent or another
 *   associated element.
 *   
 *   E.g. $('td').sortElements(comparator, function(){
 *      return this.parentNode; 
 *   })
 *   
 *   The <td>'s parent (<tr>) will be sorted instead
 *   of the <td> itself.
 */
jQuery.fn.sortElements = (function(){
 
    var sort = [].sort;
 
    return function(comparator, getSortable) {
 
        getSortable = getSortable || function(){return this;};
 
        var placements = this.map(function(){
 
            var sortElement = getSortable.call(this),
                parentNode = sortElement.parentNode,
 
                // Since the element itself will change position, we have
                // to have some way of storing its original position in
                // the DOM. The easiest way is to have a 'flag' node:
                nextSibling = parentNode.insertBefore(
                    document.createTextNode(''),
                    sortElement.nextSibling
                );
 
            return function() {
 
                if (parentNode === this) {
                    throw new Error(
                        "You can't sort elements if any one is a descendant of another."
                    );
                }
 
                // Insert before flag:
                parentNode.insertBefore(this, nextSibling);
                // Remove flag:
                parentNode.removeChild(nextSibling);
 
            };
 
        });
 
        return sort.call(this, comparator).each(function(i){
            placements[i].call(getSortable.call(this));
        });
 
    };
 
})();