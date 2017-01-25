import Ember from 'ember';
import moment from 'moment';

export default Ember.Mixin.create({
    /** datetime picker */
    daysOfWeek: [
        "Su",
        "Mo",
        "Tu",
        "We",
        "Th",
        "Fr",
        "Sa"
    ],
    monthNames: [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agusto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre"
    ],
    today : Ember.computed(function () {
        let date = new Date();
        return `${date.getFullYear()}/${date.getMonth() < 10 ? '0'+(date.getMonth()+1) :date.getMonth()+1} /${date.getDate() <10 ?'0'+(date.getDate()) :date.getDate()}`.replace(/\//g,'');
    }),
    ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
});
