import Ember from 'ember';
import FileUploadModel from './../models/file-upload';

export default Ember.Route.extend({
    model() {
        return [];
    },

    actions: {
        filesDropped(files) {
            let  model = this.controller.get('model');
            for(let i = 0; i < files.files.length; i++) {
                let fileUploadModel = FileUploadModel.create({ fileToUpload: files.files[i] });
                model.pushObject(fileUploadModel);
            }
        }
    }
});
