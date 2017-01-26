import Ember from 'ember';
const { emojify } = window;

export default Ember.Component.extend({
    didInsertElement: function() {
        this._super();

        this.$('.single-message-content').each(function(index, element){
            emojify.run(element);
        });
    }
});