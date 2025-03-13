/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
(function ($) {
  "use strict";

  window.kbg_app = {
    settings: {
      admin_bar: {
        height: 0,
        position: ''
      },
      pushes: {
        url: [],
        up: 0,
        down: 0
      },
      window_last_top: 0,
      infinite_allow: true,
      play_allow: true
    },
    init: function init() {
      this.admin_bar_check();
      this.sticky_header();
      this.accordion_widget();
      this.kbg_toogle();
      this.pagination();
      this.check_history();
      this.sidebar();
      this.reverse_menu();
      this.hamburger_navigation();
      this.masonry_posts();
      this.responsive_search();
    },
    resize: function resize() {
      this.admin_bar_check();
      this.sidebar();
    },
    scroll: function scroll() {
      this.sticky_header();
    },
    admin_bar_check: function admin_bar_check() {
      if ($('#wpadminbar').length && $('#wpadminbar').is(':visible')) {
        this.settings.admin_bar.height = $('#wpadminbar').height();
        this.settings.admin_bar.position = $('#wpadminbar').css('position');
      }
    },
    sticky_header: function sticky_header() {
      if (!kbg_js_settings.header_sticky) {
        return false;
      }

      var sticky_top = this.settings.admin_bar.position == 'fixed' ? this.settings.admin_bar.height : 0;
      var top = $(window).scrollTop();
      var last_top = this.settings.window_last_top;
      $('.header-sticky').css('top', sticky_top);

      if (kbg_js_settings.header_sticky_up) {
        if (last_top > top && top >= kbg_js_settings.header_sticky_offset) {
          if (!$("body").hasClass('kbg-header-sticky-active')) {
            $("body").addClass("kbg-header-sticky-active");
          }
        } else {
          if ($("body").hasClass('kbg-header-sticky-active')) {
            $("body").removeClass("kbg-header-sticky-active");
          }
        }
      } else {
        if (top >= kbg_js_settings.header_sticky_offset) {
          if (!$("body").hasClass('kbg-header-sticky-active')) {
            $("body").addClass("kbg-header-sticky-active");
          }
        } else {
          if ($("body").hasClass('kbg-header-sticky-active')) {
            $("body").removeClass("kbg-header-sticky-active");
          }
        }
      }

      this.settings.window_last_top = top;
    },
    kbg_toogle: function kbg_toogle() {
      $('body').on('click', '.kbg-toogle-action', function () {
        $(this).next().slideToggle('fast');
        $(this).toggleClass('kbg-toogle-active');
      });
    },
    hamburger_navigation: function hamburger_navigation() {
      $('.kbg-hamburger').on('click', '.kbg-open-responsive-menu', function () {
        $(this).closest('ul').find('ul.hamburger-sub-menu:first').slideToggle('fast').parent().toggleClass('accordion-active');
      });
      $('.kbg-hamburger').on('click', '.kbg-has-sub-menu', function () {
        $(this).closest('li').find('ul.sub-menu:first').slideToggle('fast').parent().toggleClass('accordion-active');
      });
    },
    sidebar: function sidebar() {
      if ($('.kbg-sticky').length || $('.widget-sticky').length) {
        if (window.matchMedia('(min-width: ' + kbg_js_settings.grid.breakpoint.lg + 'px)').matches && $('.widget-sticky').length && !$('.kbg-sticky').length) {
          $('.kbg-sidebar').each(function () {
            if ($(this).find('.widget-sticky').length) {
              $(this).find('.widget-sticky').wrapAll('<div class="kbg-sticky"></div>');
            }
          });
        }

        $('body').imagesLoaded(function () {
          var sticky_sidebar = $('.kbg-sticky');
          var top_padding = window.matchMedia('(min-width: ' + kbg_js_settings.grid.breakpoint.xl + 'px)').matches ? kbg_js_settings.grid.gutter.xl : kbg_js_settings.grid.gutter.lg;
          sticky_sidebar.each(function () {
            var content = $(this).closest('.section-content').find('.kbg-content-height');
            var parent = $(this).parent();
            var sticky_offset = $('.kbg-header.header-sticky').length && !kbg_js_settings.header_sticky_up ? $('.kbg-header.header-sticky').outerHeight() : 0;
            var admin_bar_offset = kbg_app.settings.admin_bar.position == 'fixed' ? kbg_app.settings.admin_bar.height : 0;
            var offset_top = sticky_offset + admin_bar_offset + top_padding;
            var widgets = $(this).children().addClass('widget-sticky');
            parent.height(content.height());

            if (window.matchMedia('(min-width: ' + kbg_js_settings.grid.breakpoint.lg + 'px)').matches) {
              $(this).stick_in_parent({
                offset_top: offset_top
              });
              kbg_app.masonry_widgets();
            } else {
              parent.css('height', 'auto');
              parent.css('min-height', '1px');
              widgets.unwrap();
              kbg_app.masonry_widgets();
            }
          });
        });
      } else {
        kbg_app.masonry_widgets();
      }
    },
    masonry_widgets: function masonry_widgets() {
      if (!$('.kbg-sidebar').length) {
        return false;
      }

      $('body').imagesLoaded(function () {
        var sidebar = $('.kbg-sidebar');
        sidebar.each(function () {
          if (window.matchMedia('(min-width: ' + kbg_js_settings.grid.breakpoint.lg + 'px)').matches) {
            if ($(this).hasClass('has-masonry')) {
              $(this).removeClass('has-masonry').masonry('destroy');
            }
          } else {
            $(this).addClass('has-masonry').masonry({
              columnWidth: '.col-md-6',
              percentPosition: true
            });
          }
        });
      });
    },
    responsive_search: function responsive_search() {
      /* Responsive Search functionality addons */
      $('.header-mobile').on('click', '.kbg-menu-popup-search span', function (e) {
        e.preventDefault();
        $('.kbg-in-popup').toggle();
        $(this).toggleClass('kg-close', 'kg-search');
      });
    },
    masonry_posts: function masonry_posts() {
      $('body').imagesLoaded(function () {
        if ($('.kbg-masonry').length) {
          $('.kbg-masonry').masonry({
            percentPosition: true
          });
        }
      });
    },
    masonry_append_posts: function masonry_append_posts(items) {
      $('.kbg-masonry').masonry().append(items).masonry('appended', items).masonry();
    },
    pagination: function pagination() {
      $('body').on('click', '.kbg-pagination.load-more > a', function (e) {
        e.preventDefault();
        $('.kbg-pagination').find('a').append('<span class="cssload-container"><span class="cssload-speeding-wheel"></span></span>');
        kbg_app.load_more_items({
          opener: $(this),
          url: $(this).attr('href'),
          next_url_selector: '.kbg-pagination.load-more > a'
        }, function () {});
      });

      if (!$('.kbg-pagination.kbg-infinite-scroll').length) {
        return false;
      }

      $(window).scroll(function () {
        if (kbg_app.settings.infinite_allow && $('.kbg-pagination').length) {
          var pagination = $('.kbg-pagination');
          var opener = pagination.find('a');

          if ($(this).scrollTop() > pagination.offset().top - $(this).height() - 200) {
            kbg_app.settings.infinite_allow = false;
            kbg_app.load_more_items({
              opener: opener,
              url: opener.attr('href'),
              next_url_selector: '.kbg-pagination.kbg-infinite-scroll a'
            }, function () {
              kbg_app.settings.infinite_allow = true;
            });
          }
        }
      });
    },
    load_more_items: function load_more_items(args, callback) {
      $('.kbg-pagination').toggleClass('kbg-loader-active');
      $('.kbg-pagination').find('a').append('<span class="cssload-container"><span class="cssload-speeding-wheel"></span></span>');
      var defaults = {
        opener: '',
        url: '',
        next_url_selector: '.load-more > a'
      };
      var options = $.extend({}, defaults, args);
      $("<div>").load(options.url, function () {
        var $this_new_page = $(this);
        var next_link_html = $this_new_page.find('.load-more').html();
        var next_url = $this_new_page.find(options.next_url_selector).attr('href');
        var next_title = $this_new_page.find('title').text();
        var new_items = $this_new_page.find('.kbg-items').children();
        var container = options.opener.closest('.section-content').find('.kbg-items');
        new_items.imagesLoaded(function () {
          if (container.hasClass('kbg-masonry')) {
            kbg_app.masonry_append_posts(new_items);
          } else {
            new_items.hide().appendTo(container).fadeIn();
          }

          if (next_url !== undefined) {
            $('.load-more').html(next_link_html);
          } else {
            $(options.next_url_selector).closest('.kbg-pagination').parent().fadeOut('fast').remove();
          }

          var push_obj = {
            prev: window.location.href,
            next: options.url,
            offset: $(window).scrollTop(),
            prev_title: window.document.title,
            next_title: next_title
          };
          kbg_app.push_state(push_obj);
          $('.kbg-pagination').toggleClass('kbg-loader-active');
          kbg_app.sidebar();
          callback();
        });
      });
    },
    push_state: function push_state(args) {
      var defaults = {
        prev: window.location.href,
        next: '',
        offset: $(window).scrollTop(),
        prev_title: window.document.title,
        next_title: window.document.title,
        increase_counter: true
      },
          push_object = $.extend({}, defaults, args);

      if (push_object.increase_counter) {
        kbg_app.settings.pushes.up++;
        kbg_app.settings.pushes.down++;
      }

      delete push_object.increase_counter;
      kbg_app.settings.pushes.url.push(push_object);
      window.document.title = push_object.next_title;
      window.history.pushState(push_object, '', push_object.next);
    },
    check_history: function check_history() {
      if (!$('.kbg-pagination.load-more').length && !$('.kbg-pagination.kbg-infinite-scroll').length) {
        return false;
      }

      kbg_app.push_state({
        increase_counter: false
      });
      var last_up,
          last_down = 0;
      $(window).scroll(function () {
        if (kbg_app.settings.pushes.url[kbg_app.settings.pushes.up].offset !== last_up && $(window).scrollTop() < kbg_app.settings.pushes.url[kbg_app.settings.pushes.up].offset) {
          last_up = kbg_app.settings.pushes.url[kbg_app.settings.pushes.up].offset;
          last_down = 0;
          window.document.title = kbg_app.settings.pushes.url[kbg_app.settings.pushes.up].prev_title;
          window.history.replaceState(kbg_app.settings.pushes.url, '', kbg_app.settings.pushes.url[kbg_app.settings.pushes.up].prev);
          kbg_app.settings.pushes.down = kbg_app.settings.pushes.up;

          if (kbg_app.settings.pushes.up !== 0) {
            kbg_app.settings.pushes.up--;
          }
        }

        if (kbg_app.settings.pushes.url[kbg_app.settings.pushes.down].offset !== last_down && $(window).scrollTop() > kbg_app.settings.pushes.url[kbg_app.settings.pushes.down].offset) {
          last_down = kbg_app.settings.pushes.url[kbg_app.settings.pushes.down].offset;
          last_up = 0;
          window.document.title = kbg_app.settings.pushes.url[kbg_app.settings.pushes.down].next_title;
          window.history.replaceState(kbg_app.settings.pushes.url, '', kbg_app.settings.pushes.url[kbg_app.settings.pushes.down].next);
          kbg_app.settings.pushes.up = kbg_app.settings.pushes.down;

          if (kbg_app.settings.pushes.down < kbg_app.settings.pushes.url.length - 1) {
            kbg_app.settings.pushes.down++;
          }
        }
      });
    },
    accordion_widget: function accordion_widget() {
      $('.widget').find('.menu-item-has-children > a, .page_item_has_children > a, .cat-parent > a').after('<span class="kbg-accordion-nav"><i class="kb kg-down"></i></span>');
      $('.widget').on('click', '.kbg-accordion-nav', function () {
        $(this).closest('li').find('ul.sub-menu:first, ul.children:first').slideToggle('fast').parent().toggleClass('accordion-active');
      });
    },
    reverse_menu: function reverse_menu() {
      $('.kbg-header ul li').on('mouseenter', 'ul li', function (e) {
        if ($(this).find('ul').length) {
          var rt = $(window).width() - ($(this).find('ul').offset().left + $(this).find('ul').outerWidth());

          if (rt < 0) {
            $(this).find('ul').addClass('kbg-rev');
          }
        }
      });
    }
  };
  $(document).ready(function () {
    kbg_app.init();
  });
  $(window).resize(function () {
    kbg_app.resize();
  });
  $(window).scroll(function () {
    kbg_app.scroll();
  });
})(jQuery);
/******/ })()
;