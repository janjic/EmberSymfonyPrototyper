import Ember from 'ember';

export default Ember.Component.extend({

    validFormats: ['png', 'jpg', 'jpeg', 'gif', 'bmp' ],

    file: null,
    isImage: Ember.computed('file', 'validFormats', function() {
        let extension = /(?:\.([^.]+))?$/.exec(this.get('file.name'))[1];

        return this.get('validFormats').includes(extension);
    }),

    items: Ember.computed('file', function() {
        return [{
            src: this.get('file.webPath'),
            w: 600,
            h: 400,
            title: this.get('file.name'),
        }];
    }),

    options: {
        hideToggleFullScreen: true,
        hideZoomInOut: true
    }
});