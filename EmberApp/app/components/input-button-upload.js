import Ember from 'ember';

export default Ember.TextField.extend({
    type: 'file',
    attributeBindings: ['multiple', 'type'],
    change: function (evt) {
        let files = evt.target.files;
        this.get('doOnFilesSelected')(files);
    }
});
