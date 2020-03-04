import $ from 'jquery'

$(document).ready(function () {
    $(".lengthCounter").each(function () {
        let $element = $(this),
            minLength = $element.data('min-length'),
            $counter = $("<p>");
        $counter.addClass('counter-info text-right').insertAfter($element);

        $element.keyup(function () {
            let charCount = $element.val().length
            if (charCount < minLength) {
                $counter.text(minLength - charCount + " more characters needed").show();
            } else {
                $counter.hide();
            }
        }).trigger('keyup');
    })
})