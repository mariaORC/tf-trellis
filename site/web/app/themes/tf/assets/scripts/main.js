function urldecode(str) {
    return decodeURIComponent((str+'').replace(/\+/g, '%20')).replace(/\\'/, "'");
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)===' ') {
            c = c.substring(1,c.length);
        }

        if (c.indexOf(nameEQ) === 0) {
            return urldecode(c.substring(nameEQ.length,c.length));
        }
    }
    return null;
}

// function equalizeRowHeights(childSelector) {
//     var maxHeight = 0;

//     $(childSelector).each(function(){
//         $(this).height('auto');

//         if ($(this).height() > maxHeight) {
//             maxHeight = $(this).height();
//             // console.log(maxHeight);
//         }
//     });

//     $(childSelector).height(maxHeight);
// }

jQuery(function($){
	$('#primaryNav > .nav > li.dropdown').hover(
		function() {
			$('.dropdown-menu', $(this).siblings('li')).addClass('hide');
		}, function() {
			$('.dropdown-menu', $(this).siblings('li')).removeClass('hide');
		});

    $('.mobile-nav-toggle').click(function(e) {
        var $target = $($(this).attr('href'));

        if ($target.hasClass('open')) {
            $('.mobile-nav-panel.open').removeClass('open').slideUp(300);
            $(this).removeClass('active');
        } else {
            $('.mobile-nav-toggle').removeClass('active');
            $('.mobile-nav-panel.open').removeClass('open').slideUp(300);
            $(this).addClass('active');
            $($(this).attr('href')).addClass('open').slideDown(300);
        }

        e.preventDefault();
	});

	//Don't let the user submit the header form unless they have entered a value. I would have used HTML5 validation here, but the user can trigger this if they're even trying to open the search box.
	$('.topbar .searchform').submit(function(e) {
		if ($('#s', $(this)).val() === '') {
			e.preventDefault();
		}
	});

	$('.topbar .searchform .searchButton').click(function(e) {
		$('.topbar .searchform #s').focus();
	});

    //On mobile devices we will auto scroll the use to the top of a dropdown list as we close the previously selected drop. So if our browser
      //width is less than or equal to the 768 pixel break where we switch to the hamburger menu then we'll enable this functionality.
      $('#primaryNavMobile .nav-pills a').click(function(e) {
        var $parent = $(this).parent();

		if ($( window ).width() <= 768 && $parent.hasClass('dropdown')) {

            if (!$parent.hasClass('active')) {
                $('li.dropdown.active', $parent.parent()).removeClass('active');
                $parent.addClass('active');

                setTimeout(function() {
                    $('html, body').animate({
                        scrollTop: $parent.offset().top
                    }, 700);
                }, 350);
            } else {
                $parent.removeClass('active');
            }

            e.preventDefault();
        }
    });

    //Stick the sidenav in view.
    $('.page-template-template-fluid-layout-with-subnav .sidebar').waypoint({
        offset: 20,
        handler: function(direction) {
            $safari = false;

            if (navigator.userAgent.indexOf('Safari') !== -1 && navigator.userAgent.indexOf('Chrome') === -1) {
                $safari = true;
            }

			if ($(window).width() > '768' && $('#subNav').outerHeight() < ($('main.main').outerHeight() - 350)) {
				if (direction === 'down') {
                    $('#subNav').addClass('stuck');

                    if ($safari) {
                        $('aside.sidebar').addClass('nav-stuck');
                    }
                } else {
                    $('#subNav').removeClass('stuck');
                    $('aside.sidebar').removeClass('nav-stuck');
                }
            } else {
                $('#subNav').removeClass('stuck fixed-bottom').css('top', '0');
                $('aside.sidebar').removeClass('nav-stuck');
            }
        }
    });

    $('main.main').waypoint({
        offset: 'bottom-in-view',
        handler: function(direction) {
            if ($('.page-template-template-fluid-layout-with-subnav #subNav').length > 0) {
                if ($(window).width() > '768' && $('#subNav').outerHeight() < ($('main.main').outerHeight() - 350)) {
                    if (direction === 'down') {
                        $('#subNav').css('top', ($('#subNav').offset().top-$('.header_wrap').outerHeight()-$('#primaryNav').outerHeight()-$('.home-feature').outerHeight()-142)+'px').addClass('fixed-bottom');
                    } else {
                        $('#subNav').css('top', '20px').removeClass('fixed-bottom');
                    }
                } else {
                    $('#subNav').removeClass('stuck fixed-bottom').css('top', '0');
                }
            }
        }
    });

    //Stick the scroll CTA buttons to the footer when we get near the bottom.
    $('#cta_waypoint').waypoint({
        offset: 'bottom-in-view',
        handler: function(direction) {
            if (direction === 'down') {
                $('#ctas').addClass('stuck');
            } else {
                $('#ctas').removeClass('stuck');
            }
        }
    });

    //Stick the blog subscribe form to the top of the viewport and then hide it once we reach the bottom of the page.
    $('#blog_subscribe_form').waypoint({
        offset: 20,
        handler: function(direction) {
            if (direction === 'down') {
                var $placeholder = $('#subscribe_form_placeholder');
                $placeholder.css('height',  $(this).outerHeight()+40);
                $(this).css('width', $(this).outerWidth()).addClass('stuck');
            } else {
                $(this).removeClass('stuck');
            }
        }
    });

    $('.blog .cta_wrap').waypoint({
        offset: 'bottom-in-view',
        handler: function(direction) {
            $('#blog_subscribe_form').fadeToggle(300);
        }
    });

    var fancyBoxBtnTpl = {
         close   : '<button data-fancybox-close class=" fancybox-close" title="{{CLOSE}}"><i class="icon-close-delete"></i></button>',
         smallBtn   : '<button data-fancybox-close class="fancybox-button fancybox-close-small" title="{{CLOSE}}"><i class="icon-cross-mark"></i></button>',
         // Arrows
         arrowLeft : '<button data-fancybox-prev class="fancybox-button fancybox-button--arrow_left" title="{{PREV}}"><i class="icon-chevron-left"></i></button>',
         arrowRight : '<button data-fancybox-next class="fancybox-button fancybox-button--arrow_right" title="{{NEXT}}"><i class="icon-chevron-right"></i></button>'
      };


    //Custom FancyBox for employee profiles
   $('a.people').attr('data-fancybox','gallery').fancybox({
      baseClass    : 'people',
      padding     : 26,
      loop        : false,
      animationEffect  : 'fade',
      transitionEffect : 'fade',
      iframe : {
          attr : {
              scrolling : 'auto'
          }
      },
      clickOutside : 'close',
      btnTpl : fancyBoxBtnTpl
    });

    //Custom Fancybox for Video Popups.
    $('a.full-videobox').fancybox({
        baseClass   : 'full-videobox',
        animationEffect  : 'fade',
        transitionEffect : 'fade',
        iframe : {
            attr : {
                scrolling : 'no'
            }
        },
        buttons : [
           'close'
        ],
        btnTpl : fancyBoxBtnTpl
    });


    $('.home-feature .tour-button, .play-demo').click(function(e) {
        $('.demo-video-modal').trigger('click');
        window.location.hash = 'demo';
    });

    if(window.location.hash === '#demo') {
        $('.demo-video-modal').trigger('click');
    }

    //Custom Fancybox for Video Popups.
    $('a.videobox').fancybox({
        baseClass   : 'full-videobox',
        animationEffect  : 'fade',
        transitionEffect : 'fade',
        iframe : {
            attr : {
                scrolling : 'no'
            }
        },
        buttons : [
           'close'
        ],
        btnTpl : fancyBoxBtnTpl
    });

      //When the user clicks one of the items for our custom image-switcher control, we then need to initiate a cross-fade to swap out the images.
      $('.image-switcher .item').click(function(e) {
          var newImage = $(this).attr('data-image-src');
          var $switcherImageContainer = $('#'+$(this).parent().attr('data-target'));
          var $switcherImage = $('img.fade-image', $switcherImageContainer);
          //var $crossFader = $('.crossfader', $switcherImageContainer);

          //var $tempImage = $('<img src="'+$switcherImage.attr('src')+'" style="position: absolute; bottom: 0; left: 0; z-index: 9999;" />');
          //$crossFader.prepend($tempImage);
          $switcherImage.attr('src', newImage);
          //$tempImage.fadeOut(0, function() { $(this).remove(); });
          $('.item', $(this).parent()).removeClass('active');
          $(this).addClass('active');
      });

    //Remove the lightbox on any tiny icon images.
    $('a.lightbox').each(function() {
        var image = $('img', this);

        if (image.length > 0) {
            $(image).load();
            var imageWidth = image.width();
            var imageHeight = image.height();

            if (!imageHeight || imageHeight === 0) {
                imageHeight = image.attr('height');
            }

            if ($(window).width() < '768' || imageHeight < 135 || imageWidth < 135) {
                $(this).removeClass('lightbox').attr("href","#").css('cursor', 'default').click(function(){return false;});
            }
        }
    });

    if ($(window).width() >= '768') {
        $('.features, .technology').each(function() {
			$('.equalize-item-heights .item').matchHeight({byRow: true});

			$('.equalize-heights .height-target').matchHeight({byRow: true});
        });


        //Set up the lightbox for any lightbox enabled photos on the page. This will also add the '+' icon to the
        //top right corner of the image. Note: The images MUST have their height and width set.
         $('a.lightbox').attr('data-fancybox','gallery').fancybox({
            baseClass    : 'gallery',
            padding     : 20,
            loop        : false,
            animationEffect  : 'fade',
            transitionEffect : 'fade',
            clickOutside : 'close',
            btnTpl : fancyBoxBtnTpl
          });
    }

	//Remove the dropdown menu's from the Intranets 101 and Case Studies menus on mobile.
	//Removed with homepage redesign
    // if ($(window).width() <= '480') {
    //     $('#menu-footer-menu .menu-intranets-101, #menu-footer-menu .menu-case-studies').removeClass('dropdown');
    // }

    $('#menu-footer-menu > li.dropdown > a').click(function(e) {
        if ($(window).width() <= '480') {
            if ($(this).parent().hasClass('open')) {
                $(this).parent().removeClass('open');
            } else {
                $(this).parent().addClass('open');
            }

            e.preventDefault();
        }
    });

    $('.support-tabs a').click(function(e) {
        window.location.hash = $(this).attr('href');
        e.preventDefault();
    });

    //Check if the link contains a hash. If it does, we'll see if the hashtag relates to a link that has a hash in it. If it doesn't we'll trigger
    //the link since this is targeting a lightbox to open.
    if(window.location.hash) {
        var $hashObject = $(window.location.hash);

        //If a hash was set in the URL and we have an object with an ID matching the has, we'll then click it on load.
        if ($hashObject.length > 0) {
            if ($hashObject.hasClass('lightbox') || $hashObject.hasClass('people')) {
                $hashObject.trigger('click');
            } else if ($('body').hasClass('support')) {
                $('html, body').animate({ scrollTop: $('#support-docs').offset().top}, 500);
                // $('.support-tabs li').removeClass('active');
                $('.support-tabs a[href="'+window.location.hash+'"]').trigger('click');
            }
        }
    }

    //Even out the flexbox tile rows if there are 5 or 6
    $(document).on('click.bs.tab.data-api', '[data-toggle="tab"], [data-toggle="pill"]', function (e) {
        var range = $(".tab-pane.active .support-wrapper .support-tile-wrapper").length;
        if (range >= 5 && range <= 6) {
            $(".tab-pane.active .support-wrapper").addClass('awkward-number');
        }
    });

    $(window).resize(function() {
        if ($(this).width() <= 768) {
            $('.responsive-image').each(function() {
                $(this).attr('src', $(this).attr('data-mobile-image'));
            });
        }
    }).trigger('resize');
});

