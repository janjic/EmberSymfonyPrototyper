import Ember from 'ember';

export default Ember.Component.extend({
    actions: {
        handlePageChange: function (page) {
            this.get('filter')(page);
        },
        handleOffsetChange: function () {
            this.set('offset', this.$('select')[0].value);
            this.get('filter')(1);
        }
    }
});
