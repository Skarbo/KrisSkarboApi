/**
 * Slider
 */
function Slider() {
}

// VARIABLES

Slider.SLIDER_WRAPPER_CLASS = "slider_wrapper";
Slider.SLIDER_SWIPE_CLASS = "swipe";
Slider.SLIDER_CONTENT_CLASS = "slider_content";
Slider.SLIDER_SCROLLER_WRAPPER_CLASS = "slider_scroller_wrapper";
Slider.SLIDER_SCROLLER_HANDLE_CLASS = "slider_scroller_handle";
Slider.SLIDER_SCROLLER_HANDLE_DRAG_CLASS = "drag";

// /VARIABLES

// FUNCTIONS

// /FUNCTIONS

(function($) {

	$.fn.slider = function(options) {
		return this.each(function() {

			var content = $(this);

			// Get content display
			var contentDisplay = content.css("display");

			// Hide content
			content.hide();

			// Settings
			var settings = $.extend({
				'id' : null,
				'class' : null,
				'width' : null,
				'width-parent' : null
			}, options);
			var swipe = {};

			// Get wrapper id, class and width
			settings["id"] = settings["id"] || content.attr("data-id");
			settings["class"] = settings["class"] || content.attr("data-class");
			settings["width"] = settings["width"] || content.attr("data-width");
			settings["width-parent"] = settings["width-parent"] || content.attr("data-width-parent");

			// DOM-ELEMENTS

			// Create wrapper
			var wrapper = $("<div />", {
				"class" : Slider.SLIDER_WRAPPER_CLASS,
				"id" : settings["id"]
			});

			wrapper.addClass(settings["class"]);

			// Wrapper width
			if (settings["width"]) {
				wrapper.css("width", settings["width"]);
			}

			// Wrapper width from parent
			if (settings["width-parent"]) {
				var widthParentElement = $(settings["width-parent"]);
				if (widthParentElement.length > 0) {
					wrapper.css("width", widthParentElement.innerWidth());
				}
			}

			// Create scroller handle
			var scrollerHandle = $("<div />", {
				"class" : Slider.SLIDER_SCROLLER_HANDLE_CLASS,
				"html" : "&nbsp;"
			});

			// Create scroller wrapper
			var scrollerWrapper = $("<div />", {
				"class" : Slider.SLIDER_SCROLLER_WRAPPER_CLASS,
				"html" : scrollerHandle
			});

			// Add content class
			content.addClass(Slider.SLIDER_CONTENT_CLASS);

			// Wrap content
			content.wrap(wrapper);

			// Add scroller after content
			content.after(scrollerWrapper);

			// Show content
			content.css("display", contentDisplay);

			// /DOM-ELEMENTS

			// SLIDER

			// Get handle width
			var handleWidth = wrapper.innerWidth() / content.innerWidth();

			// Get handle slide max
			var handleSlideMax = Math.round(wrapper.innerWidth() - (handleWidth * wrapper.innerWidth()));

			// Get content slide max
			var contentSlideMax = Math.round(content.innerWidth() - wrapper.innerWidth());

			// Set handle properties
			scrollerHandle.attr("data-handle-slide-max", handleSlideMax);
			scrollerHandle.attr("data-content-slide-max", contentSlideMax);

			// Set handle width
			scrollerHandle.css("width", Math.round(handleWidth * wrapper.innerWidth()) + "px");

			// /SLIDER

			// DRAG

			// Handle drag
			scrollerHandle.drag(function(event, dd) {

				// Get handle
				var handle = $(dd.target);

				// Get content
				var content = handle.parent().parent().find("." + Slider.SLIDER_CONTENT_CLASS);

				// Get handle properties
				var handleSlideMax = parseInt(handle.attr("data-handle-slide-max"));
				var contentSlideMax = parseInt(handle.attr("data-content-slide-max"));
				var handleMarginOriginal = parseInt(handle.attr("data-margin-original"));

				// Calculate handle margin
				var handleMargin = Math.min(Math.max(0, handleMarginOriginal + dd.deltaX), handleSlideMax);

				// Calculate slide procent
				var slideProcent = handleMargin / handleSlideMax;

				// Calculate content margin
				var contentMargin = Math.round(contentSlideMax * slideProcent) * -1;

				// Set handle margin
				handle.css({
					"margin-left" : handleMargin
				});

				// Set content margin
				content.css({
					"margin-left" : contentMargin
				});

			}, {
				"relative" : true
			});

			// Handle drag start
			scrollerHandle.drag("start", function(event, dd) {
				// Set original handle margin
				$(dd.target).attr("data-margin-original", $(dd.target).css("margin-left").replace("px", ""));
				$(dd.target).addClass(Slider.SLIDER_SCROLLER_HANDLE_DRAG_CLASS);
			});

			// Handle drag end
			scrollerHandle.drag("end", function(event, dd) {
				$(dd.target).removeClass(Slider.SLIDER_SCROLLER_HANDLE_DRAG_CLASS);
			});

			// Handle scroller wrapper click
			scrollerWrapper.click(function(event) {
				if (event.target == this) {

					// Get wrapper
					var wrapper = $(event.target);

					// Get handle
					var handle = wrapper.find("." + Slider.SLIDER_SCROLLER_HANDLE_CLASS);

					// Get content
					var content = handle.parent().parent().find("." + Slider.SLIDER_CONTENT_CLASS);

					// Get handle properties
					var handleSlideMax = parseInt(handle.attr("data-handle-slide-max"));
					var contentSlideMax = parseInt(handle.attr("data-content-slide-max"));

					// Calculate handle margin
					var handleMargin = Math.min(handleSlideMax, Math.max(0, Math.round((event.pageX - wrapper
							.position().left)
							- (handle.width() / 2))));

					// Calculate slide procent
					var slideProcent = handleMargin / handleSlideMax;

					// Calculate content margin
					var contentMargin = Math.round(contentSlideMax * slideProcent) * -1;

					// Set handle margin
					handle.css({
						"margin-left" : handleMargin
					});

					// Set content margin
					content.css({
						"margin-left" : contentMargin
					});

				}
			});

			// /DRAG

			// SWIPE

			// Touch start
			content.bind("touchstart", function(event) {
				if (event.originalEvent.touches != null && event.originalEvent.touches.length > 0) {
					swipe.start = event.originalEvent.touches[0].pageX;
					swipe.swipe = null;
				}
			});

			// Touch move
			content.bind("touchmove", function(event) {

				// Ensure swiping, not pinching
				if (event.originalEvent.touches.length > 1 || event.originalEvent.scale
						&& event.originalEvent.scale !== 1) {
					return;
				}

				if (swipe.start != null) {
					swipe.swipe = event.originalEvent.touches[0].pageX;
				}

			});

			// Touch end
			content.bind("touchend", function(event) {

				if (swipe.start != null && swipe.swipe != null) {

					// Target
					var target = $(event.target);

					// Get wrapper
					var wrapper = target.parentsUntil("." + Slider.SLIDER_WRAPPER_CLASS).parent();

					// Get content
					var content = wrapper.find("." + Slider.SLIDER_CONTENT_CLASS);

					// Get handle
					var handle = wrapper.find("." + Slider.SLIDER_SCROLLER_WRAPPER_CLASS + " ."
							+ Slider.SLIDER_SCROLLER_HANDLE_CLASS);

					// Get content slide max
					var contentSlideMax = parseInt(handle.attr("data-content-slide-max"));

					// Get handle slide max
					var handleSlideMax = parseInt(handle.attr("data-handle-slide-max"));

					// Get delta
					var delta = (swipe.swipe - swipe.start)*-1; // != null &&
					// parseInt(event.originalEvent.touches[0].pageX
					// - swipe);

					// Get procentile
					var procentile = delta / wrapper.width();

					// Get content margin
					var contentMargin = parseInt(content.css("margin-left").replace("px", "")) * -1;
					var contentMarginNew = Math.max(0, Math.min(contentSlideMax, Math.round(contentMargin
							+ (contentSlideMax * procentile))));

					// Cancel if no change
					if (delta == 0 || contentMargin == contentMarginNew) {
						return;
					}

					// Get handle margin
					var handleMargin = parseInt(handle.css("margin-left").replace("px", ""));
					var handleMarginNew = Math.max(0, Math.min(handleSlideMax, Math.round(handleMargin
							+ (handleSlideMax * procentile))));

					// Set new handle/content margin
					handle.css("margin-left", handleMarginNew);
					content.css("margin-left", (contentMarginNew * -1));

					swipe.start = null;
					swipe.swipe = null;

				}
			});

			// /SWIPE

		});
	};

})(jQuery);

