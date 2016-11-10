import Ember from 'ember';

export default Ember.Component.extend({
    actions: {
        prevPage: function () {
            this.get('prevPage')();
        },
        nextPage: function () {
            this.get('nextPage')();
        },
        handleFilterEntry(colon) {
            let filterInputValue = this.get(colon);
            this.get('filter')(colon, filterInputValue);
        }
    }
});
