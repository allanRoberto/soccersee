(function($) {
    "use strict";

    function initPopup() {
        if ('magnificPopup' in $.fn) {
            $('a.image-popup').magnificPopup({
                type: 'image',
                removalDelay: 300,
                mainClass: 'mfp-fade',
                overflowY: 'scroll'
            });
            $('a.iframe-popup').magnificPopup({
                type: 'iframe',
                removalDelay: 300,
                mainClass: 'mfp-fade',
                overflowY: 'scroll',
                iframe: {
                    markup: '<div class="mfp-iframe-scaler">' +
                            '<div class="mfp-close"></div>' +
                            '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>' +
                            '</div>',
                    patterns: {
                        youtube: {
                            index: 'youtube.com/',
                            id: 'v=',
                            src: '//www.youtube.com/embed/%id%?autoplay=1'
                        },
                        vimeo: {
                            index: 'vimeo.com/',
                            id: '/',
                            src: '//player.vimeo.com/video/%id%?autoplay=1'
                        },
                        gmaps: {
                            index: '//maps.google.',
                            src: '%id%&output=embed'
                        }
                    },
                    srcAction: 'iframe_src'
                }
            });
        }
    }
    function initAzexoCarousel() {
        if ('owlCarousel' in $.fn) {
            $('.carousel-wrapper .carousel').each(function() {
                var carousel = this;
                if ($(carousel).data('owlCarousel') == undefined) {

                    while ($(carousel).find('> div:not(.item)').length) {
                        $(carousel).find('> div:not(.item)').slice(0, $(carousel).data('contents-per-item')).wrapAll('<div class="item" />');
                    }

                    var r = $(carousel).data('responsive');
                    $(carousel).show();
                    var hold = false;
                    $(carousel).owlCarousel({
                        responsive: window[r],
                        center: ($(carousel).data('center') == 'yes'),
                        margin: $(carousel).data('margin'),
                        loop: ($(carousel).data('loop') == 'yes'),
                        autoplay: ($(carousel).data('autoplay') == 'yes'),
                        autoplayHoverPause: true,
                        nav: true,
                        navText: ['', '']
                    }).on('translate.owl.carousel', function(event) {
                        if (!hold) {
                            var item = $(carousel).data('owlCarousel')._items[event.item.index];
                            $(item).find('.triggerable.active').click();
                        }
                    }).on('translated.owl.carousel', function(event) {
                        if (!hold) {
                            var item = $(carousel).data('owlCarousel')._items[event.item.index];
                            $(item).find('.triggerable:not(.active)').click();
                        }
                        try {
                            BackgroundCheck.refresh($(carousel).find('.owl-controls .owl-prev, .owl-controls .owl-next'));
                        } catch (e) {
                        }
                    });
                    setTimeout(function() {
                        var item = $(carousel).data('owlCarousel')._items[$(carousel).data('owlCarousel')._current];
                        $(item).find('.triggerable').click();

                        $(carousel).find('.triggerable').on('click', function() {
                            hold = true;
                            var item = $(this).closest('.owl-item');
                            var index = $(carousel).find('.owl-item').index(item);
                            $(carousel).data('owlCarousel').to($(carousel).data('owlCarousel').relative(index));
                            hold = false;
                        });
                    }, 0);
                    try {
                        BackgroundCheck.init({
                            targets: $(carousel).find('.owl-controls .owl-prev, .owl-controls .owl-next'),
                            images: $(carousel).find('.item .image')
                        });
                    } catch (e) {
                    }
                }
            });
        }
    }
    function initAzexoFilters() {
        $('.filters-wrapper > .filters-header > .filters > .filter').on('click', function() {
            $(this).closest('.filters').find('.filter').removeClass('active');
            $(this).closest('.filters').find('.filter').each(function() {
                if ($(this).data('selector')) {
                    $(this).closest('.filters-wrapper').find('> .filterable ' + $(this).data('selector')).removeClass('showed');
                }
            });
            $(this).addClass('active');
            if ($(this).data('selector')) {
                $(this).closest('.filters-wrapper').find('> .filterable ' + $(this).data('selector')).addClass('showed');
            }
            if ('masonry' in $.fn) {
                var container = $(this).closest('.filters-wrapper').find('> .filterable');
                if ($(container).is('.masonry')) {
                    $(container).masonry('layout', '> .showed');
                }
            }
        });
        $('.filters-wrapper > .filters-header > .filters > .filter').each(function() {
            if ($(this).data('selector')) {
                $(this).closest('.filters-wrapper').find('> .filterable ' + $(this).data('selector')).addClass('showed');
            }
        });
    }
    function initMasonry() {
        if ('masonry' in $.fn) {
            $('.masonry').each(function() {
                var container = this;
                var containerWidth = $(container).width();

                var r = $(container).data('responsive');
                var items = 0;
                for (var width in window[r]) {
                    if (containerWidth > width) {
                        items = window[r][width].items;
                    }
                }
                var columnWidth = containerWidth / parseInt(items, 10);
                setTimeout(function() {
                    $(container).masonry({
                        itemSelector: $(container).data('selector'),
                        gutter: parseInt($(container).data('gutter'), 10),
                        columnWidth: columnWidth
                    });
                }, 0);
            });
        }
    }
    $(function() {
        initAzexoCarousel();
        initAzexoFilters();
        initMasonry();        
        initPopup();
        if (document.documentElement.clientWidth > 768) {
            if (typeof scrollReveal === 'function') {
                window.scrollReveal = new scrollReveal();
            }
        }
        $(window).on('resize', function() {
            initMasonry();
        });
    });
})(jQuery);