// RESIZE

// Wrapper width from parent
$(window).resize(
		function() {
				$("#log").text("Resize: " + new Date().getTime());
			var content = $("." + Slider.SLIDER_CONTENT_CLASS + "[data-resize][data-width-parent]");

			if (content.length == 0) {
				return;
			}

			content.each(function(i, element) {
				var element = $(element);
				var wrapper = element.parent();
				var handle = wrapper.find("." + Slider.SLIDER_SCROLLER_WRAPPER_CLASS + " ."
						+ Slider.SLIDER_SCROLLER_HANDLE_CLASS);
				var widthParentElement = $(element.attr("data-width-parent"));
				
				if (widthParentElement.length > 0) {
					
					// Don't resize if parent width not changed
					if (wrapper.innerWidth() == widthParentElement.innerWidth())
					{
						return;
					}
					
					// Hide wrapper
					var wrapperDisplay = wrapper.css("display");
					wrapper.css("display", "none");
					
					// Set wrapper width
					wrapper.css("width", widthParentElement.innerWidth());
					
					// Show wrapper
					wrapper.css("display", wrapperDisplay);
					
					// Get handle width
					var handleWidth = wrapper.innerWidth() / element.innerWidth();

					// Get content slide
					var contentSlide = parseInt(element.css("margin-left").replace("px", "")) * -1;
										
					// Get content slide max
					var contentSlideMax = handle.attr("data-content-slide-max");
					
					// Slide procentile
					var slideProcentile = Math.max(0.0, Math.min(1.0, contentSlide / contentSlideMax));
					
					// Get new handle slide max
					var handleSlideMaxNew = Math.round(wrapper.innerWidth() - (handleWidth * wrapper.innerWidth()));

					// Get new content slide max
					var contentSlideMaxNew = Math.round(element.innerWidth() - wrapper.innerWidth()); 
					
					// Set handle width
					handle.css("width", Math.round(handleWidth * wrapper.innerWidth()) + "px");
					
					// Set handle properties
					handle.attr("data-handle-slide-max", handleSlideMaxNew);
					handle.attr("data-content-slide-max", contentSlideMaxNew);

					// Set handle margin
					handle.css("margin-left", Math.round(handleSlideMaxNew * slideProcentile));
					
					// Set content margin
					element.css("margin-left", Math.round(contentSlideMaxNew * slideProcentile) * -1);
					
				}
			});

		});

// /RESIZE
