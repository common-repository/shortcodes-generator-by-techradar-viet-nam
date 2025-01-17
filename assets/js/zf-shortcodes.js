(function ($) {
    "use strict";



    if (zfv_shortcode_front.animation) {

        /*==============================================
         * Animations
         ===============================================*/
        if (typeof WOW != 'undefined') {
            var wow = new WOW(
                {
                    boxClass:     'wow',      // animated element css class (default is wow)
                    animateClass: 'animated', // animation css class (default is animated)
                    offset:       zfv_shortcode_front.animation_offset,          // distance to the element when triggering the animation (default is 0)
                    mobile:       Boolean(zfv_shortcode_front.animation_on_mobile),       // trigger animations on mobile devices (default is true)
                    live:         true,       // act on asynchronously loaded content (default is true)
                    callback:     function(box) {
                        // the callback is fired every time an animation is started
                        // the argument that is passed in is the DOM node being animated
                    }
                }
            );
            wow.init();
        }
    }

})(jQuery);