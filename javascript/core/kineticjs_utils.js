function KineticjsUtil() {
}

/**
 * @param {Kinetic.Stage}
 *            stage
 * @returns {Object}
 */
KineticjsUtil.getPointerRelativePosition = function(stage) {
	if (!stage)
		return null;

	var pointer = stage.getPointerPosition();

	if (!pointer)
		return null;

	var pos = stage.getPosition();
	var offset = stage.getOffset();
	var scale = stage.getScale();

	return {
		x : ((pointer.x / scale.x) - (pos.x / scale.x) + offset.x),
		y : ((pointer.y / scale.y) - (pos.y / scale.y) + offset.y)
	};
};

KineticjsUtil.getPointRelative = function(stage, point) {
	if (!stage)
		return null;

	var pos = stage.getPosition();
	var offset = stage.getOffset();
	var scale = stage.getScale();

	return {
		x : ((point.x / scale.x) - (pos.x / scale.x) + offset.x),
		y : ((point.y / scale.y) - (pos.y / scale.y) + offset.y)
	};
};

KineticjsUtil.getViewport = function(stage) {
	var topleft = KineticjsUtil.getPointRelative(stage, {
		x : 0,
		y : 0
	});
	var bottomright = KineticjsUtil.getPointRelative(stage, {
		x : stage.getWidth(),
		y : stage.getHeight()
	});
	return {
		topleft : topleft,
		topright : {
			x : bottomright.x,
			y : topleft.y
		},
		bottomright : bottomright,
		bottomleft : {
			x : topleft.x,
			y : bottomright.y
		},
		center : {
			x : bottomright.x / 2,
			y : bottomright.y / 2
		},
		height : bottomright.y - topleft.y,
		width : bottomright.x - topleft.x
	};
};
