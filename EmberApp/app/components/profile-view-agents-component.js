import Ember from 'ember';

export default Ember.Component.extend({
    actions: {
        filterModel (searchArray, page, column, sortType) {
            return this.get('filter')(searchArray, page, column, sortType);
        }
    }
});
