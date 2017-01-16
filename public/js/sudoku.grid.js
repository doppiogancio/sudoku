jQuery(document).ready(function ($) {
    $('.cell').hover(function (e) {
        var backgroundColor = 'yellow';

        var cell = $(this);

        console.log("hover row", cell.data('row'));
        console.log("hover column", cell.data('column'));

        $('.cell').css('background-color', 'white');

        $('.row-' + cell.data('row')).css('background-color', backgroundColor);
        $('.column-' + cell.data('column')).css('background-color', backgroundColor);
        $('.region-' + cell.data('region')).css('background-color', backgroundColor);

    });
});