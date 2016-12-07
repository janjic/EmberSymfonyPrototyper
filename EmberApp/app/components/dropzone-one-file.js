import Ember from 'ember';
import EmberDropzone from 'ui-dropzone/components/drop-zone';
export default EmberDropzone.extend({
    didInsertElement() {
        this._super(...arguments);
        Ember.run.scheduleOnce('afterRender', this, ()=>{
            let dropzone = this.get('dropzone');
             dropzone.on("addedfile", function() {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
             });

        });
    }
});
