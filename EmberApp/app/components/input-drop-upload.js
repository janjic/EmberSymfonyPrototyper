import Ember from 'ember';
import dragDropEventHasFiles from './../utils/drag-drop-event-has-files';
var { set } = Ember;

export default Ember.Component.extend({
    classNames        : [ 'draggableDropzone' ],
    classNameBindings : [ 'dragClass' ],
    dragClass         : 'deactivated',

    dragLeave(event) {
        event.preventDefault();
        set(this, 'dragClass', 'deactivated');
    },

    dragOver(event) {
        event.preventDefault();
        set(this, 'dragClass', 'activated');
    },

    drop(event) {
        set(this, 'dragClass', 'deactivated');
        if(dragDropEventHasFiles(event)) {
            let files = event.dataTransfer;
            this.get('doOnFilesSelected')(files);
            return false;
        }
    },
});