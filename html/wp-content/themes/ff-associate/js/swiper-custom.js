var ff_associateSliderAutoplay = false;

if ( '1' == ff_associateSliderOptions.slider.autoplay ) {
	ff_associateSliderAutoplay = {
	    delay: ff_associateSliderOptions.slider.autoplayDelay,
	};
}

var mainSlider = new Swiper ( '#slider-section', {
	autoHeight: true, //enable auto height
	// If we need pagination
	pagination: {
		el: '#slider-section .swiper-pagination',
		type: 'bullets',
		clickable: 'true',
	},

	autoplay: ff_associateSliderAutoplay,
	// Navigation arrows
	navigation: {
		nextEl: '#slider-section .swiper-button-next',
		prevEl: '#slider-section .swiper-button-prev',
	},

	// And if we need scrollbar
	scrollbar: {
		el: '#slider-section .swiper-scrollbar',
	},
});

if ( 'undefined' != typeof mainSlider.el && '1' == ff_associateSliderOptions.slider.autoplay && '1' == ff_associateSliderOptions.slider.pauseOnHover ) {
	mainSlider.el.addEventListener( 'mouseenter', function( event ) {
		mainSlider.autoplay.stop();
	}, false);

	mainSlider.el.addEventListener( 'mouseleave', function( event ) {
		mainSlider.autoplay.start();
	}, false);
}
