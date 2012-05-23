/**
 * GUI
 */
function Gui() {
}

// VARIABLES

Gui.GUI_CLASS = "gui";
Gui.GUI_COMP_CLASS = "guiComp";
Gui.BUTTON_CLASS = "button";
Gui.ICON_CLASS = "icon";
Gui.TEXT_CLASS = "text";
Gui.TOGGLE_CLASS = "toggle";
Gui.CHECKED_CLASS = "checked";
Gui.RADIO_CLASS = "radio";
Gui.INPUT_CLASS = "input";
Gui.SPRITE_CLASS = "sprite";

Gui.DATA_TYPE_BUTTON = "button";
Gui.DATA_TYPE_BUTTON_ICON = "button_icon";
Gui.DATA_TYPE_ICON = "icon";
Gui.DATA_TYPE_TOGGLE = "toggle";
Gui.DATA_TYPE_RADIO = "radio";
Gui.DATA_TYPE_INPUT = "input";
Gui.DATA_TYPE_RESET = "reset";
Gui.DATA_TYPE_SPRITE = "sprite";
Gui.DATA_TYPE_BUTTON_SPRITE = "button_sprite";

Gui.DATA_ATTR_DISABLED = "data-disabled";

Gui.EMPTY_IMAGE = "images/1x1.png";

// /VARIABLES

// FUNCTIONS

Gui.randomString = function(length) {
	length = length ? length : 6;
	var text = "";
	var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	for ( var i = 0; i < length; i++)
		text += possible.charAt(Math.floor(Math.random() * possible.length));

	return text;
};

// /FUNCTIONS

