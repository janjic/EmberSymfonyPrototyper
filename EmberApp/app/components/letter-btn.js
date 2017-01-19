import Ember from 'ember';

export default Ember.Component.extend({
    tagName: 'button',
    classNameBindings: ['selectedClass'],
    selectedClass: Ember.computed('selected', function () {
        if (this.get('selected')) {
            return 'button rounded-btn icon-btn green';
        }
         return 'button rounded-btn icon-btn letter-btn';

    }),

    focusIn() {
        this.set('selected', true);
        this.get('filter')(this.get('letter'));
    },
    focusOut() {
        this.set('selected', false);
    }

});
