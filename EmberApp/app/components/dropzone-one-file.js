import Ember from 'ember';
import EmberDropzone from 'ui-dropzone/components/drop-zone';
const {Dropzone} = window;
export default EmberDropzone.extend({
    loadPreExistingFiles() {
        let file = this.get('currentImage');
        if (file) {
            let extension = /(?:\.([^.]+))?$/.exec(file.get('name'))[1];
            extension     = extension ? extension :'png';
            let dropFile = {
                name: `current.${extension}`,
                type: extension,
                size: file.get('fileSize'),
                status: Dropzone.ADDED,
                url: file.get('webPath')
            };

            let thumbnail = file.get('webPath');

            if ( typeof(thumbnail) === 'string' ) {

                dropFile.thumbnail = thumbnail;
            }
            this.get('dropzone').emit('addedfile', dropFile);

            if ( typeof(thumbnail) === 'string' ) {
                this.get('dropzone').emit('thumbnail', dropFile, thumbnail);
            }

            this.get('dropzone').emit('complete', dropFile);
            this.get('dropzone').files.push(file);
        }

    },
    didInsertElement() {
        this._super(...arguments);
        Ember.run.scheduleOnce('afterRender', this, ()=>{
            let dropZone = this.get('dropzone');
            dropZone.on('addedfile', function() {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
             });

        });
    },
});