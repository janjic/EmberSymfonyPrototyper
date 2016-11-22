import Ember from 'ember';
import dragDropEventHasFiles from './../utils/drag-drop-event-has-files';

export default Ember.TextField.extend({
    type: 'file',
    attributeBindings: ['multiple', 'type'],
    change: function (evt) {
        let files = evt.target.files;
        this.get('doOnFilesSelected')(files);
    }
});
