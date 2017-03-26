jQuery(document).ready(function ($) {
    $(".isotope-filter li a").click(function (e) {
        e.preventDefault();
        $(this).closest("ul").find("li").removeClass('active');
        $(this).closest("li").addClass('active');
        var selector = $(this).data('filter');
        $('.isotope').isotope({filter: selector});
    });
});