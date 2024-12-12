/**
 * jQuery Star Rating plugin
 * Joost van Velzen - http://joost.in
 *
 * v 1.0.3
 *
 * cc - attribution + share alike
 * http://creativecommons.org/licenses/by-sa/4.0/
 */

(function ($) {
	$.fn.addRating = function (options) {
		var obj = this;
		var objId = $(this).attr('data-id');
		var settings = $.extend({
			max: 5,
			half: true,
			fieldName: 'rating',
			fieldId: objId,
			icon: ''
		}, options);
		this.settings = settings;

		// create the stars
		for (var i = 1; i <= settings.max; i++) {
			var star = $('<i/>').addClass('icon-star').html(this.settings.icon + '').data('rating', i).appendTo(this).click(
				function () {
					obj.setRating($(this).data('rating'));
				}
			).hover(
				function (e) {
					obj.showRating($(this).data('rating'), false);
				}, function () {
					obj.showRating(0, false);
				}
			);
		}
		$(this).append('<span class="count-star"><span id="' + settings.fieldId + '"></span>');
	};

	$.fn.setRating = function (numRating) {
		var obj = this;
		$('#' + obj.settings.fieldId).text(numRating);
		obj.showRating(numRating, true);
	};

	$.fn.showRating = function (numRating, force) {
		var obj = this;
		if ($('#' + obj.settings.fieldId).text() == '' || force) {
			$(obj).find('i').each(function () {
				var icon = obj.settings.icon + '';
				$(this).removeClass('active');

				if ($(this).data('rating') <= numRating) {
					icon = obj.settings.icon;
					$(this).addClass('active');
				}
				$(this).html(icon);
			})
		}
	}

}(jQuery));
