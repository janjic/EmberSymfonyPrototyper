import Ember from 'ember';

export default Ember.Component.extend({
    currencyEUR : true,

    didInsertElement(){
        this._super(...arguments);
        this.get('getNewElements')();
        let ctx = this;
        if ( this.get('isMultipleCard') ){
            let id = window.setInterval(function () {
                ctx.set('currencyEUR', !ctx.get('currencyEUR'));
            }, 4000);
            this.set('intervalId', id);
        }
    },

    willDestroy(){
      window.clearInterval(this.get('intervalId'));
    }
});
