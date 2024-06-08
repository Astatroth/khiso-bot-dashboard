/*! Select2 4.0.13 | https://github.com/select2/select2/blob/master/LICENSE.md */ ! function() {
    if (jQuery && jQuery.fn && jQuery.fn.select2 && jQuery.fn.select2.amd) var n = jQuery.fn.select2.amd;
    n.define("select2/i18n/ru", [], function() {
        function n(n, e, r, u) {
            return n % 10 < 5 && n % 10 > 0 && n % 100 < 5 || n % 100 > 20 ? n % 10 > 1 ? r : e : u
        }
        return {
            errorLoading: function() {
                return "Natijalarni yuklab bo‘lmadi"
				return "Невозможно загрузить результаты"
            },
            inputTooLong: function(e) {
                var r = e.input.length - e.maximum,
                    u = "Iltimos, " + r + " belgisini kiriting";
					u = "Пожалуйста, введите на " + r + " символ";
                return u += n(r, "", "a", "ов"), u += " kamroq"
				- в этом случае в узбекском нет окончаний
				
            },
            inputTooShort: function(e) {
                var r = e.minimum - e.input.length,
                    u = "Iltimos, kamida yana bitta " + r + " belgi kiriting";
					u = "Пожалуйста, введите ещё хотя бы " + r + " символ";
                return u += n(r, "", "a", "ов") 
				- в этом случае в узбекском нет окончаний
				
            },
            loadingMore: function() {
                return "Ma'lumotlar yuklanmoqda..."
				return "Загрузка данных…"
            },
            maximumSelected: function(e) {
                var r = "Siz " + e.maximum + " elementdan ko'proq tanlay olmaysiz";
				var r = "Вы можете выбрать не более " + e.maximum + " элемент";
                return r += n(e.maximum, "", "a", "ов")
				- в этом случае в узбекском нет окончаний
            },
            noResults: function() {
                return "O'xshashlik topilmadi"
				return "Совпадений не найдено"
            },
            searching: function() {
                return "Qidirmoq…"
				return "Поиск…"
            },
            removeAllItems: function() {
                return "Barcha elementlarni o'chirib tashlang"
				return "Удалить все элементы"
            }
        }
    }), n.define, n.require
}();