import Ember from 'ember';
const {assign} = Ember;
export default Ember.Controller.extend({
    actions: {
        addNewImageToAgent (imageObject) {
            let image = this.store.createRecord('image');
            assign(image, imageObject);
            this.set('model.image', image);
        },
        goToRoute (route) {
            this.transitionToRoute(route);
        }
    }
});
