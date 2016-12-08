// $(document).on("resize",function(){
//     var leftSectionWidth=$(".left-section").width();
//     $(".right-section").css("margin-left", leftSectionWidth + "px");
// });


$(".toggle-left-section").on("click",function(e){
    e.preventDefault();
    /* funckija da se pojavi leva sekcija. Prvo se gubi klasa visible sa desne sekcije, pa se ukljucuje leva. */
    $(".left-section").toggleClass("left-section-visible");
    $(".toggle-left-section").toggleClass("collapsed");
});


$('#nav-icon3').click(function(){
    $(this).toggleClass('open');
});

