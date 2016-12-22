import Ember from 'ember';
const { assign } = Ember;

export default Ember.Mixin.create({
    actions: {
        addNewImage(settings, imageObject){
            let image = this.store.createRecord('image');
            assign(image, imageObject);
            settings.set('image', image);
        }
    }
});