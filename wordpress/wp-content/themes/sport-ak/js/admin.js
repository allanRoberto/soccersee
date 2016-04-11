(function($) {
    "use strict";

    $(function() {
        setTimeout(function() {
            if ('redux' in $ && 'ajax_save' in $.redux) {
                var redux_ajax_save = $.redux.ajax_save;
                $.redux.ajax_save = function(button) {
                    $('fieldset.redux-container-media input.upload-height, fieldset.redux-container-media input.upload-width, fieldset.redux-container-media input.upload-thumbnail').remove();
                    redux_ajax_save(button);
                };
            }
        }, 0);
    });
})(jQuery);
