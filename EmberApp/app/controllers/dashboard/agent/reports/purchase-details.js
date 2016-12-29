import Ember from 'ember';

export default Ember.Controller.extend({
    datesArray: [],
    maxDate: Ember.computed('model.items', function () {
        let ctx = this;
        this.get('model.items').forEach(function (item) {
            ctx.get('datesArray').push(new Date(item.get('date_to')).getTime());
        });

        return (new Date(Math.max.apply(null, this.get('datesArray')))).toString();
    })
});
