import Ember from 'ember';

export default Ember.Component.extend({
    didInsertElement(){
        $('table').each(function() {
            let currentPage = 0;
            let numPerPage = 10;
            let $table = $(this);
            $table.bind('repaginate', function() {
                $table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
            });
            $table.trigger('repaginate');
            let numRows = $table.find('tbody tr').length;
            let numPages = Math.ceil(numRows / numPerPage);
            let $pager = $('<div class="pager"></div>');
            for (let page = 0; page < numPages; page++) {
                $('<span class="page-number"></span>').text(page + 1).bind('click', {
                    newPage: page
                }, function(event) {
                    currentPage = event.data['newPage'];
                    $table.trigger('repaginate');
                    $(this).addClass('active').siblings().removeClass('active');
                }).appendTo($pager).addClass('clickable');
            }
            $pager.insertAfter($table).find('span.page-number:first').addClass('active');
        });
    }
});