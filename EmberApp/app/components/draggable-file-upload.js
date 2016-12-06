import Ember from 'ember';
import humanReadableFileSize from './../utils/human-readable-file-size';
import FileUploadModel from './../models/file-upload';

export default Ember.Component.extend({
    init() {
        this._super(...arguments);
        this.set('model', Ember.A([]));
        this.set('uploadedLog', Ember.A([]));
    },
    totalFileSize: Ember.computed('model.@each.rawSize', function() {
        let total = 0;
        this.get('model').forEach((file) =>{
            total += file.get('rawSize');
        });
        return humanReadableFileSize(total);
    }),

    hasUploads: Ember.computed('model.length', function() {
        return this.get('model.length') > 0;
    }),

    hasCompleted: Ember.computed('model.@each.didUpload', function() {
        return this.get('model').filterBy('didUpload', true);
    }),

    actions: {
        removeFile(file) {
            this.get('model').removeObject(file);
        },

        removeCompleted() {
            var completed = this.get('model').filterBy('didUpload', true);
            this.get('model').removeObjects(completed);
        },

        uploadFile(file) {
            var uploadedLog = this.get('uploadedLog');
            file.uploadFile().then((url)=> {
                uploadedLog.pushObject(url);
            });
        },
        uploadAll() {
            var uploadedLog = this.get('uploadedLog');
            this.get('model').forEach((item) =>{
                if (!item.get('didUpload')) {
                    item.uploadFile().then((url)=> {
                        uploadedLog.pushObject(url);
                    });
                }

            });
        },
        handleMultipleFilesUploads(files) {
            let model = this.get('model');

            if (Object.is(files.files, undefined)) {
                for (let i = 0, f; f = files[i]; i++) {
                    let fileUploadModel = FileUploadModel.create({ fileToUpload: f });
                    model.pushObject(fileUploadModel);
                }
            } else {
                for(let i = 0; i < files.files.length; i++) {
                    if (files.files[i].type) {
                        let fileUploadModel = FileUploadModel.create({ fileToUpload: files.files[i] });
                        model.pushObject(fileUploadModel);
                    }

                }
            }


        }
    }
});