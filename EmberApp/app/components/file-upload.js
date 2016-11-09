import EmberUploader from 'ember-uploader';
import Ember from 'ember';
export default EmberUploader.FileField.extend({
    multiple: true,
    url: 'http://example.com/upload',

    filesDidChange (files) {
        const uploader = EmberUploader.Uploader.create({
            url: this.get('url')
        });

        if (!Ember.isEmpty(files)) {
            // this second argument is optional and can to be sent as extra data with the upload
            uploader.upload(files, { id:1});
        }
    }
});