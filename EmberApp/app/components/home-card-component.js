import Ember from 'ember';

export default Ember.Component.extend({
    currencyEUR : true,

    didRender() {
        this._super(...arguments);
        let refreshFunc = Ember.run.schedule('sync', this, function() {
            let ctx = this;
            ctx.$('.timer').each(function () {
                ctx.$(this).prop('Counter',0).animate({
                    Counter: ctx.$(this).text()
                }, {
                    duration: 700,
                    easing: 'swing',
                    step: function (now) {
                        ctx.$(this) ? ctx.$(this).text(Math.ceil(now)) : window.$('.timer').stop();
                    }
                });
            });
        });
        this.set('refresh', refreshFunc);

    },
    didInsertElement(){
        this._super(...arguments);
        this.get('getNewElements')();
        if ( this.get('isMultipleCard') ){
            this.changeCurrency();
        }
    },

    changeCurrency(){
        let ctx = this;
        let id = Ember.run.later(this, function () {
            ctx.set('currencyEUR', !ctx.get('currencyEUR'));
            ctx.changeCurrency();
        }, 4000);
        this.set('intervalId', id);
    },

    willDestroy(){
        Ember.run.cancel(this.get('intervalId'));
        Ember.run.cancel(this.get('refresh'));
        this.set('refresh', undefined);
        window.$('.timer').stop();
    }
});
