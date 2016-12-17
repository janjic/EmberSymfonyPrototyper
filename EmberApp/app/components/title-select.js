import Ember from 'ember';

export default Ember.Component.extend({

    titles: Ember.computed(function () {
        return ['MR', 'MRS'];
    }),

    actions: {
        titleChanged(title){
            this.get('on-title-changed')(title);
        }
    }
});
