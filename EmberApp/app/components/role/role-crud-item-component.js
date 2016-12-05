import Ember from 'ember';

export default Ember.Component.extend({
    tagName: '',

    actions: {
        setCurrentEditingItem() {
            this.get('setCurrentEditing')(this.get('item'));
        },
        deleteItemOwn() {
            this.get('deleteItem')(this.get('item'));
        }
    }
});
