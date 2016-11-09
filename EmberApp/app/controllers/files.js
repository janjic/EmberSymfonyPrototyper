import Ember from 'ember';
import humanReadableFileSize from './../utils/human-readable-file-size';

export default Ember.Controller.extend({
    uploadedLog: [],

    totalFileSize: Ember.computed('model.@each.rawSize', function() {
        let total = 0;
        this.get('model').forEach((file) =>{
            total += file.get('rawSize');
        });
        return humanReadableFileSize(total);
    }),

    hasUploads: Ember.computed('length', function() {
        return this.get('length') > 0;
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
                item.uploadFile().then((url)=> {
                    uploadedLog.pushObject(url);
                });
            });
        }
    }
});
