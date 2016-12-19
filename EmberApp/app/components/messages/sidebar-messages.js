import Ember from 'ember';

export default Ember.Component.extend({
    actions: {
        threadSelected(thread) {
            this.get('threadSelectedAction')(thread);
        }
    }
});