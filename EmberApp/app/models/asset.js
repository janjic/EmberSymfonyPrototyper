import DS from 'ember-data';
import Ember from 'ember';
import Validation from '../mixins/validation';

const {
    computed: { alias },
    observer
} = Ember;

const {
    Model: {extend},
    attr
}  = DS;

export default extend(Validation, {
    title: attr('string'),
    image: attr(),
    imageUrl: alias('image.url'),
    imageName: attr(),

    imageNameObserver: observer('imageUrl', function(){
        /*
         This computed property is simply to when we receive the file from our
         servers on a store.find('asset', id) query we are still able to isolate
         it's file name correctly.
         If you api returns the imageName on the response you do not need this observer
         */
        var url,
            imageName;

        url = this.get('fileUrl');
        imageName = this.get('imageName');

        if(Ember.isPresent(url) && Ember.isNone(imageName)){
            return url.split('/').find(function(urlPart){
                return !!urlPart.match(/\.(?:jpg|gif|png)$/) ? urlPart : null;
            });
        }

        else{
            return "";
        }
    }),

    validations:{
        // this is a property to be observed and validated accordingly
        imageName: {
            // this is our validator intended to be executed
            file: {
                // this is the restrictions that we want
                // to apply to our imageName property
                accept: ['png', 'jpg', 'gif'],
                // this is the message to display in case of a faulty value
                message: 'Accepts only images'
            }
        }
    },

    progress: 0
});