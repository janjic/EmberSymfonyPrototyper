import Ember from 'ember';
import humanReadableFileSize from './../utils/human-readable-file-size';

export default Ember.Object.extend({
        init() {
            this._super();
            Ember.assert("File to upload required on init.", this.get('fileToUpload'));
            this.set('uploadPromise', Ember.RSVP.defer());
        },

    readFile: Ember.on('init', function() {
        var self = this;
        var fileToUpload = this.get('fileToUpload');
        var isImage = fileToUpload.type.indexOf('image') === 0;

        this.set('name', fileToUpload.name);
        this.set('rawSize', fileToUpload.size);
        this.set('size', humanReadableFileSize(fileToUpload.size));

        // Don't read anything bigger than 5 MB
        if(isImage && fileToUpload.size < 1*1024*1024) {
            this.set('isDisplayableImage', isImage);

            // Create a reader and read the file.
            var reader = new FileReader();
            reader.onload = function(e) {
                self.set('base64Image', e.target.result);
            };

            // Read in the image file as a data URL.
            reader.readAsDataURL(fileToUpload);
        }
    }),

    // ...........................................
    // Name is used for the upload property
    name: '',

    // {Property} Human readable size of the selected file
    size: "0 KB",

    // {Property} Raw file size of the selected file
    rawSize: 0,

    // {Property} Indicates if this file is an image we can display
    isDisplayableImage: false,

    // {Property} String representation of the file
    base64Image: '',

    // {Property} Will be an HTML5 File
    fileToUpload: null,

    // {Property} Will be a $.ajax jqXHR
    uploadJqXHR: null,

    // {Property} Promise for when a file was uploaded
    uploadPromise: null,

    // {Property} Upload progress 0-100
    uploadProgress: null,

    // {Property} If a file is currently being uploaded
    isUploading: false,

    // {Property} If the file was uploaded successfully
    didUpload: false,

    // ..........................................................
    // Actually do something!
    //
    uploadFile: function() {
        if(this.get('isUploading') || this.get('didUpload') || this.get('didError')) {
            return this.get('uploadPromise');
        }

        var fileToUpload = this.get('fileToUpload');
        var name = this.get('name');
        var key = "public-uploads/" + (new Date).getTime() + '-' + name;
        var fd = new FormData();
        var self = this;

        fd.append('key', key);
        fd.append('acl', 'public-read-write');
        fd.append('success_action_status', '201');
        fd.append('Content-Type', fileToUpload.type);
        fd.append('file', fileToUpload);

        this.set('isUploading', true);

        $.ajax({
            url: 'https://192.168.11.3/app_dev.php/file_upload',
            type: "POST",
            data: fd,
            processData: false,
            contentType: false,
            xhr: function() {
                var xhr = $.ajaxSettings.xhr() ;
                // set the onprogress event handler
                xhr.upload.onprogress = function(evt) {
                    self.set('progress', (evt.loaded/evt.total*100));
                };
                return xhr ;
            }
        }).done(function(data, textStatus, jqXHR) {
            var value = "";
            try {
                value = data.getElementsByTagName('Location')[0].textContent;
            } catch(e) { }
            console.log('Value je ', value);
            self.set('isUploading', false);
            self.set('didUpload', true);
            self.get('uploadPromise').resolve(value);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log('Neuspeno');
            self.set('isUploading', false);
            self.set('didError', true);
            self.get('uploadPromise').reject(errorThrown);
        });

        return this.get('uploadPromise').promise;
    },

    // ..........................................................
    // Progress support, this belongs in a component. Ran out of time.
    //
    showProgressBar: Ember.computed.or('isUploading', 'didUpload'),

    progressStyle:  Ember.computed('progress', function() {
        let progress = this.get('progress');
        return  Ember.String.htmlSafe(`width: ${progress}%`);
    })
});
