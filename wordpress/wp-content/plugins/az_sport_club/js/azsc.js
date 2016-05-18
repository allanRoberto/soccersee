(function($) {
    "use strict";
    window.azsc = $.extend({}, window.azsc);
    window.azsc.map_init = function() {
        window.azsc = $.extend({}, {
            markerContent: '<div class="azsc-map-marker">' +
                    '<span class="azsc-icon">' +
                    '</span>' +
                    '</div>'
        }, window.azsc);

        $('.match-location').each(function() {
            var location = new google.maps.LatLng(parseFloat(azsc.location.latitude), parseFloat(azsc.location.longitude));
            var map = new google.maps.Map(this, {
                center: location,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var boxText = document.createElement("div");            

            var markerContent = document.createElement('DIV');
            markerContent.innerHTML = azsc.markerContent;

            var marker = new RichMarker({
                position: location,
                map: map,
                content: markerContent,
                flat: true
            });
        });

    }

    $(function() {
        azsc.map_init();
    });
})(jQuery);