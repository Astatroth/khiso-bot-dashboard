/*! Select2 4.0.13 | https://github.com/select2/select2/blob/master/LICENSE.md */ ! function() {
    if (jQuery && jQuery.fn && jQuery.fn.select2 && jQuery.fn.select2.amd) var n = jQuery.fn.select2.amd;
    n.define("select2/i18n/ru", [], function() {
        function n(n, e, r, u) {
            return n % 10 < 5 && n % 10 > 0 && n % 100 < 5 || n % 100 > 20 ? n % 10 > 1 ? r : e : u
        }
        return {
            errorLoading: function() {
                return "Natijalarni yuklab bo'lmadi"
            },
            inputTooLong: function(e) {
                var r = e.input.length - e.maximum;
                return "Iltimos, " + r + "ta belgisini kamroq kiriting";
            },
            inputTooShort: function(e) {
                var r = e.minimum - e.input.length;
                return "Iltimos, kamida yana " + r + "ta belgi kiriting";
            },
            loadingMore: function() {
                return "Ma'lumotlar yuklanmoqda...";
            },
            maximumSelected: function(e) {
                return "Siz maksimal " + e.maximum + "ta elementnitanlashingiz mumkin";
            },
            noResults: function() {
                return "Hech narsa topilmadi"
            },
            searching: function() {
                return "Qidirmoq..."
            },
            removeAllItems: function() {
                return "Barcha elementlarni olib tashlang"
            }
        }
    }), n.define, n.require
}();
