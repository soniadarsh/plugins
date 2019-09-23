var dates = new Array();

function addNewDate(date) {
	if (jQuery.inArray(date, dates) < 0)
		dates.push(date);
}

function removeExistDate(index) {
	dates.splice(index, 1);
}

// Add new date if we need otherwise remove it
function addOrRemoveDates(date) {
	var index = jQuery.inArray(date, dates);
	if (index >= 0)
		removeExistDate(index);
	else
		addNewDate(date);
}

jQuery("#open_datepick").datepicker({
	dateFormat: 'm-d-yy',
	onSelect: function (dateText, inst) {
		addOrRemoveDates(dateText);
		// implode the dates array with comma
		jQuery("#open_datepick").val(dates.join(','));
	},

	beforeShowDay: function (date) {
		var year = date.getFullYear();
		var month = date.getMonth() + 1;
		var day = date.getDate();
		var dateString = month + "-" + day + "-" + year;
		console.log(dateString);
		console.log(dates);
		var gotDate = jQuery.inArray(dateString, dates);
		if (gotDate >= 0) {
			return [true, "ui-state-highlight"];
		}
		// leave enabled all dates
		return [true, ""];
	}

});

jQuery(document).ready(function () {
	var flip = 0;
	jQuery('#expand_options').click(function () {
		if (flip == 0) {
			flip = 1;
			jQuery('#of_container #of-nav').hide();
			jQuery('#of_container #content').width(755);
			jQuery('#of_container .group').add('#of_container .group h2').show();

			jQuery(this).text('[-]');

		} else {
			flip = 0;
			jQuery('#of_container #of-nav').show();
			jQuery('#of_container #content').width(595);
			jQuery('#of_container .group').add('#of_container .group h2').hide();
			jQuery('#of_container .group:first').show();
			jQuery('#of_container #of-nav li').removeClass('current');
			jQuery('#of_container #of-nav li:first').addClass('current');

			jQuery(this).text('[+]');

		}

	});

	jQuery('.group').hide();
	jQuery('.group:first').fadeIn();

	jQuery('.group .collapsed').each(function () {
		jQuery(this).find('input:checked').parent().parent().parent().nextAll().each(
			function () {
				if (jQuery(this).hasClass('last')) {
					jQuery(this).removeClass('hidden');
					return false;
				}
				jQuery(this).filter('.hidden').removeClass('hidden');
			});
	});

	jQuery('.group .collapsed input:checkbox').click(unhideHidden);

	function unhideHidden() {
		if (jQuery(this).attr('checked')) {
			jQuery(this).parent().parent().parent().nextAll().removeClass('hidden');
		} else {
			jQuery(this).parent().parent().parent().nextAll().each(
				function () {
					if (jQuery(this).filter('.last').length) {
						jQuery(this).addClass('hidden');
						return false;
					}
					jQuery(this).addClass('hidden');
				});

		}
	}

	jQuery('.of-radio-img-img').click(function () {
		jQuery(this).parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
		jQuery(this).addClass('of-radio-img-selected');

	});
	jQuery('.of-radio-img-label').hide();
	jQuery('.of-radio-img-img').show();
	jQuery('.of-radio-img-radio').hide();
	jQuery('#of-nav li:first').addClass('current');
	jQuery('#of-nav li a').click(function (evt) {

		jQuery('#of-nav li').removeClass('current');
		jQuery(this).parent().addClass('current');

		var clicked_group = jQuery(this).attr('href');

		jQuery('.group').hide();

		jQuery(clicked_group).fadeIn();

		evt.preventDefault();

	});

});