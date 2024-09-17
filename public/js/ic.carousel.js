/* JavaScript Document */
jQuery(window).on('load', function() {
    'use strict';
	
	// main-silder-swiper
	if(jQuery('.main-silder-swiper').length > 0){
		var swiper = new Swiper('.main-silder-swiper', {
			speed: 1500,
			parallax: true,
			effect: 'fade',
			loop:true,
			autoplay: {
			   delay: 3000,
			},
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
				renderBullet: function (index, className) {
				  return '<span class="' + className + '">' + (index + 1) + '</span>';
				},
			},
			navigation: {
				nextEl: '.swiper-button-next1',
				prevEl: '.swiper-button-prev1',
			},
		});
	}
	
	// main-silder-swiper
	if(jQuery('.main-silder-two').length > 0){
		var swiper = new Swiper('.main-silder-two', {
			speed: 1500,
			parallax: true,	
			autoplay: {
			   delay: 3000,
			},
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
				
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
		});
	}
	
	// About Swiper
	if(jQuery('.about-swiper').length > 0){
		var aboutswiper1 = new Swiper('.about-swiper', {
			speed: 1500,
			slidesPerView: 3,
			spaceBetween: 0,
			autoplay: {
			   delay: 3000,
			},
			pagination: {
				el: '.swiper-pagination1',
				clickable: true,
				renderBullet: function (index, className) {
				  return '<span class="' + className + '">' + (index + 1) + '</span>';
				},
			},
			breakpoints: {
				1280: {
					slidesPerView: 3,
				},
				768: {
					slidesPerView: 2,
				},
				320: {
					slidesPerView: 1,
				},
			}
		});
	}
	
	// img slider
	if(jQuery('.portfolio-swiper').length > 0){
		var swiper = new Swiper('.portfolio-swiper', {
			slidesPerView: 4,
			spaceBetween: 30,
			speed: 1000,
			parallax: true,
			loop:true,
			// autoplay: {
			//    delay: 1000,
			// }, 
			navigation: {
				nextEl: '.img-button-next',
				prevEl: '.img-button-prev',
			},
			breakpoints: {
				1200: {
					slidesPerView: 4,
				},
				1024: {
					slidesPerView: 4,
				},
				768: {
					slidesPerView: 2,
				},
				600: {
					slidesPerView: 2,
				},
				320: {
					slidesPerView: 1,
				},
			}
		});
	}
	
	// Feature Swiper
	if(jQuery('.feature-swiper').length > 0){
		var featureswiper = new Swiper('.feature-swiper', {
			speed: 1500,
			slidesPerView: 1,
			effect: 'fade',
			spaceBetween: 0,
			autoplay: {
			   delay: 3000,
			},
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
				
			}
		});
	}
	
	function changeItemBoxed() {
		if($("body").hasClass("boxed")) {
			return 3;
		} else {
			return 4;
		}
	}
	
	// Deal Swiper
	if(jQuery('.deal-swiper').length > 0){
		var dealswiper = new Swiper('.deal-swiper', {
			speed: 1500,
			slidesPerView: changeItemBoxed(),
			spaceBetween: 30,
			autoplay: {
			   delay: 3000,
			},
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
				
			},
			breakpoints: {
				1600: {
					slidesPerView: changeItemBoxed(),
				},
				1200: {
					spaceBetween: 30,
					slidesPerView: 3,
				},
				991: {
					slidesPerView: 2,
				},
				768: {
					slidesPerView: 2,
					spaceBetween: 30
				},
				320: {
					slidesPerView: 1,
				},
			}
		});
	}
	
	
	// similar-slider
	if(jQuery('.similar-slider').length > 0){
		var dealswiper = new Swiper('.similar-slider', {
			speed: 1500,
			slidesPerView: 3,
			spaceBetween: 30,
			observer: true,
			observeParents: true,
			autoplay: {
			   delay: 3000,
			},
			navigation: {
				nextEl: '.swiper-button-next2',
				prevEl: '.swiper-button-prev2',
			},
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
				
			},
			breakpoints: {
				1400: {
					slidesPerView: 3,
				},
				1200: {
					spaceBetween: 30,
					slidesPerView: 3,
				},
				991: {
					slidesPerView: 2,
				},
				768: {
					slidesPerView: 2,
					spaceBetween: 30
				},
				320: {
					slidesPerView: 1,
				},
			}
		});
	}
	
	
	
	if(jQuery('.similar-slider-5').length > 0){
		var dealswiper = new Swiper('.similar-slider-5', {
			speed: 1500,
			slidesPerView: 3,
			spaceBetween: 30,
			observer: true,
			observeParents: true,
			autoplay: {
			   delay: 3000,
			},
			navigation: {
				nextEl: '.swiper-button-next2',
				prevEl: '.swiper-button-prev2',
			},
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
				
			},
			breakpoints: {
				1400: {
					slidesPerView: 2,
				},
				1200: {
					spaceBetween: 30,
					slidesPerView: 2,
				},
				991: {
					slidesPerView: 2,
				},
				768: {
					slidesPerView: 2,
					spaceBetween: 30
				},
				320: {
					slidesPerView: 1,
				},
			}
		});
	}
	
	// post-swiper
	if(jQuery('.post-swiper').length > 0){
		var swiper = new Swiper('.post-swiper', {
			speed: 1500,
			parallax: true,
			slidesPerView: 1,
			spaceBetween: 0,
			loop:true,
			autoplay: {
			   delay: 2700,
			},
			navigation: {
				nextEl: '.next-post-swiper-btn',
				prevEl: '.prev-post-swiper-btn',
			}
		});
	}
	
	var swiper = new Swiper(".sync2", {
		spaceBetween: 30,
		slidesPerView: 'auto',
		freeMode: true,
		watchSlidesVisibility: true,
		watchSlidesProgress: true,
		breakpoints: {
			576: {
				spaceBetween: 30
			},
			320: {
				spaceBetween: 15
			}
		}
	});
	
	var swiper2 = new Swiper(".sync1", {
		spaceBetween: 10,
		navigation: {
		  nextEl: ".swiper-button-next",
		  prevEl: ".swiper-button-prev",
		},
		thumbs: {
		  swiper: swiper,
		},
	});
	
	
});
/* Document .ready END */



(function() {
  'use strict';

  // breakpoint where swiper will be destroyed
  // and switches to a dual-column layout
  const breakpoint = window.matchMedia( '(min-width:62em)' );

  // keep track of swiper instances to destroy later
  let mySwiper;

  //////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////

  const breakpointChecker = function() {
    // if larger viewport and multi-row layout needed
    if ( breakpoint.matches === true ) {

      // clean up old instances and inline styles when available
	  if ( mySwiper !== undefined ) mySwiper.destroy( true, true );

	  // or/and do nothing
	  return;

      // else if a small viewport and single column layout needed
      } else if ( breakpoint.matches === false ) {

        // fire small viewport version of swiper
        return enableSwiper();

      }
  };

  const enableSwiper = function() {

    mySwiper = new Swiper ('.team-slider', {

      loop: true,
      
      slidesPerView: 'auto',

      //centeredSlides: true,

      //a11y: true,
      keyboardControl: true,
      grabCursor: true,

      // pagination
      pagination: '.swiper-pagination',
      paginationClickable: true,

    });

  };

  // keep an eye on viewport size changes
  breakpoint.addListener(breakpointChecker);

  // kickstart
  breakpointChecker();

})(); /* IIFE end */