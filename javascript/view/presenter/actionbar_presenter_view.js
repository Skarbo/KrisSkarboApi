// CONSTRUCTOR
ActionbarPresenterView.prototype = new AbstractPresenterView();

function ActionbarPresenterView(view) {
	AbstractPresenterView.apply(this, arguments);
	this.referral = null;
	this.buttons = [];
	this.menu = [];
};

// VARIABLES

// /VARIABLES

// FUNCTIONS

// ... GET

ActionbarPresenterView.prototype.getActionbarElement = function() {
	return this.getRoot().find(".actionbar");
};

ActionbarPresenterView.prototype.getIconElement = function() {
	return this.getActionbarElement().find(".actionbar_icon");
};

ActionbarPresenterView.prototype.getIconReferralElement = function() {
	return this.getIconElement().find(".actionbar_icon_referral");
};

ActionbarPresenterView.prototype.getIconIconElement = function() {
	return this.getIconElement().find(".actionbar_icon_icon");
};

ActionbarPresenterView.prototype.getViewControlElement = function() {
	return this.getActionbarElement().find(".actionbar_viewcontrol");
};

ActionbarPresenterView.prototype.getViewControlMenuElement = function() {
	return this.getRoot().find(".actionbar_viewcontrol_menu");
};

ActionbarPresenterView.prototype.getButtonsElement = function() {
	return this.getActionbarElement().find(".actionbar_buttons");
};

ActionbarPresenterView.prototype.getButtonsContainerElement = function() {
	return this.getButtonsElement().find(".actionbar_buttons_container");
};

ActionbarPresenterView.prototype.getButtonElement = function(buttonId) {
	return this.getButtonsContainerElement().find("#" + buttonId);
};

// ... /GET

// ... DO

ActionbarPresenterView.prototype.doBindEventHandler = function() {
	AbstractPresenterView.prototype.doBindEventHandler.call(this);
	var context = this;

	// Referral
	this.getIconElement().unbind(".actionbar").on("touchclick.actionbar", function(event) {
		if (context.referral) {
			context.referral(context.getIconReferralElement());
		}
	});

	// View control
	this.getViewControlElement().unbind(".actionbar").bind("touchclick.actionbar", function(event) {
		if ($(this).attr("data-menu") == "true") {
			var position = $(this).position();
			context.getViewControlMenuElement().toggle().css("margin-left", Core.sprintf("%dpx", position.left));
			if (context.getViewControlMenuElement().is(":visible")) {
				setTimeout(function() {
					$("html").one("touchclick", function(event) {
						context.getViewControlMenuElement().hide();
					});
				}, 10);
			}
		}
	});

	// View control menu
	this.getViewControlMenuElement().unbind(".actionbar").bind("touchclick.actionbar", function(event) {
		var target = $(event.target);
		var menuWrapper = target.closest("[data-index]");
		if (menuWrapper.length > 0) {
			var dataIndex = parseInt(menuWrapper.attr("data-index"));
			if (context.menu[dataIndex].callback)
				context.menu[dataIndex].callback(context.menu[dataIndex].id);
		}
		$(this).hide();
	});

	// Buttons
	this.getButtonsElement().unbind(".actionbar").on("touchclick.actionbar", function(event) {
		var button = $(event.target);
		var buttonIndex = button.attr("data-index");
		var disabled = button.is("[data-disabled]");
		if (context.buttons[buttonIndex] && !disabled) {
			context.buttons[buttonIndex](button);
		}
	});
};

ActionbarPresenterView.prototype.doSetIcon = function(icon) {
	this.getIconIconElement().empty();
	if (icon)
		this.getIconIconElement().append(icon);
};

ActionbarPresenterView.prototype.doSetReferral = function(referral) {
	this.referral = referral;

	if (this.referral) {
		this.getIconReferralElement().removeClass("invisible");
		this.getIconElement().addClass("pointer");
	} else {
		this.getIconReferralElement().addClass("invisible");
		this.getIconElement().removeClass("pointer");
	}
};

ActionbarPresenterView.prototype.doSetViewControl = function(viewControl, double) {
	var viewControlElement = $("<div />", {
		text : viewControl
	});

	this.getViewControlElement().empty();

	if (double) {
		var doubleWrapper = $("<div />", {
			"class" : "double"
		});
		var viewControlDouble = $("<div />", {
			text : double
		});
		doubleWrapper.append(viewControlElement).append(viewControlDouble);
		this.getViewControlElement().append(doubleWrapper);
	} else {
		var singleWrapper = $("<div />", {
			"class" : "single",
			"html" : viewControlElement
		});
		this.getViewControlElement().append(singleWrapper);
	}
};

ActionbarPresenterView.prototype.doEmptyViewControlMenu = function() {
	this.menu = [];
	this.getViewControlMenuElement().empty();
	this.getViewControlElement().attr("data-menus", "false");
	this.getViewControlMenuElement().hide();
};
ActionbarPresenterView.prototype.doAddViewControlMenu = function(menu, sub, id, callback) {
	var menuWrapper = $("<div />", {
		'data-index' : this.menu.length
	});
	if (menu)
		menuWrapper.append($("<div />", {
			html : menu
		}));
	if (sub)
		menuWrapper.append($("<div />", {
			html : sub
		}));
	this.getViewControlMenuElement().append(menuWrapper);
	menuWrapper.touchActive();
	this.menu.push({
		id : id,
		callback : callback
	});
	this.getViewControlElement().attr("data-menu", "true");
};

ActionbarPresenterView.prototype.doEmptyButtons = function() {
	this.buttons = [];
	this.getButtonsContainerElement().empty();
};

ActionbarPresenterView.prototype.doAddButton = function(button, callback) {
	this.buttons.push(callback);
	$(button).attr("data-index", this.buttons.length - 1);
	this.getButtonsContainerElement().append($(button));
};

// ... /DO

ActionbarPresenterView.prototype.draw = function(root) {
	AbstractPresenterView.prototype.draw.call(this, root);
	if (this.getIconReferralElement().attr("data-referral"))
		this.doSetReferral(true);
	else
		this.doSetReferral(null);
};

// /FUNCTIONS
