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

			// Re-iniate
			var reIniate = content.hasClass(Slider.SLIDER_CONTENT_CLASS);

			// Get content display
			var contentDisplay = content.css("display");

			// Content width
			var contentWidth = content.innerWidth();

			// Hide content
			content.hide();

			// Settings
			var settings = $.extend({
				'id' : null,
				'class' : null,
				'width' : null,
				'width-parent' : null,
				'nohandle' : false
			}, options);
			var swipe = {};

			// Get wrapper id, class and width
			settings["id"] = settings["id"] || content.attr("data-id");
			settings["class"] = settings["class"] || content.attr("data-class");
			settings["width"] = settings["width"] || content.attr("data-width");
			settings["width-parent"] = settings["width-parent"] || content.attr("data-width-parent");

			// DOM-ELEMENTS

			// Create wrapper
			var wrapper = !reIniate ? $("<div />", {
				"class" : Slider.SLIDER_WRAPPER_CLASS,
				"id" : settings["id"]
			}) : content.parent();

			wrapper.addClass(settings["class"]);			
			var wrapperDisplay = wrapper.css("display");
			wrapper.hide();

			// Wrapper width
			if (settings["width"]) {
				wrapper.css("width", settings["width"]);
			}

			// Wrapper width from parent
			if (settings["width-parent"]) {
				var widthParentElement = content.closest(settings["width-parent"]);
				if (widthParentElement.length > 0) {
					wrapper.css("width", widthParentElement.innerWidth());
				}
			}

			// Create scroller handle
			var scrollerHandle = !reIniate ? $("<div />", {
				"class" : Slider.SLIDER_SCROLLER_HANDLE_CLASS,
				"html" : "&nbsp;"
			}) : content.parent().find("." + Slider.SLIDER_SCROLLER_HANDLE_CLASS);

			// Create scroller wrapper
			var scrollerWrapper = !reIniate ? $("<div />", {
				"class" : Slider.SLIDER_SCROLLER_WRAPPER_CLASS,
				"html" : scrollerHandle
			}) : content.parent().find("." + Slider.SLIDER_SCROLLER_WRAPPER_CLASS);

			if (!reIniate) {
				// Add content class
				content.addClass(Slider.SLIDER_CONTENT_CLASS);

				// Wrap content
				content.wrap(wrapper);

				// Add scroller after content
				content.after(scrollerWrapper);
			}
			var wrapper = content.closest(".slider_wrapper");

			// Show content/wrapper
			content.css("display", contentDisplay);
			wrapper.css("display", wrapperDisplay);

			// /DOM-ELEMENTS

			// SLIDER

			// Get handle width
			var handleWidth = wrapper.innerWidth() / contentWidth;

			// Get handle slide max
			var handleSlideMax = Math.round(wrapper.innerWidth() - (handleWidth * wrapper.innerWidth()));

			// Get content slide max
			var contentSlideMax = Math.round(contentWidth - wrapper.innerWidth());

			// Set handle properties
			scrollerHandle.attr("data-handle-slide-max", handleSlideMax);
			scrollerHandle.attr("data-content-slide-max", contentSlideMax);

			// Set handle width
			scrollerHandle.css("width", Math.round(handleWidth * wrapper.innerWidth()) + "px");

			// Hide handle
			if (settings["nohandle"])
				scrollerHandle.addClass("hide");
			else
				scrollerHandle.removeClass("hide");

			// /SLIDER

			// WRAPPER

			var slideProcent = parseFloat(scrollerHandle.css("margin-left")) / handleSlideMax;
			if (contentSlideMax > 0 && slideProcent > 0.98)
				wrapper.attr("data-slide-rest", "left");
			else if (contentSlideMax > 0 && slideProcent < 0.02)
				wrapper.attr("data-slide-rest", "right");
			else if (contentSlideMax > 0)
				wrapper.attr("data-slide-rest", "both");
			else
				wrapper.attr("data-slide-rest", null);

			// /WRAPPER

