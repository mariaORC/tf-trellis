jQuery(function($){
	// init Isotope
	var $grid = $('.grid').isotope({
		itemSelector: '.element-item',
		layoutMode: 'packery',
		getSortData: {
			order: '[data-order]'
		}
	});
console.log('here');
	$('.industry-filter .dropdown-toggle').click(function() {
		$(this).toggleClass('active');
	});

	// bind sort button click
	$('.industry-filter a').click(function(e) {
		$('.industry-filter .dropdown-toggle span').html($(this).html());
		$('.industry-filter .dropdown-toggle').removeClass('active');

		window.location.hash = $(this).attr('href');

		//capture the button value in a variable
		var buttonValue = $(this).attr('href').substring(1);

		//console.log(buttonValue);

		if((buttonValue) === 'all') {
			$('.option-all').hide();
			$('.grid').removeClass('clicked');
			$grid.isotope({
				sortBy: 'original-order'
			});
		}
		else {
			$('.option-all').show();
			//reset everything in case this is the second click
			$('.element-item').attr('data-order', 'z').removeClass('is-active');
			//add class to container so we can hide children
			$('.grid').addClass('clicked');
			//if the class of the div is the same as the button clicked
			if ($('.element-item').hasClass(buttonValue)) {
				//select the div, change the data order for sorting, and add the class so it's not hidden
				$('.element-item.' + buttonValue).attr('data-order', 'a').addClass('is-active');
			}
				//wait until the data is set, then sort by data element
			$grid.isotope('updateSortData').isotope({
				sortBy: 'order'
			});
		}


		e.preventDefault();
	});

	if (window.location.hash) {
		var hash = window.location.hash;
                        var $filterLink = $('a[href="'+hash+'"]');
		$('.industry-filter .dropdown-toggle span').html($filterLink.html());
                        $filterLink.trigger('click');
	}
});