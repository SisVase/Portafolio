(function ($) {
  "user strict";

  // preloader
  $(".preloader").delay(800).animate({
    "opacity": "0"
  }, 800, function () {
      $(".preloader").css("display", "none");
  });

  // xzoom magific
  $('.xzoom-magnific').magnificPopup({
    type: 'image'
  });

// wow
if ($('.wow').length) {
  var wow = new WOW({
    boxClass: 'wow',
    // animated element css class (default is wow)
    animateClass: 'animated',
    // animation css class (default is animated)
    offset: 0,
    // distance to the element when triggering the animation (default is 0)
    mobile: false,
    // trigger animations on mobile devices (default is true)
    live: true // act on asynchronously loaded content (default is true)
  });
  wow.init();
}

//Create Background Image
(function background() {
  let img = $('.bg_img');
  img.css('background-image', function () {
    var bg = ('url(' + $(this).data('background') + ')');
    return bg;
  });
})();

// lightcase
$(window).on('load', function () {
  $("a[data-rel^=lightcase]").lightcase();
})

// color version change
$('.template-version button').on('click', function () {
  $('.template-version').toggleClass('open');
});

// navbar-click
$(".navbar li a").on("click", function () {
  var element = $(this).parent("li");
  if (element.hasClass("show")) {
    element.removeClass("show");
    element.find("li").removeClass("show");
  }
  else {
    element.addClass("show");
    element.siblings("li").removeClass("show");
    element.siblings("li").find("li").removeClass("show");
  }
});

// scroll-to-top
var ScrollTop = $(".scrollToTop");
$(window).on('scroll', function () {
  if ($(this).scrollTop() < 500) {
      ScrollTop.removeClass("active");
  } else {
      ScrollTop.addClass("active");
  }
});


var swiper = new Swiper('.info-slider', {
  slidesPerView: 3,
  spaceBetween: 0,
  loop: true,
  autoplay: {
    speed: 1000,
    delay: 3000,
  },
  speed: 1000,
  breakpoints: {
    991: {
      slidesPerView: 2,
    },
    767: {
      slidesPerView: 1,
    },
    575: {
      slidesPerView: 1,
    },
  }
});

var swiper = new Swiper('.product-slider', {
  slidesPerView: 3,
  spaceBetween: 30,
  loop: true,
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  autoplay: {
    speed: 1000,
    delay: 3000,
  },
  speed: 1000,
  breakpoints: {
    991: {
      slidesPerView: 2,
    },
    767: {
      slidesPerView: 1,
    },
    575: {
      slidesPerView: 1,
    },
  }
});


var swiper = new Swiper('.product-slider-two', {
  slidesPerView: 4,
  spaceBetween: 30,
  loop: true,
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  autoplay: {
    speed: 1000,
    delay: 3000,
  },
  speed: 1000,
  breakpoints: {
    991: {
      slidesPerView: 2,
    },
    767: {
      slidesPerView: 1,
    },
    575: {
      slidesPerView: 1,
    },
  }
});


var swiper = new Swiper('.product-single-slider', {
  slidesPerView: 4,
  spaceBetween: 10,
  loop: true,
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  speed: 1000,
  breakpoints: {
    991: {
      slidesPerView: 4,
    },
    767: {
      slidesPerView: 4,
    },
    575: {
      slidesPerView: 3,
    },
  }
});

// product Tab
var tabWrapper = $('.product-tab'),
  tabMnu = tabWrapper.find('.tab-menu li'),
  tabContent = tabWrapper.find('.tab-cont > .tab-item');
tabContent.not(':nth-child(1)').fadeOut(10);
tabMnu.each(function (i) {
  $(this).attr('data-tab', 'tab' + i);
});
tabContent.each(function (i) {
  $(this).attr('data-tab', 'tab' + i);
});
tabMnu.on('click', function () {
  var tabData = $(this).data('tab');
  tabWrapper.find(tabContent).fadeOut(10);
  tabWrapper.find(tabContent).filter('[data-tab=' + tabData + ']').fadeIn(10);
});
$('.tab-menu > li').on('click', function () {
  var before = $('.tab-menu li.active');
  before.removeClass('active');
  $(this).addClass('active');
});

// overview Tab
var tabWrapper2 = $('.product-single-tab'),
  tabMnu2 = tabWrapper2.find('.tab-menu li'),
  tabContent2 = tabWrapper2.find('.tab-cont > .tab-item');
tabContent2.not(':nth-child(1)').fadeOut(10);
tabMnu2.each(function (i) {
  $(this).attr('data-tab', 'tab' + i);
});
tabContent2.each(function (i) {
  $(this).attr('data-tab', 'tab' + i);
});
tabMnu2.on('click', function () {
  var tabData2 = $(this).data('tab');
  tabWrapper2.find(tabContent2).fadeOut(10);
  tabWrapper2.find(tabContent2).filter('[data-tab=' + tabData2 + ']').fadeIn(10);
});
$('.tab-menu > li').on('click', function () {
  var before = $('.tab-menu li.active');
  before.removeClass('active');
  $(this).addClass('active');
});

// sidebar
$(".has-sub > a").on("click", function () {
  var element = $(this).parent("li");
  if (element.hasClass("active")) {
    element.removeClass("active");
    element.children("ul").slideUp(500);
  }
  else {
    element.siblings("li").removeClass('active');
    element.addClass("active");
    element.siblings("li").find("ul").slideUp(500);
    element.children('ul').slideDown(500);
  }
});

//sidebar Menu
$(document).on('click', '.mobile-menu-toggler', function () {
  $('#version').toggleClass('show');
});

//Cross Menu
$('.mobile-menu-close').on('click', function () {
  $('#version').removeClass('show');
});

//sidebar Menu
$(document).on('click', '.sidebar-toggle', function () {
  $('#version').toggleClass('open');
});

//Cross Menu
$('.mobile-menu-close').on('click', function () {
  $('.page-wrapper').removeClass('show');
});

//Close Menu
$(document).on('click', '.mfp-close', function () {
  $('.top-notice').toggleClass('remove');
});

//Search Menu
$(document).on('click', '.search-toggle', function () {
  $('.header-search-wrapper').toggleClass('active');
});

  function mountZoomImage(image, width, height, target) {
    target.prepend('<div class="zoom"><div class="zoom__image"></div></div>');
    $('div.zoom__image').css({
      'width': width,
      'height': height,
      'background-image': 'url(' + image + ')'
    });
  }

  function unmountZoomImage() {
    $('div.zoom').remove();
  }

  function zoomImage(zoom) {
    $('div.zoom__image').css({
      'transform': 'scale(' + zoom + ')',
      'margin-top': '50px'
    });
  }

  function panZoomImage(x, y, target) {
    var transformX = (x / (target.width() - 100) * 100) + '%';
    var transformY = (y / (target.height() - 50) * 100) + '%';

    target.css({ 'transform-origin': transformX + ' ' + transformY });
  }

  $('div.standard').mousemove(function (event) {
    var $zoomTarget = $('div.zoom__image');
    var x = event.pageX - $(this).offset().left;
    var y = event.pageY - $(this).offset().top;
    panZoomImage(x, y, $zoomTarget);
  });

  $('div.standard').mouseover(function () {
    var $zoomParent = $('div.copy');
    var image = $(this).find('img').attr('src');
    var imageWidth = $(this).find('img').width();
    var imageHeight = $(this).find('img').height();
    var zoomAmount = $(this).attr('data-zoom');

    $(this).css({ 'cursor': 'zoom-in' });
    mountZoomImage(image, imageWidth, imageHeight, $zoomParent);
    zoomImage(zoomAmount);
  });

  $('div.standard').mouseout(function () {
    unmountZoomImage();
  });

  // product + - start here
  $(function () {
    $(".qtybutton").on("click", function () {
      var $button = $(this);
      var oldValue = $button.parent().find("input").val();
      if ($button.text() === "+") {
        var newVal = parseFloat(oldValue) + 1;
      } else {
        // Don't allow decrementing below zero
        if (oldValue > 1) {
          var newVal = parseFloat(oldValue) - 1;
        } else {
          newVal = 1;
        }
      } 
      $button.parent().find("input").val(newVal);
    });
  });

  // main wrapper calculator
  var bodySelector = document.querySelector('body');
  var header = document.querySelector('.header-section');
  var footer = document.querySelector('.footer-section');

  (function(){
    if(bodySelector.contains(header) && bodySelector.contains(footer)){
      var headerHeight = document.querySelector('.header-section').clientHeight;
      var footerHeight = document.querySelector('.footer-section').clientHeight;

      // if header isn't fixed to top
      var totalHeight = parseInt( headerHeight, 10 ) + parseInt( footerHeight, 10 ) + 'px'; 
      
      // if header is fixed to top
      // var totalHeight = parseInt( footerHeight, 10 ) + 'px'; 
      var minHeight = '100vh';
      document.querySelector('.page-wrapper').style.minHeight = `calc(${minHeight} - ${totalHeight})`;
    }
  })();

})(jQuery);