//			if (reIniate)
//				return;

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
			scrollerWrapper.unbind(".slider").bind("click.slider", function(event) {
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
					var handleMargin = Math.min(handleSlideMax, Math.max(0, Math.round((event.pageX - wrapper.position().left) - (handle.width() / 2))));

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

			content.unbind(".slider");

			// Touch start
			var match = null;
			var translateRegex = /translate3d\(([0-9\-]+)px,0,0\)/;
			content.bind("touchstart.slider", function(event) {
				$this = $(this);
				if (event.originalEvent.touches != null && event.originalEvent.touches.length > 0) {
					swipe.start = event.originalEvent.touches[0].clientX;

					// Regex transform
					match = translateRegex.exec($this[0].style.MozTransform);
					if (!match)
						match = translateRegex.exec($this[0].style.webkitTransform);
					swipe.margin = match != null ? parseFloat(parseInt(match[1])) : 0;

					$this[0].style.MozTransitionDuration = $this[0].style.webkitTransitionDuration = 0;
				}
			});

			// Touch move
			content.bind("touchmove.slider", {
				handle : scrollerHandle,
				wrapper : wrapper,
				handleSlideMax : handleSlideMax,
				contentSlideMax : contentSlideMax
			}, function(event) {
				$this = $(this);

				// Ensure swiping, not pinching
				if (event.originalEvent.touches.length > 1 || event.originalEvent.scale && event.originalEvent.scale !== 1) {
					return;
				}

				if (swipe.start != null) {
					// prevent native scrolling
					event.preventDefault();

					var pageX = event.originalEvent.touches[0].clientX;
					var diff = Math.round(swipe.start - pageX);

					// Calculate content margin
					var contentMargin = Math.min(0, Math.max(event.data.contentSlideMax * -1, swipe.margin - diff));

					// Set content margin
					// $this.css({
					// "margin-left" : contentMargin
					// });
					$this[0].style.MozTransform = $this[0].style.webkitTransform = 'translate3d(' + contentMargin + 'px,0,0)';

					// Wrapper
					if (contentSlideMax > 0 && contentMargin == event.data.contentSlideMax * -1)
						event.data.wrapper.attr("data-slide-rest", "left");
					else if (contentSlideMax > 0 && contentMargin == 0)
						event.data.wrapper.attr("data-slide-rest", "right");
					else if (contentSlideMax > 0)
						event.data.wrapper.attr("data-slide-rest", "both");
					else
						event.data.wrapper.attr("data-slide-rest", null);

					event.stopPropagation();
				}

			});

			// Touch end
			content.bind("touchend", {
				handle : scrollerHandle,
				wrapper : wrapper,
				handleSlideMax : handleSlideMax,
				contentSlideMax : contentSlideMax
			}, function(event) {
				// Regex transform
				match = translateRegex.exec($this[0].style.MozTransform);
				if (!match)
					match = translateRegex.exec($this[0].style.webkitTransform);
				if (match != null) {
					// Calculate content margin
					var contentMargin = margin = parseInt(match[1]);

					// Calculate slide procent
					var slideProcent = (contentMargin / event.data.contentSlideMax) * -1;

					// Calculate handle margin
					var handleMargin = Math.round(event.data.handleSlideMax * slideProcent);

					// Reset transform
					// $this[0].style.MozTransform =
					// $this[0].style.webkitTransform = 'translate3d(0,0,0)';

					// // Set content margin
					// $this.css({
					// "margin-left" : contentMargin
					// });

					// Set handle margin
					event.data.handle.css({
						"margin-left" : handleMargin
					});
				}

				event.stopPropagation();
			});

			// /SWIPE

		});
	};

})(jQuery);

// RESIZE

// Wrapper width from parent
$(window).resize(function() {
	var content = $("." + Slider.SLIDER_CONTENT_CLASS + "[data-resize][data-width-parent]");

	if (content.length == 0) {
		return;
	}

	content.each(function(i, element) {
		var element = $(element);
		var wrapper = element.parent();
		var handle = wrapper.find("." + Slider.SLIDER_SCROLLER_WRAPPER_CLASS + " ." + Slider.SLIDER_SCROLLER_HANDLE_CLASS);
		var widthParentElement = $(element.attr("data-width-parent"));

		if (widthParentElement.length > 0) {

			// Don't resize if parent width not changed
			if (wrapper.innerWidth() == widthParentElement.innerWidth()) {
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
