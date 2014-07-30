
(function($) {
    $.fn.notnu = function() {
        return this.each(function() {
            $(this).keydown(function(event) {

                return KEYS_ALLOWED[event.keyCode] ? false : true;
            });
        });
    };
    var KEYS_ALLOWED = {
		13: 'ENTER',32:'SPACE'
		, 48: 'ZERO'
		, 49: 'ONE'
		, 50: 'TWO'
		, 51: 'THREE'
		, 52: 'FOUR'
		, 53: 'FIVE'
		, 54: 'SIX'
		, 55: 'SEVEN'
		, 56: 'EIGHT'
		, 57: 'NINE'
		, 96: 'ZERO'
		, 97: 'ONE'
		, 98: 'TWO'
		, 99: 'THREE'
		, 100: 'FOUR'
		, 101: 'FIVE'
		, 102: 'SIX'
		, 103: 'SEVEN'
		, 104: 'EIGHT'
		, 105: 'NINE'
    };
})(jQuery);