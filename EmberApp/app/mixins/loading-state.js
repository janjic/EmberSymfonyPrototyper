import Ember from 'ember';

export default Ember.Mixin.create({
    isLoading:false,
    loadingText: '',

    showLoader(loadingText=null) {
        this.set('isLoading', true);
        if (loadingText) {
          this.setLoadingText(loadingText);
        }
    },

    setLoadingText(loadingText) {
            this.set('loadingText', loadingText);
    },

    disableLoader() {
        this.set('isLoading', false);
        this.setLoadingText('');
    },

});
