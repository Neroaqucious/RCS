"use strict";

(function($) {

    "use strict";

    /* Initialize Tooltip */
    $('[data-toggle="tooltip"]').tooltip();

    /* Initialize Popover */
    $('[data-toggle="popover"]').popover();

    /* Initialize Lightbox */
    $('body').delegate('[data-toggle="lightbox"]', 'click', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });

    /************************************************
		Append Preloader (use in ajax call)
    ************************************************/
    $('.loading').addClass('is-active');
        $(window).on('load', function() {
            setTimeout(removeLoader, 100);
        });

    function removeLoader() {
        $(".loading").fadeOut(50, function() {
            // fadeOut complete. Remove the loading div
            $('.loading').removeClass('is-active');
        });

    }

    /************************************************
		Toggle Preloader in card or box
    ************************************************/
    $('body').delegate('[data-toggle="loader"]', 'click', function() {

        var target = $(this).attr('data-target');
        $('#' + target).show();

    });

    /************************************************
		Toggle Sidebar Nav
    ************************************************/
    $('body').delegate('.toggle-sidebar', 'click', function() {
        $('.sidebar').toggleClass('collapsed');

        if (localStorage.getItem("asideMode") === 'collapsed') {
            localStorage.setItem("asideMode", 'expanded')
        } else {
            localStorage.setItem("asideMode", 'collapsed')
        }
        return false;
    });

    var p;
    $('body').delegate('.hide-sidebar', 'click', function() {
        if (p) {
            p.prependTo(".wrapper");
            p = null;
        } else {
            p = $(".sidebar").detach();
        }
    });

    $.fn.setAsideMode = function() {
        if (localStorage.getItem("asideMode") === null) {

        } else if (localStorage.getItem("asideMode") === 'collapsed') {
            $('.sidebar').addClass('collapsed');
        } else {
            $('.sidebar').removeClass('collapsed');
        }
    }
    if ($(window).width() > 768) {
        $.fn.setAsideMode();
    }

    /************************************************
		Sidebar Nav Accordion
    ************************************************/
    $('body').delegate('.navigation li:has(.sub-nav) > a', 'click', function() {
        /*$('.navigation li').removeClass('open');*/
        $(this).siblings('.sub-nav').slideToggle();
        $(this).parent().toggleClass('open');
        return false;
    });

    /************************************************
    Sidebar Colapsed state submenu position
    ************************************************/
    $('body').delegate('.navigation ul li:has(.sub-nav)', 'mouseover', function() {

        if ($(".sidebar").hasClass("collapsed")) {

            var $menuItem = $(this),
                $submenuWrapper = $('> .sub-nav', $menuItem);

            // grab the menu item's position relative to its positioned parent
            var menuItemPos = $menuItem.position();

            // place the submenu in the correct position relevant to the menu item
            $submenuWrapper.css({
                top: menuItemPos.top,
                left: menuItemPos.left + $menuItem.outerWidth()
            });
        }

    });

    /************************************************
    Toggle Controls on small devices
    ************************************************/
    $('body').delegate('.toggle-controls', 'click', function() {
        $('.controls-wrapper').toggle().toggleClass('d-none');
    });

    /************************************************
    Toast Messages
    ************************************************/
    $('body').delegate('[data-toggle="toast"]', 'click', function() {

        var dataAlignment = $(this).attr('data-alignment');
        var dataPlacement = $(this).attr('data-placement');
        var dataContent = $(this).attr('data-content');
        var dataStyle = $(this).attr('data-style');


        if ($('.toast.' + dataAlignment + '-' + dataPlacement).length) {

            $('.toast.' + dataAlignment + '-' + dataPlacement).append('<div class="alert alert-dismissible fade show alert-' + dataStyle + ' "> ' + dataContent + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" class="material-icons md-18">clear</span></button></div>');

        } else {
            $('body').append('<div class="toast ' + dataAlignment + '-' + dataPlacement + '"> <div class="alert alert-dismissible fade show alert-' + dataStyle + ' "> ' + dataContent + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" class="material-icons md-18">clear</span></button></div> </div>');
        }

    });

    /**************************************
    Chosen Form Control
    **************************************/
    $('.form-control-chosen').chosen({
        allow_single_deselect: true,
        width: '100%'
    });
    $('.form-control-chosen-required').chosen({
        allow_single_deselect: false,
        width: '100%'
    });
    $('.form-control-chosen-search-threshold-100').chosen({
        allow_single_deselect: true,
        disable_search_threshold: 100,
        width: '100%'
    });
    $('.form-control-chosen-optgroup').chosen({
        width: '100%'
    });
    $(function() {
        $('[title="clickable_optgroup"]').addClass('chosen-container-optgroup-clickable');
    });
    $(document).delegate('[title="clickable_optgroup"] .group-result', 'click', function() {
        var unselected = $(this).nextUntil('.group-result').not('.result-selected');
        if (unselected.length) {
            unselected.trigger('mouseup');
        } else {
            $(this).nextUntil('.group-result').each(function() {
                $('a.search-choice-close[data-option-array-index="' + $(this).data('option-array-index') + '"]').trigger('click');
            });
        }
    });

    $('#RcsTable').DataTable();

})(jQuery);
