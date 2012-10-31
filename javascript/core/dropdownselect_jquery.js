(function($) {

	var dropdownSelectMethods = {
		init : function(options) {
			options = options || {};
			return this.each(function() {
				var $this = $(this), data = $this.data("dropdown_select"), init = false;

				// Data
				if (!data) {
					$(this).data("dropdown_select", {
						dropdown : $this,
						options : options
					});
					data = $this.data("dropdown_select");
					init = true;
				}
				var name = $this.attr("data-name");
				var callback = data.options.callback;

				// Selected element
				var selectedElement = $this.find(".dropdown_selected").length > 0 ? $this.find(".dropdown_selected") :
				$("<div />", {
					"class" : "dropdown_selected"
			    });

				// Value element
			    var valueElement = $this.find(".dropdown_value").length > 0 ? $this.find(".dropdown_value") :
			    $("<input />", {
			        "class" : "dropdown_value",
			        "type" : "hidden",
			        "name" : name
			    });

				// Contents element
			    var contentsElement = $this.find(".dropdown_contents").length > 0 ? $this.find(".dropdown_contents") :
			    $("<div />", {
			        "class" : "dropdown_contents"
			    });

			    if (init)
			    {
				    $this.addClass("dropdown");
			    	$this.children().appendTo(contentsElement);
			    	$this.append(selectedElement);
			    	$this.append(contentsElement);
			    	$this.append(valueElement);
			    	data.options.contentsElement = contentsElement;
			    	data.options.selectedElement = selectedElement;
			    	data.options.valueElement = valueElement;
			    }

			    contentsElement.children().addClass("dropdown_content");

			    // Bind content
			    contentsElement.children().unbind("click.dropdown").bind("click.dropdown", { context : $this, callback : callback }, function(event){
				    if ($(this).attr("data-value")) {
				        event.data.context.dropdownSelect("select", $(this).attr("data-value"));
				        console.log("Select dropdown", $(this));
				        if (event.data.callback)
				            event.data.callback($(this).attr("data-value"));
				    }
		        });

			    // Select
			    $this.dropdownSelect("select");
			});
		},
		select : function(value) {
			var $this = $(this), data = $this.data("dropdown_select");
			var selectedElement = data.options.selectedElement;
			var contentsElement = data.options.contentsElement;
			var valueElement = data.options.valueElement;
			var selectedContent = null;
			if (value)
			    selectedContent = contentsElement.children().filter("[data-value=\"" + value + "\"]");
			else
				selectedContent = contentsElement.children().filter("[data-selected]");
		    if (selectedContent.length == 0)
		    	selectedContent = contentsElement.children().length > 0 ? contentsElement.children().filter(":first-child") : null;
		    if (selectedContent && selectedContent.length > 0) {
		    	contentsElement.children().removeAttr("data-selected");
		    	selectedElement.empty().append(selectedContent.clone());
		    	selectedContent.attr("data-selected", "true");
		    	valueElement.val(selectedContent.attr("data-value"));
		    }
		},
		change : function(callback) {
			return this.each(function() {
				var $this = $(this), data = $this.data("dropdown_select");
			    data.callback = callback;
			});
		}
	};

	$.fn.dropdownSelect = function(method) {
		if (dropdownSelectMethods[method]) {
			return dropdownSelectMethods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return dropdownSelectMethods.init.apply(this, arguments);
		} else {
			$.error('Method ' + method + ' does not exist on jQuery.dropdownSelect');
		}
	};


})(jQuery);