(function($) {

	$.fn.disable = function() {
		return this.each(function() {

			var $this = $(this);

			// Disable children
			if ($this.hasClass(Gui.GUI_CLASS)) {
				$this.children("." + Gui.GUI_COMP_CLASS).disable();
			}
			// Disable
			else {
				$this.attr(Gui.DATA_ATTR_DISABLED, "true");
				
				if ($this.attr("data-type") == Gui.DATA_TYPE_INPUT)
				{
					$this.prop('disabled', true);
				}
			}

		});
	};

	$.fn.enable = function() {
		return this.each(function() {

			var $this = $(this);

			// Enable children
			if ($this.hasClass(Gui.GUI_CLASS)) {
				$this.children("." + Gui.GUI_COMP_CLASS).enable();
			}
			// Enable
			else {
				$this.removeAttr(Gui.DATA_ATTR_DISABLED);
				
				if ($this.attr("data-type") == Gui.DATA_TYPE_INPUT)
				{
					$this.prop('disabled', false);
				}
			}

		});
	};

	$.fn.isDisabled = function() {
		var disabled = false;

		this.each(function() {

			// Is disabled
			disabled |= $(this).attr(Gui.DATA_ATTR_DISABLED) == "true";

		});

		return disabled;
	};

	$.fn.gui = function(options) {

		return this
				.each(function() {

					var $this = $(this);

					// Settings
					var settings = $.extend({
						'checked' : [],
						'handler' : {}
					}, options);

					// Add class
					$this.addClass(Gui.GUI_CLASS);

					// For each children
					var element, dataType, icon, span, checked, id, radio, sprite;
					$this
							.children()
							.filter("." + Gui.GUI_COMP_CLASS)
							.each(
									function(i, child) {

										// Element
										element = $(child);

										// Data type
										dataType = element.attr("data-type");

										// Switch type
										switch (dataType) {

										case Gui.DATA_TYPE_ICON:
											// Icon

											// Create icon
											icon = $("<div />", {
												'class' : Gui.ICON_CLASS,
												'data-icon' : element
														.attr('data-icon'),
												'html' : element.html()
											});

											// Remove data icon attribute
											element.attr('data-icon', null);

											// Remove content
											element.empty();

											// Add class
											element
													.addClass(Gui.GUI_COMP_CLASS);

											// Append element
											element.append(icon);

											break;

										case Gui.DATA_TYPE_SPRITE:
											// Sprite

											// Create sprite
											sprite = $("<div />", {
												'class' : Gui.SPRITE_CLASS,
												'html' : element.html()
											});

											// Remove content
											element.empty();

											// Add class
											element
													.addClass(Gui.GUI_COMP_CLASS);

											// Append element
											element.append(sprite);

											break;

										case Gui.DATA_TYPE_BUTTON_SPRITE:
											// Button icon

											// Create sprite
											sprite = $("<div />", {
												'class' : Gui.SPRITE_CLASS,
												'html' : $("<img />", {
													'src' : Gui.EMPTY_IMAGE
												})
											});

											// Create span
											span = $("<div />", {
												'class' : Gui.TEXT_CLASS,
												'html' : element.html()
											});

											// Add class
											element.addClass(Gui.BUTTON_CLASS);
											element
													.addClass(Gui.GUI_COMP_CLASS);

											// Remove content
											element.empty();

											// Append element
											if (span.text() != "") {
												element.append(span);
											}

											if (element
													.attr("data-sprite-placing") == "right") {
												element.append(sprite);
											} else {
												element.prepend(sprite);
											}

											break;

										case Gui.DATA_TYPE_BUTTON_ICON:
										case Gui.DATA_TYPE_RESET:
											// Button icon

											// Create icon
											icon = $("<div />", {
												'class' : Gui.ICON_CLASS,
												'data-icon' : element
														.attr('data-icon')
											});

											// Create span
											span = $("<div />", {
												'class' : Gui.TEXT_CLASS,
												'html' : element.html()
											});

											// Add class
											element.addClass(Gui.BUTTON_CLASS);
											element
													.addClass(Gui.GUI_COMP_CLASS);

											// Remove content
											element.empty();

											// Append element
											if (span.text() != "") {
												element.append(span);
											}

											if (element.attr("data-icon")) {
												if (element
														.attr("data-icon-placing") == "right") {
													element.append(icon);
												} else {
													element.prepend(icon);
												}
											}

											// Remove data icon attribute
											element.attr('data-icon', null);

											// Handle click
											if (dataType == Gui.DATA_TYPE_RESET) {
												element
														.click(
																{
																	'input' : element
																			.attr("data-reset-id")
																},
																function(event) {
																	// Prevent
																	// default
																	event
																			.preventDefault();

																	// Disabled
																	if ($(
																			event.currentTarget)
																			.attr(
																					Gui.DATA_ATTR_DISABLED)) {
																		return false;
																	}

																	// Get input
																	var inputReset = $this
																			.find("input#"
																					+ event.data.input);

																	// Get id
																	var id = $(
																			event.currentTarget)
																			.attr(
																					"id");

																	// Reset
																	// input
																	inputReset
																			.val("");
																	inputReset
																			.focus();

																	// Handle
																	// reset
																	if (settings['handler'][id]) {
																		settings['handler'][id]
																				();
																	}
																});
											}

											break;

										case Gui.DATA_TYPE_TOGGLE:
											// Toggle

											// Get id
											id = element.attr("id");

											// Is checked
											checked = element
													.hasClass(Gui.CHECKED_CLASS)
													|| jQuery
															.inArray(
																	id,
																	settings["checked"]) > -1;

											// Create checkbox
											checkbox = $('<input />', {
												'type' : 'checkbox',
												'checked' : checked
											});

											// Create icon
											icon = $("<div />", {
												'class' : Gui.ICON_CLASS,
												'data-icon' : element
														.attr('data-icon')
											});

											// Create span
											span = $("<div />", {
												'class' : Gui.TEXT_CLASS,
												'html' : element.html()
											});

											// Add class
											element.addClass(Gui.TOGGLE_CLASS);
											element
													.addClass(Gui.GUI_COMP_CLASS);

											if (checked) {
												element
														.addClass(Gui.CHECKED_CLASS);
											}

											// Remove data icon attribute
											element.attr('data-icon', null);

											// Empty content
											element.empty();

											// Append element
											if (span.text() != "") {
												element.append(span);
											}

											if (element
													.attr("data-icon-placing") == "right") {
												element.append(icon);
											} else {
												element.prepend(icon);
											}

											element.append(checkbox);

											// Handle click
											element
													.click(function(event) {
														// Prevent default
														event.preventDefault();

														// Get target
														var target = $(event.currentTarget);

														// Disabled
														if (target.isDisabled()) {
															return false;
														}

														// Get checkbox
														var toggleCheckbox = target
																.find("input[type=checkbox]");

														// Get id
														var toggleId = target
																.attr("id");

														// Is checked
														var toggleChecked = !toggleCheckbox
																.is(":checked");

														// Set checked
														toggleCheckbox.attr(
																"checked",
																toggleChecked);

														// Toggle class
														target
																.toggleClass(Gui.CHECKED_CLASS);

														// Handle toggle
														if (settings['handler'][toggleId]) {
															settings['handler'][toggleId]
																	(toggleChecked);
														}
													});

											break;

										case Gui.DATA_TYPE_RADIO:
											// Radio

											// Get id
											id = element.attr("id") ? element
													.attr("id") : "radio_"
													+ Gui.randomString();

											// Get name
											name = element
													.attr("data-radio-name")
													|| "name_"
													+ Gui.randomString();

											// Get checked
											checked = element
													.hasClass(Gui.CHECKED_CLASS)
													|| jQuery
															.inArray(
																	id,
																	settings["checked"]) > -1;

											// Create radio
											radio = $('<input />', {
												'type' : 'radio',
												'id' : 'input_' + id,
												'checked' : checked,
												'name' : name
											});

											// Add class
											element.addClass(Gui.RADIO_CLASS);
											element
													.addClass(Gui.GUI_COMP_CLASS);

											if (checked) {
												element
														.addClass(Gui.CHECKED_CLASS);
											}

											// Append element
											element.append(radio);

											// Handle click
											element
													.click(
															{
																'name' : name,
																'parent' : $this
															},
															function(event) {
																// Prevent
																// default
																event
																		.preventDefault();

																// Get target
																var target = $(event.currentTarget);

																// Disabled
																if (target
																		.isDisabled()) {
																	return false;
																}

																// Get radio
																var radioInput = target
																		.find("input[type=radio]");

																// Get id
																var radioId = target
																		.attr("id");

																// Remove
																// checked class
																event.data.parent
																		.find(
																				"[data-radio-name="
																						+ event.data.name
																						+ "]")
																		.removeClass(
																				Gui.CHECKED_CLASS);
																event.data.parent
																		.find(
																				"[data-radio-name="
																						+ event.data.name
																						+ "] :checked")
																		.attr(
																				"checked",
																				false);

																// Set checked
																radioInput
																		.attr(
																				"checked",
																				true);

																// Add class
																target
																		.addClass(Gui.CHECKED_CLASS);

																// Handle toggle
																if (settings['handler'][event.data.name]) {
																	settings['handler'][event.data.name]
																			(radioId);
																}

															});

											break;

										case Gui.DATA_TYPE_INPUT:
											// Input

											// Add class
											element.addClass(Gui.INPUT_CLASS);
											element
													.addClass(Gui.GUI_COMP_CLASS);

											// Add type
											element.prop("type", "text");

											break;

										default:
											// Button

											// Add class
											element.addClass(Gui.BUTTON_CLASS);
											element
													.addClass(Gui.GUI_COMP_CLASS);

											// Handle click
											element
													.click(function(event) {
														// Get target
														var target = $(event.currentTarget);

														// Disabled
														if (target.isDisabled()) {
															event
																	.preventDefault();
														}
													});

											break;

										}

									});

				});
	};

})(jQuery);