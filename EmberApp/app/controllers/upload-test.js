import Ember from 'ember';

export default Ember.Controller.extend({
    assets: [],
    actions:{
        receiveFile: function(file){
            var asset;

            this.set('uploadDisabled', true);
            asset = this.store.createRecord('asset', {
                image:  file,
                imageName: file.name,
                title: 'something'
            });

            if(asset.get('isValid')){
                this.get('assets').pushObject(asset);

                asset.save().then(function(asset){
                    console.info(asset.get('imageUrl'));
                }, function(error){
                    console.debug('Upload failed', error);
                }, 'file upload');
            }

            else{
                // our model is invalid...
                this.set('uploadDisabled', false);
            }
        },

        uploadProgress: function(progress){
            this.set('assets.lastObject.progress', progress);
        }
    }
});