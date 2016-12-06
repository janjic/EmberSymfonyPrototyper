import Ember from 'ember';
import FileUploadModel from './../models/file-upload';

export default Ember.Route.extend({
    model() {
        return [];
    },

    actions: {
        filesDropped(files) {
            var model = this.controller.get('model');
            for(var i = 0; i < files.files.length; i++) {
                var fileUploadModel = FileUploadModel.create({ fileToUpload: files.files[i] });
                model.pushObject(fileUploadModel);
            }
        }
    }
});
