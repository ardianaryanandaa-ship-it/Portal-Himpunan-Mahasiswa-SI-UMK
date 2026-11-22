"use strict";

// Class definition
var KTLandingPage = function () {
    // Private methods
    var initTyped = function() {
        var el = document.querySelector("#kt_landing_hero_text");
        if (el && !el.hasAttribute("data-typed-init")) {
            el.setAttribute("data-typed-init", "true");
            var typed = new Typed("#kt_landing_hero_text", {
                strings: [
                    "Masa Depan Teknologi",
                    "Generasi Unggul",
                    "Inovasi & Kreativitas",
                    "Prestasi & Kolaborasi"
                ],
                typeSpeed: 60,
                backSpeed: 30,
                backDelay: 2500,
                loop: true
            });
        }
    }

    // Public methods
    return {
        init: function () {
            initTyped();
        }   
    }
}();

// Webpack support
if (typeof module !== 'undefined') {
    module.exports = KTLandingPage;
}

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTLandingPage.init();
});
