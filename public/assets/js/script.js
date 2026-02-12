$(document).ready(function(){
	$('.dropdown .btn').click(function(e){
		e.stopPropagation();
		$(this).toggleClass('active');
	});

	$(document).click(function(e) {
		if (!$(e.target).closest('.dropdown').length) {
			$('.dropdown .btn').removeClass('active');
		}
	});
	$('.payment-methods input[type="radio"][name="flexRadioDefault"]').change(function() {
		$('.payment-methods .form-check').removeClass('active');
		if ($(this).is(':checked')) {
			$(this).closest('.form-check').addClass('active');
		}
	});	
	$('ul li div a.menuArrow').click(function () {
		var $submenu = $(this).parent('.dropWrap').next('.drop-menu');
		var isArrowRotated = $(this).hasClass("rotate");
		$('.drop-menu').removeClass('show');
		$('.menuArrow').removeClass("rotate");
		$submenu.toggleClass("show", !isArrowRotated);
		$(this).toggleClass("rotate", !isArrowRotated);
	});


	jQuery('#fixedHeader .menu-item > .menInrWrp > span').click(function () {
		alert('123')
		var $this = jQuery(this).parent('.menInrWrp').parent('.menu-item');
		if ($this.hasClass('active')) {
			$this.removeClass('active');
		} else {
			jQuery('#fixedHeader .menu-item').removeClass('active');
			$this.addClass('active');
		}
	});

	jQuery(function() {
		if (window.innerWidth >= 992) {
			jQuery('.header .menu-item').mouseover(function () {
				jQuery('.header .menu-item').removeClass('active');
				jQuery(this).addClass('active');
			}).mouseleave(function() {
				jQuery(this).removeClass('active');
			});
		} else {
			jQuery('.header .menu-item').off('mouseover mouseleave');
		}
	});

	function adjustOffcanvasMargin() {
		var headerHeight = $(".headerWrap").outerHeight();
		$(".offcanvas").css("top", headerHeight + "px");
	}
	adjustOffcanvasMargin();
	$(window).resize(function () {
		adjustOffcanvasMargin();
	});
	jQuery('#mainMenu .menu-item > a').click(function () {
		var $this = jQuery(this).parent('.menu-item');
		if ($this.hasClass('active')) {
			$this.removeClass('active');
		} else {
			jQuery('#mainMenu .menu-item').removeClass('active');
			$this.addClass('active');
		}
	});

	jQuery('.header .menu-item').mouseover(function () {
		jQuery('.header .menu-item').removeClass('active');
		jQuery(this).addClass('active');
	});

	$('.burgermenu').click(function(){
		$(this).toggleClass('active')
	})

	$('.hero-slider').slick({
		infinite: true,swipeToSlide: true,autoplay: true,speed: 1000,
		draggable: true,arrows: false,dots: true,slidesToShow: 1,fade:true,rtl: $('html').attr('dir') === 'rtl',
	});

	$('.sec2Slider').slick({
		infinite: true,swipeToSlide: true,autoplay: false,speed: 1000,
		draggable: true,arrows: true,
		prevArrow:'<a href="javascript:;" class="slick-arrow slick-prev"><svg width="23" height="16" viewBox="0 0 23 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.33331 7.99987L22.6667 7.99992M1.33331 7.99987L7.99993 14.6666M1.33331 7.99987L7.99998 1.33325" stroke="#6D7D36"/></svg><svg width="23" height="16" viewBox="0 0 23 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.33331 7.99987L22.6667 7.99992M1.33331 7.99987L7.99993 14.6666M1.33331 7.99987L7.99998 1.33325" stroke="#6D7D36"/></svg></a>',
		nextArrow:'<a href="javascript:;" class="slick-arrow slick-next"><svg width="23" height="16" viewBox="0 0 23 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21.6667 7.99987L0.333374 7.99992M21.6667 7.99987L15.0001 14.6666M21.6667 7.99987L15.0001 1.33325" stroke="#6D7D36"/></svg><svg width="23" height="16" viewBox="0 0 23 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21.6667 7.99987L0.333374 7.99992M21.6667 7.99987L15.0001 14.6666M21.6667 7.99987L15.0001 1.33325" stroke="#6D7D36"/></svg></a>',
		dots: false,slidesToShow: 3,
		responsive: [{
			breakpoint: 991,
			settings: {
				slidesToShow: 2
			}
		}
		, {
			breakpoint: 575,
			settings: {
				slidesToShow: 1
			}
		}]
	});

	$('.related-pro-slider').slick({
		infinite: true,swipeToSlide: true,autoplay: false,speed: 1000,
		draggable: true,arrows: true,
		prevArrow:'<a href="javascript:;" class="slick-arrow slick-prev"><svg width="23" height="16" viewBox="0 0 23 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.33331 7.99987L22.6667 7.99992M1.33331 7.99987L7.99993 14.6666M1.33331 7.99987L7.99998 1.33325" stroke="#6D7D36"/></svg><svg width="23" height="16" viewBox="0 0 23 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.33331 7.99987L22.6667 7.99992M1.33331 7.99987L7.99993 14.6666M1.33331 7.99987L7.99998 1.33325" stroke="#6D7D36"/></svg></a>',
		nextArrow:'<a href="javascript:;" class="slick-arrow slick-next"><svg width="23" height="16" viewBox="0 0 23 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21.6667 7.99987L0.333374 7.99992M21.6667 7.99987L15.0001 14.6666M21.6667 7.99987L15.0001 1.33325" stroke="#6D7D36"/></svg><svg width="23" height="16" viewBox="0 0 23 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21.6667 7.99987L0.333374 7.99992M21.6667 7.99987L15.0001 14.6666M21.6667 7.99987L15.0001 1.33325" stroke="#6D7D36"/></svg></a>',
		dots: false,slidesToShow: 4,
		responsive: [{
			breakpoint: 991,
			settings: {
				slidesToShow: 2
			}
		}
		, {
			breakpoint: 575,
			settings: {
				slidesToShow: 1
			}
		}]
	});
	
	function productSliderSettings(){

		return {
			slidesToShow: 1,slidesToScroll: 1,infinite: true,arrows:false,
			fade:true,autoplay:true,speed: 300,swipeToSlide:true,asNavFor: '.pro-slider-thumb',rtl: $('html').attr('dir') === 'rtl',
		}
	}
	
	function productThumbSliderSettings(){

		return {
			slidesToShow: 4,slidesToScroll: 1,asNavFor: '.pro-slider',speed: 300,dots: false,
			focusOnSelect: true,arrows: true,variableWidth:true,swipeToSlide:true,infinite:true,rtl: $('html').attr('dir') === 'rtl',
			prevArrow: '<a href="javascript:;" class="slick-arrow slick-prev"><svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.5752 16.8L1.1002 9.32499L8.5752 1.84999" stroke="#080F22" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>',
			nextArrow: '<a href="javascript:;" class="slick-arrow slick-next"><svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.1001 1.84998L8.5751 9.32498L1.1001 16.8" stroke="#080F22" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>',
			responsive: 
			[
				{breakpoint: 992,settings: {slidesToShow: 2,}},
			]
		}
	}

	$('.pro-slider').slick(productSliderSettings()); //These settings are also being used elsewhere, kindly update the function if needed
	$('.pro-slider-thumb').slick(productThumbSliderSettings()); //These settings are also being used elsewhere, kindly update the function if needed
    
    ////// mob slider
	$(".sliderxs").slick({
		arrows: true,
		dots: false,
		autoplay: true,
		adaptiveHeight: true,
		prevArrow: '<a href="javascript:;" class="slick-arrow slick-prev"><svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.90002 1.84998L1.42502 9.32498L8.90002 16.8" stroke="#080F22" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>',
		nextArrow: '<a href="javascript:;" class="slick-arrow slick-next"><svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.09998 1.84998L8.57498 9.32498L1.09998 16.8" stroke="#080F22" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>',
		responsive: [{
			breakpoint: 10000,
			settings: "unslick"
		}
		, {
			breakpoint: 991,
			settings: {
				unslick: true,
				slidesToShow: 2
			}
		}
		, {
			breakpoint: 767,
			settings: {
				slidesToShow: 1
			}
		}]
	});


	$(window).scroll(function(){
		if(jQuery('html, body').scrollTop() >= 10){
			$('.header').addClass('scrll');
		}else{
			$('.header').removeClass('scrll');
		}
	});
	

 // Append Phone Field 

	var maxFields = 3;
	var phoneCounter = 1;

	$('.addphone').click(function(e) {
		e.preventDefault();

		if (phoneCounter < maxFields) {
			var phoneWrapper = $('.phone-wrapper').first();
			var clone = phoneWrapper.clone();
			var removeBtn = $('<a href="#" class="removephone mb-2 me-4">Remove</a>');

			clone.find('input').val('');
			removeBtn.click(function(e) {
				e.preventDefault();
				$(this).closest('.phone-wrapper').remove();
				phoneCounter--;
			});

			clone.append(removeBtn);
			phoneWrapper.parent().append(clone);
			phoneCounter++;
		} else {
			alert('Maximum of three phone fields allowed.');
		}
	});

	$(document).on('click', '.removephone', function(e) {
		e.preventDefault();
		$(this).closest('.phone-wrapper').remove();
		phoneCounter--;
	});


	jQuery('body').delegate('.careerFilterInr li a','click',function() {

		jQuery(this).parents('.child_option').find('button')[0].childNodes[0].data = jQuery(this).text();

		let val = jQuery(this).attr('value')

		val == '' || val == undefined || val == null ? val == jQuery(this).text() : ''

		jQuery(this).parents('.child_option').find('.inputhide').val(val)
		jQuery(this).parents('.ct-slct').find('.inputhide').val(val)



	});

	

	jQuery('body').delegate(".careerFilter .child_option",'click',function(e){

		e.stopPropagation();

		var abc = $(this).find(".open-menu2").hasClass('active');

		if (abc == true) {

			$(this).find(".dropdown-menu2").slideUp("fast");

			$(".open-menu2").removeClass('active');

		}

		else{

			$(".dropdown-menu2").slideUp("fast");

			$(this).find(".dropdown-menu2").slideDown("fast");

			$(".open-menu2").removeClass('active');

			$(this).find(".open-menu2").addClass('active');

		}

	});

	$(window).click(function () {
		$(".dropdown-menu2").slideUp("fast");
		$(".open-menu2").removeClass('active');
	});

	jQuery(".clear").click(function() {

		jQuery(this).siblings("input").val("").focus();

	});

	jQuery('#upresume').change(function() {

		let name = ''

		console.log(jQuery(this)[0].files)

		for( i in jQuery(this)[0].files ){

			if( jQuery(this)[0].files[i].name != undefined && jQuery(this)[0].files[i].name != '' && jQuery(this)[0].files[i].name != 'item' ){

				name = name + jQuery(this)[0].files[i].name + ','

			}
		}

		name = name.slice(0,-1)

		jQuery(this).siblings('span').find('filename').text(name).css('color','#333')
	})

});