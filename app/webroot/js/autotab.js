(function ($) {
    $.fn.autoTab = function () {
        var els = this.length;
        for (var i = 0; i < els; i++) {
            var next = i + 1;
            var prev = i - 1;

            if (i > 0 && next < this.length) {
                $(this[i])._auTab({
                    next: $(this[next]),
                    prev: $(this[prev])
                });
            } else if (i > 0) {
                $(this[i])._auTab({
                    prev: $(this[prev])
                });
            } else {
                $(this[i])._auTab({
                    next: $(this[next])
                });
            }

            //$(this[0]).focus();

        }
        return this;
    };

    $.fn._auTab = function (options) {
        var defaults = {
            maxlength: 2147483647, //max length of type int
            prev: null,
            next: null
        };

        $.extend(defaults, options);

        // allow over riding the maxlength by passing it in the options:
        if (defaults.maxlength == 2147483647) { //maxlength has not been changed
            defaults.maxlength = $(this).attr('maxlength');
        }

        $(this).bind('keydown', function (e) {
            var cursorPos = $(this).getCursorPosition(),
                keyPressed = e.which,
                charactersEntered = this.value.length;
            // ( the key pressed is 8 (backspace) || the key pressed is 37 (left arrow) )
            // && ( the field is empty || the cursor position is at 0 )
            // && the previous field exists
            if ((keyPressed === 8 || keyPressed === 37) && (charactersEntered === 0 || cursorPos === 0) && defaults.prev) {
                defaults.prev.focus().val(defaults.prev.val());
            }
        });

        $(this).bind('keyup', function (e) {

            var v = $(this).val(),
                keyPressed = e.which,
                cursorPos = $(this).getCursorPosition(),
                /**
                 * ignore autoTab when it's one of the following:
                 * 8:	Backspace
                 * 16:	Shift
                 * 17:	Ctrl
                 * 18:	Alt
                 * 19:	Pause Break
                 * 20:	Caps Lock
                 * 27:	Esc
                 * 33:	Page Up
                 * 34:	Page Down
                 * 35:	End
                 * 36:	Home
                 * 37:	Left Arrow
                 * 38:	Up Arrow
                 * 39:	Right Arrow
                 * 40:	Down Arrow
                 * 45:	Insert
                 * 46:	Delete
                 * 144:	Num Lock
                 * 145:	Scroll Lock
                 */
                ignore_keys = [8, 16, 17, 18, 19, 20, 27, 33, 34, 35, 36, 37, 38, 39, 40, 45, 46, 144, 145];

            // the next element exists
            // &&
            // ( the key pressed isn't in the ignore list
            //   && the input has reached the max length
            // )
            // ||
            // ( the key pressed is the right arrow key
            //   && the cursor position is at the max length (the end of the input)
            // ) 
            if (defaults.next && ($.inArray(keyPressed, ignore_keys) === -1 && v.length == defaults.maxlength) || (keyPressed === 39 && cursorPos === parseInt(defaults.maxlength, 10))) {
                defaults.next.focus();
            }
        });
        return this;
    };


    $.fn.getCursorPosition = function () {
        var input = this.get(0);
        if (!input) return; // No (input) element found
        if ('selectionStart' in input) {
            // Standard-compliant browsers
            return input.selectionStart;
        } else if (document.selection) {
            // IE
            input.focus();
            var sel = document.selection.createRange();
            var selLen = document.selection.createRange().text.length;
            sel.moveStart('character', -input.value.length);
            return sel.text.length - selLen;
        }
    };
})(jQuery);