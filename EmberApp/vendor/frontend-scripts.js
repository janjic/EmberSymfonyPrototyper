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

    $('.button').mousedown(function (e) {
        var target = e.target;
        var rect = target.getBoundingClientRect();
        var ripple = target.querySelector('.ripple');
        $(ripple).remove();
        ripple = document.createElement('span');
        ripple.className = 'ripple';
        ripple.style.height = ripple.style.width = Math.max(rect.width, rect.height) + 'px';
        target.appendChild(ripple);
        var top = e.pageY - rect.top - ripple.offsetHeight / 2 -  document.body.scrollTop;
        var left = e.pageX - rect.left - ripple.offsetWidth / 2 - document.body.scrollLeft;
        ripple.style.top = top + 'px';
        ripple.style.left = left + 'px';
        return false;
    });

});