$(window).load(function() {
    $('.post a.lightbox').each(function() {
        var image = $('img', this);

        if (image.length > 0 && $(window).width() >= '768') {
            var zoomButtonClass = "zoom";

            var zoomButton = $('<a href="#" class="'+zoomButtonClass+'">Zoom</a>');

            $(this).append(zoomButton);

//          positionZoomButtons();

            //There seems to be a glitch where items below the fold don't get positioned properly the first time so
            //on scroll we'll reposition the zoom button and then remove the scroll listener.
            $(document).on('scroll', function() {
//              positionZoomButtons();

                $(document).off('scroll');
            });
        }
    });

    if ($(this).width() > 767) {
		$('.equalize-item-heights .item').matchHeight({byRow: true});

		$('.equalize-heights .height-target').matchHeight({byRow: true});
    }
});

function enableFormModal() {
   $('a.form').fancybox({
      baseClass    : 'fancy-form',
      padding     : 20,
      loop        : false,
      animationEffect  : 'fade',
      transitionEffect : 'fade',
      clickOutside : 'close',
      iframe : {
          attr : {
              scrolling : 'auto'
          }
      },
      btnTpl : fancyBoxBtnTpl
    });
}

function setMaxQuoteHeight() {
    var maxQuoteHeight = -1;

    $('#homeQuote li').each(function() {
        maxQuoteHeight = maxQuoteHeight > $(this).height() ? maxQuoteHeight : $(this).height();
    });

    $('#homeQuote li').each(function() {
        $(this).css('top', parseInt((maxQuoteHeight - $(this).height())/2, 10));
    });

    $('#homeQuote ul').height(maxQuoteHeight);
}

function homepageQuoteRotator() {
    var $active = $('#homeQuote li.active');

    if ( $active.length === 0 ) {
        var list = $("#homeQuote li").toArray();
        var elemlength = list.length;
        var randomnum = Math.floor(Math.random()*elemlength);
        var randomitem = list[randomnum];
        $active = $(randomitem);
    }

    var $next =  $active.next().length ? $active.next()
        : $('#homeQuote li:first');

    $active.addClass('last-active');

    $active.fadeOut('fast').removeClass('active last-active');
    $next.addClass('active').fadeIn('slow');

    var quoteWords = $('.quote', $next).html().split(" ").length;
    var authorWords = $('.author', $next).html().split(" ").length;
    var readingTimeout = 380 * (quoteWords + authorWords); //380 milliseconds per word based on 200 words per minute multiplied by the quote and author word count.
    $next.addClass('timeout'+readingTimeout);
    window.setTimeout(homepageQuoteRotator, readingTimeout);
}
