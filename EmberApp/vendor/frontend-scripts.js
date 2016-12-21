$( document ).ready(function() {
    $(".toggle-left-section").on("click",function(e){
        e.preventDefault();
        /* funckija da se pojavi leva sekcija. Prvo se gubi klasa visible sa desne sekcije, pa se ukljucuje leva. */
        $(".left-section").toggleClass("left-section-visible");
        $(".toggle-left-section").toggleClass("collapsed");
    });


    $('#nav-icon3').click(function(){
        $(this).toggleClass('open');
    });

// Add slideDown animation to Bootstrap dropdown when expanding.
    $('.dropdown').on('show.bs.dropdown', function() {
        $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
    });

// Add slideUp animation to Bootstrap dropdown when collapsing.
    $('.dropdown').on('hide.bs.dropdown', function() {
        $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
    });
});

