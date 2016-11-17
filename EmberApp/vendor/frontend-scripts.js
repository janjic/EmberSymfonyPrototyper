$(document).ready(function () {

    var navListItems = $('div.setup-panel div a'),
        allWells = $('.setup-content'),
        allNextBtn = $('.nextBtn');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-primary').addClass('btn-default');
            $item.addClass('btn-primary');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allNextBtn.click(function(){
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url']"),
            isValid = true;

        $(".form-group").removeClass("has-error");
        for(var i=0; i<curInputs.length; i++){
            if (!curInputs[i].validity.valid){
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (isValid)
            nextStepWizard.removeAttr('disabled').trigger('click');
    });

    $('div.setup-panel div a.btn-primary').trigger('click');
});

$(document).on("ready",function(){
    $(".toggle-left-section").on("click",function(e){
        e.preventDefault();
        /* funckija da se pojavi leva sekcija. Prvo se gubi klasa visible sa desne sekcije, pa se ukljucuje leva. */
        $(".left-section").toggleClass("left-section-visible");
        $(".toggle-left-section").toggleClass("collapsed");

    });
});


$(document).on("resize",function(){
    var leftSectionWidth=$(".left-section").width();
    $(".right-section").css("margin-left", leftSectionWidth + "px");
})


$(document).ready(function(){
    $('#nav-icon3').click(function(){
        $(this).toggleClass('open');
    });
});

function progress(){
    var brojDugmica=$(".stepwizard-step").length;
    var brojAktivnihDugmica=$(".btn-primary").length;
    $(".progress-bar").css("width",(100/brojDugmica)*brojAktivnihDugmica+"%");
    console.log((100/brojDugmica)*brojAktivnihDugmica);
}

progress();

