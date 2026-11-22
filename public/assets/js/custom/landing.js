"use strict";

// Modul landing page: mengatur animasi pergantian kalimat pada judul hero.
var KTLandingPage = (function () {
  // Mengambil elemen hero dan menjalankan rotasi teks secara berulang.
  var initHeroTextRotation = function () {
    var el = document.querySelector("#kt_landing_hero_text");
    if (el && !el.hasAttribute("data-hero-text-init")) {
      el.setAttribute("data-hero-text-init", "true");
      // Daftar kalimat yang akan ditampilkan bergantian pada hero.
      var strings = [
        "Masa Depan Teknologi",
        "Generasi yang Unggul",
        "Inovasi & Kreativitas",
        "Prestasi & Kolaborasi",
      ];

      // Menyimpan urutan kalimat yang sedang ditampilkan.
      var index = 0;
      var measureText = document.createElement("span");
      measureText.style.cssText =
        "position:absolute;visibility:hidden;white-space:nowrap;";
      measureText.style.font = getComputedStyle(el).font;
      measureText.style.letterSpacing = getComputedStyle(el).letterSpacing;
      document.body.appendChild(measureText);

      // Mengunci lebar area teks agar pergantian kalimat tidak menggeser layout.
      var widestWidth = strings.reduce(function (width, text) {
        measureText.textContent = text;
        return Math.max(width, measureText.scrollWidth);
      }, 0);

      el.style.width = widestWidth + "px";
      el.style.textAlign = "left";
      measureText.remove();

      // Pergantian teks memakai fade keluar dan fade masuk agar transisi halus.
      var rotateText = function () {
        el.classList.remove("hero-text-entering");
        el.classList.add("hero-text-leaving");

        window.setTimeout(function () {
          index = (index + 1) % strings.length;
          el.textContent = strings[index];
          el.classList.remove("hero-text-leaving");
          el.classList.add("hero-text-entering");

          window.requestAnimationFrame(function () {
            window.requestAnimationFrame(function () {
              el.classList.remove("hero-text-entering");
            });
          });
        }, 280);
      };

      window.setInterval(rotateText, 3200);
    }
  };

  // API publik untuk memulai fungsi khusus halaman landing.
  return {
    init: function () {
      initHeroTextRotation();
    },
  };
})();

// Webpack support
if (typeof module !== "undefined") {
  module.exports = KTLandingPage;
}

// On document ready
KTUtil.onDOMContentLoaded(function () {
  KTLandingPage.init();
});
